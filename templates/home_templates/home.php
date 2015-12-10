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
                    <a role="button" href="/register" class="button regular purple first">Register</a>
                    <a role="button" href="#login" class="button regular green" id="login-button">Login</a>
                </div>
				<script type="text/javascript">
				$(document).ready(function(){
					$("#register > form").submit(function(){ 								
						//var str = $(this).serialize(); 
						var title = $("#title").val();						
						var email=$('#email').val();
						var invitename=$('#invitename').val();
						//alert(title);
						console.log(str);
						//console.log(str);
						$.ajax({
							//url: '../../processes.php',
							type: "POST",
							url: "../../processes.php",													  
							data: "title="+title+"&email="+email+"&invitename="+invitename,
							
							success: function(html) {
								$.colorbox({inline:true, width:666});	
								if(html =='true'){
									$("#login_response").html(html);
								}else{
								alert(123);
								}
							},
						});
						
						return false;
				    });
			    });
				
				</script>
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
