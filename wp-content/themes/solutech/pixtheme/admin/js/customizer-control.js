/* customizer preview */

( function( wp, $ ) {
    wp.customize.bind('ready', function(){
        $.each($('.pix-google-font'), function(){

            var weight_id = $(this).data('weight-id'),
                weights = [],
                font_weights = $(this).find(':selected').data('weights');

            $('#'+weight_id).find('option').remove().end();
            if(typeof font_weights !== 'undefined' && font_weights.length > 0){
                weights = font_weights.split(",");
                $.each(weights, function(i, item){
                    var $selected = item == $('#'+weight_id).data('value') ? 'selected="selected"' : '';
                    $('#'+weight_id).append("<option value='" + item + "' " + $selected +">" + item + "</option>");
                });
            } else {
                $('#'+weight_id).append("<option value='400'>400</option>");
            }
        })
    });
} )( wp, jQuery );

jQuery(function($){

    "use strict";

    var customize = wp.customize;
    
    customize( 'pixtheme_decor_show', function( value ) {
        if( value.get() == '0' ){
            customize.control( 'pixtheme_decor_img' ).container.hide();
            customize.control( 'pixtheme_decor_width' ).container.hide();
            customize.control( 'pixtheme_decor_height' ).container.hide();
        }

        value.bind( function( to ) {
            if( to == '0' ) {
                customize.control( 'pixtheme_decor_img' ).container.hide();
                customize.control( 'pixtheme_decor_width' ).container.hide();
                customize.control( 'pixtheme_decor_height' ).container.hide();
            } else {
                customize.control( 'pixtheme_decor_img' ).container.show();
                customize.control( 'pixtheme_decor_width' ).container.show();
                customize.control( 'pixtheme_decor_height' ).container.show();
            }
        } );
    } );

    customize( 'pixtheme_decor_img', function( value ) {
        var width = customize.control( 'pixtheme_decor_width' ).setting.get();
        if( value.get() ){
            var img = customize.control( 'pixtheme_decor_img' ).container.find( '.thumbnail.thumbnail-image img' );
            if( img[0] ){
                img[0].width = width;
            }
        }
        value.bind( function( to ) {
            if( to != '' ) {
                var img = customize.control( 'pixtheme_decor_img' ).container.find( '.thumbnail.thumbnail-image img' );
                if( img[0] ){
                    img[0].width = width;
                }
            }
        } );
    } );

    customize( 'pixtheme_decor_width', function( value ) {
        value.bind( function( to ) {
            var img = customize.control( 'pixtheme_decor_img' ).container.find( '.thumbnail.thumbnail-image img' );
            if( img[0] ){
                img[0].width = to;
            }
        } );
    } );



    customize( 'pixtheme_general_settings_logo', function( value ) {
        var width = customize.control( 'pixtheme_general_settings_logo_width' ).setting.get();
        if( value.get() ){
            var img = customize.control( 'pixtheme_general_settings_logo' ).container.find( '.thumbnail.thumbnail-image img' );
            if( img[0] ){
                img[0].width = width;
            }
        }
        value.bind( function( to ) {
            if( to != '' ) {
                var img = customize.control( 'pixtheme_general_settings_logo' ).container.find( '.thumbnail.thumbnail-image img' );
                if( img[0] ){
                    img[0].width = width;
                }
            }
        } );
    } );

    customize( 'pixtheme_general_settings_logo_width', function( value ) {
        value.bind( function( to ) {
            var img = customize.control( 'pixtheme_general_settings_logo' ).container.find( '.thumbnail.thumbnail-image img' );
            if( img[0] ){
                img[0].width = to;
            }
        } );
    } );



    /// Header

    customize( 'pixtheme_header_bar', function( value ) {
        if( value.get() == '0' ){
            customize.control( 'pixtheme_top_bar_background' ).container.hide();
            customize.control( 'pixtheme_top_bar_transparent' ).container.hide();
        }
        value.bind( function( to ) {
            if( to == '0' ) {
                customize.control( 'pixtheme_top_bar_background' ).container.hide();
                customize.control( 'pixtheme_top_bar_transparent' ).container.hide();
            } else {
                customize.control( 'pixtheme_top_bar_background' ).container.show();
                customize.control( 'pixtheme_top_bar_transparent' ).container.show();
            }
        } );
    } );

    function pix_info_sections_hide(){
        customize.control( 'pixtheme_header_info_icon_1' ).container.hide();
        customize.control( 'pixtheme_header_info_title_1' ).container.hide();
        customize.control( 'pixtheme_header_info_1' ).container.hide();
        customize.control( 'pixtheme_header_info_icon_2' ).container.hide();
        customize.control( 'pixtheme_header_info_title_2' ).container.hide();
        customize.control( 'pixtheme_header_info_2' ).container.hide();
        customize.control( 'pixtheme_header_info_icon_3' ).container.hide();
        customize.control( 'pixtheme_header_info_title_3' ).container.hide();
        customize.control( 'pixtheme_header_info_3' ).container.hide();
    }

    function pix_info_sections_toogle(val) {
        if( val == 'info_1' ) {
            pix_info_sections_hide();
            customize.control( 'pixtheme_header_info_icon_1' ).container.show();
            customize.control( 'pixtheme_header_info_title_1' ).container.show();
            customize.control( 'pixtheme_header_info_1' ).container.show();
        } else if( val == 'info_2' ) {
            pix_info_sections_hide();
            customize.control( 'pixtheme_header_info_icon_2' ).container.show();
            customize.control( 'pixtheme_header_info_title_2' ).container.show();
            customize.control( 'pixtheme_header_info_2' ).container.show();
        } else if( val == 'info_3' ) {
            pix_info_sections_hide();
            customize.control( 'pixtheme_header_info_icon_3' ).container.show();
            customize.control( 'pixtheme_header_info_title_3' ).container.show();
            customize.control( 'pixtheme_header_info_3' ).container.show();
        }
    }

    customize( 'pixtheme_header_info_segment', function( value ) {
        if( value.get() == '' ){
            pix_info_sections_hide();
        } else {
            pix_info_sections_toogle(value.get());
        }

        $('#customize-control-pixtheme_header_info_segment .pix-vc-segmented-button input[type=radio]').on('change', function(){
            var val = $(this).val();
            pix_info_sections_toogle(val);
        });

    } );

    customize( 'pixtheme_header_type', function( value ) {
        if( value.get() != 'header3' && value.get() != 'header4' ){
            customize.control( 'pixtheme_header_menu_background' ).container.hide();
            customize.control( 'pixtheme_header_menu_transparent' ).container.hide();
            customize.control( 'pixtheme_header_info_segment' ).container.hide();
            customize.control( 'pixtheme_header_layout' ).container.show();
            pix_info_sections_hide();
            if( value.get() == 'header1' ) {
                customize.control( 'pixtheme_header_menu_pos' ).container.show();
                customize.control( 'pixtheme_header_menu_right_info' ).container.show();
            }
        } else {
            customize.control( 'pixtheme_header_layout' ).container.hide();
        }
        value.bind( function( to ) {
            if( to != 'header3' && to != 'header4' ) {
                customize.control( 'pixtheme_header_menu_background' ).container.hide();
                customize.control( 'pixtheme_header_menu_transparent' ).container.hide();
                customize.control( 'pixtheme_header_info_segment' ).container.hide();
                customize.control( 'pixtheme_header_menu_pos' ).container.hide();
                customize.control( 'pixtheme_header_menu_right_info' ).container.hide();
                customize.control( 'pixtheme_header_layout' ).container.show();
                pix_info_sections_hide();
                if( to == 'header1' ) {
                    customize.control( 'pixtheme_header_menu_pos' ).container.show();
                    customize.control( 'pixtheme_header_menu_right_info' ).container.show();
                }
            } else {
                customize.control( 'pixtheme_header_menu_background' ).container.show();
                customize.control( 'pixtheme_header_menu_transparent' ).container.show();
                customize.control( 'pixtheme_header_menu_pos' ).container.show();
                customize.control( 'pixtheme_header_menu_right_info' ).container.show();
                customize.control( 'pixtheme_header_layout' ).container.hide();
                if( to == 'header4' ){
                    customize.control( 'pixtheme_header_info_segment' ).container.show();
                    pix_info_sections_toogle('info_1');
                }
            }
        } );
    } );

    customize( 'pixtheme_header_sticky', function( value ) {
        if( value.get() != '' ){
            customize.control( 'pixtheme_header_sticky_width' ).container.show();
        } else {
            customize.control( 'pixtheme_header_sticky_width' ).container.hide();
        }

        value.bind( function( to ) {
            if( to != '' ) {
                customize.control( 'pixtheme_header_sticky_width' ).container.show();
            } else {
                customize.control( 'pixtheme_header_sticky_width' ).container.hide();
            }
        });

    } );


    customize( 'pixtheme_header_menu_background', function( value ) {
        if( value.get() == 'black' || value.get() == 'white' ){
            customize.control( 'pixtheme_header_menu_transparent' ).container.show();
        } else {
            customize.control( 'pixtheme_header_menu_transparent' ).container.hide();
        }

        value.bind( function( to ) {
            if( to == 'black' || to == 'white' ) {
                customize.control( 'pixtheme_header_menu_transparent' ).container.show();
            } else {
                customize.control( 'pixtheme_header_menu_transparent' ).container.hide();
            }
        });

    } );



    customize( 'pixtheme_tab_position', function( value ) {
        var hide = customize.control( 'pixtheme_tab_hide' ).setting.get();
        if( value.get() == 'left_right' || value.get() == 'right_left' ){
            customize.control( 'pixtheme_tab_breadcrumbs_v_position' ).container.hide();
        } else if (hide == '') {
            customize.control( 'pixtheme_tab_breadcrumbs_v_position' ).container.show();
        }
        value.bind( function( to ) {
            if( to == 'left_right' || to == 'right_left' ) {
                customize.control( 'pixtheme_tab_breadcrumbs_v_position' ).container.hide();
            } else if (hide == '') {
                customize.control( 'pixtheme_tab_breadcrumbs_v_position' ).container.show();
            }
        });
    });

    customize( 'pixtheme_tab_hide', function( value ) {
        var position = customize.control( 'pixtheme_tab_position' ).setting.get();
        if( value.get() != '' ){
            customize.control( 'pixtheme_tab_breadcrumbs_v_position' ).container.hide();
        } else if( position != 'left_right' && position != 'right_left' ) {
            customize.control( 'pixtheme_tab_breadcrumbs_v_position' ).container.show();
        }
        value.bind( function( to ) {
            if( to != '' ) {
                customize.control( 'pixtheme_tab_breadcrumbs_v_position' ).container.hide();
            } else if( position == 'left_right' && position == 'right_left' ) {
                customize.control( 'pixtheme_tab_breadcrumbs_v_position' ).container.show();
            }
        });
    });



    customize( 'pixtheme_buttons_shadow', function( value ) {
        if( value.get() == '0' ){
            customize.control( 'pixtheme_buttons_shadow_h' ).container.hide();
            customize.control( 'pixtheme_buttons_shadow_v' ).container.hide();
            customize.control( 'pixtheme_buttons_shadow_blur' ).container.hide();
            customize.control( 'pixtheme_buttons_shadow_spread' ).container.hide();
            customize.control( 'pixtheme_buttons_shadow_color' ).container.hide();
            customize.control( 'pixtheme_buttons_shadow_opacity' ).container.hide();
        }

        value.bind( function( to ) {
            if( to == '0' ) {
                customize.control( 'pixtheme_buttons_shadow_h' ).container.hide();
                customize.control( 'pixtheme_buttons_shadow_v' ).container.hide();
                customize.control( 'pixtheme_buttons_shadow_blur' ).container.hide();
                customize.control( 'pixtheme_buttons_shadow_spread' ).container.hide();
                customize.control( 'pixtheme_buttons_shadow_color' ).container.hide();
                customize.control( 'pixtheme_buttons_shadow_opacity' ).container.hide();
            } else {
                customize.control( 'pixtheme_buttons_shadow_h' ).container.show();
                customize.control( 'pixtheme_buttons_shadow_v' ).container.show();
                customize.control( 'pixtheme_buttons_shadow_blur' ).container.show();
                customize.control( 'pixtheme_buttons_shadow_spread' ).container.show();
                customize.control( 'pixtheme_buttons_shadow_color' ).container.show();
                customize.control( 'pixtheme_buttons_shadow_opacity' ).container.show();
            }
        } );
    } );


    function pix_fonts_method_hide(){
        customize.control( 'pixtheme_fonts_embed' ).container.hide();
        customize.control( 'pixtheme_font_api' ).container.hide();
        customize.control( 'pixtheme_fonts_loader' ).container.hide();
    }

    function pix_fonts_method_toogle(val) {
        if( val == 'embed' ) {
            pix_fonts_method_hide();
            customize.control( 'pixtheme_fonts_embed' ).container.show();
        } else if( val == 'gapi' ) {
            pix_fonts_method_hide();
            customize.control( 'pixtheme_font_api' ).container.show();
            customize.control( 'pixtheme_fonts_loader' ).container.show();
        }
    }

    customize( 'pixtheme_fonts_method_segment', function( value ) {

        if( value.get() == '' ){
            pix_fonts_method_toogle('embed');
        } else {
            pix_fonts_method_toogle(value.get());
        }

        $('#customize-control-pixtheme_fonts_method_segment .pix-vc-segmented-button input[type=radio]').on('change', function(){
            var val = $(this).val();
            pix_fonts_method_toogle(val);
        });

    } );



    function pix_fonts_use_hide(){
        customize.control( 'pixtheme_font' ).container.hide();
        customize.control( 'pixtheme_font_weight' ).container.hide();
        customize.control( 'pixtheme_font_size' ).container.hide();
        customize.control( 'pixtheme_font_line_height' ).container.hide();
        customize.control( 'pixtheme_font_ratio' ).container.hide();
        customize.control( 'pixtheme_font_color' ).container.hide();
        customize.control( 'pixtheme_font_color_light' ).container.hide();
        customize.control( 'pixtheme_title_font' ).container.hide();
        customize.control( 'pixtheme_title_font_weight' ).container.hide();
        customize.control( 'pixtheme_title_font_size' ).container.hide();
        customize.control( 'pixtheme_title_font_color' ).container.hide();
        customize.control( 'pixtheme_title_font_style' ).container.hide();
        customize.control( 'pixtheme_title_letter_spacing' ).container.hide();
        customize.control( 'pixtheme_subtitle_font' ).container.hide();
        customize.control( 'pixtheme_subtitle_font_weight' ).container.hide();
        customize.control( 'pixtheme_subtitle_font_size' ).container.hide();
        customize.control( 'pixtheme_subtitle_font_color' ).container.hide();
        customize.control( 'pixtheme_subtitle_font_style' ).container.hide();
        customize.control( 'pixtheme_subtitle_letter_spacing' ).container.hide();
        customize.control( 'pixtheme_link_font' ).container.hide();
        customize.control( 'pixtheme_link_font_weight' ).container.hide();
        customize.control( 'pixtheme_link_font_size' ).container.hide();
        customize.control( 'pixtheme_link_font_color' ).container.hide();
        customize.control( 'pixtheme_link_font_style' ).container.hide();
        customize.control( 'pixtheme_buttons_font' ).container.hide();
        customize.control( 'pixtheme_buttons_font_weight' ).container.hide();
        customize.control( 'pixtheme_buttons_font_size' ).container.hide();
        customize.control( 'pixtheme_buttons_text_transform' ).container.hide();
        customize.control( 'pixtheme_buttons_font_style' ).container.hide();
        customize.control( 'pixtheme_buttons_letter_spacing' ).container.hide();
    }

    function pix_fonts_use_toogle(val) {
        if( val == 'text' ) {
            pix_fonts_use_hide();
            customize.control( 'pixtheme_font' ).container.show();
            customize.control( 'pixtheme_font_weight' ).container.show();
            customize.control( 'pixtheme_font_size' ).container.show();
            customize.control( 'pixtheme_font_line_height' ).container.show();
            customize.control( 'pixtheme_font_ratio' ).container.show();
            customize.control( 'pixtheme_font_color' ).container.show();
            customize.control( 'pixtheme_font_color_light' ).container.show();
        } else if( val == 'title' ) {
            pix_fonts_use_hide();
            customize.control( 'pixtheme_title_font' ).container.show();
            customize.control( 'pixtheme_title_font_weight' ).container.show();
            customize.control( 'pixtheme_title_font_size' ).container.show();
            customize.control( 'pixtheme_title_font_color' ).container.show();
            customize.control( 'pixtheme_title_font_style' ).container.show();
            customize.control( 'pixtheme_title_letter_spacing' ).container.show();
        } else if( val == 'subtitle' ) {
            pix_fonts_use_hide();
            customize.control( 'pixtheme_subtitle_font' ).container.show();
            customize.control( 'pixtheme_subtitle_font_weight' ).container.show();
            customize.control( 'pixtheme_subtitle_font_size' ).container.show();
            customize.control( 'pixtheme_subtitle_font_color' ).container.show();
            customize.control( 'pixtheme_subtitle_font_style' ).container.show();
            customize.control( 'pixtheme_subtitle_letter_spacing' ).container.show();
        } else if( val == 'link' ) {
            pix_fonts_use_hide();
            customize.control( 'pixtheme_link_font' ).container.show();
            customize.control( 'pixtheme_link_font_weight' ).container.show();
            customize.control( 'pixtheme_link_font_size' ).container.show();
            customize.control( 'pixtheme_link_font_color' ).container.show();
            customize.control( 'pixtheme_link_font_style' ).container.show();
        } else if( val == 'button' ) {
            pix_fonts_use_hide();
            customize.control( 'pixtheme_buttons_font' ).container.show();
            customize.control( 'pixtheme_buttons_font_weight' ).container.show();
            customize.control( 'pixtheme_buttons_font_size' ).container.show();
            customize.control( 'pixtheme_buttons_text_transform' ).container.show();
            customize.control( 'pixtheme_buttons_font_style' ).container.show();
            customize.control( 'pixtheme_buttons_letter_spacing' ).container.show();
        }
    }

    customize( 'pixtheme_fonts_use_segment', function( value ) {

        if( value.get() == '' ){
            pix_fonts_use_hide();
        } else {
            pix_fonts_use_toogle(value.get());
        }

        $('#customize-control-pixtheme_fonts_use_segment .pix-vc-segmented-button input[type=radio]').on('change', function(){
            var val = $(this).val();
            pix_fonts_use_toogle(val);
        });

    } );



    $('.pix-vc-segmented-button').each(function () {

        var $container = $(this),
        $input = $container.find('input.pix-input-vc-segmented-button'),
        $radioboxes = $container.find('.pix-segmented-button-field'),
        $value = $input.val();

        //reset all selected value
        $container.find('.pix-segmented-button-field').prop('checked', false);
        $container.find('.pix-segmented-button-field[value="'+ $value +'"]').prop('checked', true);

        $radioboxes.on('click', function() {
            if($(this).prop('checked')) {
                $container.find('.pix-segmented-button-field').prop('checked', false);
                $(this).prop('checked', true);
                $value = $(this).val();
            }
            $input.val($value);
            if( !$input.hasClass('tabs') ) {
                $input.trigger("change");
            }
        });

    });




    /// Google Fonts Loader

    function pix_set_fonts(){
    	var font_families = [];
	    $.each($('.pix-google-font-str'), function(){
    		if($(this).val() != '') {
                font_families.push($(this).val());
            }
        });

    	$('#pix-fonts-embed').val(font_families.join('|'));
    	$('#pix-fonts-embed').change();
	}

	function pix_set_selected_fonts(){
    	$('.pix-google-font').find('option').remove().end();
    	$.each($('.pix-google-font-str'), function(){
    		var font_family = $(this).val().split(":");
    		var font_weights = '';
    		if(typeof font_family[1] !== 'undefined') {
				font_weights = font_family[1];
			}
    		$('.pix-google-font').append("<option value='" + font_family[0] + "' data-weights='" + font_weights + "'>" + font_family[0] + "</option>");
        });
	}

	function pix_change_selected_weights(){
    	$.each($('.pix-google-font'), function(){
            var weight_id = $(this).data('weight-id');
            var current_weight = $('#'+weight_id).find(':selected').val();
            var font_weights = [];
            font_weights = String($(this).find(':selected').data('weights')).split(',');

            $('#'+weight_id).find('option').remove().end();
            if(font_weights[0] != ''){
                $.each(font_weights, function(i, item){
                    $('#'+weight_id).append("<option value='" + item + "'>" + item + "</option>");
                });
                $('#'+weight_id).val(current_weight);
            } else {
                $('#'+weight_id).append("<option value='400'>400</option>");
            }
        });
	}

    $(document).on('change', '#pix-fonts-embed', function(){
		var font_families = $(this).val().split("|");
		$('.pix-google-font').find('option').remove().end();
	    $('.pix-google-font-wrapper').remove();
	    $.each(font_families, function(i, item){
	        var font_family = item.split(":");
	        var font_weights = '';
            if(typeof font_family[1] !== 'undefined') {
				font_weights = font_family[1];
			}
			var font_family_name = font_family[0].replace(/\+/g, ' ');
            var font_item = item.replace(/\+/g, ' ');
			var font_wrapper = '<div class="pix-google-font-wrapper" data-font="'+font_family_name+'"><label class="pix-customize-control-label">'+font_item+'</label><input type="hidden" class="pix-google-font-str" value="'+item+'" data-font-weights="'+font_weights+'"><button type="button" class="btn pix-wrapper-delete"><i class="fas fa-trash-alt"></i></button></div>';
			$('#pix-google-font-select').before(font_wrapper);
			$('.pix-google-font').append("<option value='" + font_family_name + "' data-weights='" + font_weights + "'>" + font_family_name + "</option>");
        });

		$('#pix-font-weights').val('');
		$('#pix-google-font-select').addClass('close');
	});

	$(document).on('change', '.pix-google-font', function(){
		var weight_id = $(this).data('weight-id');
		var font_weights = [];
		font_weights = String($(this).find(':selected').data('weights')).split(",");
		$('#'+weight_id).find('option').remove().end();
		if(font_weights[0] != ''){
		    $.each(font_weights, function(i, item){
                $('#'+weight_id).append("<option value='" + item + "'>" + item + "</option>");
            });
        } else {
		    $('#'+weight_id).append("<option value='400'>400</option>");
        }
    });

	$(document).on('click', '.pix-wrapper-apply', function(){
    	var font_name = $('#pix-google-font-select').attr('data-font');
        var font_weights = $('#pix-font-weights').val();
        var font_name_str = font_name.replace(/ /g, '+');
        if(font_weights != ''){
            font_name_str = font_name_str+':'+font_weights;
        }

        $('.pix-google-font-wrapper[data-font="'+font_name+'"]').find('.pix-google-font-str').val(font_name_str);
		pix_set_fonts();
	});

    $(document).on('click', '.pix-wrapper-delete', function(){
    	$(this).parent().remove();
		pix_set_fonts();
	});

	$(document).on('click', '.pix-customize-control-label', function(){
		var font_name = $(this).parent().attr('data-font');
		var font_weights = $(this).parent().find('.pix-google-font-str').data('font-weights');
		$.each($('.pix-google-font-wrapper'), function(){
            $('.pix-customize-control-label', this).removeClass('active');
        });
		$(this).addClass('active');
		$('#pix-font-weights').val(font_weights);
		$('#pix-google-font-select').attr('data-font', font_name);
		$('#pix-google-font-select').removeClass('close');

	});


});
