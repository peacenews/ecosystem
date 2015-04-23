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
session_start();
ini_set('display_errors', 1); 
//load config
include ("control/config.php");

$page_control = new stdClass();

function get_template($uri){
    global $page_control;
    global $dbpdo;
   $stmt = $dbpdo->prepare(" SELECT * FROM `redirects` WHERE `url`=:url   ");
   $stmt->execute(array(
       ':url' => $uri
  ));
   $num_rows = $stmt->rowCount(); 
   if ($num_rows==1){
      $data = $stmt->fetch(PDO::FETCH_BOTH);
      $page_control->file= $data[2];
      $page_control->security= $data[4];
      $page_control->template= $data[3];
   }
   else{
       $bits=explode("/",$uri);
       $stmt = $dbpdo->prepare(" SELECT * FROM `users` WHERE `url`=:url   ");
       $stmt->execute(array(
        ':url' => '/'.$bits[1]
      ));
      //      echo $bits[1];
       $num_rows = $stmt->rowCount(); 
         if ($num_rows==1){
              $data = $stmt->fetch(PDO::FETCH_BOTH);
              $page_control->file= 'website_home.php';
              $page_control->security= 'Public';
              $page_control->template= 'website';
              $page_control->web_id=$data[0];
              $page_control->web_name=$data[5];
              $page_control->extension='/'.$bits[1];
           }
           else{
              include('404.html'); exit;   
           }
   }
}

//get the url for redirects
$page_control->uri=strtok($_SERVER["REQUEST_URI"],'?');
$page_control->breakdown=explode("/",$page_control->uri);

get_template($page_control->uri);

include ("control/security.php");
include("control/functions.php"); 
include("control/processes.php"); 
if ($page_control->template== 'website'){
   include ("control/website.php");
}

//start buffering content
ob_start(save_buffer);
$content_file="templates/".$page_control->template."_templates/".$page_control->file;
// echo $content_file;
include ($content_file);
ob_end_flush(); 
unset($content_file);
//end content

  if ($debug=='yes'){
            $page_control->content.='
            <fieldset style="margin: 20px; font-family: Courier New, Courier, monospace ; background-color: MistyRose  ">
            <legend><strong>Page and debugging information:</strong></legend>
            <p>
            <strong>Main template: </strong>'.$page_control->template.'.php<br />
            <strong>Content template: </strong>'.$page_control->template.'/'.$page_control->file.'<br />
            <strong>Security level: </strong>'.$page_control->security.'<br />
            
            <strong>user\'s level: </strong>'.$user_level.'<br />
            <strong>Security level no.l: </strong>'.$security_level.'<br />
            '.md5($salt."gehty877").'
            </p>
            </fieldset>
            <div id="ajax"></div>
            ';
}

// start the output by getting the template, content is added in the template
$template="templates/".$page_control->template.'.php';
include ($template);
unset($template);
?>
