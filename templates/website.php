<?
/*
"Peace News Ecosystem" is a CMS developed to allow small groups with no tech' expertise to have an internet presence. Its USP is freedom from choice. You can see one installation of Peace News Ecosystem at https://zylum.org/
Copyright (C) 2014 Zylum Ltd.
admin@zylum.org / 5 Caledonian Rd, London, N1 9DY

Version one of Peace News Ecosystem was authored by http://www.wave.coop/ info@wave.coop

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program.  If not, see http://www.gnu.org/licenses/agpl-3.0.html
*/
?>

<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><? echo $page_control->web_name?></title>
    <link rel="stylesheet" href="/css/zurb/css/foundation.css" />
    <!-- <link rel="stylesheet" href="/css/zurb/css/jquery.fullPage.css" /> -->
    <link rel="stylesheet" href="/css/zurb/fonts.css" />
    <link rel="stylesheet" href="/css/zurb/tools.css" />
    <link rel="stylesheet" href="/css/zurb/media.css" />
    <link rel="stylesheet" href="/css/colorbox/colorbox.css" />
    <link rel='stylesheet' href='/css/spectrum.css' />
    <link rel='stylesheet' href='/css/website.css' />
    <script src="/js/zurb/js/vendor/modernizr.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">

    <? if ($_SESSION[public_user][site_id]==$page_control->web_id  && $user_level>=2){?>
    tinymce.init({
        selector: ".caption-content",
        inline: true,
        toolbar: "undo redo",
        menubar: false
    });

    tinymce.init({
        selector: "#news_header",
        inline: true,
        toolbar: "undo redo",
        menubar: false
    });

    tinymce.init({
        selector: "#id_news",
        inline: false,
             plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime  table contextmenu paste"
        ],
        toolbar: "undo redo |  bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent "
    });

    tinymce.init({
        selector: "#content",
        inline: true,
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime  table contextmenu paste"
        ],
        toolbar: "undo redo |  bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent "
    });

    <? }?>
    </script>
    <style>
        .change {
            background-color: red ;
        }
    </style>
  </head>

  <body class="website">
    <?  if ($_SESSION[public_user][site_id]==$page_control->web_id && $user_level>=2){?>
    <div class="logged-in-menu">
        <div class="row">
            <div class="large-2 medium-3 small-4 columns">
                <a href="/"><img src="logo.png" /></a> <!-- Logo -->
            </div>
            <div class="large-4 small-8 medium-2 columns"><p class="regular-zylum"><? echo $page_control->web_name?></p></div>
            <div class="large-6 medium-7 columns">
                <nav class="top-bar" data-topbar role="navigation">
                    <ul class="title-area">
                        <li class="name"></li>
                        <li class="toggle-topbar menu-icon"><a href="#"><span>Website Navigation</span></a></li>
                    </ul>

                <section class="top-bar-section">
                    <? echo  $page_control->public_navigation ?>
                </section>
                </nav>
            </div>
        </div>
    </div>

    <!-- user controls -->
    <div class="logged-in-user-controls">
        <div class="row">
            <div class="large-12 columns">
                <nav class="top-bar" data-topbar role="navigation">
                    <ul class="title-area">
                        <li class="name"></li>
                        <li class="toggle-topbar menu-icon"><a href="#"><span>Website Controls</span></a></li>
                    </ul>

                <section class="top-bar-section">
                <ul class="inline-list right">
                    <li id="on-off"><? site_info();?></li>
                    <li id="colour-wheel"><a href="">Edit Colour</a></li>
                    <li id="add-images"><a href="">Add Images</a></li>
                    <li id="add-page"><a href="">Add a page</a></li>
                    <li id="email-signup"><? email_info();?></li>
                    <li id="add-social"><a href="">Add Social Media</a></li>
                </ul>
                </section>
                </nav>
            </div>
        </div>
    </div>

    <div class="logged-in-user-controls-input">
        <div class="row">
            <div class="large-12 columns tools-action" id="colour-wheel-input">
                <input id="clickoutFiresChange" type="text" value="<? echo $page_control->color ?>" name="clickoutFiresChange" style="display: none;" class="basic">
                <em id='basic-log'></em>
            </div>
            <div class="large-12 columns tools-action" id="add-images-input">
                <div class="large-4 columns">
                    <label>Logo:</label>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="file"  name="graphic[logo]"/> <input name="graphic[delete][logo]" type="checkbox" value="delete"> delete<br>
                        <input name="" type="submit" value="save">
                    </form>
                </div>
                <div class="large-4 columns">
                    <label>Banner:</label>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="file"  name="graphic[banner]"/> <input name="graphic[delete][banner]" type="checkbox" value="delete"> delete<br>
                        <input name="" type="submit" value="save">
                    </form>
                </div>
                <div class="large-4 columns">
                    <label>Content image:</label>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="file"  name="graphic[cimage]"/> <input name="graphic[delete][cimage]" type="checkbox" value="delete"> delete<br>
                        <input name="" type="submit" value="save">
                    </form>
                </div>
            </div>
            <div class="large-12 columns tools-action" id="add-page-input">
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="page_name">Please enter the name of your page:</label>
                    <input type="text" input name="page[name]" />
                    <input type="submit" value="Submit" class="button" <? echo $pdis;?> />
                </form>
            </div>
            <div class="large-12 columns tools-action" id="add-social-input">
                <div class="large-6 columns">
                    <label>Facebook:</label>
                <form action="" method="post" enctype="multipart/form-data">
                        <input type="text" placeholder="Please enter your Facebook URL"  name="facebook" value="<? echo $page_control->facebook_url?>"/>
                </div>
                <div class="large-6 columns">
                    <label>Twitter:</label>
                        <input type="text" placeholder="Please enter your Twitter URL" name="twitter"  value="<? echo $page_control->twitter_url?>" />
                </div>
                <div class="large-4 columns left">
                    <input type="submit" value="Submit" class="button" id="social" />
                </div>
            </form>
            </div>
        </div>
        <? }?>
    </div>
    <div id="top" class="change">
        <div class="row">
            <div class="large-12 columns">
                <nav class="top-bar" data-topbar role="navigation">
                    <ul class="inline-list left home-icon">
                        <li class="text-center"><a href="<? echo $page_control->extension ?>"><img src="/img/tools/home-icon.png" /></a></li>
                    </ul>
                    <ul class="title-area">
                        <li class="name"></li>
                        <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
                    </ul>

                    <section class="top-bar-section">
                        <ul class="inline-list right" id="web_nav">
                            <? echo  $page_control->website_navigation ?>
                        </ul>
                    </section>
                </nav>
            </div>
        </div>
    </div>

    <section id="intro">
    <?
    $he=450;
    $ht=349;
    $extra_styles = '';

     if ($page_control->banner_id==0) { $he=100; $ht=0; $extra_styles = 'margin-top:0;position:relative;background-color:#000000;'; }?>
        <div class="intro-image text-center" style="height: <? echo $he;?>px; background-image: url(/img/<? echo $page_control->banner_id?>/1750); background-size:cover">
             <? // if ($page_control->banner_id!='0') { echo '<img src="/img/'.$page_control->banner_id.'/1750" />'; } ?>
            <section class="intro-text" style="<? echo $extra_styles ?> top:<? echo $ht;?>px;">
            <div class="row">
                <div class="large-12 columns">
                    <h1 class="bold"><? echo $page_control->web_name?></h1>
                    <div class="website-logo">  <?  if ($page_control->logo_id!='0') echo '<img src="/img/'.$page_control->logo_id.'/165/const" />'; ?></div>
                </div>
            </div>
            </section>
        </div>
    </section>

<? echo $page_control->content ?>

    <section id="newsletter" class="text-center change">
        <div class="row">
            <div class="large-3 columns">&nbsp;</div>
            <div class="large-6 columns" id="newsletter-form">
              <? echo $page_control->sign_up ?>
            </div>
            <div class="large-3 columns">&nbsp;</div>
        </div>
        <div class="row">
            <div class="large-2 columns">&nbsp;</div>
            <div class="large-8 columns">

              <? echo  $page_control->facebook ?>
              <? echo  $page_control->twiiter ?>

            </div>
            <div class="large-2 columns">&nbsp;</div>
        </div>
    </section>
    <section id="footer">
        <div class="row">
            <div class="large-4 columns">
                <ul class="inline-list">
                    <li><a href="/login">login/logout</a></li> <!-- Login -->
                </ul>
            </div>
            <div class="large-8 columns text-right">
                <p>Strapline and footer link</p> <!-- Footer -->
            </div>
        </div>
    </section>
    <script src="/js/zurb/js/vendor/jquery.js"></script>
    <script src="/js/zurb/js/foundation.min.js"></script>
    <script src="/js/zurb/js/foundation/foundation.topbar.js"></script>
    <script src="/js/colorbox/jquery.colorbox-min.js"></script>
    <script src="/js/zurb/custom.js"></script>
    <script src="/js/ecosystem2.js"></script>
    <script src='/js/spectrum.js'></script>
    <script>
      $(document).foundation();

      $(document).ready(function() {
          $('.change').css( "background-color","<? echo $page_control->color; ?>");
          $('.changeh h1, .changeh h2, .changeh h3, .changeh h4, .changeh h5, .changeh a').css( "color","<? echo $page_control->color; ?>");
          $(".basic").spectrum({
            change: function(color) {
                change_color (color.toHexString());
            }
        });
      })
    </script>
  </body>
</html>
