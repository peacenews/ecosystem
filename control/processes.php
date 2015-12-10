<?php
/*
"Peace News Ecosystem" is a CMS developed to allow small groups with no tech' expertise to have an internet presence. Its USP is freedom from choice. You can see one installation of Peace News Ecosystem at https://zylum.org/
Copyright (C) 2014 Zylum Ltd.
admin@zylum.org / 5 Caledonian Rd, London, N1 9DY

Version one of Peace News Ecosystem was authored by http://www.wave.coop/ info@wave.coop

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program.  If not, see http://www.gnu.org/licenses/agpl-3.0.html
*/
global $site_vars;
// $_SESSION['message'] prepares a pop up message in the page
$now=strtotime("now");
$mysql_now=date('Y-m-d H:i:s', $now);



//$_SESSION['message']='';
// process that deal with files are in a seperate file
if (count($_FILES) > 0) {
    include("file_process.php");
}

// sign up confirmation email return
if (isset ($_GET['email_id']) ) {
        //see if the id and password pair exists
    $stmt = $dbpdo->prepare("SELECT * from sign_ups where id=:id and pass=:pass " );
    $stmt->execute(array(
        ":id" =>$_GET['email_id'],
        ":pass"=>$_GET['pass']
        ));
    $num_rows = $stmt->rowCount();
        // if it does add them into the mailing list
    if ($num_rows==1) {
        $data = $stmt->fetch(PDO::FETCH_BOTH);
        $pass=makeRandomPassword();
        $stmt = $dbpdo->prepare(" INSERT INTO `mailing_list` (`id`, `site_id`, `email`, `active`, `pass`) VALUES (NULL, :web , :email  , '1', :pass); ");
        $stmt->execute(array(
                ':email' => $data['email'], // email  from sign_ups table
                ':pass' => $pass, //new password
                ':web' => $data['site_id'] // the site_id the email is associated with
                ));
        $_SESSION['message']='You have been added to the mailing list';
    }
}

// if you are allowed - prepare the  top navigation in admin area
if (isset($_SESSION['manager']['user_id'])) {
    $page_control->navigation='
    <ul class="inline-list right">
        <li><a href="/manage">Home</a></li>
        <li><a href="/manage/new">New sign ups</a></li>
        <li><a href="/manage/users">Existing users</a></li>
        <li><a href="/manage/emails">Edit emails</a></li>
        <li><a href="/logout">logout</a></li>
    </ul>';
}

// not implemented yet
$cms_nav=cms_nav();

// add a dashboard link if you are the right level of user
if (isset($_SESSION['public_user']['level']) && $_SESSION['public_user']['level']!='Participant') {
    $logged_in_nav='<li><a href="/dashboard">Dashboard</a></li>';
} else {
    $logged_in_nav = '';
}
// the top navigation
$page_control->public_navigation='
<ul class="inline-list right">
    <li><a href="/about">About</a></li>
    <li><a href="/contact">Contact</a></li>
    <li><a href="/help">Help</a></li>
    <li><a href="/login">login/logout</a></li>
    '.$cms_nav.'
    '.$logged_in_nav.'
</ul>';

// if the template is any of thses files
if ($page_control->file=='new_sign_ups.php' || $page_control->file=='users.php' || $page_control->file=='emails.php') {
    // if there are logged in as manager (superuser)
    if (isset($_SESSION['manager'])) {
        if (isset($_GET['delete_user'])) {
            // call delete user functionj
            delete_user($_GET['delete_user']) ;
        }
        if (isset($_GET['suspend_user'])) {
            // call suspend user function
            suspend_user($_GET['suspend_user'])    ;
        }
        if (isset($_GET['restate_user'])) {
            // call reinstate user function
            restate_user($_GET['restate_user'])    ;
        }
        if (isset($_GET['approve_user'])) {
            // call approve user function
            $rnd_pass=approve_user($_GET['approve_user']);			
            // and send an email
			if($rnd_pass !=''){
				send_email($_GET['approve_user'],$rnd_pass,'approval');
			}else{
				send_email($_GET['approve_user'],$rnd_pass,'existinguser_groupapproval');
			}
        }
        if (isset($_POST['update_email'])) {
            // call update email templates function
            update_email($_POST['update_email'],$_POST['app_subject'],$_POST['app_content']);
        }
		
	
        // for updating current form
        $query = "SELECT * FROM `emails` WHERE name='approval'  ";
        $result = $dbpdo->query($query);
        while($r = $result->fetch(PDO::FETCH_BOTH)) {
            $app_subject = $r['subject'];
            $app_message= $r['content'];
        }
		
		$query = "SELECT * FROM `emails` WHERE name='existinguser_groupapproval'  ";
        $result1 = $dbpdo->query($query);
        while($r = $result1->fetch(PDO::FETCH_BOTH)) {
            $app_subject1 = $r['subject'];
            $app_message1= $r['content'];
        }
		
		
    }
}

// add document
if (isset ($_POST['add_doc']) ) {
    // if you are logged in
    if (isset($_SESSION['public_user'])) {
        // clean it up a bit
        $_POST['add_doc']['title']=strip_tags($_POST['add_doc']['title']);
        // add the document
        $stmt = $dbpdo->prepare("INSERT INTO `documents` (`id`, `web_id`, `user_id`, `title`, `content`, `archive`) VALUES (NULL, :site_id,  :user_id, :title, :content , 'No');");
        $stmt->execute(array(
            ':user_id' => $_SESSION['public_user']['user_id'], // the user who added it
            ':site_id' => $_SESSION['public_user']['site_id'],  //the site it is from
            ':title' => $_POST['add_doc']['title'], //title
            ':content' => $_POST['add_doc']['content'] // title
            ));
        // add this documents id as the original
        $this_id=$dbpdo->lastInsertId();
        $query = " update documents set original=$this_id where id=$this_id ";
        $result = $dbpdo->query($query);
    }
}

// editing a document
if (isset ($_POST['edit_doc']) ) {
// are they logged in
    if (isset($_SESSION['public_user'])) {
        // clean up a little
        $_POST['edit_doc']['title']=strip_tags($_POST['edit_doc']['title']);
        // insert the new version
        $stmt = $dbpdo->prepare("INSERT INTO `documents` (`id`, `web_id`, `user_id`, `title`, `content`, `archive`, `original`) VALUES (NULL, :site_id,  :user_id, :title, :content , 'No', :original);");
        $stmt->execute(array(
            ':user_id' => $_SESSION['public_user']['user_id'],
            ':site_id' => $_SESSION['public_user']['site_id'],
            ':title' => $_POST['edit_doc']['title'],
            ':content' => $_POST['edit_doc']['content'],
            ':original' => $_SESSION['this_edit'] //the original document id
            ));
        // make this page the current one
        $goto = "Location: /document_sharing?edit_doc=".$dbpdo->lastInsertId();
        // change he original to archived
        $stmt = $dbpdo->prepare("update `documents` set archive = 'Yes' where id=:id ");
        $stmt->execute(array(
            ':id' => $_GET['edit_doc']
            ));
        //  goto the url
        header ($goto);
    }
}
// re instating documents
if (isset ($_GET['reinstate_doc']) ) {
    // are they logged in
    if (isset($_SESSION['public_user'])) {
        // archive current doc
        $stmt = $dbpdo->prepare("update `documents` set archive = 'Yes' where id=:id and  web_id=:site_id  ");
        $stmt->execute(array(
            ':id' => $_GET['edit_doc'],
            ':site_id' => $_SESSION['public_user']['site_id'],
            ));
        // make archived  current
        $stmt = $dbpdo->prepare("update `documents` set archive = 'No' where id=:id and  web_id=:site_id ");
        $stmt->execute(array(
            ':id' => $_GET['reinstate_doc'],
            ':site_id' => $_SESSION['public_user']['site_id'],
            ));
        // goto current doc
        $goto = "Location: /document_sharing?edit_doc=".$_GET['reinstate_doc'];
        header ($goto);
    }
}

if ($page_control->file=='document_sharing.php') {
    if (isset($_SESSION['public_user'])) {
        // delete a doc
        if (isset ($_GET['delete_doc']) ) {
            $stmt = $dbpdo->prepare("delete from `documents` where  web_id=:site_id and id=:id ");
            $stmt->execute(array(
                ':id' => $_GET['delete_doc'],
                ':site_id' => $_SESSION['public_user']['site_id']
                ));
        }
    }
}

// swap template if editing
if ($page_control->file=='document_sharing.php') {
    if (isset ($_GET['edit_doc']) ) {
        $page_control->file='edit_document.php';
    }
}

// if someone ihas filled in the invitaion form
if (isset ($_POST['invitename']) ) {
    // google code for recapcha
    if($_SERVER['REQUEST_METHOD'] == "POST") {	
        $recaptcha=$_POST['g-recaptcha-response'];
        if(!empty($recaptcha)) {
            $google_url="https://www.google.com/recaptcha/api/siteverify";
            $secret = $site_vars['recaptcha_secret']; // Recaptcha secret
            $ip=$_SERVER['REMOTE_ADDR'];
            $url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;			
            //$res=getCurlData($url);
			//changed by srinu
			$res = file_get_contents($url);			
            $res= json_decode($res, true);
            // if the google is a success
			$dberror=false;
            if($res['success']) {			
				
				$stmt = $dbpdo->query("SELECT count(*) from website where title='".$_POST['title']."'");
				$groupcount = $stmt->fetch(PDO::FETCH_NUM);				
				$stmt = $dbpdo->query("SELECT count(*) from users where email='".$_POST['email']."'");
				$emailcount = $stmt->fetch(PDO::FETCH_NUM);	
			// User registration, if email address is already available or not available in users table and if group name is not available in website table.
				if(($emailcount[0] >= 1) && ($groupcount[0] == 0)){
					$url=ltrim($_POST['url'],'/');
					// sanitise the url
					$url=toAscii($url);
					// add a forward slash
					$url='/'.$url;					
					// serialize th deputies to fit into one field - this is an afterthought so not planned well
					$deps=serialize($_POST['email-deputy']);					
					$stmt = $dbpdo->query("SELECT id from users where email='".$_POST['email']."' limit 1");
					$lastId = $stmt->fetch(PDO::FETCH_NUM);								
					$query = "INSERT INTO `website` (`id`, `name`, `descr`, `pages`, `logo`, `title_pic`, `color`, `email`, `fb`, `twitter`, `active`, `on`,`why`,`title`,`url`) VALUES (NULL, '', '', '0', '', '', '#00469b', '0', '', '', 'No', '0','".$_POST['reason']."','".$_POST['title']."','".$url."')";
					$result = $dbpdo->query($query);					
					$query = $dbpdo->prepare("SELECT id FROM `website` ORDER BY id DESC LIMIT 1");
					$query->execute();
					$latest_wsiteID = $query->fetch(PDO::FETCH_NUM);
					$current_time = date('Y-m-d h:i:s');
					$website_users = "INSERT INTO `website_users` (`id`, `user_id`, `website_id`, `role_on_Website`, `email_preferences`,`registration_date_on_website`) VALUES (NULL, $lastId[0], $latest_wsiteID[0], 'Superuser', '".$deps."','".$current_time."')";
					$wusers = $dbpdo->query($website_users);
					header( "Location: /thank_you" );
					exit;					
				}else if (($emailcount[0] == 0) && ($groupcount[0] == 0)){
					// insert user into users table
					$stmt = $dbpdo->prepare("INSERT INTO `users` (`id`, `name`, `email`)
						VALUES (NULL, :name , :email)");					
					$url=ltrim($_POST['url'],'/');
					// sanitise the url
					$url=toAscii($url);
					// add a forward slash
					$url='/'.$url;					
					// serialize th deputies to fit into one field - this is an afterthought so not planned well
					$deps=serialize($_POST['email-deputy']);
					$stmt->execute(array(
						':name' => $_POST['invitename'],
						':email' => $_POST['email']
						));	
					
					$stmt = $dbpdo->query("SELECT id from users where name='".$_POST['invitename']."' and email='".$_POST['email']."' limit 1");
					$lastId = $stmt->fetch(PDO::FETCH_NUM);					
					$query = "INSERT INTO `website` (`id`, `name`, `descr`, `pages`, `logo`, `title_pic`, `color`, `email`, `fb`, `twitter`, `active`, `on`,`why`,`title`,`url`) VALUES (NULL, '', '', '0', '', '', '#00469b', '0', '', '', 'No', '0','".$_POST['reason']."','".$_POST['title']."','".$url."');";
					$result = $dbpdo->query($query);					
					$query = $dbpdo->prepare("SELECT id FROM `website` ORDER BY id DESC LIMIT 1");
					$query->execute();
					$latest_wsiteID = $query->fetch(PDO::FETCH_NUM);
					$current_time = date('Y-m-d h:i:s');
					$website_users = "INSERT INTO `website_users` (`id`, `user_id`, `website_id`, `role_on_Website`, `email_preferences`,`registration_date_on_website`) VALUES (NULL, $lastId[0], $latest_wsiteID[0], 'Superuser', '".$deps."','".$current_time."')";
					$wusers = $dbpdo->query($website_users);
					header( "Location: /thank_you" );
					exit;
				}else{				
					$dberror=true;
					
				}
            }
        }
    }
}

// contact page form
if (isset ($_POST['contact']) ) {
    // google stuff
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        $recaptcha=$_POST['g-recaptcha-response'];
        if(!empty($recaptcha)) {
            $google_url="https://www.google.com/recaptcha/api/siteverify";
            $secret = $site_vars['recaptcha_secret']; // Recaptcha secret
            $ip=$_SERVER['REMOTE_ADDR'];
            $url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
            $res=getCurlData($url);
            $res= json_decode($res, true);
            // if it is successful
            if($res['success']) {
                // clean up a little
                foreach($_POST['contact'] as $key=>$val) {
                    $_POST[$key]=strip_tags($_POST[$key]);
                    $message.='<p>'.$key.' - '.$val.'</p>';
                }
                // use php mailer
                require 'PHPMailerAutoload.php';
                $mail = new PHPMailer;
                $mail->From = $_POST['contact']['email'];
                $mail->FromName = $_POST['name'];
                $mail->addAddress($site_email);
                $mail->isHTML(true);
                $mail->Subject = 'Contact from Zylum site';
                $mail->Body    = $message;
                if(!$mail->send()) {
                    $_SESSION['message']= 'Message could not be sent.';
                    //echo 'Mailer Error: ' . $mail->ErrorInfo;
                } else {
                    $_SESSION['message']= 'Message has been sent';
                }
            }
        }
    }
}

// invite a contributor
if (isset($_POST['invite_contrib']) ) {
    //if the user is an owner
    if ($_SESSION['public_user']['level']=='Superuser') {
		$get_email = $dbpdo->prepare("select id,email from users where email=:email");
		$get_email->execute(array(            
				':email' =>$_POST['invite_contrib']['email']
				));
		$get_email_count = $get_email->fetch(PDO::FETCH_BOTH);
		
		if($get_email_count['email'] == ''){			
			$stmt = $dbpdo->prepare(" INSERT INTO `users` (`id`, `name`, `email`)
				VALUES (NULL, :name , :email)");
			$stmt->execute(array(
				':name' =>$_POST['invite_contrib']['name'],
				':email' =>$_POST['invite_contrib']['email']
				));
			// get this users id
			$user_id= $dbpdo->lastInsertId();
		}else{
			// get this users id
			$user_id = $get_email_count['id'];		
		}
        
        // send an email to them with their password
        $_SESSION['temp']['message']=$_POST['invite_contrib']['message'];
		if($get_email_count['email'] == ''){
			$rnd_pass=set_password($user_id);
			send_email($user_id,$rnd_pass,'contributor invite');
		}else{
			$rnd_pass='';
			send_email($user_id,$rnd_pass,'contributor invitation for existing users');
		}
        
		$current_time = date('Y-m-d h:i:s');
		$website_users = "INSERT INTO `website_users` (`id`, `user_id`, `website_id`, `role_on_Website`, `email_preferences`,`valid`,`registration_date_on_website`) VALUES (NULL, '".$user_id."', '".$_SESSION['public_user']['site_id']."', 'Contributor','', 1,'".$current_time."')";
		$wusers = $dbpdo->query($website_users);
		
        // pop up message
        $_SESSION['message'].='Invitation sent';
    }
}

// delete contributor and participant
if (isset($_GET['delete_contributor']) ) {
    if ($_SESSION['public_user']['level']=='Superuser') {
        /*$stmt = $dbpdo->prepare('DELETE from users WHERE id = :id' );		
        $stmt->execute(array(':id' => $_GET['delete_contributor']));
		$website_users = $dbpdo->prepare('DELETE from website_users WHERE user_id = :id' );
		$website_users->execute(array(':id' => $_GET['delete_contributor']));*/
		$get_contrib_count = $dbpdo->prepare("select count(user_id) from `website_users` where user_id=:id and role_on_Website='Contributor'");
		$get_contrib_count->execute(array(':id' => $_GET['delete_contributor']));
		$get_del_contrib_count = $get_contrib_count->fetchColumn();
		if($get_del_contrib_count == 1){
			$stmt = $dbpdo->prepare("DELETE from users WHERE id in (select `user_id` from `website_users` where user_id=:id and role_on_Website='Contributor')");
			$stmt->execute(array(':id' => $_GET['delete_contributor']));
		}
		$stmt = $dbpdo->prepare("DELETE from website_users WHERE role_on_Website='Contributor'and user_id =:id ");
		$stmt->execute(array(':id' => $_GET['delete_contributor']));
    }
}

if (isset($_GET['delete_participant']) ) {
	if ($_SESSION['public_user']['level']=='Superuser') {
		$get_participant_count = $dbpdo->prepare("select count(user_id) from `website_users` where user_id=:id and role_on_Website='Participant'");
		$get_participant_count->execute(array(':id' => $_GET['delete_participant']));
		$get_del_participant_count = $get_participant_count->fetchColumn();
		if($get_del_participant_count == 1){
			$stmt = $dbpdo->prepare("DELETE from users WHERE id in (select `user_id` from `website_users` where user_id=:id and role_on_Website='Participant')");
			$stmt->execute(array(':id' => $_GET['delete_participant']));
		}
		$stmt = $dbpdo->prepare("DELETE from website_users WHERE user_id =:id and role_on_Website='Participant'");
		$stmt->execute(array(':id' => $_GET['delete_participant']));
	}
    
}

// add a list of  users
if (isset($_POST['add_lister']) ) {
    if ($_SESSION['public_user']['level']=='Superuser') {
        // split the list apart
        $lines = preg_split ('/$\R?^/m', $_POST['add_lister']);
        // move throgh  emails
        foreach($lines as $key=>$val) {
            $lines[$key]=trim($lines[$key]);
            // is it an email?
            if(filter_var($lines[$key], FILTER_VALIDATE_EMAIL)) {
                // insert it
                $stmt = $dbpdo->prepare(" INSERT INTO `mailing_list` (`id`, `site_id`, `email`, `active`, `pass`) VALUES (NULL, :web , :email  , '1', :pass); ");
                $stmt->execute(array(
                    ':email' => $lines[$key],
                    ':pass' => $pass,
                    ':web' => $_SESSION['public_user']['site_id']
                    ));
            }
        }
    }
}

// add someone to the discussion group
if (isset($_POST['add_disc']) ) {
    // are they an owner
    if ($_SESSION['public_user']['level']=='Superuser') {
        //split the upload into lines
        $lines = preg_split ('/$\R?^/m', $_POST['add_disc']);
        // movce through the lines
        foreach($lines as $key=>$val) {
            $lines[$key]=trim($lines[$key]);
            // is it an email?
            if(filter_var($lines[$key], FILTER_VALIDATE_EMAIL)) {
                //insert it
                $stmt = $dbpdo->prepare(" INSERT INTO `disc_groups` (`id`, `site_id`, `email`, `active`, `pass`) VALUES (NULL, :web , :email  , '1', :pass); ");
                $stmt->execute(array(
                    ':email' => $lines[$key],
                    ':pass' => $pass,
                    ':web' => $_SESSION['public_user']['site_id']
                    ));
            }
        }
    }
}

// delete from the mailing list
if (isset($_GET['delete_lister']) ) {
    // is it an owner
    if ($_SESSION['public_user']['level']=='Superuser') {
        // delete
        $stmt = $dbpdo->prepare('DELETE from mailing_list WHERE id = :id and `site_id`= '.$_SESSION['public_user']['site_id'] );
        $stmt->execute(array(':id' => $_GET['delete_lister']));
    }
}

// delete from a discussion group
if (isset($_GET['delete_dlister']) ) {
    if ($_SESSION['public_user']['level']=='Superuser') {
        $stmt = $dbpdo->prepare('DELETE from disc_groups WHERE id = :id and `site_id`= '.$_SESSION['public_user']['site_id'] );
        $stmt->execute(array(':id' => $_GET['delete_dlister']));
    }
}

// send a mailing list - this vasically call a function
if (isset($_POST['send_mailing_list']) ) {
    if ($_SESSION['public_user']['level']=='Superuser') {
        send_mailing_list($_POST['send_mailing_list']);
    }
}

//invite a participant
if (isset($_POST['invite_part']) ) {
    // is it an owner
    if ($_SESSION['public_user']['level']=='Superuser') {
        //insert the  participant
		$get_email = $dbpdo->prepare("select id,email from users where email=:email");
		$get_email->execute(array(            
				':email' =>$_POST['invite_part']['email']
				));
		$get_email_count = $get_email->fetch(PDO::FETCH_BOTH);		
		if($get_email_count['email'] == ''){
			$stmt = $dbpdo->prepare(" INSERT INTO `users` (`id`, `name`, `email`)
				VALUES (NULL, :name , :email)" );
			$stmt->execute(array(
				':name' =>$_POST['invite_part']['name'],
				':email' =>$_POST['invite_part']['email']
				));
			// get this users id
			$user_id= $dbpdo->lastInsertId();
		}else{
			// get this users id
			$user_id = $get_email_count['id'];		
		}
        // send them an email telling them
        
        $_SESSION['temp']['message']=$_POST['invite_part']['message'];
        if($get_email_count['email'] == ''){
			$rnd_pass=set_password($user_id);
			// call the function
			send_email($user_id,$rnd_pass,'participant invite');
		}else{
			$rnd_pass='';
			// call the function
			send_email($user_id,$rnd_pass,'participant invitation for existing users');
		}
        
		$current_time = date('Y-m-d h:i:s');
		$website_users = "INSERT INTO `website_users` (`id`, `user_id`, `website_id`, `role_on_Website`, `email_preferences`,`valid`,`registration_date_on_website`) VALUES (NULL, '".$user_id."', '".$_SESSION['public_user']['site_id']."', 'Participant','', 1,'".$current_time."')";
		$wusers = $dbpdo->query($website_users);
        // set up a message
        $_SESSION['message'].='Invitation sent';
    }
}

// request a password change
if (isset($_POST['resetemail']) || isset($_GET['resetemail']) ) {
    // if the request is from the forgotten password form - get the email address (if it exists)
    if (isset($_POST['resetemail']) ) {
        $stmt = $dbpdo->prepare(" SELECT * FROM `users` WHERE `email`=:email   ");
        $stmt->execute(array(
            ':email' => $_POST['resetemail']
            ));
        $num_rows = $stmt->rowCount();
    }
    //If it is from an email that has been sent from below
    if (isset($_GET['resetemail']) ) {
        // make sure it is a genuine request (see process below)
        $stmtx = $dbpdo->prepare(" SELECT * from `resets` where id=:id and `pass`=:pass " );
        $stmtx->execute(array(
            ":id" =>$_GET['resetemail'],
            ":pass"=>$_GET['pass']
            ));
        // if it is select the email
        if ($stmtx->rowCount()!=0) {
            $stmt = $dbpdo->prepare(" SELECT * FROM `users` WHERE `id`=:id   ");
            $stmt->execute(array(
                ':id' => $_GET['resetemail']
                ));
        }
        $num_rows = $stmtx->rowCount();
    }
    // counts the results from above - if it is one result an email is sent out with a new password
    // send a reset
    if ($num_rows==1) {
        $data = $stmt->fetch(PDO::FETCH_BOTH);
        $rnd_pass=set_password($data['id']);
        send_email($data['id'],$rnd_pass,'reset');
        $_SESSION['message'].='A new pasword has been sent to you.';
        header( "Location: /login" );
        exit;
    }
    // cant find the email
    else if ($num_rows==0) {
        $_SESSION['message'].='Sorry we cannot find that email in our records';
    }
    // if there are more than one occurences of  the email  a request is sent
    else {
        // $resetlist is the variable which is the email message
        $reset_list='<p>You recently requested a password change at Zylum. If this was not you please ignore this email</p>
        <p>Please select a password to reset:</p>';
        $data = $stmt->fetchAll(PDO::FETCH_BOTH);
        // move through the email
        foreach($data as $key=>$val) {
            $rnd_pass=makeRandomPassword();
            //  insert an id - password key to varify callback
            $query = "INSERT INTO `resets` (`id` ,`pass`) VALUES ('".$data[$key]['id']."', '$rnd_pass') ON DUPLICATE KEY UPDATE   `pass`=VALUES(pass) ";
            $result = $dbpdo->query($query);
            // if it is an owner we need to get the name of the site
            if ($data[$key]['type']=='Superuser') $data[$key]['type']='Owner';
            # @TODO: $r is not (likely) to be defined at this point!!
            if ($r['type']!='Superuser') {
                $queryx = "select * from users where id=".$data[$key]['site_id']." ";
                $resultx = $dbpdo->query($queryx);
                while($rx = $resultx->fetch(PDO::FETCH_BOTH)) {
                    $title=$rx['title'];
                    //$r['url']=$rx['url'];
                }
            }
            // create the list
            $reset_list.= $title.' - '.$data[$key]['type'].' - <a href="https://zylum.org/forgotten_password?resetemail='.$data[$key]['id'].'&pass='.$rnd_pass.'">reset >></a> <br />';
        }
        $reset_list.= '<br />';
        // pop up message
        $_SESSION['message'].='A  pasword reset message has been sent to you.';
        $rnd_pass=set_password($data['id']);
        //send an email
        send_reset_email($data[0]['id'],$rnd_pass,$reset_list);
        // then redirct them
        header( "Location: /login" );
        exit;
    }
}

// logout
if ($_SERVER['REQUEST_URI']=='/logout') {
    session_destroy();
    header( "Location: /login" );
}

// the login process
if (isset ($_POST['login_email']) ) {
    // a debug function
    function pdo_sql_debug($sql,$placeholders) {
        foreach($placeholders as $k => $v) {
            $sql = preg_replace('/:'.$k.'/',"'".$v."'",$sql);
        }
        return $sql;
    }	
    // see if the email password pair are there
    $stmt = $dbpdo->prepare(" SELECT * FROM `users` WHERE `email`=:email AND `password`=:pass  ");
    $stmt->execute(array(
        ':email' => $_POST['login_email'],
        ':pass' => md5($salt.$_POST['login_password'])
        ));
    $num_rows = $stmt->rowCount();
    // if they are there set up session variables which underpin the flow of a logged in user
    if ($num_rows==1) {
        $data = $stmt->fetch(PDO::FETCH_BOTH);
		$_SESSION['public_user']['user_id'] = $data['id']; // user id
        $_SESSION['public_user']['email'] = $data['email']; // user email
        $_SESSION['public_user']['name'] = $data['name']; // user name
        $_SESSION['public_user']['level'] = $data['type']; // type of user
        // get the name and the url of the site
         $query = "select * from website_users where user_id=".$data['id'];
        $result = $dbpdo->query($query);
		$website_users_details = $result->fetchAll(PDO::FETCH_ASSOC);		
		$_SESSION['public_user']['site_title'] = array();
		$_SESSION['public_user']['site_url'] = array();
		$_SESSION['public_user']['site_id'] = array();
		foreach($website_users_details as $website_users_data){
			$website_details_query = "select * from website where id=".$website_users_data['website_id'];
			$website_details_result = $dbpdo->query($website_details_query);
			$website_details = $website_details_result->fetch(PDO::FETCH_ASSOC);
			$_SESSION['public_user']['site_title'][] = $website_details['title']; // site name
			$_SESSION['public_user']['site_url'][] = $website_details['url']; // site url
			$_SESSION['public_user']['site_id'][] = $website_details['id']; // id of the site
		} 
		// To update the last_login date & time.
		$current_time = date('Y-m-d h:i:s');
		$update_last_login = $dbpdo->prepare("update `website_users` set `last_login_date`= :login where user_id= :uid");
		$update_last_login->execute(array(
		':login' => $current_time,
		':uid' => $data['id']
		));
		
		
        // if they are a participant send them to the website
        if  ($_SESSION['public_user']['level']=='Participant') {
            $url=$_SESSION['public_user']['site_url'];
            header( "Location: $url " );
        }
        // if not to the dashboard
        else {
            header( "Location: /dashboard" ); 
        }
    }
}

// back end log in
if (isset ($_POST['admin_email']) ) {
    $stmt = $dbpdo->prepare(" SELECT * FROM `superusers` WHERE `email`=:email AND `password`=:pass  ");
    $stmt->execute(array(
        ':email' => $_POST['admin_email'],
        ':pass' => md5($salt.$_POST['admin_pass'])
        ));
    $num_rows = $stmt->rowCount();
    // if varified set up a session
    if ($num_rows==1) {
        $data = $stmt->fetch(PDO::FETCH_BOTH);
        $_SESSION['manager']['user_id'] = $data['id'];
        $_SESSION['manager']['email'] = $data['email'];
        header ("location: /manage/new");
    }
}

// website controls
// change twitter variable on website
if (isset($_SESSION['public_user']['user_id'])) {
    if (isset($_POST['twitter'])) {	
        $stmt = $dbpdo->prepare(" UPDATE `website` set  `fb`= :fb, twitter= :twitter where title= :web ");
        $stmt->execute(array(
            ':fb' => $_POST['facebook'],
            ':twitter' => $_POST['twitter'],
            ':web' => $_SESSION['public_user']['site_title']
            ));			
    }	
}

if ($page_control->template=='website') {
    // google recaptcha foe email sign up
    if($_SERVER['REQUEST_METHOD'] == "POST") {	
        $recaptcha=$_POST['g-recaptcha-response'];
        if(!empty($recaptcha)) {
            $google_url="https://www.google.com/recaptcha/api/siteverify";
            $secret = $site_vars['recaptcha_secret']; // Recaptcha secret
            $ip=$_SERVER['REMOTE_ADDR'];
            $url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
            //$res=getCurlData($url);
			$res = file_get_contents($url);
            $res= json_decode($res, true);
            // if successful
            if($res['success']) {
				if (isset($_POST['newsletter_email']) && $page_control->web_id!='') {
					$pass=makeRandomPassword();
					// set up an email site password key for email varificaition
					$stmt = $dbpdo->prepare(" INSERT INTO `sign_ups` (`id`, `site_id`, `email`,  `pass`) VALUES (NULL, :web , :email , :pass); ");
					$stmt->execute(array(
						':email' => $_POST['newsletter_email'],
						':pass' => $pass,
						':web' => $page_control->web_id
						));
					$this_id=$dbpdo->lastInsertId();
					// send a confirmation eamil
					send_email($this_id,$pass,'Check sign up');
                }
            }
        }
    }

    // I think this redundant - but I am reluctant to remove it unless vari
    $num_rows=is_site_live($page_control->web_id);
    if ($num_rows==1) {
    } else {
        //$page_control->template='public';
        // $page_control->file= 'login.php';
    }
}

// make site public
if (isset($_GET['turn_it_on'])) {
    $query = "update website set `on`=1 where title='".$_SESSION['public_user']['site_title']."'";
    $result = $dbpdo->query($query);
}

// make site private
if (isset($_GET['turn_it_off'])) {
    $query = "update website set `on`=0 where title='".$_SESSION['public_user']['site_title']."'";
    $result = $dbpdo->query($query);
}

// turn email sign up on
if (isset($_GET['turn_email_on'])) {
    $query = "update website set `email`=1 where id=".$_SESSION['public_user']['site_id'];
    $result = $dbpdo->query($query);
}

// turn email sign up off
if (isset($_GET['turn_email_off'])) {
    $query = "update website set `email`=0 where id=".$_SESSION['public_user']['site_id'];
    $result = $dbpdo->query($query);
}

// add apage
if (isset($_POST['page'])) {
    if (isset($_SESSION['public_user']['user_id'])) {
        // make a url
        $page_url=toAscii($_POST['page']['name']);
        // check if the page exists
        $page_control->error=check_page($page_url);
        if ($page_control->error==0) {
            add_page($_POST['page']['name'],$_POST['page']['news'],$page_url);
        } else {
            $page_control->error='<p class="error">Sorry that page already exists</p>';
        }
    }
}

// add a news item
if (isset($_POST['news'])) {
    if (isset($_SESSION['public_user']['user_id'])  ) {
        //if they have not added a picture
        if (!isset($media_id)) $media_id=0;
		$stmt = $dbpdo->prepare(" INSERT INTO `news` (`id`, `title`, `date`, `web_id`, `page_id`, `content`, `media_id`) VALUES (NULL, :title, CURRENT_TIMESTAMP, :web_id,  :page_id, :content, :media_id) ");
        $stmt->execute(array(
            ':title' => $_POST['news']['title'],
            ':page_id' => $_SESSION['page_id'],
            //':web_id' => $_SESSION['public_user']['site_id'],
			':web_id' => $page_control->web_id,
            ':media_id' => $media_id,
            ':content' => $_POST['news']['content'],
            ));
    }
}

// delete a page
if (isset($_GET['delete_page'])) {
    if (isset($_SESSION['public_user']['user_id']) && $_SESSION['public_user']['level']=='Superuser' ) {
        $stmt = $dbpdo->prepare("delete from pages where id=:page_id and web_id=:web_id ");
        $stmt->execute(array(
            ':page_id' => $_GET['delete_page'],
            ':web_id' => $_SESSION['public_user']['site_id']
            ));
    }
}

// delete a news item
if (isset($_GET['dn'])) {
    if (isset($_SESSION['public_user']['user_id']) && $_SESSION['public_user']['level']=='Superuser' ) {
        $stmt = $dbpdo->prepare("delete from news where id=:news_id and web_id=:web_id ");
        $stmt->execute(array(
            ':news_id' => $_GET['dn'],
            ':web_id' => $_SESSION['public_user']['site_id']
            ));
    }
}
//////////// bc code
if(isset($_GET['url']))
	$surl=$_GET['url'];
elseif ($_SESSION['public_user']['site_url'])
	$surl=$_SESSION['public_user']['site_url'];
else {
		$stmt = $dbpdo->query("SELECT url FROM `website` where id in (SELECT website_id FROM `website_users` where user_id='".$_SESSION['public_user']['user_id']."') Limit 1");
		$surl = $stmt->fetchColumn();
	}
	$stmt = $dbpdo->prepare("SELECT id,title,url FROM `website` where url='".$surl."'");			
	$stmt->execute();
	$data = $stmt->fetch(PDO::FETCH_ASSOC);
	$_SESSION['public_user']['site_title'] = $data['title'];
	$_SESSION['public_user']['site_url'] = $data['url'];
	$_SESSION['public_user']['site_id'] = $data['id'];	
				
	$role_usertype = $dbpdo->prepare("SELECT role_on_Website FROM `website_users` where website_id in (SELECT id FROM `website` where url='".$surl."') and user_id='".$_SESSION['public_user']['user_id']."'");
	$role_usertype->execute();
	$role_on_website = $role_usertype->fetchColumn();
	
	$_SESSION['public_user']['level'] = $role_on_website;	
	
	$user_level     = isset($_SESSION['public_user']['level'])
                  ? $security_group[ $_SESSION['public_user']['level'] ]
                  : 0;
	
	
?>
