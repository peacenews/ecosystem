<!--
"Peace News Ecosystem" is a CMS developed to allow small groups with no tech' expertise to have an internet presence. Its USP is freedom from choice. You can see one installation of Peace News Ecosystem at https://zylum.org/
Copyright (C) 2014 Zylum Ltd.
admin@zylum.org / 5 Caledonian Rd, London, N1 9DY

Version one of Peace News Ecosystem was authored by http://www.wave.coop/ info@wave.coop

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program.  If not, see http://www.gnu.org/licenses/agpl-3.0.html
-->

<div class="about">

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

                <section class="top-bar-section">
                    <? echo  $page_control->public_navigation ?>
                </section>
            </div>
        </div>

        <div class="row content first">
            <div class="large-2 columns">&nbsp;</div><!--large-2 columns-->

            <div class="large-8 columns">
                <h1 class="bold green">Managing and using Zylum</h1>

                <p><a href="#logging_in">Logging in</a>
                    <br /><a href="#forgotten_password">Forgotten your password</a>
                    <br /><a href="#how_do_i_sign_up">How do I sign up?</a>
                </p>

                <h3 class="bold purple" id="logging_in">Logging in</h3>
                <p><a href="/login">login</a></p>
                <p>Body text</p>

                <h3 class="bold purple" id="forgotten_password">Forgotten your password</h3>
                <p><a href="/forgotten_password">forgotten password</a></p>
                <p>Body text</p>

                <h3 class="bold purple" id="how_do_i_sign_up">How do I sign up?</h3>
                <p>Body text</p>

                <div class="leaf-bg text-center">
                    <img src="/img/about-leaf-bg-faded.jpg">
                </div><!--leaf-bg text-center-->
                <div class="back-to-top text-center">
                    <div class="text-center"><img src="/img/back-to-top.png"></div><!--text-center-->
                    <a href="" class="back-to-top">
                        back to top
                    </a>
                </div><!--back-to-top text-center-->
            </div>
            <div class="large-2 columns">&nbsp;</div><!--large-2 columns-->
        </div><!--row content-->
    </div>
