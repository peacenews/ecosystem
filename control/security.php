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

$security_group = array(
    'Public'      => 0,
    'Participant' => 1,
    'Contributor' => 2,
    'Owner'       => 3,
    'Superuser'   => 4
);

$security_level = $security_group[ $page_control->security ];

# @TODO - this 'isset' hides a bigger structural error which needs fixing...
$user_level     = isset($_SESSION['public_user']['level'])
                  ? $security_group[ $_SESSION['public_user']['level'] ]
                  : 0;

// is requested page protected?
if ($page_control->security != 'Public') {

    // if we're not logged in as a 'manager', check template security
    if (!isset($_SESSION['manager']['user_id'])) {

        switch ($page_control->template) {

            case 'public':
                // if page security level is higher than user level, force public login
                if ($security_level > $user_level) {
                    header('Location: /login');
                }
                break;

            case 'admin':
                // force admin login
                header('Location: /manage/login');
                break;

        }
    }
}
