<?php
/*
"Peace News Ecosystem" is a CMS developed to allow small groups with no tech' expertise to have an internet presence. Its USP is freedom from choice. You can see one installation of Peace News Ecosystem at https://zylum.org/
Copyright (C) 2014 Zylum Ltd.
admin@zylum.org / 5 Caledonian Rd, London, N1 9DY

Version one of Peace News Ecosystem was authored by http://www.wave.coop/ info@wave.coop

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program.  If not, see http://www.gnu.org/licenses/agpl-3.0.html
*/

$body_class = (isset($_SERVER['REQUEST_URI'])) ? strtolower(str_replace('/', '', $_SERVER['REQUEST_URI'])) : '';
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>title</title> <!-- Title -->
    <link rel="stylesheet" href="/../css/zurb/css/foundation.css" />
    <!-- <link rel="stylesheet" href="/../css/zurb/css/jquery.fullPage.css" /> -->
    <link rel="stylesheet" href="/../css/zurb/fonts.css" />
    <link rel="stylesheet" href="/../css/zurb/tools.css" />
    <link rel="stylesheet" href="/../css/zurb/media.css" />
    <link rel="stylesheet" href="/../css/colorbox/colorbox.css" />
    <script src="/../js/zurb/js/vendor/modernizr.js"></script>
    <script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: "textarea.tinymce",
            plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
            ],
            toolbar: "undo redo |  bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent "
        });
    </script>
</head>

<body class="website <?php echo $body_class ?>">
    <div class="logged-in-menu">
        <div class="row">
            <div class="large-2 columns">
                <a href="/"><img src="logo.png" /></a> <!-- Logo -->
            </div>
            <div class="large-4 small-4 columns"><p class="regular-zylum"></p></div>
            <div class="large-6 small-8 columns">
                <nav class="top-bar" data-topbar role="navigation">
                    <ul class="title-area">
                        <li class="name"></li>
                        <li class="toggle-topbar menu-icon"><a href="#"><span>Website Navigation</span></a></li>
                    </ul>

                    <section class="top-bar-section">
                        <?php echo $page_control->navigation ?>
                    </section>
                </nav>
            </div>
        </div>
    </div>

    <div style="width:1000px; margin: auto;"> <?php echo $page_control->content ?></div>
    <section id="footer">
        <div class="row">
            <div class="large-4 columns">
                <ul class="inline-list">
                    <li><a href="">About us</a></li>
                    <li><a href="">Contact us</a></li>
                </ul>
            </div>

            <div class="large-8 columns text-right">
                <p>Strapline and footer link</p> <!-- Footer -->
            </div>
        </div>
    </section>

    <script src="/../js/zurb/js/vendor/jquery.js"></script>
    <script src="/../js/zurb/js/foundation.min.js"></script>
    <script src="/../js/zurb/js/foundation/foundation.topbar.js"></script>
    <script src="/../js/colorbox/jquery.colorbox-min.js"></script>
    <script src="/../js/zurb/custom.js"></script>
    <script src="/js/ecosystem2.js"></script>
    <script>
        $(document).foundation();
    </script>
</body>
</html>
