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
    <div class="row">
        <div class="large-12 columns">
            <h2 class="bold">Dashboard</h2>
            <h3 class="bold text-center">What would you like to do?</h3>
            <p style="text-align: center">Your website address is : http://zylum.org<?php echo $_SESSION['public_user']['site_url'] ?></p>
        </div>
    </div>
    <div class="row" id="dashboard-boxes">
        <!-- Website composer link -->
        <a href="<?php echo $_SESSION['public_user']['site_url'] ?>">
            <div class="large-3 medium-4 columns text-center">
                <div class="text-center"><img src="/img/dashboard/box-1.png" /></div> <!-- Website composer icon -->
                <h4 class="bold">website</h4>
                <p>create and manage your website and blog</p>
                <a class="button green bold" href="<?php echo $_SESSION['public_user']['site_url'] ?>">Do it!</a>
            </div>
        </a>

        <!-- Manage mailing list link -->
        <a href="/mailing_list">
            <div class="large-3 medium-4 columns text-center">
                <div class="text-center"><img src="/img/dashboard/box-2.png" /></div> <!-- Manage mailing list icon -->
                <h4 class="bold">e-newsletters</h4>
                <p>manage your email list and send e-newsletters</p>
                <a class="button green bold" href="/mailing_list">Do it!</a>
            </div>
        </a>

        <!-- Shared documents -->
        <a href="/document_sharing">
            <div class="large-3 medium-4 columns text-center" id="share-documents">
                <div class="text-center"><img src="/img/dashboard/box-3.png" /></div> <!-- Shared documents icon -->
                <h4 class="bold">documents</h4>
                <p>create and share documents with key participants</p>
                <a class="button green bold" href="/document_sharing">Do it!</a>
            </div>
        </a>

        <!-- Manage discussion group: Owners /Contributors /Participants see different content here -->
        <?php if ( $user_level>=3 ) { ?>
        <a href="/contributors">
            <div class="large-3 medium-4 columns text-center" id="discussions">
                <div class="text-center"><img src="/img/dashboard/box-4.png" /></div> <!-- Manage discussion group icon -->
                <h4 class="bold">manage group</h4>
                <p>manage participants and your email discussion group</p>
                <a class="button green bold" href="/contributors">Do it!</a>
            </div>
        </a>
        <?php } ?>
    </div>
</section>
