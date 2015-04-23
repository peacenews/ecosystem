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
            <h2 class="bold">e-newsletter &amp; manage e-mail list</h2>
        </div>
    </div>

    <div class="row">
        <div class="large-9 columns">
            <p class="regular">Compose your newsletter in the template below. When you are done, send yourself a test copy by checking the tick box and clicking 'send'. When you are happy with it, uncheck 'send as test', click 'send' and your newsletter will be sent to everyone on your email list. </p>
        </div>
        <div class="large-2 columns right">
            <img src="" alt="" id="dashboard-icon" /> <!-- Mailing list icon -->
        </div>

    <div class="large-12 columns">
    <form action="" method="post">
        <input name="send_mailing_list[sublect]" type="text" placeholder="Subject" value="<? echo $_POST[send_mailing_list][sublect]?>"/>
        <textarea  style="width: 500px; height: 600px;" class="sendx" name="send_mailing_list[content]"><? echo $_POST[send_mailing_list][content]?></textarea>
    </div>
    <div class="large-3 columns right">
    <div class="form-controls">
        <label>send as test:</label> <input name="send_mailing_list[test]" type="checkbox" value="test" checked style="margin-right:20px">
        <input name="" type="submit" value="Send" class="button green bold">
    </form>
    </div>
    </div>

    <div class="large-12 columns email-list-intro">
        <h3>Email List</h3>
        <p>These are the email addresses which you have added, or people who have joined the list using the Email Sign up at the bottom of your Zylum webpages.</p>

        <div class="email-list">
            <? echo mailing_list();?>
        </div>

        <h3 style="margin-top:30px;">Add emails</h3>
        <form action="" method="post">
            <p>(place each email on a seperate line):
            <textarea name="add_lister" cols="40" rows="10" ></textarea></p>
            <p><input name="" type="submit" value="Add" class="button green"/></p>
        </form>
    </div>
    </div>
</section>
