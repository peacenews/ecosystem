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
session_start();
include ("config.php");

if (isset($_SESSION['public_user']['user_id'])) {
    // cahnge color
    if (isset($_POST['cw'])) {
        $stmt = $dbpdo->prepare(" UPDATE `website` set  `color`= :color where title= :stitle");
        $stmt->execute(array(
            ':color' => $_POST['cw'],
            ':stitle' => $_SESSION['public_user']['site_title']
            ));
    }
    // social
    if (isset($_POST['twitter'])) {
        $stmt = $dbpdo->prepare(" UPDATE `website` set  `fb`= :fb, twitter= :twitter where title= :stitle");
        $stmt->execute(array(
            ':fb' => $_POST['facebook'],
            ':twitter' => $_POST['twitter'],
            ':stitle' => $_SESSION['public_user']['site_title']
            ));
    }
    // page save
    if (isset($_POST['pcontent'])) {
		if ($_SESSION['news_id']==0) {
		$stmt = $dbpdo->prepare(" UPDATE `pages` set  `content`= :content  where id= :pid ");
		$stmt->execute(array(
			':content' => $_POST['pcontent'],
			':pid' => $_SESSION['page_id']
			));
        }
        if ($_SESSION['news_id']!=0) {
		    $stmt = $dbpdo->prepare(" UPDATE `news` set  `content`= :content  where id= :nid");
            $stmt->execute(array(
                ':content' => $_POST['pcontent'],
                ':nid' => $_SESSION['news_id']
                //':pid' => $_SESSION['page_id']
                ));
        }
        echo 'content saved';
    }
    if (isset($_POST['ccontent'])) {
        $stmt = $dbpdo->prepare(" UPDATE `pages` set  `caption`= :content  where id= :pid ");
        $stmt->execute(array(
            ':content' => $_POST['ccontent'],
            ':pid' => $_SESSION['page_id']
            ));
        echo 'caption saved';
    }
}
?>
