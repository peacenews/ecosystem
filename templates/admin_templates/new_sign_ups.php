<!--
"Peace News Ecosystem" is a CMS developed to allow small groups with no tech' expertise to have an internet presence. Its USP is freedom from choice. You can see one installation of Peace News Ecosystem at https://zylum.org/
Copyright (C) 2014 Zylum Ltd.
admin@zylum.org / 5 Caledonian Rd, London, N1 9DY

Version one of Peace News Ecosystem was authored by http://www.wave.coop/ info@wave.coop

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program.  If not, see http://www.gnu.org/licenses/agpl-3.0.html
-->

<h1>New users</h1>

<table class="control">
    <tr>
        <th>Name</th>
        <th>email</th>
        <th>Reason for joining</th>
        <th>Delete</th>
        <th>Approve</th>
    </tr>
    <? echo  new_sign_ups()?>
</table>

<h4>Update welcome email:</h4>
<form action="" method="post">
    <input name="app_subject" type="text" value="<? echo $app_subject?>" /><br />
    <textarea name="app_content" cols="" rows="" class="tinymce ta"><? echo $app_message?></textarea><br />
    <input name="update_email" type="hidden" value="approval"/>
    <input name="update" type="submit" value="Update" />
</form>
