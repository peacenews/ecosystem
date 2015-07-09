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

include ("control/config.php");
$existing=array();

$query = "select * from forwardings ";
$result = $dbpdo->query($query);
while($r = $result->fetch(PDO::FETCH_BOTH)) {
    $existing[$r[id]]=$r[source];
}

echo '<pre>';
print_r($existing);
echo '</pre>';

$sites=array();

$query = "select * from website where active='Yes' ";
$result = $dbpdo->query($query);
while($r = $result->fetch(PDO::FETCH_BOTH)) {
    $sites[$r[id]]=$r[name];
}

echo '<pre>';
print_r($sites);
echo '</pre>';

foreach($sites as $key=>$val) {
    if (!in_array($val,$existing)) {
        $query = "INSERT INTO `forwardings` (`destination`, `source`, `id`) VALUES ('vmail', '$val', NULL); ";
        $result = $dbpdo->query($query);
    }
}

foreach($existing as $key=>$val) {
    if (!in_array($val,$sites)) {
        $query = "delete from  `forwardings` where id=$key";
        $result = $dbpdo->query($query);
    }
}
?>
