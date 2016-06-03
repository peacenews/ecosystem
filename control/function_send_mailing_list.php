<?php
/*
Current mailing functionality is inadequate eg. No bounce processing.

This function is intended to replace send_mailing_list in control/functions.php

When the code in this file is proven it can be moved to function.php or or use include/require if prefered.
*/

/*
"Peace News Ecosystem" is a CMS developed to allow small groups with no tech' expertise to have an internet presence. Its USP is freedom from choice. You can see one installation of Peace News Ecosystem at https://zylum.org/
Copyright (C) 2014 Zylum Ltd.
admin@zylum.org / 5 Caledonian Rd, London, N1 9DY

Version one of Peace News Ecosystem was authored by http://www.wave.coop/ info@wave.coop

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program.  If not, see http://www.gnu.org/licenses/agpl-3.0.html
*/

//Please be aware of the typo $send_data[sublect] in the code which calls this function see templates/public_templates/mailing_list.php

// TESTING: we need to declare the array $_SESSION - this array will already exist when the code runs for real
echo "function_send_mailing_list.php<br />";
$_SESSION = array ( 'public_user' => array ('user_id' => "4",
                                            'email' => "admin@zylum.org",
                                            'name' => "Luddite",
                                            'level' => "Superuser",
                                            'site_id' => "4",
                                            'site_title' => "Group against bad stuff and for good stuff",
                                            'site_url' => "/weaving",
                                            ),
                    'message' => "",
                   );
// end testing

//function send_mailing_list
function send_mailing_list($send_data){
    require 'html2text.php'; //convert_html_to_text from http://journals.jevon.org/users/jevon-phd/entry/19818

    $mailman_data = array ('listowner' => $_SESSION ['public_user'] ['email'],
                           'fromname' => $_SESSION ['public_user'] ['site_title'],
                           'groupname' => ltrim($_SESSION [public_user] [site_url], '/'),
                           'subject' => $send_data ['subject'],
                           'doctype' => "\nMIME-Version: 1.0\nContent-Type: multipart/alternative;\nContent-Type: text/html; charset=utf-8;\n<!DOCTYPE html>\n<html>\n<body>\n",
                           'body' => $send_data[content]."</body>\n</html>\n",
                           'altbody' => "\nContent-type: text/plain; charset=utf-8\n".convert_html_to_text($send_data[content]),
                           );

    function send_as_test($mail_data) {
        require 'PHPMailerAutoload.php'; // http://phpmailer.worxware.com/index.php?pg=examplebmail
        $mail = new PHPMailer();
        $mail->SetFrom($mail_data['groupname'].'@groups.zylum.org', $mail_data['fromname']);
        $mail->addBCC($mail_data['listowner']);
        $mail->Subject = $mail_data['subject'];
        $mail->MsgHTML($mail_data['body']);
        $mail->AltBody = $mail_data['altbody'];
        $mail->isHTML(true);

        if(!$mail->send()) {
		    $_SESSION[message]= 'Message could not be sent.';
		    //echo 'Mailer Error: ' . $mail->ErrorInfo;
	    } else {
		$_SESSION[message]= 'Message has been sent';
    	} //if sent else

    } //function send_as_test

    if (isset ($send_data['test'])) {
        send_as_test($mailman_data);
    } else {
        exec ('printf "From: '.$mailman_data['fromname'].' <'.$mailman_data['listowner'].'>\nTo: <'.$mailman_data['groupname'].'@groups.zylum.org>\nSubject: '.$mailman_data['subject'].'\n\n'.$mailman_data['doctype'].'\n'.$mailman_data['body'].'\n'.$mailman_data['altbody'].'" | sudo /usr/lib/mailman/bin/inject --listname='.$mailman_data['groupname']);
        // IMPORTANT Mailman only understands the header fields if To: From: etc are at the begining of a line thus "\n To" (with space) will not work.
    } //if isset test

} //function send_mailing_list

//TESTING: call the above function
$mail = array('subject' => "list message",
              'content' => "here is some\n<b>important</b> information\n",
              'test' => "test",
              //when the checkbox is unchecked it's not transmitted in the post http://stackoverflow.com/questions/4554758/how-to-read-if-a-checkbox-is-checked-in-php
              );

send_mailing_list ($mail);
// end testing


// Still to fix - Proper syntax for multipart message
?>
