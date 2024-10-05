
jQuery(document).ready(function($){

	"use strict";

    // Add Color Picker to all inputs that have 'pix-admin-color-field' class
    $('.pix-admin-color-field').wpColorPicker();

    $.fn.SynevoAddThumb = function() {
        // Set all variables to be used in scope
        var frame,
            metaBox = $(this),
            addImgLink = metaBox.find('.pix-image-upload'),
            delImgLink = metaBox.find( '.pix-image-delete');
        
        // ADD IMAGE LINK
        addImgLink.on( 'click', function( event ){
            
            event.preventDefault();

            var metaBox = $(this).closest('.pix-upload-image-container'), // Your meta box id here
                addImgLink = $(this),
                delImgLink = metaBox.find( '.pix-image-delete'),
                imgContainer = metaBox.find( '.pix-thumb-container'),
                imgIdInput = metaBox.find( '.pix-thumb-id' );
            
            // If the media frame already exists, reopen it.
            if ( frame ) {
                frame.open();
                return;
            }

            // Sets up the media library frame
            frame = wp.media.frames.meta_image_frame = wp.media({
                    title: meta_image.title,
                    button: { text:  meta_image.button },
                    library: { type: 'image' }
            });


            // When an image is selected in the media frame...
            frame.on( 'select', function() {

                // Get media attachment details from the frame state
                var attachment = frame.state().get('selection').first().toJSON();

                // Send the attachment URL to our custom image input field.
                imgContainer.append( '<img src="'+attachment.url+'" alt="" style="width:235px;"/>' );

                // Send the attachment id to our hidden input
                imgIdInput.val( attachment.id );

                // Hide the add image link
                addImgLink.addClass( 'hidden' );

                // Unhide the remove image link
                delImgLink.removeClass( 'hidden' );
            });

            // Finally, open the modal on click
            frame.open();
        });

        // DELETE IMAGE LINK
        delImgLink.on( 'click', function( event ){
            
            event.preventDefault();
            
            var metaBox = $(this).closest('.pix-upload-image-container'), // Your meta box id here
            addImgLink = metaBox.find('.pix-image-upload'),
            delImgLink = $(this),
            imgContainer = metaBox.find( '.pix-thumb-container'),
            imgIdInput = metaBox.find( '.pix-thumb-id' );

            // Clear out the preview image
            imgContainer.html( '' );

            // Un-hide the add image link
            addImgLink.removeClass( 'hidden' );

            // Hide the delete image link
            delImgLink.addClass( 'hidden' );

            // Delete the image id from the hidden input
            imgIdInput.val( '' );

        });
    };

    $( '#synevo_page_settings' ).SynevoAddThumb();
    $( '#synevo_portfolio_options' ).SynevoAddThumb();

});
