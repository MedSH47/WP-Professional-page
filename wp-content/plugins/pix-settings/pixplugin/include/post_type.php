<?php
// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


if( ! class_exists( 'PixTheme_Post_Types' ) ) {
	class PixTheme_Post_Types {
        
        private $permalinks = array();
	    
		public function __construct() {
			add_action( 'init', array( $this, 'post_type_init' ) );
			if(function_exists('wpcf7_init')) {
                add_action('plugins_loaded', array($this, 'pix_calculator_form'));
            }
		}
		
		function post_type_init() {
            global $pix_settings;
            
            register_post_type('pix-calculator-field',
                array(
                    'label' => __('Calculator Fields', 'pixsettings'),
                    'singular_label' => __('Calculator Field', 'pixsettings'),
                    'exclude_from_search' => false,
                    'publicly_queryable' => true,
                    'menu_position' => null,
                    'show_ui' => true,
                    'public' => true,
                    'show_in_menu' => true,
                    'menu_icon' => 'dashicons-editor-table',
                    'query_var' => true,
                    'rewrite' => array('slug' => 'calc-field'),
                    'capability_type' => 'page',
                    'has_archive' => true,
                    'hierarchical' => false,
                    'edit_item' => __('Edit', 'pixsettings'),
                    'supports' => array('title', 'excerpt', 'page-attributes'),
                    'register_meta_box_cb'	=> 'pix_meta_boxes'
                )
            );

            register_taxonomy('pix-calculator',
                'pix-calculator-field',
                array(
                    'hierarchical' => true,
                    'label' => __('Calculators', 'pixsettings'),
                    'singular_label' => __('Calculator', 'pixsettings'),
                    'public' => true,
                    'show_tagcloud' => false,
                    'query_var' => true,
                    'rewrite' => array('slug' => 'calculator', 'with_front' => false)
                )
            );

            add_filter('manage_edit-pix-calculator-field_columns', 'pixtheme_pixcalc_edit_columns');
            add_action('manage_pix-calculator-field_posts_custom_column', 'pixtheme_pixcalc_custom_columns');

            function pixtheme_pixcalc_edit_columns($columns){
                $columns = array(
                    'cb' => '<input type="checkbox" />',
                    'title' => __('Title', 'pixsettings'),
                    'price' => __('Price', 'pixsettings'),
                    'id' => __('ID', 'pixsettings'),
                    'calculator' => __('Calculator', 'pixsettings'),
                );

                return $columns;
            }

            function pixtheme_pixcalc_custom_columns($column){
                global $post;
                switch ($column) {
                    case "calculator":
                        echo get_the_term_list($post->ID, 'pix-calculator', '', ', ', '');
                        break;

                    case 'id':
                        echo $post->ID;
                        break;

                    case 'price':
                        the_excerpt();
                        break;
                }
            }

		}
		
		public function pix_calculator_form(){
		    add_action( 'wpcf7_init', 'pixtheme_add_calculator_field' );
		    
            function pixtheme_add_calculator_field() {
                wpcf7_add_form_tag( 'calculator', 'pixtheme_add_calculator_field_handler', array( 'name-attr' => true ));
            }
            
            function pixtheme_add_calculator_field_handler( $tag ) {
                
                $tag = new WPCF7_FormTag( $tag );

                if ( empty( $tag->name ) ) {
                    return '';
                }
            
                $atts = array();
            
                $class = wpcf7_form_controls_class( $tag->type );
                $atts['class'] = 'pix-calculator-data '.$tag->get_class_option( $class );
                $atts['id'] = $tag->get_id_option();
            
                $atts['name'] = $tag->name;
                $atts = wpcf7_format_atts( $atts );
            
                $html = sprintf( '<textarea %s></textarea>', $atts );
                return $html;
            }
        }

	}
	new PixTheme_Post_Types;

}