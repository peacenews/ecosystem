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

// function send_mailing_list
function send_mailing_list($send_data){
    require 'html2text.php'; //convert_html_to_text from http://journals.jevon.org/users/jevon-phd/entry/19818
    // Declare an array containing the info needed by mailman or send_as_test
    $mailman_data = array ('listowner' => $_SESSION ['public_user'] ['email'],
                           'fromname' => $_SESSION ['public_user'] ['site_title'],
                           'groupname' => ltrim($_SESSION [public_user] [site_url], '/'),
                           'subject' => $send_data ['subject'],
                           'header' => "\nMime-Vession: 1.0\nContent-Type: multipart/alternative; boundary=BOUNDARY;\n",
                           'part_text' => "\n--BOUNDARY\nContent-Type: text/plain; charset=UTF-8;\n",
                           'part_html' => "\n\n--BOUNDARY\nContent-Type: text/html; charset=UTF-8;\n<!DOCTYPE html>\n<html>\n<body>\n",
                           'body' => $send_data[content],
                           'altbody' => convert_html_to_text($send_data[content]),
                           );

    // Declare a function to be called IF we need to send_as_test
    function send_as_test($mail_data) {
        require 'PHPMailerAutoload.php'; // http://phpmailer.worxware.com/index.php?pg=examplebmail
        $mail = new PHPMailer();
        $mail->SetFrom($mail_data['groupname'].'@groups.zylum.org', $mail_data['fromname']);
        $mail->addBCC($mail_data['listowner']);
        $mail->Subject = $mail_data['subject'];
        $mail->MsgHTML($mail_data['body']);
        $mail->AltBody = $mail_data['altbody'];
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
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
    	// Format variables for use in mailman shell command
        $mailman_from = "From: ".$mailman_data['fromname']." <".$mailman_data['listowner'].">\n";
        $mailman_to   = "To: <".$mailman_data['groupname']."@groups.zylum.org>\n";

        // Execute the Mailman shell command. Single quotes are PHP syntax. Double quotes are BASH syntax.
        exec ('printf "'
              .$mailman_from
              .$mailman_to
              .'Subject: '
              .$mailman_data['subject']
              .$mailman_data['header']
              .$mailman_data['part_text']
              .$mailman_data['altbody']
              .$mailman_data['part_html']
              .$mailman_data['body']
              .'\n</body>\n</html>\n--BOUNDARY--\n" | sudo /usr/lib/mailman/bin/inject --listname='
              .$mailman_data['groupname']
             );
        // Mailman only understands the header fields if To: From: etc are at the begining of a line thus "\n To" (with space) will not work.
    }; // if isset test
}; // function send_mailing_list

//TESTING: call the above function
$mail = array('subject' => "list message",
              'content' => "here is some\n<b>important</b> information\n",
              //'test' => "test",
              // When the checkbox is unchecked it's not transmitted in the post http://stackoverflow.com/questions/4554758/how-to-read-if-a-checkbox-is-checked-in-php
             );
send_mailing_list ($mail);
// end testing

/*
NB: The test vs list emails are not entirely identical. Noted differences are:

1. PHPMailer sets charset=us-ascii, $mail->CharSet = 'UTF-8'; seems to have no effect.
   Vs Mailman related code above specifies charset=UTF-8

2. Mailman adds its own footer to all list messages. Perhaps this should be replecated in the test version?

3. Mailman will prepend [Groupname] to the subject of all list messages.

4. Mailman adds some additional headers.

5. Mailman specifies sub-optimal From and Reply-to addresses:
   PHPMailer  From: Group name <groupmane@groups.domain.org>
   Vs Mailman From: groupname@domain.org

6. Mailmam constructs a message where the declared, Content-Type: multipart/alternative; boundary=BOUNDARY;
   appears INSIDE a, Content-Type: multipart/mixed; This is valid according to
   http://stackoverflow.com/questions/3902455/smtp-multipart-alternative-vs-multipart-mixed
*/

?>
