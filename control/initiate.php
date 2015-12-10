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

//load config
include ("config.php");
//load functions and modules
include("functions.php");
//load modules
session_start();
$page_control->module_list=array(
    "sign_up"
    );
foreach ($page_control->module_list as $key=>$val) {
    $file='modules/'.$val.'.php';
    include($file);
    unset ($file);
}

// the template and content file for the uri
get_template ($page_control->uri);

//start buffering content
ob_start(save_buffer);
$content_file="modules/".$page_control->file;
include ($content_file);
ob_end_flush();
unset($content_file);
//end content
?>
