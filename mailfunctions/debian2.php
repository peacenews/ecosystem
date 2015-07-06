<?
/*
"Peace News Ecosystem" is a CMS developed to allow small groups with no tech' expertise to have an internet presence. Its USP is freedom from choice. You can see one installation of Peace News Ecosystem at https://zylum.org/
Copyright (C) 2014 Zylum Ltd.
admin@zylum.org / 5 Caledonian Rd, London, N1 9DY

Version one of Peace News Ecosystem was authored by http://www.wave.coop/ info@wave.coop

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program.  If not, see http://www.gnu.org/licenses/agpl-3.0.html
*/

ini_set('display_errors', 1);
include ("../control/config.php");
require_once('../control/class.phpmailer.php');

$mail_server = ""; // Server URL
$mail_port = ""; // Server port
$mail_username = ""; // Server username
$mail_password = ""; // Server password

$tos=array();
$query = "select id,source from forwardings ";
$result = $dbpdo->query($query);
while($r = $result->fetch(PDO::FETCH_BOTH)) {
    $tos[$r[id]]=$r[source];
}

$froms=array();
$query = "select disc_groups.id, disc_groups.site_id, disc_groups.email from disc_groups , users where disc_groups.site_id=users.id and users.valid='Yes' ";
$result = $dbpdo->query($query);
while($r = $result->fetch(PDO::FETCH_BOTH)) {
    $froms[$r[site_id]][$r[id]]=$r[email];
}

$inbox= imap_open("{".$mail_server.":".$mail_port."}".$mail_folder, $mail_username, $mail_password) or die("Error opening mailbox: ".imap_last_error());
$emails = imap_search($inbox,'UNSEEN');

if($emails) {
    rsort($emails);
    foreach($emails as $email_number) {
        $overview = imap_fetch_overview($inbox,$email_number,0);
        $plain_message = imap_fetchbody($inbox,$email_number,1.1);
        $message = imap_fetchbody($inbox,$email_number,1.2);
        if ($message==''){
            $plain_message = imap_fetchbody($inbox,$email_number,1);
            $message = imap_fetchbody($inbox,$email_number,2);
        }
        $structure = imap_fetchstructure($inbox,$email_number);
        $header = imap_headerinfo($inbox, $email_number);

        // Who is it to?
        $this_to=$header->to[0]->mailbox;

        //  if not in recipient list continue
        echo $this_to.'<br />';
        if (!in_array($this_to,$tos)) {
            $status = imap_setflag_full($inbox, $email_number, "\\Seen");
            // echo 'discarded because not valid from<br />';
            continue;
        }

        $site_id = array_search($this_to, $tos);

        // Who is it from?
        $this_from=$header->reply_toaddress;

        //if not in  to list for this one isoLATE or dISCARD? discard at moment
        echo $this_from.'<br />';
        if (!in_array($this_from,$froms[$site_id])) {
            $status = imap_setflag_full($inbox, $email_number, "\\Seen");
            // echo 'discarded because not valid to<br />';
            continue;
        }

        //send message on

        $message=quoted_printable_decode($message);
        $plain_message=quoted_printable_decode($plain_message);

        $attachments = array();
        if(isset($structure->parts) && count($structure->parts)) {
            for($i = 0; $i < count($structure->parts); $i++) {
                $attachments[$i] = array(
                    'is_attachment' => false,
                    'filename' => '', 'name' => '',
                    'attachment' => ''
                    );

                if($structure->parts[$i]->ifparameters) {
                    foreach($structure->parts[$i]->parameters as $object) {
                        if(strtolower($object->attribute) == 'name') {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['name'] = $object->value;
                        }
                        if($object->type == 'HTML') {
                            $message='g';
                        }
                    }
                }
                if($attachments[$i]['is_attachment']) {
                    $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i+1);
                    if($structure->parts[$i]->encoding == 3) {
                        $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                    } elseif($structure->parts[$i]->encoding == 4) {
                        $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                    }
                }
            }
        }

        $file_attachments = array();
        if(count($attachments) != 0) {
            foreach($attachments as $at) {
                if($at[is_attachment]==1) {
                    $fname = $at['name'];
                    $file_attachments[] = "attachments/$fname";
                    $fp = fopen("attachments/$fname","w"); fwrite($fp, $at['attachment']); fclose($fp);
                }
            }
        }

        $mail = new PHPMailer();

    $recepeint_email_address = 'example@domain.com'; // eMail
    $recepeint_name = 'Firstname Lastname'; // Name

    $subject = $overview[0]->subject;
    $from = $overview[0]->from;
    $fromEmail = $header->from[0]->mailbox . "@" . $header->from[0]->host;
    $mail->SetFrom($fromEmail, $from);
    $mail->Subject = $subject;
    $body = $message;
    $mail->isHTML(true);
    $mail->Body = ($message);
    $mail->AltBody = $plain_message;
    foreach($froms[$site_id] as $key=>$val) {
        $mail->AddAddress($val);
    }
    if(!empty($file_attachments)) {
        foreach($file_attachments as $file) {
            $mail->AddAttachment($file);
        }
    }
    // $mail->send();
    if(!$mail->send()) {
    //echo 'Message could not be sent.';
    //echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        //echo 'Message has been sent';
    }

    $status = imap_setflag_full($inbox, $email_number, "\\Seen");

}
}
imap_close($inbox);
?>
