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

if (count($_FILES["graphic"])!=0) {
    foreach($_POST["graphic"]["delete"]  as $key=>$val) {
        if ($_SESSION[news_id]!=0) {
            //echo 'deleting '.$key;
            $media_id=delete_image('news',$_SESSION[news_id]);
        }
        else {
            //echo 'deleting '.$key;
            $media_id=delete_image($key,$_SESSION[page_id]);
        }
    }
    foreach($_FILES["graphic"]["name"]  as $key=>$val) {
        if ($_FILES["graphic"]["name"][$key]!='') {
            if ($_FILES["graphic"]["type"][$key]=='image/jpeg' && $_FILES["graphic"]["size"][$key]<='3000000' ) {
                $image_file=$_FILES['graphic']['tmp_name'][$key];
                $return=scaleImageFileToBlob($image_file);
                $blob = $return[0];
                $media_id=save_image($key,$blob);
            }
            else {
                $page_control->error='Sorry, you are only allowed to upload .jpg pictures of less than 3Mb';
            }
        }
    }
}
?>
