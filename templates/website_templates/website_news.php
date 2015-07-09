<!--
"Peace News Ecosystem" is a CMS developed to allow small groups with no tech' expertise to have an internet presence. Its USP is freedom from choice. You can see one installation of Peace News Ecosystem at https://zylum.org/
Copyright (C) 2014 Zylum Ltd.
admin@zylum.org / 5 Caledonian Rd, London, N1 9DY

Version one of Peace News Ecosystem was authored by http://www.wave.coop/ info@wave.coop

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program.  If not, see http://www.gnu.org/licenses/agpl-3.0.html
-->

<div class="row content" id="latest-news-home">
    <div class="large-2 columns">&nbsp;</div>
    <div class="large-8 columns">
        <h1 class="change">Latest news</h1>
        <?php if ($_SESSION[public_user][site_id]==$page_control->web_id  && $user_level>=2) { ?>
        <button class="light green" id="add-news-button">Add news post</button>
        <div class="add-news">
            <form action="" method="post" enctype="multipart/form-data">
                <?php if ($page_control->error!='') echo '<h3 style="color: red !important;">'.$page_control->error,'</h3>' ?>
                <p>Title: <input name="news[title]" type="text"><br><input type="file"  name="graphic[news]"/></p>
                <textarea name="news[content]" cols="" rows="" id="id_news"></textarea>
                <p><input name="" type="submit" value="Save post"></p>
            </form>
        </div>
        <?php } ?>

        <?php page_news($_SESSION[page_id],$page_control->page_type, $news_id) ?>
        <?php if ($_SESSION[public_user][site_id]==$page_control->web_id && $news_id!='' && $user_level>=2) { ?>

        <input name="" type="button" value="Save" id="csave"> <a href="<?php echo $_SESSION[public_user][site_url] ?>?dn=<?php echo $_SESSION[news_id] ?>" class="confirm">Delete</a>
        <div id="cresult"></div>

        <?php } ?>
    </div>
    <div class="large-2 columns">&nbsp;</div>
</div>
