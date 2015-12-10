<?php
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

$body_class = (isset($_SERVER['REQUEST_URI'])) ? strtolower(str_replace('/', '', $_SERVER['REQUEST_URI'])) : '';
$body_class = ($body_class == '') ? $body_class = 'home' : $body_class;
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
    <link rel="stylesheet" href="/../css/zurb/style.css" />
    <link rel="stylesheet" href="/../css/colorbox/colorbox.css" />
    <link rel="stylesheet" href="/../css/zurb/media.css" />
    <link rel="stylesheet" href="/../js/alertify-js-shim-03/themes/alertify.core.css" />
    <link rel="stylesheet" href="/../js/alertify-js-shim-03/themes/alertify.default.css" />
    <!--<link href='http://fonts.googleapis.com/css?family=Oxygen:400,700,300' rel='stylesheet' type='text/css'>-->
    <script src="/../js/zurb/js/vendor/jquery.js"></script>
    <script src="/../js/zurb/js/vendor/modernizr.js"></script>
    <script src="/../js/alertify-js-shim-03/alertify.min.js"></script>
    <script src="/../js/ecosystem.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body class="<?php echo $body_class ?>">
    <?php echo $page_control->content ?>
    <section class="footer">
        <div class="row">
            <div class="large-2 columns">
                <a href="/"><img src="img/logo.png" /></a> <!-- Logo -->
            </div>
            <div class="large-4 columns">
                <ul class="inline-list">
                    <li><a href="/about">About</a></li> <!-- About -->
                    <li><a href="/terms">Terms</a></li> <!-- Terms -->
                    <li><a href="/privacy">Privacy</a></li> <!-- Privacy -->
                    <li><a href="/contact">Contact</a></li> <!-- Contact -->
                </ul>
            </div>
            <div class="large-6 columns">
                <p>Strapline and footer link</p> <!-- Footer -->
            </div>
        </div>
    </section>

    <script src="/../js/zurb/js/foundation.min.js"></script>
    <script src="/../js/colorbox/jquery.colorbox-min.js"></script>
    <script src="/../js/zurb/custom.js"></script>
    <script src="/js/ecosystem2.js"></script>
    <script>
        $(document).foundation();
    </script>
</body>
</html>
