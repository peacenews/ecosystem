<!--
/**
 * "Peace News Ecosystem" is a CMS developed to allow small groups with no tech' expertise
 * to have an internet presence. Its USP is freedom from choice. You can see one installation
 * of Peace News Ecosystem at https://zylum.org/
 *
 * Copyright (C) 2014 Zylum Ltd.
 * admin@zylum.org / 5 Caledonian Rd, London, N1 9DY
 *
 * Version one of Peace News Ecosystem was authored by http://www.wave.coop/ info@wave.coop
 *
 * This program is free software: you can redistribute it and/or modify it under the terms
 * of the GNU Affero General Public License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with this program.
 * If not, see http://www.gnu.org/licenses/agpl-3.0.html
 */
 -->
<?php global $site_vars; ?>
<section id="homepage-slide">
    <div class="row">
        <div class="large-3 small-6 medium-3 columns logo">
            <a href="/"><img src="/img/logo.png" id="logo" /></a> <!-- Logo -->
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
            <div  id="cboxContent" class="large-7 small-12 columns">
                <div>
                    <div id="register">
                        <h2 class="text-center bold">Register</h2>
						<?php if($dberror): ?>
								<p class="reg-error">Error's detected! Please check below.</p>
							<?php endif; ?>
						<form method="post" action="" class="group full-form">
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
                                <input type="text" id="title" name="title" value="" placeholder="Your group's full name here" required /></p>
							<?php if($dberror): ?>
								<p class="reg-error">Group name is already taken, please choose another.</p>
							<?php endif; ?>
                                <span id="check_site_title">&nbsp;</span>
                                <p> <label for="title">Your website url: <span class="required">*</span></label></p>

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
                                    <div style="margin-bottom:20px;" class="g-recaptcha" data-sitekey="<?php echo $site_vars['recaptcha_sitekey']; ?>"></div>
                                </div>
                                <button class="green light" id="create" >Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

         </section>

