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

include ("control/config.php");

$mail_server = ""; // Server URL
$mail_port = ""; // Server port
$mail_username = ""; // Server username
$mail_password = ""; // Server password

echo "<h1>".$mail_username." on ".$mail_server."</h1>\n\n" ;
$mbox = imap_open("{".$mail_server.":".$mail_port."}".$mail_folder, $mail_username, $mail_password) or die("Error opening mailbox: ".imap_last_error());
$mailboxheaders = imap_headers($mbox);
if ($mailboxheaders == false) {
    echo "<p>".$mail_folder." is empty.</p>\n\n";
} else {
    $messageCount = imap_num_msg($mbox);
    for( $MID = 1; $MID <= $messageCount; $MID++ ) {
        $EmailHeaders[$MID] = imap_headerinfo( $mbox, $MID );
        $Body[$MID] = imap_fetchbody( $mbox, $MID, 1 );
        //doSomething( $EmailHeaders, $Body );
    }

    foreach($EmailHeaders as $key=>$val) {
        $to=$EmailHeaders[$key]->to[0]->mailbox;
        $from=$EmailHeaders[$key]->from[0]->mailbox.'@'.$EmailHeaders[$key]->from[0]->host;
        $sent=$EmailHeaders[$key]->date;
        $structure = imap_fetchstructure($mbox,$key);

        echo '<pre>';
        print_r($EmailHeaders[$key]);
        print_r($structure);
        echo '</pre>';

        if ($EmailHeaders[$key]->Deleted!= 'D') {
            $query = "INSERT INTO `to_be_sent` (`id`, `from`, `to`, `body`, `date`, `sent_date`, `sent`)
            VALUES ('NULL', '".addslashes($from )."', '".addslashes($to )."', '".addslashes($Body[$key] )."', CURRENT_TIMESTAMP, '$sent', '0'); ";
            $result = $dbpdo->query($query);
        }

        /* ?> <textarea name="" cols="30" rows="30"><? print_r($Body[$key]); ?></textarea> <? */
        imap_delete($mbox, $key);
    }
}
//imap_expunge($mbox);
imap_close($mbox);
?>
