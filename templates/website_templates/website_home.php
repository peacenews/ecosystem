<!--
"Peace News Ecosystem" is a CMS developed to allow small groups with no tech' expertise to have an internet presence. Its USP is freedom from choice. You can see one installation of Peace News Ecosystem at https://zylum.org/
Copyright (C) 2014 Zylum Ltd.
admin@zylum.org / 5 Caledonian Rd, London, N1 9DY

Version one of Peace News Ecosystem was authored by http://www.wave.coop/ info@wave.coop

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program.  If not, see http://www.gnu.org/licenses/agpl-3.0.html
-->

<div class="row content">
    <div class="large-2 columns">&nbsp;<?php if ($page_control->error!='') echo '<h3 style="color: red !important;">'.$page_control->error,'</h3>' ?></div>
    <div class="large-8 columns changeh" id="content">
        <?php echo $page_control->page_content ?>
    </div>
    <div class="large-2 columns">&nbsp;</div>
</div>

<?php if ($_SESSION[public_user][site_id]==$page_control->web_id  && $user_level>=2) { ?>
<div class="row content">
    <div class="large-2 columns">&nbsp;</div>
    <div class="large-8 columns changeh" id="content">
        <input name="" type="button" value="Save" id="csave">
        <div id="cresult"></div>
    </div>
    <div class="large-2 columns">&nbsp;</div>
</div>
<?php } ?>

<?php if ($page_control->media_id!='0') { ?>
<div class="row" id="content-image">
    <div class="large-2 columns">&nbsp;</div>
    <div class="large-8 columns website-image">
        <?php echo '<img src="/img/'.$page_control->media_id.'/722" />' ?>
    </div>
    <div class="large-2 columns">
        <div class="website-image-caption">
            <div class="caption-break"></div>
            <p class="caption-content"><?php echo $page_control->page_caption ?></p>
            <?php if ($_SESSION[public_user][site_id]==$page_control->web_id && $user_level>=2) { ?>
            add your caption above<br />
            <input name="" type="button" value="Save" id="capsave">
            <div id="capresult"></div>
            <?php } ?>
            <div class="caption-break"></div>
        </div>
    </div>
</div>
<?php } ?>
<?php if ($page_control->page_type=='Home') { ?>
<div class="row" id="latest-news-home">
    <div class="large-2 columns">&nbsp;</div>
    <div class="large-8 columns">
        <h1 class="change">Latest news</h1>
        <?php page_news($page_control->web_id, $page_control->page_type) ?>
    </div>
    <div class="large-2 columns"></div>
</div>
<?php } ?>
