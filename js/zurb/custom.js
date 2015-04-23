/*
"Peace News Ecosystem" is a CMS developed to allow small groups with no tech' expertise to have an internet presence. Its USP is freedom from choice. You can see one installation of Peace News Ecosystem at https://zylum.org/
Copyright (C) 2014 Zylum Ltd.
admin@zylum.org / 5 Caledonian Rd, London, N1 9DY

Version one of Peace News Ecosystem was authored by http://www.wave.coop/ info@wave.coop

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program.  If not, see http://www.gnu.org/licenses/agpl-3.0.html
*/

$(document).ready(function() {
    //$('.home #register-for-zylum-button').colorbox({inline:true,width:'60%',height:'75%',className: 'register-for-zylum'});
    //$('.home #login-to-zylum-button').colorbox({inline:true,width:'40%',height:'60%', className: 'login-to-zylum'});

    if($(document).width() > 700) {
        $('.home #register-for-zylum-button').colorbox({
            width:'60%',
            height:'75%',
            inline: true,
            className: 'register-for-zylum'
        });

        $('.home #login-to-zylum-button').colorbox({
            width:'40%',
            height:'60%',
            inline: true,
            className: 'login-to-zylum'
        });
    } else {
        jQuery('.home #register-for-zylum-button').colorbox({
            width:'90%',
            height:'90%',
            inline: true,
            className: 'register-for-zylum'
        });

        $('.home #login-to-zylum-button').colorbox({
            width:'90%',
            height:'90%',
            inline: true,
            className: 'login-to-zylum'
        });
    }

    $('.home .save-password .box').click(function(){
        $(this).css('background-image', 'url(/../img/tick.jpg)');
    });

    var offset = 220;
    var duration = 500;
    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > offset) {
            jQuery('.back-to-top').fadeIn(duration);
        } else {
            jQuery('.back-to-top').fadeOut(duration);
        }
    });

    jQuery('.back-to-top').click(function(event) {
        event.preventDefault();
        jQuery('html, body').animate({scrollTop: 0}, duration);
        return false;
    });

    // website logged in actions

    //hide input fields prior to page load
    //done it like this to make it easier to edit individual actions in future

    $('.website .tools-action').hide();
    $('.website .logged-in-user-controls ul li#colour-wheel').click(function(e) {
        e.preventDefault();
        $('.website .tools-action').hide();
        $('.website .logged-in-user-controls-input #colour-wheel-input').toggle();
    });

    $('.website .logged-in-user-controls ul li#add-images').click(function(e) {
        e.preventDefault();
        $('.website .tools-action').hide();
        $('.website .logged-in-user-controls-input #add-images-input').toggle();
    });

    $('.website .logged-in-user-controls ul li#add-page').click(function(e) {
        e.preventDefault();
        $('.website .tools-action').hide();
        $('.website .logged-in-user-controls-input #add-page-input').toggle();
    });

    $('.website .logged-in-user-controls ul li#add-social').click(function(e) {
        e.preventDefault();
        $('.website .tools-action').hide();
        $('.website .logged-in-user-controls-input #add-social-input').toggle();
    });

    /** website page **/

    if($('.website #intro .intro-image #website-banner').length == 0) {
        $('.website #intro .intro-image .website-logo').css({'top' : '30px'});
    }

    /** latest news list page **/

    $('.website #add-news-button').click(function() {
        $('.website .add-news').toggle();
    });
});
