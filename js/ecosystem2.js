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
    $('#confirmx').delay(5000).fadeOut(400);
    $('.top-bar-section ul').addClass('inline-list right');
    $( '#title' ).focusout(function() {
        var data = '';
        var title = $('input[name=title]');
        var data = 'site_titlec=' + encodeURIComponent(title.val());
        $.ajax({
            url: "/js/ajax.php",
            type: "GET",
            data: data,
            success: function(data) {
                // alert(data);
                $( "#url" ).val(data);
                $('#check_site_title').addClass('ok');
                $('#check_site_address').addClass('ok');
                $('#check_site_address').html('<div class="registration-response success"><img src="/img/tick.gif" width="20" height="20"></div>');
                if ( $('#check_site_address').hasClass( "ok" )  &&  $('#check_site_title').hasClass( "ok" )) {
                    $( '#create' ).removeAttr('disabled');
                } else {
                    alert('did');
                    $( '#create' ).attr('disabled','disabled');
                }
            }
        });
    });
    $('#uurl').keyup(function() {
        var data = '';
        var title  = $( this ).val();
        var data = 'uurl=' + encodeURIComponent(title.val());
        //alert (data);
        //  $('#check_site_title').html('ddddd>');
        $.ajax({
            url: "/js/ajax.php",
            type: "GET",
            data: data,
            success: function(data) {
                alert(data);
            }
        });
    });
    $('#title').keyup(function() {
        var data = '';
        var title = $('input[name=title]');
        var data = 'site_title=' + encodeURIComponent(title.val());
        //alert (data);
        //  $('#check_site_title').html('ddddd>');
        $.ajax({
            url: "/js/ajax.php",
            type: "GET",
            data: data,
            success: function(data) {
                // alert(data);
                if (data==0) {
                    $('#check_site_title').html('<div class="registration-response error"><img src="/img/kill.png" width="20" height="20"></div>');
                    //$( '#create' ).attr('disabled','disabled');
                    $('#check_site_title').removeClass('ok');
                }
                if (data==1) {
                    $('#check_site_title').html('<div class="registration-response success"><img src="/img/tick.gif" width="20" height="20"></div>');
                    //$( '#create' ).removeAttr('disabled');
                    $('#check_site_title').addClass('ok');
                }
            }
        });
    });
    $('#url').keyup(function() {
        var data = '';
        var site_address = $('input[name=url]');
        var data = 'site_address=' + encodeURIComponent(site_address.val());
        //alert (data);
        $.ajax({
            url: "/js/ajax.php",
            type: "GET",
            data: data,
            success: function(data) {
            //  alert (data);
                if (data==0) {
                    $('#check_site_address').html('<div class="registration-response error"><img src="/img/kill.png" width="20" height="20"></div>');
                    //$( '#create' ).attr('disabled','disabled');
                    $('#check_site_address').removeClass('ok');
                }
                if (data==1) {
                    $('#check_site_address').html('<div class="registration-response success"><img src="/img/tick.gif" width="20" height="20"></div>');
                    //$( '#create' ).removeAttr('disabled');
                    $('#check_site_address').addClass('ok');
                }
                if (data=='x') {
                    $('#check_site_address').html('<div class="registration-response error">Your url contains an invalid character</div>');
                    //$( '#create' ).attr('disabled','disabled');
                    $('#check_site_address').removeClass('ok');
                }
            }
        });
        if ( $('#check_site_address').hasClass( "ok" )  &&  $('#check_site_title').hasClass( "ok" )) {
            $( '#create' ).removeAttr('disabled');
        } else {
            $( '#create' ).attr('disabled','disabled');
        }
    });
    if ($('#create').hasClass('ton') ) {
        // alert('poo');
        $('#create').removeAttr( "disabled" );
    }
    $.ajaxSetup({
        url: "/control/save_data.php",
        global: false,
        type: "POST"
    });
    $('.cw').change(function() {
        var cw = $('input[name=cw]');
        var data = 'cw=' + encodeURIComponent(cw.val());
        var color = encodeURIComponent(cw.val());
        //alert(data);
        $('.change').css( "background-color", color);
        $('.changeh h1, .changeh h2, .changeh h3, .changeh h4, .changeh h5, .changeh a').css( "color",color);
        $.ajax({
            data: data,
            success: function(data) {
                $('#ajax').html(data);
            }
        });
    });
    $('#socisal').click(function() {
        var facebook = $('input[name=facebook]');
        var twitter = $('input[name=twitter]');
        var data = 'facebook=' + encodeURIComponent(facebook.val()) + '&twitter=' + encodeURIComponent(twitter.val());
        //alert(data);
        $.ajax({
            data: data,
            success: function(data) {
                $('#ajax').html(data);
            }
        });
    });
    $('#csave').click(function() {
        var content = $( "#content" ).html();
        var data = 'pcontent=' + encodeURIComponent(content);
        // var data = tinyMCE.get('#content');
        //alert(data);
        $.ajax({
            data: data,
            success: function(data) {
                $('#cresult').html(data);
            }
        });
    });
    $('#capsave').click(function() {
        var content = $( ".caption-content" ).html();
        var data = 'ccontent=' + encodeURIComponent(content);
        //alert(data);
        $.ajax({
            data: data,
            success: function(data) {
                $('#capresult').html(data);
            }
        });
    });
    $('.confirm').click(function() {
        return window.confirm("Are you sure?");
    });
});
    function change_color(color) {
    $('.change').css( "background-color", color);
    $('.changeh h1, .changeh h2, .changeh h3, .changeh h4, .changeh h5, .changeh a').css( "color",color);
    var data = 'cw=' +color;
    $.ajax({
        data: data,
        success: function(data) {
            $('#ajax').html(data);
        }
    });
}
