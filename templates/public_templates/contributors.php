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
            <h2 class="bold">contributors and participants</h2>
        </div>
    </div>

    <div class="row" id="participate-form">
        <div class="large-12 columns">
            <h3>manage users and your email discussion group</h3>
            <p>The owner of the site can invite three types of users: contributors, participants and discussion list members.</p>
        </div>
    </div>

    <!-- Contributors -->
    <div class="row" id="participate-form">
        <div class="large-6 columns">
            <h3>Your contributors:</h3>
            <p>a contributor can edit your group website and blog, send e-newsletters and manage your email list in addition to the privileges of a participant.</p>
            <div style="height: 300px; width: 500px; overflow: auto;">
                <?php echo  contributors() ?>
            </div>
        </div>
        <div class="large-6 columns">
            <h3>Invite a contributor</h3>
            <form action="" method="post">
                <input name="invite_contrib[name]" type="text" placeholder="name" required><br />
                <input name="invite_contrib[email]" type="email" placeholder="email" required><br />
                <textarea name="invite_contrib[message]"  placeholder="message" cols="20" rows="4"> </textarea><br />
                <input name="" type="submit" value="send" class="button bold"></p>
            </form>
        </div>
    </div>

    <!-- Participants -->
    <div class="row" id="participate-form">
        <div class="large-6 columns">
            <h3>Your participants:</h3>
            <p>a participant can create and share documents and take part in the discussion email group.</p>
            <div style="height: 300px; width: 500px; overflow: auto;">
                <?php echo  participants() ?>
            </div>
        </div>
        <div class="large-6 columns">
            <h3>Invite a participant</h3>
            <form action="" method="post">
                <input name="invite_part[name]" type="text" placeholder="name" required><br />
                <input name="invite_part[email]" type="email" placeholder="email" required> <br />
                <textarea name="invite_part[message]"  placeholder="message"  cols="20" rows="4"> </textarea><br />
                <input name="" type="submit" value="send" class="button bold"></p>
            </form>
        </div>
    </div>

    <!-- Discussion group -->
    <div class="row">
        <div class="large-6 columns">
            <h3>Discussion group:</h3>
            <p>Your discussion group email address is <a href="mailto:<?php echo ltrim($_SESSION[public_user][site_url],'/') ?>@zylum.org"><?php echo ltrim($_SESSION[public_user][site_url],'/') ?>@zylum.org</a> <br />Emails sent to this address will be distributed to the email addresses below. Only messages sent from the email addresses below will be distributed to the discussion group.</p>
            <div class="email-list">
                <?php echo mailing_disc() ?>
            </div>
        </div>
        <div class="large-6 columns">
            <h3>Add to the list</h3>
            <form action="" method="post">
                <p>(place each email on a seperate line):
                    <textarea name="add_disc" cols="40" rows="10" ></textarea></p>
                    <p><input name="" type="submit" value="Add" class="button green"/></p>
                </form>
            </div>
        </div>
    </section>
