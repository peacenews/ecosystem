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

ini_set('display_errors', 1);

// get the template and content file
function new_sign_ups() {
    global $page_control;
    global $dbpdo;
    $query = "SELECT * FROM `users` WHERE `valid`='No' AND `type`='Superuser'  ";
    $result = $dbpdo->query($query);
    while($r = $result->fetch(PDO::FETCH_BOTH)) {
        $url=ltrim($r['url'],'/');
        echo '<tr>
        <td>'.$r['name'].'</td>
        <td>'.$r['email'].'</td>
        <td>'.$r['why'].'</td>
        <td><input name="url" type="text" class="uurl" value="'.$url.'"/></td>
        <td class="delete"><a href="?delete_user='.$r['id'].'" class="confirm">delete</a></td>
        <td class="approve"><a href="?approve_user='.$r['id'].'" class="confirm">approve and send email</a></td>
    </tr>';
    }
}

function getCurlData($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
    $curlData = curl_exec($curl);
    curl_close($curl);
    return $curlData;
}

function list_docs() {
    global $page_control;
    global $dbpdo;
    global $_SESSION;
    $query = "SELECT * FROM `documents` where web_id=".$_SESSION['public_user']['site_id']." and `archive`='No' ";
    $result = $dbpdo->query($query);
    while($r = $result->fetch(PDO::FETCH_BOTH)) {
        echo '<tr>
        <td>'.$r['title'].'</td>
        <td>'.$r['timestamp'].'</td>
        <td><a href="?edit_doc='.$r['id'].'">edit</a></td>
        <td><a href="?delete_doc='.$r['id'].'" class="confirm ">delete</a></td>
    </tr>';
    }
}

function edit_document($id, $original=0) {
    global $dbpdo;
    $query = "select * from documents where id=$id and archive='No' AND  web_id=".$_SESSION['public_user']['site_id']." ";
    $result = $dbpdo->query($query);
    while($r = $result->fetch(PDO::FETCH_BOTH)) {
        $_SESSION['this_edit']=$r['original'];
        ?>
        <form action="" method="post">
            <p>Title: <input name="edit_doc[title]" type="text" value="<?php echo $r['title'] ?>" required></p>
            <p><textarea  style="width: 500px; height: 600px;" class="sendx" name="edit_doc[content]"><?php echo $r['content'] ?></textarea> </p>
            <p><input name="" type="submit" value="Save revision"></p>
        </form>
        <?php }
    }

    function get_revisions($id) {
        global $page_control;
        global $dbpdo;
        global $_SESSION;
        $query = "SELECT * FROM `documents` where web_id=".$_SESSION['public_user']['site_id']." and `archive`='Yes'  and `original`=".$_SESSION['this_edit']." order by `timestamp` desc ";
    // echo $query;
        $result = $dbpdo->query($query);
        while($r = $result->fetch(PDO::FETCH_BOTH)) {
            echo '<tr>
            <td>'.$r['title'].'</td>
            <td>'.$r['timestamp'].'</td>
            <td><a href="'.$_SESSION['public_user']['site_url'].'/documents/'.$r['id'].'" target="_blank">preview</a></td>
            <td><a href="?delete_doc='.$r['id'].'">delete</a></td>
            <td><a href="/document_sharing?edit_doc='.$_GET['edit_doc'].'&reinstate_doc='.$r['id'].'">reinstate</a></td>
        </tr>';
    }
}

function existing_users($page_control) {
    global $page_control;
    global $dbpdo;
    global $_POST;
    // echo '<pre>';
    // print_r($page_control);
    // echo '</pre>';
    if ($page_control->uri=='/manage/users/owners')  $sql="`valid`='Yes'  and `type`='Superuser' ";
    if ($page_control->uri=='/manage/users/all') $sql="`valid`='Yes'  ";
    if ($page_control->uri=='/manage/users') $sql="`valid`='Yes'  ";
    if ($page_control->uri=='/manage/users/suspended')  $sql="`valid`='No'  ";
    if (isset($_POST['usearch']))  $sql="  `email` like '%".$_POST['usearch']."%' ";
    $query = "SELECT * FROM `users` WHERE   $sql  order by `email` ";
    //echo $query;
    $result = $dbpdo->query($query);
    while($r = $result->fetch(PDO::FETCH_BOTH)) {
        if ($r['valid']=='Yes')  $drop = '<td class="delete"><a href="?suspend_user='.$r['id'].'" class="confirm">suspend</a></td>';
        if ($r['valid']=='No')  $drop = '<td class="delete"><a href="?restate_user='.$r['id'].'" class="confirm">re-instate</a></td>';
        if ($r['type']=='Superuser') $r['type']='Owner';
        if ($r['type']!='Superuser') {
            $queryx = "select * from users where id=".$r['site_id']." ";
            $resultx = $dbpdo->query($queryx);
            while($rx = $resultx->fetch(PDO::FETCH_BOTH)) {
                $r['title']=$rx['title'];
                $r['url']=$rx['url'];
            }
        }
        $deps=implode(', ',unserialize($r['deputies']));
        echo '<form ><tr>
        <td>'.$r['name'].'</td>
        <td>'.$r['email'].'</td>
        <td>'.$deps.'</td>
        <td>'.$r['why'].'</td>
        <td>'.$r['title'].'</td>
        <td>'.$r['url'].'</td>
        <td>'.$r['type'].'</td>
        '.$drop.'
        <td class="delete confirm"><a href="?delete_user='.$r['id'].'">delete</a></td>
    </tr></form >';
    }
}

function contributors() {
    global $page_control;
    global $dbpdo;
    $query = "SELECT * FROM `users` WHERE `valid`='yes' AND `type`='Contributor' and `site_id`='".$_SESSION['public_user']['site_id']."' order by email  ";
    //echo $query;
    $result = $dbpdo->query($query);
    while($r = $result->fetch(PDO::FETCH_BOTH)) {
        echo '<p><a href="/contributors?delete_contributor='.$r['id'].'" class="confirm">Delete</a> '.$r['email'].'</p>';
    }
}

function participants() {
    global $page_control;
    global $dbpdo;
    $query = "SELECT * FROM `users` WHERE `valid`='yes' AND `type`='Participant' and `site_id`='".$_SESSION['public_user']['site_id']."'  order by email ";
    //echo $query;
    $result = $dbpdo->query($query);
    while($r = $result->fetch(PDO::FETCH_BOTH)) {
        echo '<p><a href="/contributors?delete_contributor='.$r['id'].'" class="confirm">Delete</a> '.$r['email'].'</p>';
    }
}

function mailing_list() {
    global $page_control;
    global $dbpdo;
    $query = "SELECT * FROM `mailing_list` WHERE  `site_id`='".$_SESSION['public_user']['site_id']."'  ";
    //echo $query;
    $result = $dbpdo->query($query);
    while($r = $result->fetch(PDO::FETCH_BOTH)) {
        echo '<p><a href="/mailing_list?delete_lister='.$r['id'].'"  class="confirm">Delete</a> '.$r['email'].'</p>';
    }
}

function mailing_disc() {
    global $page_control;
    global $dbpdo;
    $query = "SELECT * FROM `disc_groups` WHERE  `site_id`='".$_SESSION['public_user']['site_id']."'  ";
    //echo $query;
    $result = $dbpdo->query($query);
    while($r = $result->fetch(PDO::FETCH_BOTH)) {
        echo '<p><a href="/mailing_list?delete_dlister='.$r['id'].'" class="confirm">Delete</a> '.$r['email'].'</p>';
    }
}

function cms_nav() {
}

function access_control($user_type, $type) {
    if ($user_type!=$type) header( "Location: /login");
}

function send_mailing_list($send_data) {
    global $dbpdo;
    require 'PHPMailerAutoload.php';
    require 'html2text.php';
    $text = convert_html_to_text($send_data['content']);
    $mail = new PHPMailer;
    $mail->From = 'noreply@zylum.org';
    $mail->FromName = 'No reply @ Zylum';
    $mail->addAddress( 'noreply@zylum.org', 'noreply@zylum.org');
    if ($send_data['content']!='test') {
        $query = "SELECT * FROM `mailing_list` WHERE  `site_id`='".$_SESSION['public_user']['site_id']."'  ";
        $result = $dbpdo->query($query);
        while($r = $result->fetch(PDO::FETCH_BOTH)) {
            $mail->addBCC($r['email']);
        }
        $mail->addBCC($_SESSION['public_user']['email']);
    }
    //$unsubscribe='<p><a href="https://zylum.org/unsub?">Click here to unsubscribe to this list</a></p>';
    //$send_data['content'].=$unsubscribe;
    $mail->addReplyTo('noreply@zylum.org', 'noreply@zylum.org');
    $mail->isHTML(true);
    $mail->Subject = $send_data['sublect'];
    $mail->Body    = $send_data['content'];
    $mail->AltBody = $text;

    if(!$mail->send()) {
        $_SESSION['message']= 'Message could not be sent.';
        //echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        $_SESSION['message']= 'Message has been sent';
    }
}

function makeRandomPassword() {
    $salt = "abchefghjkmnpqrstuvwxyz0123456789!@&%$ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    srand((double)microtime()*1000000);
    $i = 0;
    while ($i <= 10) {
        $num = rand() % 50;
        $tmp = substr($salt, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
    return $pass;
}

// save output
function save_buffer($buffer) {
    global $page_control;
    $page_control->content=$buffer;
}

function  delete_user($user_id) {
    global $dbpdo;
    $stmt = $dbpdo->prepare('DELETE from users WHERE id = :id');
    $stmt->execute(array(':id' => $user_id));
    $stmt = $dbpdo->prepare('delete from forwardings  WHERE id = :id');
    $stmt->execute(array(':id' => $user_id));
}

function  suspend_user($user_id) {
    global $dbpdo;
    $stmt = $dbpdo->prepare('update  users  set `valid`=\'No\' WHERE id = :id');
    $stmt->execute(array(':id' => $user_id));
    $stmt = $dbpdo->prepare('delete from forwardings  WHERE id = :id');
    //echo  "delete from forwardings  WHERE id = $user_id ";
    $stmt->execute(array(':id' => $user_id));
}


function  restate_user($user_id) {
    global $dbpdo;
    $stmt = $dbpdo->prepare('update  users  set `valid`=\'Yes\' WHERE id = :id');
    $stmt->execute(array(':id' => $user_id));
    $query = "select url from users where  id=$user_id ";
    $result= $dbpdo->query($query);
    $mysql_result = $result->fetch(PDO::FETCH_BOTH);
    $url=$mysql_result[0];
    $disc=ltrim($url,'/');
    $query = "INSERT INTO `forwardings` (`destination`, `source`, `id`) VALUES ('vmail', '$disc', $user_id)";
    $result = $dbpdo->query($query);
}

function  set_password($user_id) {
    global $dbpdo;
    global $salt;
    $rnd_pass=makeRandomPassword();
    // echo $rnd_pass;
    $stmt = $dbpdo->prepare("UPDATE users set `password`= :pass WHERE id = :id");
    $stmt->execute(array(
        ':id' => $user_id,
        ':pass' => md5($salt.$rnd_pass)
        ));
    return $rnd_pass;
}

function send_email($user_id,$rnd_pass,$email) {
    global $dbpdo;
    global $site_name;
    global $site_email;
    global $site_vars;
    $query = "SELECT * FROM `emails` WHERE name='$email'  ";
    $result = $dbpdo->query($query);
    while($r = $result->fetch(PDO::FETCH_BOTH)) {
        $subject = $r['subject'];
        $message= $r['content'];
    }
    if ($email=='Check sign up') {
        $stmt = $dbpdo->prepare("SELECT email from sign_ups  WHERE id = :id");
        $stmt->execute(array(
            ':id' => $user_id
            ));
        while($r = $stmt->fetch(PDO::FETCH_BOTH)) {
            $to_email = $r['email'];
            $to_name = $r['email'];
        }
        $link= 'https://zylum.org/?email_id='.$user_id.'&pass='.$rnd_pass.'';
    } else {
        $stmt = $dbpdo->prepare("SELECT name,email from users  WHERE id = :id");
        $stmt->execute(array(
            ':id' => $user_id
            ));
        while($r = $stmt->fetch(PDO::FETCH_BOTH)) {
            $to_email = $r['email'];
            $to_name = $r['name'];
        }
    }

    $site=$site_vars['this_domain'].$_SESSION['public_user']['site_url'];
    $message= str_replace("||pass||", $rnd_pass, $message);
    $message= str_replace("||name||", $to_name, $message);
    $message= str_replace("||site name||", $site_name, $message);
    $message= str_replace("||site url||", $site, $message);
    $message= str_replace("||sub site name||", $_SESSION['public_user']['site_title'], $message);
    $message= str_replace("||inviter||", $_SESSION['public_user']['name'], $message);
    $message= str_replace("||message||", $_SESSION['temp']['message'], $message);
    $message= str_replace("||link||", $link, $message);
    //echo $message;

    // To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    // Additional headers
    $headers .= 'To: '.$to_name.' <'.$to_email.'>' . "\r\n";
    $headers .= 'From: '.$site_name.' <'.$site_email.'>' . "\r\n";
    $headers .= 'Bcc: '.$site_email.'' . "\r\n";
    // Mail it
    mail($to, $subject, $message, $headers);
}

function send_reset_email($user_id,$rnd_pass,$message) {
    global $dbpdo;
    global $site_name;
    global $site_email;
    global $site_vars;
    $subject ='Zylum password reset';
    $stmt = $dbpdo->prepare("SELECT name,email from users  WHERE id = :id");
    $stmt->execute(array(
        ':id' => $user_id
        ));
    while($r = $stmt->fetch(PDO::FETCH_BOTH)) {
        $to_email = $r['email'];
        $to_name = $r['name'];
    }

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    // Additional headers
    $headers .= 'To: '.$to_name.' <'.$to_email.'>' . "\r\n";
    $headers .= 'From: '.$site_name.' <'.$site_email.'>' . "\r\n";
    $headers .= 'Bcc: '.$site_email.'' . "\r\n";
    // Mail it
    mail($to, $subject, $message, $headers);
}

function  approve_user($user_id) {
    global $dbpdo;
    $stmt = $dbpdo->prepare("UPDATE users set `valid`='Yes', `site_id`=$user_id WHERE id = :id");
    $stmt->execute(array(':id' => $user_id));
    $rnd_pass=set_password($user_id);
    $query = "select url from users where  id=$user_id ";
    $result= $dbpdo->query($query);
    $mysql_result = $result->fetch(PDO::FETCH_BOTH);
    $url=$mysql_result[0];
    $disc=ltrim($url,'/');
    $query = "INSERT INTO `website` (`id`, `name`, `descr`, `pages`, `logo`, `title_pic`, `color`, `email`, `fb`, `twitter`, `active`, `on`) VALUES ($user_id, '', '', '0', '', '', '#00469b', '0', '', '', 'No', '0');";
    $result = $dbpdo->query($query);
    $query = "INSERT INTO `forwardings` (`destination`, `source`, `id`) VALUES ('vmail', '$disc', $user_id)";
    $result = $dbpdo->query($query);
    $query = "INSERT INTO .`pages` (`id`, `name`, `url`, `type`, `web_id`, `content`, `pic`, `caption`) VALUES (NULL, '', '', 'Home', $user_id, '<h1>Add your Heading for your introduction here</h1>
        <h2>Add your introduction to your first story here. Join us if you also believe that imagination and fun can change the world for the better!</h2>
        <p>Start typing or insert your copy here…</p>', '', ''); ";
    $result = $dbpdo->query($query);
    $query = "INSERT INTO .`pages` (`id`, `name`, `url`, `type`, `web_id`, `content`, `pic`, `caption`) VALUES (NULL, 'News', 'news', 'News', $user_id, '', '', ''); ";
    $result = $dbpdo->query($query);
    return $rnd_pass;
}

function update_email($which,$subject,$content) {
    global $dbpdo;
    $stmt = $dbpdo->prepare("UPDATE emails set `subject`= :subject, content= :content WHERE name = :which");
    // echo "UPDATE emails set `subject`= $subject, content= $content WHERE name = $which";
    $stmt->execute(array(
        ':subject' => $subject,
        ':content' => $content,
        ':which' => $which
        ));
}

function website($wstart, $web_id) {
    global $dbpdo;
    // is the website configured?
}

function is_site_live($id) {
    global $dbpdo;
    $query = "select `on` from  website where  id=$id   ";
    //echo  "select * from  users where  id=$id and site_id!=0 ";
    $result = $dbpdo->query($query);
    while($r = $result->fetch(PDO::FETCH_BOTH)) {
        $on=$r['on'];
    }
    return $on;
}

function is_email_on($id) {
    global $dbpdo;
    $query = "select `email` from  website where  id=$id   ";
    //echo  "select * from  users where  id=$id and site_id!=0 ";
    $result = $dbpdo->query($query);
    while($r = $result->fetch(PDO::FETCH_BOTH)) {
        $on=$r['email'];
    }
    return $on;
}

function site_info() {
    // echo '<pre>';
    // print_r($_SESSION);
    //echo '</pre>';  */
    $num_rows=is_site_live($_SESSION['public_user']['site_id']);
    //echo '<p>Name: '.$_SESSION['public_user']['site_title'].'</p>';
    //echo '<p>url: <a href="http://zylum.org'.$_SESSION['public_user']['site_url'].'" target="_blank">http://zylum.org'.$_SESSION['public_user']['site_url'].'</a></p>';
    if ($_SESSION['public_user']['level']=='Superuser') {
        if ( $num_rows!=1) {
            echo '<a href="'.$this_domain.$_SESSION['public_user']['site_url'].'?turn_it_on">Make your site public</a>';
        } else {
            echo '<a href="'.$this_domain.$_SESSION['public_user']['site_url'].'?turn_it_off">Make your site private</a>    ';
        }
    }
}

function email_info() {
    $num_rows=is_email_on($_SESSION['public_user']['site_id']);
    if ($_SESSION['public_user']['level']=='Superuser') {
        if ( $num_rows==1) {
            echo '<a href="'.$this_domain.$_SESSION['public_user']['site_url'].'?turn_email_off">Remove Email Sign up</a>';
        } else {
            echo '<a href="'.$this_domain.$_SESSION['public_user']['site_url'].'?turn_email_on">Add Email Sign up</a>    ';
        }
    }
}

function toAscii($str) {
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
    $clean = strtolower(trim($clean, '_'));
    $clean = preg_replace("/[\/_|+ -]+/", '_', $clean);
    return $clean;
}

function check_page($page_name) {
    global $dbpdo;
    if ($page_name!='documents') {
        $query = "select * from pages where web_id=".$_SESSION['public_user']['site_id']." and `url`='$page_name'  ";
        $result = $dbpdo->query($query);
        $num_rows = $result->rowCount();
        return $num_rows;
    } else {
        return 0;
    }
}

function add_page($page_name, $type, $page_url) {
    global $dbpdo;
    if ($type=='') $type='Page';
    $stmt = $dbpdo->prepare("INSERT INTO .`pages` (`id`, `name`, `url`, `type`, `web_id`, `content`, `pic`, `caption`) VALUES (NULL, :page, :url, :type, ".$_SESSION['public_user']['site_id'].",
        '<h1>Add your Heading for your introduction here</h1><h2>Add your introduction to your first story here. Join us if you also believe that imagination and fun can change the world for the better!</h2>
        <p>Start typing or insert your copy here…</p>', '', ''); ");
    // echo "UPDATE emails set `subject`= $subject, content= $content WHERE name = $which";
    $stmt->execute(array(
        ':page' => $page_name,
        ':type' => $type,
        ':url' => $page_url
        ));

}

function scaleImageFileToBlob($file) {
    ini_set('display_errors', 1);
    $source_pic = $file;
    //echo  $source_pic.' xxxx';
    $max_width = 772;
    $max_height =1000;
    list($width, $height, $image_type) = getimagesize($file);
    // echo '<pre>';
    // print_r(getimagesize($file));
    // echo '</pre>';
    switch ($image_type) {
        case 1: $src = imagecreatefromgif($file); break;
        case 2: $src = imagecreatefromjpeg($file);  break;
        case 3: $src = imagecreatefrompng($file); break;
        default: return '';  break;
    }

    $x_ratio = $max_width / $width;
    $y_ratio = $max_height / $height;

    if( ($width <= $max_width) && ($height <= $max_height) ) {
        $tn_width = $width;
        $tn_height = $height;
    } elseif (($x_ratio * $height) < $max_height) {
        $tn_height = ceil($x_ratio * $height);
        $tn_width = $max_width;
    } else {
        $tn_width = ceil($y_ratio * $width);
        $tn_height = $max_height;
    }

    $tmp = imagecreatetruecolor($tn_width,$tn_height);

    /* Check if this image is PNG or GIF, then set if Transparent*/
    if(($image_type == 1) OR ($image_type==3)) {
        imagealphablending($tmp, false);
        imagesavealpha($tmp,true);
        $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
        imagefilledrectangle($tmp, 0, 0, $tn_width, $tn_height, $transparent);
        //imagefilledrectangle($tmp, 0, 0, $width, $height, $transparent);
    }
    imagecopyresampled($tmp,$src,0,0,0,0,$tn_width, $tn_height,$width,$height);
    //   imagecopyresampled($tmp,$src,0,0,0,0,$width, $height,$width,$height);

    /*
     * imageXXX() only has two options, save as a file, or send to the browser.
     * It does not provide you the oppurtunity to manipulate the final GIF/JPG/PNG file stream
     * So I start the output buffering, use imageXXX() to output the data stream to the browser,
     * get the contents of the stream, and use clean to silently discard the buffered contents.
     */
    ob_start();

    switch ($image_type)
    {
        case 1: imagegif($tmp); break;
        case 2: imagejpeg($tmp, NULL, 100);  break; // best quality
        case 3: imagepng($tmp, NULL, 0); break; // no compression
        default: echo ''; break;
    }

    $final_image = ob_get_contents();
    ob_end_clean();
    return array($final_image,$height,$width);
    //echo $final_image;
} // end function scaleImageFileToBlob($file)

function save_image($type,$blob) {
    global $dbpdo;
    $page_id=$_SESSION['page_id'];
    $news_id=$_SESSION['news_id'];
    $blob= addslashes($blob);
    $query = "insert into media (`id`, `media`) values (NULL, '$blob') ";
    $result = $dbpdo->query($query);
    $media_id=$dbpdo->lastInsertId();
    if ($type=='cimage') {
        if ($_SESSION['news_id']==0) {
            $query = "update pages set pic=$media_id where id=$page_id ";
            $result = $dbpdo->query($query);
        }
        if ($_SESSION['news_id']!=0) {
            $query = "update news set media_id=$media_id where page_id=$page_id and id=$news_id ";
            $result = $dbpdo->query($query);
        }
    }
    if ($type=='logo') {
        $query = "update `website` set `logo`=$media_id where id=".$_SESSION['public_user']['site_id']." ";
        $result = $dbpdo->query($query);
    }
    if ($type=='banner') {
        $query = "update `website` set `title_pic`=$media_id where id=".$_SESSION['public_user']['site_id']." ";
        $result = $dbpdo->query($query);
    }
    return $media_id;
}

function delete_image($type,$page_id) {
    global $dbpdo;
    if ($type=='news') {
        $query = "update news set media_id=0 where id=$page_id ";
        $result = $dbpdo->query($query);
    }
    if ($type=='cimage') {
        $query = "update pages set pic=0 where id=$page_id ";
        $result = $dbpdo->query($query);
    }
    if ($type=='logo') {
        $query = "update `website` set `logo`=0 where id=".$_SESSION['public_user']['site_id']." ";
        $result = $dbpdo->query($query);
    }
    if ($type=='banner') {
        $query = "update `website` set `title_pic`=0 where id=".$_SESSION['public_user']['site_id']." ";
        $result = $dbpdo->query($query);
    }
}

function shorten($string,$length) {
    $nohtml=strip_tags($string);
    $chunks = explode(' ', $nohtml);
    for ($i=0; $i<=$length; $i++) {
        $out.=$chunks[$i].' ';
    }
    return $out;
}

function page_news($page_id, $type, $news_id='') {
    global $dbpdo;
    global $page_control;
    //echo $news_id;
    $query = "select * from news where page_id=$page_id  order by `date` desc  ";
    if ($type=='Home') $query = "select * from news where web_id=".$page_control->web_id."  order by `date` desc limit 1  ";
    if ($news_id!='') $query = "select * from news where id=$news_id AND  web_id=".$page_control->web_id."   ";
    //echo $query;
    if ($news_id!='') $full='full';
    $result = $dbpdo->query($query);
    while($r = $result->fetch(PDO::FETCH_BOTH)) {
        $date=date('d-m-y',strtotime($r['date']));
        echo '<div class="'.$full.'news">';
        if ($news_id!='') {
            $float='  style="float: unset;" ';
        }
        if ($r['media_id']!=0) {
            echo '<p><img src="/img/'.$r['media_id'].'/772" '.$float.'/></p>';
        }
        echo "<h2 id=\"news_header\" style=\"margin-top: 20px;\">".$r['title']."</h2>";
        echo "<p><strong>$date</strong></p>";
        if ($news_id!='') {
            echo '<div id="content">'.$r['content'].'</div>';
        } else {
            echo '<p>';
            echo shorten($r['content'], 100);
            echo ' . . . . <a href="'.$page_control->extension.'/news/'.$r['id'].'">read more &gt</a><p>';
        }
        echo '</div>';
    }
}

function docs() {
    global $dbpdo;
    global $page_control;
    global $doc_id;
    global $user_level;
    //echo '|'.$doc_id.'|';
    if ($_SESSION['public_user']['site_id']==$page_control->web_id && $user_level>=1) {
        if ($doc_id!='') {
            $query = "select * from documents where web_id=".$_SESSION['public_user']['site_id']."   and id=$doc_id ";
            $result = $dbpdo->query($query);
            while ($r = $result->fetch(PDO::FETCH_BOTH)) {
                echo $r['content'];
                $_SESSION['rtf_web']=$page_control->web_id;
                echo '
                <p class="print" onclick="window.print()">Print</p>
                <!-- <a href="/doc/'.$doc_id.'" target="_blank"><p class="rtf">Download as RTF</p></a> -->
                ';
            }
        } else {
            $query = "select * from documents where web_id=".$_SESSION['public_user']['site_id']."  and archive='No' ";
            $result = $dbpdo->query($query);
            while ($r = $result->fetch(PDO::FETCH_BOTH)) {
                echo '<p><a href="'.$page_control->extension.'/documents/'.$r['id'].'">'.$r['title'].'  read >> </a></p>';
            }
        }
    }
}

function email_lists() {
    global $dbpdo;
    $query = "select * from emails ";
    $result = $dbpdo->query($query);
    while($r = $result->fetch(PDO::FETCH_BOTH)) {
        echo '<li><a href="/manage/emails?m='.$r['id'].'">'.$r['name'].'</a></li>';
    }
}

function edit_email() {
    global $_GET;
    global $dbpdo;
    if (isset ($_GET['m'])) {
        $query = "select * from emails where id=".$_GET['m']." ";
        $result = $dbpdo->query($query);
        while($r = $result->fetch(PDO::FETCH_BOTH)) { ?>
        <form action="" method="post">
            <input name="app_subject" type="text" value="<?php echo $r['subject'] ?>" /><br />
            <textarea name="app_content" cols="" rows="" class="tinymce ta"><?php echo $r['content'] ?></textarea><br />
            <input name="update_email" type="hidden" value="<?php echo $r['name'] ?>"/>
            <input name="update" type="submit" value="Update" />
        </form>
        <?php }
    }
}

function messages() {
    if ($_SESSION['message']!='') {
        echo '<div id="confirmx">'.$_SESSION['message'].'</div>';
        $_SESSION['message']='';
    }
}
?>
