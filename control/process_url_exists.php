<?php
/*
Currently, the /register page does NOT check to see whether a given url is already taken.
If /testing123 already exists and a new Owner signs up specifying /testing123 - neither the existing group or the new Owner will be able to access their web-pages.
This function checks whethether a given url already exists in the website table, in the database.

NB: There is already a check, just not a url check...
"Group name is already taken, please choose another."
$dberror
control/processes.php
circa line 240

The code below (lines 78-89) should be insterted at control/processes.php line 240 and the subsequent line ammended to add the url test...
if(($emailcount[0] >= 1) && ($groupcount[0] == 0) && ($urlexists == 0)){
*/

/*
"Peace News Ecosystem" is a CMS developed to allow small groups with no tech' expertise to have an internet presence. Its USP is freedom from choice. You can see one installation of Peace News Ecosystem at https://zylum.org/
Copyright (C) 2014 Zylum Ltd.
admin@zylum.org / 5 Caledonian Rd, London, N1 9DY

Version one of Peace News Ecosystem was authored by http://www.wave.coop/ info@wave.coop

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program.  If not, see http://www.gnu.org/licenses/agpl-3.0.html
*/

echo "process_url_exists.php<br /><br />";

// TESTING: we need to declare the array $_POST - this array will already exist when the code runs for real
$_POST = array ('invitename' => "",
                'email' => "",
                'email-deputy' => array ("",
                                         "",
                                        ),
                'reason' => "",
                'title' => "",
                'url' => "testing123",
                'g-recaptcha-response' => "",
               );

// TESTING: echo simulated $_POST
/*
echo "<pre>";
print_r ($_POST);
echo "</pre>";
// Echo just the element we willuse
echo $_POST['url'];
*/

// database conection details
$host = "localhost";
$dbname = "zylumdev";
$user = "root";
$pass = "user";

// TESTING: echo database conection details
/*
echo $host.'<br />';
echo $dbname.'<br />';
echo $user.'<br />';
echo $host.'<br />';
*/

// Connect to the database. DBH means DataBase Handle
try {
    $dbpdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    # ERRMODE use for testing
    $dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
}
catch(PDOException $e) {
    echo $e->getMessage();
};

// ---------------------------------------------------------

                                 // Check whether the url already exists in the website table
                                 //
                                 // Add a forward slash
                                 $queryurl='/'.$_POST["url"];
                                 // Prepere the SQL statement http://code.tutsplus.com/tutorials/why-you-should-be-using-phps-pdo-for-database-access--net-12059
                                 $stmt = $dbpdo->prepare('SELECT url FROM website WHERE url = :url');
                                 // Set the fetch mode
                                 $stmt->setFetchMode(PDO::FETCH_ASSOC);
                                 // Bind the parameter to the named placeholder
                                 $stmt->bindParam(':url', $queryurl);
                                 // Execute the prepared statement
                                 $stmt->execute($data);
                                 // Assign the result of the statement to a variable
                                 $urlexists = $stmt->fetch();

// Test whether we returned a match or not
if ($urlexists == 0) {
    echo "no match";
}

// Echo the data we fetched
/*
echo '<pre>';
print_r ($urlexists);
print_r ($_POST);
echo '</pre>';
*/

// ---------- Close the connection ----------

$dbpdo = null;

?>
