<!--
"Peace News Ecosystem" is a CMS developed to allow small groups with no tech' expertise to have an internet presence. Its USP is freedom from choice. You can see one installation of Peace News Ecosystem at https://zylum.org/
Copyright (C) 2014 Zylum Ltd.
admin@zylum.org / 5 Caledonian Rd, London, N1 9DY

Version one of Peace News Ecosystem was authored by http://www.wave.coop/ info@wave.coop

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program.  If not, see http://www.gnu.org/licenses/agpl-3.0.html
-->

<section id="admin-content">
    <div class="row admin-title">
        <div class="large-12 columns">
            <h2 class="bold">documents</h2>
        </div>
    </div>
    <div class="row">
    <div class="large-9 columns">
        <p class="regular" style="font-size:21px;">Write and format your text in collaboration with others. The document can then be exported (downloaded to your own computer). To compare the current text with, or go back to, previous versions, just click on the links at the bottom of the page.</p>
    </div>
    <div class="large-2 columns right">
        <img src="mailing-list-icon.png" alt="" id="dashboard-icon" /> <!-- Mailing list icon -->
    </div>
    <div class="large-12 columns" style="margin-top:40px;">
        <h3>Your shared documents</h3>
        <table style="width:100%;">
        <tr>
            <th>Title</th>
            <th>Last updated</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr> 
        <? list_docs(); ?>
        </table>

    <h3 style="margin-top:100px;">Create a document:</h3>
    <form action="" method="post">
        <p>Title: <input name="add_doc[title]" type="text" required></p>
        <p><textarea  style="width: 500px; height: 600px;" class="sendx" name="add_doc[content]"> </textarea> </p>
        <p><input name="" type="submit" value="Add" class="button green bold"></p>
    </form>
    </div>
    </div>
</section>
