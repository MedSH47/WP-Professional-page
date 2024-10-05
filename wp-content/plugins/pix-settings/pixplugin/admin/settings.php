<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'PixSettings' ) ) {

class PixSettings {

	public $defaults = array();

	public $settings = array();

	public $supported_i8n = array();

	public function __construct() {

		add_action( 'init', array( $this, 'set_defaults' ) );

		add_action( 'init', array( $this, 'load_settings_panel' ) );

	}

	public function set_defaults() {
        $year = date('Y');
		$this->defaults = array(

		    // General
            'pix-calculator'            => 'on',
		    'pix-portfolio'             => 'on',
		    'pix-service'               => 'on',
		    'pix-team'                  => 'on',
		    'pix-img-base-size'         => '650',
		    'pix-img-landscape-ratio'   => '1.618',
		    'pix-img-portrait-ratio'    => '1.333',
		    'pix-retina-img'            => 'off',
            'pix-google-api'            => '',
            'pix-dynamic-style'         => 'off',
            
            
            /// Layout
            'pix-width-global'          => 'right',
            'pix-boxed-global'          => 'on',
            'pix-layout-blog'           => 'right',
            'pix-sidebar-blog'          => 'sidebar',
            'pix-layout-page'           => 'full-width',
            'pix-sidebar-page'          => 'sidebar',
            'pix-width-page'            => '',
            'pix-layout-post'           => 'right',
            'pix-sidebar-post'          => 'sidebar',
            'pix-width-post'            => '',
            'pix-layout-shop'           => 'right',
            'pix-sidebar-shop'          => 'shop-sidebar',
            'pix-layout-product-cat'    => 'right',
            'pix-sidebar-product-cat'   => 'shop-sidebar',
            'pix-layout-product'        => 'right',
            'pix-sidebar-product'       => 'product-sidebar',
            'pix-width-product'         => '',
            'pix-layout-portfolio-cat'  => 'right',
            'pix-sidebar-portfolio-cat' => 'portfolio-sidebar',
            'pix-layout-portfolio'      => 'right',
            'pix-sidebar-portfolio'     => 'portfolio-sidebar',
            'pix-col-portfolio-cat'     => '2',
            'pix-images-portfolio-cat'  => 'pixtheme-landscape',
            'pix-width-portfolio'       => '',
            'pix-layout-service-cat'    => 'right',
            'pix-sidebar-service-cat'   => 'service-sidebar',
            'pix-col-service-cat'       => '3',
            'pix-images-service-cat'    => 'pixtheme-square',
            'pix-layout-service'        => 'right',
            'pix-sidebar-service'       => 'service-sidebar',
            'pix-width-service'         => '',
            'pix-layout-team-cat'       => 'right',
            'pix-sidebar-team-cat'      => 'team-sidebar',
            'pix-col-team-cat'          => '4',
            'pix-images-team-cat'       => 'pixtheme-portrait',
            'pix-layout-team'           => 'right',
            'pix-sidebar-team'          => 'team-sidebar',
            'pix-width-team'            => '',


            // Blog
            'pix-blog-style'            => 'classic',
            'pix-blog-sidebar'          => 'no-padding',
            'pix-blog-date'             => 'on',
            'pix-blog-author'           => 'on',
            'pix-blog-comments'         => 'on',
            'pix-blog-categories'       => 'on',
            'pix-blog-icons'            => 'off',
            'pix-blog-tags'             => 'on',
            'pix-blog-share'            => 'on',


            // Footer
            'pix-footer-copyright'      => '&copy; 2013-'.$year.' <span>All Rights Reserved</span>'
		);

		$i8n = str_replace( '-', '_', get_bloginfo( 'language' ) );
		if ( array_key_exists( $i8n, $this->supported_i8n ) ) {
			$this->defaults['i8n'] = $i8n;
		}

		$this->defaults = apply_filters( 'pix_settings_defaults', $this->defaults );
	}

	/**
	 * Get a setting's value or fallback to a default if one exists
	 */
	public function get_setting( $setting ) {

		if ( empty( $this->settings ) ) {
			$this->settings = get_option( 'pix-settings' );
		}

		if ( !empty( $this->settings[ $setting ] ) ) {
			return apply_filters( 'pix-setting-' . $setting, $this->settings[ $setting ] );
		}

		if ( !empty( $this->defaults[ $setting ] ) ) {
			return apply_filters( 'pix-setting-' . $setting, $this->defaults[ $setting ] );
		}

		return apply_filters( 'pix-setting-' . $setting, null );
	}




	public function load_settings_panel() {
        
        global $pix_settings;

		require_once( PIX_PLUGIN_DIR . '/pixplugin/admin/classes/class.Library.php' );
		$args = array(
		    'lib_url' => PIX_PLUGIN_URL . '/pixplugin/admin/',
		);
		$pix = new PixAdminLibrary( $args );

		$pix->add_page(
			'menu',
			array(
				'id'            => 'pix-settings',
				'title'         => __( 'Pix Settings', 'pixsettings' ),
				'menu_title'    => __( 'Pix Settings', 'pixsettings' ),
				'description'   => '',
				'capability'    => 'manage_options',
                'icon'          => PIX_PLUGIN_URL . '/assets/images/pix-logo.png',//'dashicons-shield',
				'position'      => '3',
                'default_tab'   => 'pix-general',
			)
		);


		/// General

		$pix->add_section(
			'pix-settings',
			array(
				'id'            => 'pix-general',
				'title'         => __( 'General', 'pixsettings' ),
				'is_tab'	    => true,
			)
		);
        
  
		$pix->add_setting(
            'pix-settings',
            'pix-general',
            'toggle',
            array(
                'id'            => 'pix-calculator',
                'title'         => __( 'Calculators', 'pixsettings' ),
                'description'   => __( 'Use calculators.', 'pixsettings' ),
                'default_value'	=> $this->defaults['pix-calculator'],
            )
        );
		
        $pix->add_setting(
            'pix-settings',
            'pix-general',
            'toggle',
            array(
                'id'            => 'pix-team',
                'title'         => __( 'Team', 'pixsettings' ),
                'description'   => __( 'Use team post type.', 'pixsettings' ),
                'default_value'	=> $this->defaults['pix-team'],
            )
        );
        
        $pix->add_setting(
            'pix-settings',
            'pix-general',
            'post',
            array(
                'id'            => 'pix-team-page',
                'title'         => __( 'Team Page', 'pixsettings' ),
                'description'   => __( 'Select a page on your site to display all Team.', 'pixsettings' ),
                'blank_option'	=> true,
                'placeholder'	=> __( 'Select Page', 'pixsettings' ),
                'args'			=> array(
                    'post_type' 		=> 'page',
                    'posts_per_page'	=> -1,
                    'post_status'		=> 'publish',
                ),
            )
        );

		$pix->add_setting(
			'pix-settings',
			'pix-general',
			'toggle',
			array(
				'id'            => 'pix-portfolio',
				'title'         => __( 'Portfolio', 'pixsettings' ),
				'description'   => __( 'Use portfolio post type.', 'pixsettings' ),
				'default_value'	=> $this->defaults['pix-portfolio'],
			)
		);
		
		$pix->add_setting(
            'pix-settings',
            'pix-general',
            'post',
            array(
                'id'            => 'pix-portfolio-page',
                'title'         => __( 'Portfolio Page', 'pixsettings' ),
                'description'   => __( 'Select a page on your site to display all Portfolio.', 'pixsettings' ),
                'blank_option'	=> true,
                'placeholder'	=> __( 'Select Page', 'pixsettings' ),
                'args'			=> array(
                    'post_type' 		=> 'page',
                    'posts_per_page'	=> -1,
                    'post_status'		=> 'publish',
                ),
            )
        );
        
        $pix->add_setting(
            'pix-settings',
            'pix-general',
            'toggle',
            array(
                'id'            => 'pix-service',
                'title'         => __( 'Services', 'pixsettings' ),
                'description'   => __( 'Use service post type.', 'pixsettings' ),
                'default_value'	=> $this->defaults['pix-service'],
            )
        );
        
        $pix->add_setting(
            'pix-settings',
            'pix-general',
            'post',
            array(
                'id'            => 'pix-service-page',
                'title'         => __( 'Services Page', 'pixsettings' ),
                'description'   => __( 'Select a page on your site to display all Services.', 'pixsettings' ),
                'blank_option'	=> true,
                'placeholder'	=> __( 'Select Page', 'pixsettings' ),
                'args'			=> array(
                    'post_type' 		=> 'page',
                    'posts_per_page'	=> -1,
                    'post_status'		=> 'publish',
                ),
            )
        );
        
        $pix->add_setting(
			'pix-settings',
			'pix-general',
			'text',
			array(
				'id'            => 'pix-img-base-size',
				'title'         => __( 'Image Base Size', 'pixsettings' ),
				'class'         => 'pix-width-xs',
				'description'   => __( 'Based on this size, Portrait, Landscape, Square thumbnails proportions of the image are created. After the change, need to Regenerate Thumbnails', 'pixsettings' ),
				'placeholder'   => $this->defaults['pix-img-base-size'],
				'default_value'	=> $this->defaults['pix-img-base-size'],
			)
		);
        
        $pix->add_setting(
			'pix-settings',
			'pix-general',
			'text',
			array(
				'id'            => 'pix-img-landscape-ratio',
				'title'         => __( 'Image Landscape Ratio', 'pixsettings' ),
				'class'         => 'pix-width-xs',
				'description'   => __( '[Ratio]:1 thumbnails proportions of the image are created. After the change, need to Regenerate Thumbnails', 'pixsettings' ),
				'placeholder'   => $this->defaults['pix-img-landscape-ratio'],
				'default_value'	=> $this->defaults['pix-img-landscape-ratio'],
			)
		);
        
         $pix->add_setting(
			'pix-settings',
			'pix-general',
			'text',
			array(
				'id'            => 'pix-img-portrait-ratio',
				'title'         => __( 'Image Portrait Ratio', 'pixsettings' ),
				'class'         => 'pix-width-xs',
				'description'   => __( '1:[Ratio] thumbnails proportions of the image are created. After the change, need to Regenerate Thumbnails', 'pixsettings' ),
				'placeholder'   => $this->defaults['pix-img-portrait-ratio'],
				'default_value'	=> $this->defaults['pix-img-portrait-ratio'],
			)
		);

        $pix->add_setting(
			'pix-settings',
			'pix-general',
			'toggle',
			array(
				'id'            => 'pix-retina-img',
				'title'         => __( 'Retina Images', 'pixsettings' ),
				'description'   => __( 'The images on the site have increased resolution (for retina displays).', 'pixsettings' ),
				'default_value'	=> $this->defaults['pix-retina-img'],
			)
		);
        
        $pix->add_setting(
            'pix-settings',
            'pix-general',
            'toggle',
            array(
                'id'            => 'pix-dynamic-style',
                'title'         => __( 'Dynamic Style CSS load', 'pixsettings' ),
                'description'   => __( 'Dynamic style css load from the file /css/dynamic-style.css. Can increased page loading speed.', 'pixsettings' ),
                'default_value'	=> $this->defaults['pix-dynamic-style'],
            )
        );
        
        $pix->add_setting(
			'pix-settings',
			'pix-general',
			'text',
			array(
				'id'            => 'pix-google-api',
				'title'         => __( 'Google API Key', 'pixsettings' ),
				'class'         => 'pix-width-xl',
				'description'   => __( '<a href="https://help.pix-theme.com/knowledge-base/how-to-create-google-api-keys/" target="_blank">How to create Google API key</a> Maps JavaScript API for billing account and Maps Embed API for free.', 'pixsettings' ),
				'default_value'	=> '',
			)
		);
        // <= General END
        
        
        
        global $wp_registered_sidebars;
        $pix_sidebars = array( '' => esc_html__( 'Select Sidebar', 'pixsettings' ));
        foreach($wp_registered_sidebars as $key => $val){
            $pix_sidebars[$val['id']] = $val['name'];
        }
        
        $pix_width_global_arr = array(
            '1300' => '1300px',
            '1200' => '1140px',
            '1000' =>  '980px',
             '900' =>  '860px',
        );
        
        $pix_width_arr = array(
            ''     => __( 'Global', 'pixsettings' ),
            '1300' => '1300px',
            '1200' => '1140px',
            '1000' =>  '980px',
             '900' =>  '860px',
        );
        
        $pix_images_arr = array(
            'pixtheme-original'     => __( 'Original', 'pixsettings' ),
            'pixtheme-landscape'    => __( 'Landscape', 'pixsettings' ),
            'pixtheme-portrait'     => __( 'Portrait', 'pixsettings' ),
            'pixtheme-square'       => __( 'Square', 'pixsettings' ),
        );
        
        $pix_cols_arr = array(
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '8' => '8',
        );
        
        /// Layout
        
        $pix->add_section(
            'pix-settings',
            array(
                'id'            => 'pix-layout',
                'title'         => __( 'Layout', 'pixsettings' ),
                'is_tab'	    => true,
            )
        );
        
        $pix->add_setting(
            'pix-settings',
            'pix-layout',
            'select',
            array(
                'id'            => 'pix-width-global',
                'title'			=> esc_html__( 'Global', 'pixsettings' ),
                'description'   => esc_html__( 'Container width.', 'pixsettings' ),
                'blank_option'	=> false,
                'default_value' => $this->defaults['pix-width-global'],
                'options'       => $pix_width_global_arr
            )
            
        );
        
        $pix->add_setting(
			'pix-settings',
			'pix-layout',
			'toggle',
			array(
				'id'            => 'pix-boxed-global',
				'title'         => '',
				'description'   => __( 'Boxed container with shadow.', 'pixsettings' ),
				'default_value'	=> $this->defaults['pix-boxed-global'],
			)
		);
        
        $pix->add_setting(
            'pix-settings',
            'pix-layout',
            'radio-image',
            array(
                'id'			=> 'pix-layout-page',
                'title'			=> esc_html__( 'Page', 'pixsettings' ),
                'description'   => esc_html__( 'Page layout type.', 'pixsettings' ),
                'default_value'	=> $this->defaults['pix-layout-page'],
                'images'        => array(
                    'left'          => 'layout-side-left.svg',
                    'full-width'    => 'layout-side-full-width.svg',
                    'right'         => 'layout-side-right.svg'
                ),
            )
        );
        
        $pix->add_setting(
            'pix-settings',
            'pix-layout',
            'select',
            array(
                'id'            => 'pix-sidebar-page',
                'title'         => '',
                'description'   => '',
                'blank_option'	=> false,
                'default_value' => $this->defaults['pix-sidebar-page'],
                'options'       => $pix_sidebars
            )
        );
        
        $pix->add_setting(
            'pix-settings',
            'pix-layout',
            'select',
            array(
                'id'            => 'pix-width-page',
                'title'         => '',
                'description'   => esc_html__( 'Container width without sidebar.', 'pixsettings' ),
                'blank_option'	=> false,
                'default_value' => $this->defaults['pix-width-page'],
                'options'       => $pix_width_arr
            )
        );
        
        $pix->add_setting(
            'pix-settings',
            'pix-layout',
            'radio-image',
            array(
                'id'			=> 'pix-layout-blog',
                'title'			=> esc_html__( 'Blog', 'pixsettings' ),
                'description'   => esc_html__( 'Blog page layout type.', 'pixsettings' ),
                'default_value'	=> $this->defaults['pix-layout-blog'],
                'images'        => array(
                    'left'          => 'layout-side-left.svg',
                    'full-width'    => 'layout-side-full-width.svg',
                    'right'         => 'layout-side-right.svg'
                ),
            )
        );
        
        $pix->add_setting(
            'pix-settings',
            'pix-layout',
            'select',
            array(
                'id'            => 'pix-sidebar-blog',
                'title'         => '',
                'description'   => '',
                'blank_option'	=> false,
                'default_value' => $this->defaults['pix-sidebar-blog'],
                'options'       => $pix_sidebars
            )
        );
        
        $pix->add_setting(
            'pix-settings',
            'pix-layout',
            'radio-image',
            array(
                'id'			=> 'pix-layout-post',
                'title'			=> esc_html__( 'Post', 'pixsettings' ),
                'description'   => esc_html__( 'Single Post layout type.', 'pixsettings' ),
                'default_value'	=> $this->defaults['pix-layout-post'],
                'images'        => array(
                    'left'          => 'layout-side-left.svg',
                    'full-width'    => 'layout-side-full-width.svg',
                    'right'         => 'layout-side-right.svg'
                ),
            )
        );
        
        $pix->add_setting(
            'pix-settings',
            'pix-layout',
            'select',
            array(
                'id'            => 'pix-sidebar-post',
                'title'         => '',
                'description'   => '',
                'blank_option'	=> false,
                'default_value' => $this->defaults['pix-sidebar-post'],
                'options'       => $pix_sidebars
            )
        );
        
        $pix->add_setting(
            'pix-settings',
            'pix-layout',
            'select',
            array(
                'id'            => 'pix-width-post',
                'title'         => '',
                'description'   => esc_html__( 'Container width without sidebar.', 'pixsettings' ),
                'blank_option'	=> false,
                'default_value' => $this->defaults['pix-width-post'],
                'options'       => $pix_width_arr
            )
        );
        
        if (class_exists('WooCommerce')) :
        
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'radio-image',
                array(
                    'id'			=> 'pix-layout-shop',
                    'title'			=> esc_html__( 'Shop', 'pixsettings' ),
                    'description'   => esc_html__( 'Shop page layout type.', 'pixsettings' ),
                    'default_value'	=> $this->defaults['pix-layout-shop'],
                    'images'        => array(
                        'left'          => 'layout-side-left.svg',
                        'full-width'    => 'layout-side-full-width.svg',
                        'right'         => 'layout-side-right.svg'
                    ),
                )
            );
    
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'select',
                array(
                    'id'            => 'pix-sidebar-shop',
                    'title'         => '',
                    'description'   => '',
                    'blank_option'	=> false,
                    'default_value' => $this->defaults['pix-sidebar-shop'],
                    'options'       => $pix_sidebars
                )
            );
            
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'radio-image',
                array(
                    'id'			=> 'pix-layout-product-cat',
                    'title'			=> esc_html__( 'Product Category', 'pixsettings' ),
                    'description'   => esc_html__( 'Product Category page layout type.', 'pixsettings' ),
                    'default_value'	=> $this->defaults['pix-layout-product-cat'],
                    'images'        => array(
                        'left'          => 'layout-side-left.svg',
                        'full-width'    => 'layout-side-full-width.svg',
                        'right'         => 'layout-side-right.svg'
                    ),
                )
            );
    
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'select',
                array(
                    'id'            => 'pix-sidebar-product-cat',
                    'title'         => '',
                    'description'   => '',
                    'blank_option'	=> false,
                    'default_value' => $this->defaults['pix-sidebar-product-cat'],
                    'options'       => $pix_sidebars
                )
            );
            
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'radio-image',
                array(
                    'id'			=> 'pix-layout-product',
                    'title'			=> esc_html__( 'Product', 'pixsettings' ),
                    'description'   => esc_html__( 'Product page layout type.', 'pixsettings' ),
                    'default_value'	=> $this->defaults['pix-layout-product'],
                    'images'        => array(
                        'left'          => 'layout-side-left.svg',
                        'full-width'    => 'layout-side-full-width.svg',
                        'right'         => 'layout-side-right.svg'
                    ),
                )
            );
    
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'select',
                array(
                    'id'            => 'pix-sidebar-product',
                    'title'         => '',
                    'description'   => '',
                    'blank_option'	=> false,
                    'default_value' => $this->defaults['pix-sidebar-product'],
                    'options'       => $pix_sidebars
                )
            );
    
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'select',
                array(
                    'id'            => 'pix-width-product',
                    'title'         => '',
                    'description'   => esc_html__( 'Container width without sidebar.', 'pixsettings' ),
                    'blank_option'	=> false,
                    'default_value' => $this->defaults['pix-width-product'],
                    'options'       => $pix_width_arr
                )
            );
        
        endif;
        
        if($pix_settings->settings->get_setting('pix-team') == 'on') :
        
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'radio-image',
                array(
                    'id'			=> 'pix-layout-team-cat',
                    'title'			=> esc_html__( 'Team Category', 'pixsettings' ),
                    'description'   => esc_html__( 'Team Category page layout type.', 'pixsettings' ),
                    'default_value'	=> $this->defaults['pix-layout-team-cat'],
                    'images'        => array(
                        'left'          => 'layout-side-left.svg',
                        'full-width'    => 'layout-side-full-width.svg',
                        'right'         => 'layout-side-right.svg'
                    ),
                )
            );
            
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'select',
                array(
                    'id'            => 'pix-sidebar-team-cat',
                    'title'         => '',
                    'description'   => '',
                    'blank_option'	=> false,
                    'default_value' => $this->defaults['pix-sidebar-team-cat'],
                    'options'       => $pix_sidebars
                )
            );
        
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'select',
                array(
                    'id'            => 'pix-col-team-cat',
                    'title'         => '',
                    'description'   => esc_html__( 'Columns count.', 'pixsettings' ),
                    'class'         => 'pix-width-xs',
                    'blank_option'	=> false,
                    'default_value' => $this->defaults['pix-col-team-cat'],
                    'options'       => $pix_cols_arr
                )
            );
            
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'select',
                array(
                    'id'            => 'pix-images-team-cat',
                    'title'         => '',
                    'description'   => esc_html__( 'Image proportions.', 'pixsettings' ),
                    'blank_option'	=> false,
                    'default_value' => $this->defaults['pix-images-team-cat'],
                    'options'       => $pix_images_arr
                )
            );
            
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'radio-image',
                array(
                    'id'			=> 'pix-layout-team',
                    'title'			=> esc_html__( 'Team', 'pixsettings' ),
                    'description'   => esc_html__( 'Team page layout type.', 'pixsettings' ),
                    'default_value'	=> $this->defaults['pix-layout-team'],
                    'images'        => array(
                        'left'          => 'layout-side-left.svg',
                        'full-width'    => 'layout-side-full-width.svg',
                        'right'         => 'layout-side-right.svg'
                    ),
                )
            );
            
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'select',
                array(
                    'id'            => 'pix-sidebar-team',
                    'title'         => '',
                    'description'   => '',
                    'blank_option'	=> false,
                    'default_value' => $this->defaults['pix-sidebar-team'],
                    'options'       => $pix_sidebars
                )
            );
    
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'select',
                array(
                    'id'            => 'pix-width-team',
                    'title'         => '',
                    'description'   => esc_html__( 'Container width without sidebar.', 'pixsettings' ),
                    'blank_option'	=> false,
                    'default_value' => $this->defaults['pix-width-team'],
                    'options'       => $pix_width_arr
                )
            );
        
        endif;
        
        if($pix_settings->settings->get_setting('pix-portfolio') == 'on') :
            
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'radio-image',
                array(
                    'id'			=> 'pix-layout-portfolio-cat',
                    'title'			=> esc_html__( 'Portfolio Category', 'pixsettings' ),
                    'description'   => esc_html__( 'Portfolio Category page layout type.', 'pixsettings' ),
                    'default_value'	=> $this->defaults['pix-layout-portfolio-cat'],
                    'images'        => array(
                        'left'          => 'layout-side-left.svg',
                        'full-width'    => 'layout-side-full-width.svg',
                        'right'         => 'layout-side-right.svg'
                    ),
                )
            );
            
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'select',
                array(
                    'id'            => 'pix-sidebar-portfolio-cat',
                    'title'         => '',
                    'description'   => '',
                    'blank_option'	=> false,
                    'default_value' => $this->defaults['pix-sidebar-portfolio-cat'],
                    'options'       => $pix_sidebars
                )
            );
            
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'select',
                array(
                    'id'            => 'pix-col-portfolio-cat',
                    'title'         => '',
                    'description'   => esc_html__( 'Columns count.', 'pixsettings' ),
                    'class'         => 'pix-width-xs',
                    'blank_option'	=> false,
                    'default_value' => $this->defaults['pix-col-portfolio-cat'],
                    'options'       => $pix_cols_arr
                )
            );
    
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'select',
                array(
                    'id'            => 'pix-images-portfolio-cat',
                    'title'         => '',
                    'description'   => esc_html__( 'Image proportions.', 'pixsettings' ),
                    'blank_option'	=> false,
                    'default_value' => $this->defaults['pix-images-portfolio-cat'],
                    'options'       => $pix_images_arr
                )
            );
            
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'radio-image',
                array(
                    'id'			=> 'pix-layout-portfolio',
                    'title'			=> esc_html__( 'Portfolio', 'pixsettings' ),
                    'description'   => esc_html__( 'Portfolio page layout type.', 'pixsettings' ),
                    'default_value'	=> $this->defaults['pix-layout-portfolio'],
                    'images'        => array(
                        'left'          => 'layout-side-left.svg',
                        'full-width'    => 'layout-side-full-width.svg',
                        'right'         => 'layout-side-right.svg'
                    ),
                )
            );
            
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'select',
                array(
                    'id'            => 'pix-sidebar-portfolio',
                    'title'         => '',
                    'description'   => '',
                    'blank_option'	=> false,
                    'default_value' => $this->defaults['pix-sidebar-portfolio'],
                    'options'       => $pix_sidebars
                )
            );
    
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'select',
                array(
                    'id'            => 'pix-width-portfolio',
                    'title'         => '',
                    'description'   => esc_html__( 'Container width without sidebar.', 'pixsettings' ),
                    'blank_option'	=> false,
                    'default_value' => $this->defaults['pix-width-portfolio'],
                    'options'       => $pix_width_arr
                )
            );
        
        endif;
        
        if($pix_settings->settings->get_setting('pix-service') == 'on') :
            
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'radio-image',
                array(
                    'id'			=> 'pix-layout-service-cat',
                    'title'			=> esc_html__( 'Services Category', 'pixsettings' ),
                    'description'   => esc_html__( 'Services Category page layout type.', 'pixsettings' ),
                    'default_value'	=> $this->defaults['pix-layout-service-cat'],
                    'images'        => array(
                        'left'          => 'layout-side-left.svg',
                        'full-width'    => 'layout-side-full-width.svg',
                        'right'         => 'layout-side-right.svg'
                    ),
                )
            );
            
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'select',
                array(
                    'id'            => 'pix-sidebar-service-cat',
                    'title'         => '',
                    'description'   => '',
                    'blank_option'	=> false,
                    'default_value' => $this->defaults['pix-sidebar-service-cat'],
                    'options'       => $pix_sidebars
                )
            );
            
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'select',
                array(
                    'id'            => 'pix-col-service-cat',
                    'title'         => '',
                    'description'   => esc_html__( 'Columns count.', 'pixsettings' ),
                    'class'         => 'pix-width-xs',
                    'blank_option'	=> false,
                    'default_value' => $this->defaults['pix-col-service-cat'],
                    'options'       => $pix_cols_arr
                )
            );
            
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'select',
                array(
                    'id'            => 'pix-images-service-cat',
                    'title'         => '',
                    'description'   => esc_html__( 'Image proportions.', 'pixsettings' ),
                    'blank_option'	=> false,
                    'default_value' => $this->defaults['pix-images-service-cat'],
                    'options'       => $pix_images_arr
                )
            );
            
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'radio-image',
                array(
                    'id'			=> 'pix-layout-service',
                    'title'			=> esc_html__( 'Service', 'pixsettings' ),
                    'description'   => esc_html__( 'Service page layout type.', 'pixsettings' ),
                    'default_value'	=> $this->defaults['pix-layout-service'],
                    'images'        => array(
                        'left'          => 'layout-side-left.svg',
                        'full-width'    => 'layout-side-full-width.svg',
                        'right'         => 'layout-side-right.svg'
                    ),
                )
            );
            
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'select',
                array(
                    'id'            => 'pix-sidebar-service',
                    'title'         => '',
                    'description'   => '',
                    'blank_option'	=> false,
                    'default_value' => $this->defaults['pix-sidebar-service'],
                    'options'       => $pix_sidebars
                )
            );
    
            $pix->add_setting(
                'pix-settings',
                'pix-layout',
                'select',
                array(
                    'id'            => 'pix-width-service',
                    'title'         => '',
                    'description'   => esc_html__( 'Container width without sidebar.', 'pixsettings' ),
                    'blank_option'	=> false,
                    'default_value' => $this->defaults['pix-width-service'],
                    'options'       => $pix_width_arr
                )
            );
        
        endif;
        
        
        


        /// Blog

        $pix->add_section(
			'pix-settings',
			array(
				'id'            => 'pix-blog',
				'title'         => __( 'Blog', 'pixsettings' ),
				'is_tab'	    => true,
			)
		);

        $pix->add_setting(
			'pix-settings',
			'pix-blog',
			'select',
			array(
				'id'            => 'pix-blog-style',
				'title'         => __( 'Display Style', 'pixsettings' ),
				'default_value'	=> $this->defaults['pix-blog-style'],
                'blank_option'  => false,
                'options'       => array(
                    'classic'   => esc_html__( 'Classic', 'pixsettings' ),
                    'grid'      => esc_html__( 'Grid', 'pixsettings' ),
                )
			)
		);
        
        $pix->add_setting(
			'pix-settings',
			'pix-blog',
			'select',
			array(
				'id'            => 'pix-blog-sidebar',
				'title'         => __( 'Sidebar Background', 'pixsettings' ),
				'default_value'	=> $this->defaults['pix-blog-sidebar'],
                'blank_option'  => false,
                'options'       => array(
                    'no-padding'   => esc_html__( 'No', 'pixsettings' ),
                    'padding-gray'      => esc_html__( 'Gray with Padding', 'pixsettings' ),
                )
			)
		);

        $pix->add_setting(
			'pix-settings',
			'pix-blog',
			'toggle',
			array(
				'id'            => 'pix-blog-date',
				'title'         => __( 'Display Date', 'pixsettings' ),
				'default_value'	=> $this->defaults['pix-blog-date'],
			)
		);

        $pix->add_setting(
			'pix-settings',
			'pix-blog',
			'toggle',
			array(
				'id'            => 'pix-blog-author',
				'title'         => __( 'Display Author', 'pixsettings' ),
				'default_value'	=> $this->defaults['pix-blog-author'],
			)
		);

        $pix->add_setting(
			'pix-settings',
			'pix-blog',
			'toggle',
			array(
				'id'            => 'pix-blog-comments',
				'title'         => __( 'Display Comments', 'pixsettings' ),
				'default_value'	=> $this->defaults['pix-blog-comments'],
			)
		);

        $pix->add_setting(
			'pix-settings',
			'pix-blog',
			'toggle',
			array(
				'id'            => 'pix-blog-categories',
				'title'         => __( 'Display Categories', 'pixsettings' ),
				'default_value'	=> $this->defaults['pix-blog-categories'],
			)
		);
        
        $pix->add_setting(
			'pix-settings',
			'pix-blog',
			'toggle',
			array(
				'id'            => 'pix-blog-icons',
				'title'         => __( 'Display Icons', 'pixsettings' ),
				'description'   => esc_html__( 'Before date, author and comments.', 'pixsettings' ),
				'default_value'	=> $this->defaults['pix-blog-icons'],
			)
		);

        $pix->add_setting(
			'pix-settings',
			'pix-blog',
			'toggle',
			array(
				'id'            => 'pix-blog-tags',
				'title'         => __( 'Display Tags', 'pixsettings' ),
				'default_value'	=> $this->defaults['pix-blog-tags'],
			)
		);

        $pix->add_setting(
			'pix-settings',
			'pix-blog',
			'toggle',
			array(
				'id'            => 'pix-blog-share',
				'title'         => __( 'Display Share', 'pixsettings' ),
				'default_value'	=> $this->defaults['pix-blog-share'],
			)
		);
        // <= Blog END






        /// Footer

        $pix->add_section(
			'pix-settings',
			array(
				'id'            => 'pix-footer',
				'title'         => __( 'Footer', 'pixsettings' ),
				'is_tab'	    => true,
			)
		);

        if(function_exists('pixtheme_get_sections_array')){
            $pix_sections = pixtheme_get_sections_array(true);
        } else {
            $pix_sections = array();
        }
        

        $pix->add_setting(
			'pix-settings',
			'pix-footer',
			'select',
			array(
				'id'            => 'pix-footer-section',
				'title'         => __( 'Footer Section', 'pixsettings' ),
				'description'   => '',
				'blank_option'	=> false,
				'options'       => $pix_sections
			)
		);

        $pix->add_setting(
			'pix-settings',
			'pix-footer',
			'textarea',
			array(
				'id'            => 'pix-footer-copyright',
				'title'         => __( 'Copyright Text', 'pixsettings' ),
				'placeholder'   => $this->defaults['pix-footer-copyright'],
				'default_value'	=> $this->defaults['pix-footer-copyright'],
			)
		);
        // <= Footer END



		$pix = apply_filters( 'pix_settings_page', $pix );

		$pix->add_admin_menus();

	}


	public function get_required_fields() {

		$required_fields = array();

		$fieldsets = $this->get_review_form_fields();
		foreach ( $fieldsets as $fieldset ) {
			$required_fields = array_merge( $required_fields, array_filter( $fieldset['fields'], array( $this, 'is_field_required' ) ) );
		}

		return $required_fields;
	}


	public function is_field_required( $field ) {
		return !empty( $field['required'] );
	}


	public function render_template_tag_descriptions() {

		$descriptions = apply_filters( 'pixsettings_notification_template_tag_descriptions', array(
				'{user_email}'		=> __( 'Email of the user who made the review', 'pixsettings' ),
				'{user_name}'		=> __( '* Name of the user who made the review', 'pixsettings' ),
				'{date}'			=> __( '* Date and time of the review', 'pixsettings' ),
				'{phone}'			=> __( 'Phone number if supplied with the request', 'pixsettings' ),
				'{message}'			=> __( 'Review text', 'pixsettings' ),
				'{reviews_link}'	=> __( 'A link to the admin panel showing pending reviews', 'pixsettings' ),
				'{confirm_link}'	=> __( 'A link to confirm this review. Only include this in admin notifications', 'pixsettings' ),
				'{close_link}'		=> __( 'A link to reject this review. Only include this in admin notifications', 'pixsettings' ),
				'{site_name}'		=> __( 'The name of this website', 'pixsettings' ),
				'{site_link}'		=> __( 'A link to this website', 'pixsettings' ),
				'{current_time}'	=> __( 'Current date and time', 'pixsettings' ),
			)
		);

		$output = '';

		foreach ( $descriptions as $tag => $description ) {
			$output .= '
				<div class="pixsettings-template-tags-box">
					<strong>' . $tag . '</strong> ' . $description . '
				</div>';
		}

		return $output;
	}


}
} // endif;
