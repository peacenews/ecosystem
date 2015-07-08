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

// forgotten password
if ($_SERVER["REQUEST_URI"]=='/forgotten_password') {
    if (isset($_POST[resetemail]) ) {
        $stmt = $dbpdo->prepare(" SELECT * FROM `users` WHERE `email`=:email  ");
        $stmt->execute(array(
            ':email' => $_POST[resetemail]
            ));
        $num_rows = $stmt->rowCount();
        if ($num_rows==1) {
            $data = $stmt->fetch(PDO::FETCH_BOTH);
            $rnd_pass=set_password($data[id]);
            send_email($data[id],$rnd_pass,'reset');
            header( "Location: /login" );
        } else {
            // echo 'else';
        }
    }
    ?>
    <form method="post" action="" class="group full-form">
        <p>Enter you email address and we will send you a new one.</p>
        <label for="email">Email Address: <span class="required">*</span></label>
        <input type="resetemail" id="resetemail" name="resetemail" value="" placeholder="johndoe@example.com" required />
        <input type="submit" value="Send it" id="submit-button" />
    </form>
    <?php
} else {
    // if not password
    if (isset ($_POST[login_email]) ) {
        $stmt = $dbpdo->prepare(" SELECT * FROM `users` WHERE `email`=:email AND `password`=:pass  ");
        $stmt->execute(array(
            ':email' => $_POST[login_email],
            ':pass' => md5($salt.$_POST[login_password])
            ));
        $num_rows = $stmt->rowCount();
        if ($num_rows==1) {
            $data = $stmt->fetch(PDO::FETCH_BOTH);
            $_SESSION[user_id] = $data[id];
            $_SESSION[email] = $data[email];
            $_SESSION[user_type] = $data[type];
            $_SESSION[site_id] = $data[site_id];
            if  ($_SESSION[site_id]==0) {
                header( "Location: /create" );
            } else {
                // echo 'else';
            }
        }
    } else {
        if ($_SERVER["REQUEST_URI"]=='/logout') {
            session_destroy();
        }
        ?>
        <form method="post" action="" class="group full-form">
            <label for="email">Email Address: <span class="required">*</span></label>
            <input type="email" id="email" name="login_email" value="" placeholder="johndoe@example.com" required />
            <label for="email">Password: <span class="required">*</span></label>
            <input type="password" id="email" name="login_password" value="" placeholder="password" required />
            <input type="submit" value="Login" id="submit-button" />
            <p><a href="/forgotten_password">Forgotten your password?</a></p>
            <p><a href="/logout">Logout</a></p>
        </form>
        <?php
    }
}
?>
