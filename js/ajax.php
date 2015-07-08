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

include ("../control/config.php");
ini_set('display_errors', 1);

function toAscii($str) {
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
    $clean = strtolower(trim($clean, '_'));
    $clean = preg_replace("/[\/_|+ -]+/", '-', $clean);
    return $clean;
}

if (isset($_GET['site_title'])) {
    $stmt = $dbpdo->prepare("select id from users WHERE title = :name ");
    // echo "select id from users WHERE title = '$_GET['site_title']'  ";
    $stmt->execute(array(':name' => $_GET['site_title']));
    $num_rows = $stmt->rowCount();
    if ($num_rows>=1) {
        //echo '<img src="/img/kill.png" width="20" height="20">';
        echo '0';
    } else {
        //echo '<img src="/img/tick.gif" width="20" height="20">';
        echo '1';
    }
}

if (isset($_GET['site_titlec'])) {
    echo toAscii($_GET['site_titlec']);
}

if (isset($_GET['site_address'])) {
    $preg_str_check="#[^][ A-Za-z0-9-]#";
    if( preg_match( $preg_str_check, $_GET['site_address'] )) {
        echo 'x';
    } else {
        $_GET['site_address']='/'.$_GET['site_address'];
        $stmt = $dbpdo->prepare("select id from users WHERE url = :url ");
        $stmt->execute(array(':url' => $_GET['site_address']));
        $num_rows = $stmt->rowCount();
        if ($num_rows>=1) {
            //echo '<img src="/img/kill.png" width="20" height="20">';
            echo '0';
        } else {
            //echo '<img src="/img/tick.gif" width="20" height="20">';
            echo '1';
        }
    }
}
?>
