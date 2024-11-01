/* global jQuery */
jQuery(function($) {
    $(window).load(function() {
      $("body").addClass("loading-complete");
    var st_profile_pic_height = $("ul.profile-section li#wp-admin-bar-user-info a img").height();
    $("body div#adminmenuwrap").css("margin-top" , st_profile_pic_height+100);
    });
    
    $(window).scroll(function() {    
    var scroll = $(window).scrollTop();

    if (scroll >= 150) {
        $("#wpcontent #wpadminbar").addClass("darkHeader");
    } else {
        $("#wpcontent #wpadminbar").removeClass("darkHeader");
    }
});
    $("#wpwrap").prepend("<ul class='profile-section'></ul>");
    $("li#wp-admin-bar-user-info").detach().appendTo("ul.profile-section");
    $("li#wp-admin-bar-logout").detach().appendTo("ul#wp-admin-bar-top-secondary");
    $("li#wp-admin-bar-logout").detach().appendTo("ul#wp-admin-bar-top-secondary");
    $("li#wp-admin-bar-my-account").detach();
    var logout_link = $("#wp-toolbar>ul>li#wp-admin-bar-logout a").attr("href");
    $("li#wp-admin-bar-user-info").append("<a class='lets-logout' href='"+logout_link+"'>Log Out</a>")
/*
 * Adapted from: http://mikejolley.com/2012/12/using-the-new-wordpress-3-5-media-uploader-in-plugins/
 */
$(document).ready(function(){
// Uploading files
 
  $('.additional-user-image').on('click', function( event ){
var file_frame;
  console.log("pro-pic");
    event.preventDefault();
 
    // If the media frame already exists, reopen it.
    if ( file_frame ) {
      file_frame.open();
      return;
    }
 
    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
      title: $( this ).data( 'uploader_title' ),
      button: {
        text: $( this ).data( 'uploader_button_text' ),
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });
 
    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {
      // We set multiple to false so only get one image from the uploader
      attachment = file_frame.state().get('selection').first().toJSON();
 
      // Do something with attachment.id and/or attachment.url here
        jQuery('#user_meta_image').attr('value',attachment.url);
        jQuery('#st_user_img_preview').attr('src' ,attachment.url);
    });
 
    // Finally, open the modal
    file_frame.open();
  });
  
  $('.additional-cover-image').on('click', function( event ){
var file_frame;
  console.log("cover-pic");
    event.preventDefault();
 
    // If the media frame already exists, reopen it.
    if ( file_frame ) {
      file_frame.open();
      return;
    }
 
    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
      title: $( this ).data( 'uploader_title' ),
      button: {
        text: $( this ).data( 'uploader_button_text' ),
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });
 
    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {
      // We set multiple to false so only get one image from the uploader
      attachment = file_frame.state().get('selection').first().toJSON();
 
      // Do something with attachment.id and/or attachment.url here
        jQuery('#user_cover_image').attr('value',attachment.url);
        jQuery('#st_cover_img_preview').attr('src' ,attachment.url);
    });
 
    // Finally, open the modal
    file_frame.open();
  });
  
  $(function() {
        $('.color-field').wpColorPicker();
    });
 
});
    
});