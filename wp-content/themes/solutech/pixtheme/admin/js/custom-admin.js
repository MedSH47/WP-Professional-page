
jQuery(document).ready(function($){

	"use strict";

    // Add Color Picker to all inputs that have 'color-field' class
	$(function() {
        $('.admin-color-field').wpColorPicker();
    });

	// post type toogle
	var postType = $('#post-formats-select').find('input:checked').val();
	if( postType == 0 ){
		$('#post_formats').hide();
	}
	else{
		$('#post_formats').fadeIn();
		$( '.pix-post-format-settings > div' ).hide();
		$( '.pix-format-' + postType ).fadeIn();
	}
	$('#post-formats-select').find('input').change( function() {

		var postType = $(this).val();

		if ( postType == 0 ) {
			$('#post_formats').hide();
		}
		else{
			$('#post_formats').fadeIn();
			$( '.pix-post-format-settings > div' ).hide();
			$( '.pix-format-' + postType ).fadeIn();
		}

	});


	// portfolio type toogle
	var portfolioType = $("#post_types_select :selected").val();
	$('#post_types .rwmb-meta-box .rwmb-field').not(':eq(0)').hide();
	if(portfolioType != "link"){
		$( 'label[for*="' + portfolioType + '"]' ).closest('.rwmb-field').siblings('.rwmb-field').hide();
		$( 'label[for*="' + portfolioType + '"]' ).closest('.rwmb-field').fadeIn();
		$('#post_types .rwmb-meta-box .rwmb-field').eq(0).show();
	}
	$('#post_types_select').change( function() {

		var portfolioType = $(this).val();
		if(portfolioType == "link"){
			$('#post_types .rwmb-meta-box .rwmb-field').not(':eq(0)').hide();
		}
		else{
			$( 'label[for*="' + portfolioType + '"]' ).closest('.rwmb-field').siblings('.rwmb-field').hide();
			$( 'label[for*="' + portfolioType + '"]' ).closest('.rwmb-field').fadeIn();
			$('#post_types .rwmb-meta-box .rwmb-field').eq(0).show();
		}
	});
	
	$('#clear_gallery').on('click', function() {
        $('#pix_post_gallery_ids').val('-1');
        $('#gallery-1').html('');
    });

	$('#manage_gallery').on('click', function() {
        // Create the shortcode from the current ids in the hidden field
        var gallerysc = '[gallery ids="' + $('#pix_post_gallery_ids').val() + '"]';
        // Open the gallery with the shortcode and bind to the update event
        wp.media.gallery.edit(gallerysc).on('update', function(g) {
            // We fill the array with all ids from the images in the gallery
            var id_array = [];

            $.each(g.models, function(id, img) { id_array.push(img.id); });
            // Make comma separated list from array and set the hidden value
            $('#pix_post_gallery_ids').val(id_array.join(","));
            // On the next post this field will be send to the save hook in WP
			var data = {
				action: 'pix_get_post_gallery',
				nonce: pix_post_ajax.nonce,
				ids: id_array.join(","),
			};
			console.log(data);
			$.get( pix_post_ajax.url, data, function( response ){
                $('.pix-gallery-content').html(response.data);
        	});
        });
    });


	$('.pix-reset').on('click', function(e){
		$(this).parent().find('input').val('');
	});

	$('#vc_ui-panel-edit-element').on('DOMNodeInserted', 'div', function () {
		if($('#vc_ui-panel-edit-element').width() > 900){
			$(this).find('.pix-vc-radio-images').addClass('pix-wide');
		} else {
			$(this).find('.pix-vc-radio-images').removeClass('pix-wide');
		}
	});

	$('#vc_ui-panel-edit-element').on('resize', function(){
		if( $(this).width() > 900 ){
			$(this).find('.pix-vc-radio-images').addClass('pix-wide');
		} else {
			$(this).find('.pix-vc-radio-images').removeClass('pix-wide');
		}
	});

	
    // Instantiates the variable that holds the media library frame.
    var meta_image_frame;
    var img_input;

    // Runs when the image button is clicked.
    $('.pix-image-upload').on('click', function(e){

	    img_input = $('#'+$(this).data('input'));
        // Prevents the default action from occuring.
        e.preventDefault();

        // If the frame already exists, re-open it.
        if ( meta_image_frame ) {
            meta_image_frame.open();
            return;
        }

        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: meta_image.title,
            button: { text:  meta_image.button },
            library: { type: 'image' }
        });

        // Runs when an image is selected.
        meta_image_frame.on('select', function(){
            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();

            // Sends the attachment URL to our custom image input field.
	        $(img_input).val(media_attachment.url);
        });

        // Opens the media library frame.
        meta_image_frame.open();
    });


	$('.pix-switch-container').each(function () {

        var $container = $(this),
        $input = $container.find('input.pix-switch-value'),
        $checkbox = $container.find('.pix-switch-button');

        $checkbox.on('click', function() {
            if($(this).prop('checked')) {
                $input.val('on');
            } else {
                $input.val('off');
            }
            $input.trigger( "change" );
        });

    });


	$( document ).ajaxComplete(function() {
		$('.pix-padding-vc-row').each(function () {

			var content = $('p', $(this)).text();

			if(content == 'padding No'){
				$(this).css('display', 'none');
			}

			$('p', $(this)).text(content.replace('padding ', 'padding: '));

		});
	});


});

