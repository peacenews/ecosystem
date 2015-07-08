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

ini_set('display_errors', 0);

$dsn = 'mysql:host=localhost;dbname='; // SQL database name
$user = ""; // SQL username
$pass= ""; // SQL password
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

$dbpdo = new PDO($dsn, $user, $pass, $options);
$dbpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

date_default_timezone_set('UTC');
header('Content-Type: text/html;  charset=UTF-8');

$site_email=''; // Site email
$site_name=''; // Site name
$admin_home=''; // Directory
$this_domain=$_SERVER['HTTP_HOST'];
$salt=''; // salt for md5 hash
$debug='no';

$site_vars[site_email]=''; // Site email
$site_vars[site_name]='';  // Site name
$site_vars[admin_home]='';  // Directory
$site_vars[this_domain]=$_SERVER['HTTP_HOST'];
$site_vars[salt]='';  // salt for md5 hash
$site_vars[debug]='no';
?>
