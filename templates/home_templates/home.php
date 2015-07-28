<!--
"Peace News Ecosystem" is a CMS developed to allow small groups with no tech' expertise to have an internet presence. Its USP is freedom from choice. You can see one installation of Peace News Ecosystem at https://zylum.org/
Copyright (C) 2014 Zylum Ltd.
admin@zylum.org / 5 Caledonian Rd, London, N1 9DY

Version one of Peace News Ecosystem was authored by http://www.wave.coop/ info@wave.coop

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program.  If not, see http://www.gnu.org/licenses/agpl-3.0.html
-->

<section id="homepage-slide">
    <div class="row">
        <div class="large-3 small-6 medium-3 columns logo">
            <a href="/"><img src="logo.png" id="logo" /></a> <!-- Logo -->
        </div>
        <div class="large-9 small-6 medium-9 columns">
            <nav class="top-bar" data-topbar role="navigation">
                <ul class="title-area">
                    <li class="name"></li>
                    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
                </ul>

                <section class="top-bar-section">
                    <?php echo  $page_control->public_navigation ?>
                </section>
            </div>
        </div>

        <div class="row content first-slide">
            <div class="large-7 small-12 columns">
                <h1 class="light">Introducing <span>Peace News Ecosystem</span>, a simple to use set of tools to help grassroots campaigners communicate, organise and win.</h1>
                <ul>
                    <li class="regular">An easy to use website composer </li>
                    <li class="regular">An intuitive system to compose newsletters </li>
                    <li class="regular">A simple way to manage a discussion email list</li>
                    <li class="regular">An uncomplicated document sharing feature</li>
                </ul>
                <p class="bold">Register now.</p>

                <div class="buttons">
                    <a role="button" href="#register" class="button regular purple first" id="register-button">Register</a>
                    <a role="button" href="#login" class="button regular green" id="login-button">Login</a>
                </div>


                <div style="display:none;">
                    <div id="register">
                        <h2 class="text-center bold">Register</h2>

                        <form method="post" action="/thank_you" class="group full-form">
                            <p> <label for="invitename">Name: <span class="required">*</span></label>
                                <input type="text" id="invitename" name="invitename" value="" placeholder="Your name, alias or nom de plume" required /></p>

                            <p> <label for="email">Your email address: <span class="required">*</span></label>
                                <input type="email" id="email" name="email" value="" placeholder="youremail@example.com" required /></p>

                            <p><label for="email">Deputy email address #1:</label>
                                <input type="email" name="email-deputy[]" value="" placeholder="someoneelseinyourgroup@example.com" /></p>

                            <p><label for="email">Deputy email address #2:</label>
                                <input type="email" name="email-deputy[]" value="" placeholder="someoneelseinyourgroup@example.com" /></p>

                            <label for="email">Please tell us briefly what you want to use your account for: <span class="required">*</span></label>
                            <textarea style="width:100%;" id="reason" name="reason"></textarea>

                            <p> <label for="title">Your Group's name: <span class="required">*</span></label>
                                <input type="text" id="title" name="title" value="" placeholder="Your group's full name here" required />

                                <span id="check_site_title">&nbsp;</span>
                                <p> <label for="title">Your website url: <span class="required">*</span></label>

                                <div class="row">
                                    <div class="large-2 columns" style="padding-top: 11px;">
                                        <!-- www... -->
                                    </div>
                                    <div class="large-10 columns">
                                        <input type="text" id="url" name="url" placeholder="your-group-name" required />
                                    </div>
                                </div>

                                <div class="large-12 columns">
                                    <span id="check_site_address">&nbsp;</span>
                                </div>

                                <div class="large-12 columns">
                                    <div style="margin-bottom:20px;" class="g-recaptcha" data-sitekey="6LcemP8SAAAAABE0TF2TRqi0_sRcoW_2r4grwQaz"></div>
                                </div>
                                <button class="green light" id="create" disabled >Submit</button>
                            </form>
                        </div>
                    </div>

                    <div style="display:none;">
                        <div id="login">
                            <div class="text-center">
                                <h2 class="bold">Login</h2>
                                <form method="post" action="/login" >
                                    <input type="email" id="email" name="login_email" value="" placeholder="example@example.com" required /></p>
                                    <input type="password" id="email" name="login_password" value="" placeholder="password" required /></p>
                                    <button class="purple light">Sign In</button>
                                    <p><a href="/forgotten_password">Forgotten your password?</a></p> <!-- Forgotten password link -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="large-12 columns text-center" id="homepage-arrow">
                    <a href="#second-slide"><img src=""/></a> <!-- Down arrow icon -->
                </div>
            </div>
        </section>

        <section class="home-white" id="second-slide">
            <div class="row content">
                <div class="large-5 small-12-centered medium-6-centered text-center columns">
                    <img src="" /> <!-- Icon -->
                </div>
                <div class="large-7 columns">
                    <h2 class="bold">Who is it for?</h2>
                    <p class="regular">Body text.</p>
                    <p><a href="/about#who_is_it_for" class="button regular purple">Read more...</a></p> <!-- About link -->
                </div>
            </div>
        </section>

        <section class="home-green">
            <div class="row content">
                <div class="large-7 columns">
                    <h2 class="bold">Simplicity</h2>
                    <h3 class="light">Designed to be easy to use - even for technophobes.</h3>
                    <p class="regular">Body text</p>
                    <p><a href="" class="button regular purple">We can help...</a></p> <!-- About link -->
                </div>
                <div class="large-5 small-10-centered medium-12 text-center columns">
                    <div class="text-center">
                        <img src="" /> <!-- abc image -->
                    </div>
                </div>
            </div>
        </section>

        <section class="home-white">
            <div class="row content">
                <div class="large-5 small-10-centered medium-12 text-center columns">
                    <div class="text-center">
                        <img src="" /> <!-- Security icon -->
                    </div>
                </div>
                <div class="large-7 columns">
                    <h2 class="bold">Security</h2>
                    <h3 class="light">Secure protocols and encryption...</h3>
                    <p class="regular">Body text</p>
                </div>
            </div>
        </section>

        <section class="home-grey">
            <div class="row content">
                <div class="large-12 columns">
                    <div class="text-center">
                        <img src="" /> <!-- Signpost icon -->
                        <h2 class="bold">Want to know more?</h2>
                        <h3 class="light">Intrigued and want a bit more information...</h3>
                        <a role="button" href="/about" class="button regular purple">Find out more</a> <!-- About link -->
                    </div>
                </div>
            </div>
        </section>
