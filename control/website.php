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

// set default (may change in script)
$_SESSION[news_id]=0;

// get the website variables
$query = "select * from website where id=".$page_control->web_id;
$result = $dbpdo->query($query);
while($r = $result->fetch(PDO::FETCH_BOTH)) {
    $page_control->color=$r[color]; // website colours
    $page_control->active=$r[on]; //is the sit on?
    $page_control->sign_up= ''; // is the email sign up on?
    if ($r[email]==1) {
        // if it is on add this html
        $page_control->sign_up= ' <h3>Get our E-Newsletter</h3>
        <p>Sign up here to get our latest news direct to your in box</p>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="large-9 columns">
                <label>Email Address</label>
                <input type="email" name="newsletter_email" required />
            </div>
            <div class="large-3 columns">
                <div style="margin-bottom:20px;" class="g-recaptcha" data-sitekey="6LcemP8SAAAAABE0TF2TRqi0_sRcoW_2r4grwQaz"></div>
                <input type="submit" value="Submit" class="regular"/>
            </div>
        </form> ';
    }
    $page_control->facebook='';
    // if facebook is not empty add this html
    if ($r[fb]!='') {
        $page_control->facebook='<div id="facebook-link">
        <a href="'.$r[fb].'"><img src="/img/tools/facebook-icon.png"  target="_blank"/> Join us on Facebook</a>
    </div> ';
    $page_control->facebook_url=$r[fb];
    }
    // if twitter is not empty add this html
    $page_control->twiiter='';
    if ($r[twitter]!='') {
        $page_control->twiiter='<div id="twitter-link">
        <a href="'.$r[twitter].'"><img src="/img/tools/twitter-icon.png"  target="_blank" /> Follow us on Twitter</a>
        </div>  ';
        $page_control->twitter_url=$r[twitter];
    }
    // the media _id of the logo
    $page_control->logo_id=$r[logo];
    // media_id of banner
    $page_control->banner_id=$r[title_pic];
}

// start with a blank canvas
$page_control->website_navigation='';
// get a list of pages for this site that are not home and not news
$query = "select * from pages where `web_id`=$page_control->web_id and `type`!='Home'  and `type`!='News'  limit 5 ";
$result = $dbpdo->query($query);
while($r = $result->fetch(PDO::FETCH_BOTH)) {
    // if they are a user let them delete
    if ($_SESSION[public_user][site_id]==$page_control->web_id && $user_level>=2) {
        $delete=' <a href="'.$page_control->extension.'?delete_page='.$r[id].'" class="delete confirm" data="'.$r[id].'" >delete</a>';
    }
    // Add page to the navigation
    $page_control->website_navigation.='<li><a href="'.$page_control->extension.'/'.$r[url].'" >'.$r[name].'</a>'.$delete.'</li>';
}

// if there are more than 5 pages disable the add page button
$pnum_rows = $result->rowCount();
if ( $pnum_rows >=5) $pdis=' disabled';
// add news by default
$page_control->website_navigation.='<li><a href="'.$page_control->extension.'/news">News</a></li>';
// if they are a logged in user add documents
if ($_SESSION[public_user][site_id]==$page_control->web_id && $user_level>=1) {
    $page_control->website_navigation.='<li><a href="'.$page_control->extension.'/documents">Documents</a></li>';
}

// start with blank canvas for content
$page_control->page_content='';
// default  banner
$page_control->header_image='<img src="/img/tools/banner-logged-in.jpg">';
// default logo
$page_control->website_logo='<img src="/img/tools/website-logo.jpg" />';
// last url for this page
$break_count=count($page_control->breakdown);
// if it is a normal page
if ($break_count==3 && $page_control->breakdown[2]!='documents' ) {
    $this_page=$page_control->breakdown[2];
}
// if this is a specific doc page
else if ($page_control->breakdown[2]=='documents' && $break_count==4) {
    $doc_id=$page_control->breakdown[3];
    $page_control->file= 'website_docs.php';
}
// if it is a specific news page
else if ($page_control->breakdown[2]=='news' && $break_count==4) {
    $news_id=$page_control->breakdown[3];
    $page_control->file= 'website_news.php';
    $_SESSION[news_id]=$news_id;
}
// if it is the document page
else if ($page_control->breakdown[2]=='documents' ) {
    $page_control->file= 'website_docs.php';
} else {
    $this_page='';
}
// if it is a specific page
if (isset($this_page)) {
    $query = "select * from pages where `url`='$this_page' and `web_id`=$page_control->web_id ";
    $result = $dbpdo->query($query);
    $num_rows = $result->rowCount();
    // if the page does not exist
    if ($num_rows==0) {
        $page_control->page_content='<h1>Sorry that page does not exist</h1>';
    } else {
        while($r = $result->fetch(PDO::FETCH_BOTH)) {
            $page_control->page_content=$r[content];
            $page_control->page_caption=$r[caption];
            $page_control->media_id=$r[pic];
            $page_control->page_type=$r[type];
            if ($page_control->page_type=='Home') $page_control->file= 'website_home.php';
            if ($page_control->page_type=='Page') $page_control->file= 'website_home.php';
            if ($page_control->page_type=='News') $page_control->file= 'website_news.php';
            $_SESSION[page_id]=$r[id];
        }
    }
}

// if they are not logged in and the site is not active
if ( $page_control->active=='0' && $_SESSION[public_user][site_id]!=$page_control->web_id) {
    $goto = "Location: /";
    header ($goto);
}
?>
