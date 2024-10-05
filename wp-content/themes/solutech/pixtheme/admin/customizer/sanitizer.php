<?php

	/** customizer sanitize functions **/

	function pixtheme_sanitize_text( $input ) {
		return wp_kses_post( $input );
	}

	function pixtheme_sanitize_checkbox( $input ) {
		if ( $input == 'on' ) {
			return 'on';
		} else {
			return '';
		}
	}

	function pixtheme_sanitize_per_page( $input ) {
		if ( is_numeric( $input ) && $input != '0' ) {
			return absint( $input );
		} else return '';
	}

	function pixtheme_sanitize_absinteger( $input ) {
		if ( is_numeric( $input ) && $input != '0' ) {
			return absint( $input );
		} else return '';
	}

	function pixtheme_sanitize_email( $email ) {
		if (is_email( $email ) ) {
			return $email;
		} else {
			return '';
		}
	}

	function pixtheme_sanitize_layout( $value ) {
		if ( ! in_array( $value, array( 'content-sidebar', 'sidebar-content' ) ) ) {
			$value = 'content-sidebar';
		}

		return $value;
	}

	function pixtheme_sanitize_loader( $value ) {
		if ( ! in_array( $value, array( 'off', 'usemain', 'useall' ) ) ) {
			$value = 'off';
		}

		return $value;
	}

	function pixtheme_sanitize_onoff( $value ) {
		if ( ! in_array( $value, array( 'on', 'off' ) ) ) {
			$value = 'on';
		}

		return $value;
	}

	function pixtheme_sanitize_sidebar_blog_type( $value ) {
		if ( ! in_array( $value, array( '1', '2', '3' ) ) ) {
			$value = '2';
		}

		return $value;
	}

	function pixtheme_sanitize_sidebar_blog_content( $value ) {
		if ( ! in_array( $value, array( 'sidebar-1', 'global-sidebar-1', 'portfolio-sidebar-1', 'product-sidebar-1', 'custom-area-1' ) ) ) {
			$value = 'sidebar-1';
		}

		return $value;
	}

	function pixtheme_sanitize_header_type( $value ) {
		if ( ! in_array( $value, array( '1', '2' ) ) ) {
			$value = '1';
		}

		return $value;
	}

	function pixtheme_sanitize_overlay_opacity( $value ) {
		if ( ! in_array( $value, array( '0.1', '0.2', '0.3', '0.4', '0.5', '0.6', '0.7', '0.8', '0.9' ) ) ) {
			$value = '0.1';
		}

		return $value;
	}

	function pixtheme_sanitize_portfolio_type( $value ) {
		if ( ! in_array( $value, array( 'type_without_icons', 'type_with_icons' ) ) ) {
			$value = 'type_without_icons';
		}

		return $value;
	}

	function pixtheme_sanitize_portfolio_perrow( $value ) {
		if ( ! in_array( $value, array( '2', '3', '4' ) ) ) {
			$value = '2';
		}

		return $value;
	}

	function pixtheme_sanitize_sidebar_portfolio_type( $value ) {
		if ( ! in_array( $value, array( '1', '2', '3' ) ) ) {
			$value = '2';
		}

		return $value;
	}

	function pixtheme_sanitize_sidebar_portfolio_content( $value ) {
		if ( ! in_array( $value, array( 'sidebar-1', 'global-sidebar-1', 'portfolio-sidebar-1', 'custom-area-1' ) ) ) {
			$value = 'sidebar-1';
		}

		return $value;
	}

	function pixtheme_sanitize_animation( $value ) {
		if ( ! in_array( $value, array(
				'bounce', 'flash', 'pulse', 'rubberBand', 'shake', 'swing', 'tada', 'wobble', 'jello', 'bounceIn',
				'bounceInDown', 'bounceInLeft', 'bounceInRight', 'bounceInUp', 'bounceOut', 'bounceOutDown',
				'bounceOutLeft', 'bounceOutRight', 'bounceOutUp', 'fadeIn', 'fadeInDown', 'fadeInDownBig',
				'fadeInLeft', 'fadeInLeftBig', 'fadeInRight', 'fadeInRightBig', 'fadeInUp', 'fadeInUpBig', 'fadeOut',
				'fadeOutDown', 'fadeOutDownBig', 'fadeOutLeft', 'fadeOutLeftBig', 'fadeOutRight', 'fadeOutRightBig',
				'fadeOutUp', 'fadeOutUpBig', 'flip', 'flipInX', 'flipInY', 'flipOutX', 'flipOutY', 'lightSpeedIn',
				'lightSpeedOut', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft',
				'rotateInUpRight', 'rotateOut', 'rotateOutDownLeft', 'rotateOutDownRight', 'rotateOutUpLeft',
				'rotateOutUpRight', 'slideInUp', 'slideInDown', 'slideInLeft', 'slideInRight', 'slideOutUp',
				'slideOutDown', 'slideOutLeft', 'slideOutRight', 'zoomIn', 'zoomInDown', 'zoomInLeft', 'zoomInRight',
				'zoomInUp', 'zoomOut', 'zoomOutDown', 'zoomOutLeft', 'zoomOutRight', 'zoomOutUp', 'hinge', 'rollIn',
				'rollOut'
			) ) ) {
			$value = '';
		}

		return $value;
	}

	function pixtheme_sanitize_footer_block($input) {
		$valid = pixtheme_get_staticblock_option_array();

		if ( array_key_exists($input, $valid) ) {
			return $input;
		} else {
			return 'default';
		}
	}