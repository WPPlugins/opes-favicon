jQuery( function() {
    var uploadID          = '';
    var storeSendToEditor = '';
    var newSendToEditor   = '';

	jQuery('#to-generate-media-button').click(function() {

        window.send_to_editor = function( html ) {
            var image_url = jQuery( 'img' , html ).attr( 'src' );
            jQuery('#to-generate-media-input').css({display: 'inline-block'}).val( image_url );
            tb_remove();
        };

        tb_show('Upload a logo', 'media-upload.php?type=image&amp;referer=opes_favicon_options&amp;tab=library&amp;TB_iframe=true', false );
        return false;
    });
/*
    jQuery('#admin-favicon-media-button').click(function() {
        window.send_to_editor = function( html ) {
            var image_url = jQuery( 'img' , html ).attr( 'src' );
            jQuery('#admin-favicon-media-input').val( image_url );
            tb_remove();
        };
        tb_show('Upload a logo', 'media-upload.php?type=image&amp;referer=opes-favicon-settings&amp;tab=library&amp;TB_iframe=true', false );
        return false;
    });
*/
});
