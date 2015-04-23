        <!--
        "Peace News Ecosystem" is a CMS developed to allow small groups with no tech' expertise to have an internet presence. Its USP is freedom from choice. You can see one installation of Peace News Ecosystem at https://zylum.org/
        Copyright (C) 2014 Zylum Ltd.
        admin@zylum.org / 5 Caledonian Rd, London, N1 9DY

        Version one of Peace News Ecosystem was authored by http://www.wave.coop/ info@wave.coop

        This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

        This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

        You should have received a copy of the GNU Affero General Public License along with this program.  If not, see http://www.gnu.org/licenses/agpl-3.0.html
        -->

        <div class="row">
        <div class="large-3 small-6 medium-3 columns logo">
            <a href="/"><img src="/../img/logo.png" id="logo" /></a> <!-- Logo -->
        </div>
        <div class="large-9 small-6 medium-9 columns">
                <nav class="top-bar" data-topbar role="navigation">

                    <ul class="title-area">
                        <li class="name"></li>
                        <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
                    </ul>

                <section class="top-bar-section columns">
                    <? echo  $page_control->public_navigation ?>
                </section>
        </div>
        </div>

    <div class="row content">
        <div class="large-2 columns">&nbsp;</div>
        <div class="large-8 columns">
            <h1 class="bold green">Contact us</h1>

            <form method="post">
                <label class="bold">Name:</label>
                <input name="contact[name]" type="text" placeholder="Please enter your name"/>
                <label class="bold">Email:</label>
                <input name="contact[email]" type="text" placeholder="Please enter your email"/>
                <label class="bold">Your message:</label>
                <textarea name="contact[message]" style="width:100%;height:200px;"></textarea>
                <div style="margin-bottom:20px;" class="g-recaptcha" data-sitekey=""></div> <!-- Sitekey -->
                <input type="submit" value="Send" class="button" />
            </form>

        </div>
        <div class="large-2 columns">&nbsp;</div>
    </div>
