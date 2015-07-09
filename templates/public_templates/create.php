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

echo '<pre>';
print_r($_POST);
print_r($_GET);
print_r($_SESSION);
echo '</pre>';

access_control($_SESSION[user_type],'Superuser');
if (isset ($_POST[site_title]) ) {
    $stmt = $dbpdo->prepare(" INSERT INTO `website` (`id`, `name`, `url`, `descr`, `title_pic`) VALUES (NULL, :name, :url, :descr, ''); ");
    $stmt->execute(array(
        ':name' => $_POST[site_title],
        ':url' => $_POST[site_address],
        ':descr' => $_POST[site_descr]
        ));
    $last_insert=$dbpdo->lastInsertId();
    $query = "UPDATE `users` set site_id=$last_insert WHERE id=$_SESSION[user_id]  ";
    $result = $dbpdo->query($query);
    $_SESSION[site_id] = $last_insert;
    header( "Location: /dashboard" );
}
?>

<h2>Create a new website</h2>
<form method="post" action="" class="group full-form">
    <label for="sitetitle">Site title <span class="required">*</span></label>
    <input type="text" id="site_title" name="site_title" value="" placeholder="site title" required /><a href="#" class="help-q" id="info-sitetitle">?</a><p id="check_site_title"></p>
    <label for="siteurl">Site address<span class="required">*</span></label>
    <input type="text" id="site_address" name="site_address" value="" placeholder="Site address" required /><a href="#" class="help-q" id="info-siteurl">?</a>
    <p id="check_site_address"></p>
    <label for="siteurl">Site description<span class="required">*</span></label>
    <input type="text" id="site_descr" name="site_descr" value="" placeholder="Site description" /><a href="#" class="help-q" id="info-siteurl">?</a>
    <input id="create" type="submit" value="Make new site" id="submit-button"/>
</form>
