<?php
/***********************************

	Plugin Name:  Pix-Settings
	Plugin URI:   https://help.pix-theme.com
	Description:  Additional functionality for PixTheme template
	Version:      1.3.1
	Author:       PixTheme
	Author URI:   https://pix-theme.com
	Text Domain:  pixsettings
	Domain Path:  /languages/
	
***********************************/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // disable direct access
}

/** Register widget for brands */

add_action('plugins_loaded', 'pixtheme_load_textdomain');
function pixtheme_load_textdomain() {
	load_plugin_textdomain( 'pixsettings', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}

require_once('pix-font-icons-loader.php');
require_once('pix-settings-widgets.php');
require_once('shortcode.php');
require_once('pixplugin/classes/class.ajax.php');

function register_pixsettings_widget() {
	register_widget('PixThemeSettings_Taxonomy_Widget');
	register_widget('PixThemeSettings_Latest_News');
    register_widget( 'PixThemeSettings_PixSection_Widget' );
}
add_action( 'widgets_init', 'register_pixsettings_widget' );



if ( ! class_exists( 'PixThemeSettings' ) ) :

/************* Custom Post Types ***************/

	class PixThemeSettings {
        
        private $permalinks = array();

	    public $is_retina = false;

	    public function __construct() {

            define( 'PIX_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
            define( 'PIX_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );

            // Load settings
            require_once( PIX_PLUGIN_DIR . '/pixplugin/admin/settings.php' );
            $this->settings = new PixSettings();
            $this->settings->set_defaults();
            
            // Register the post type.
            require_once( PIX_PLUGIN_DIR . '/pixplugin/include/post_type.php' );
            
            // Register meta_boxes.
            require_once( PIX_PLUGIN_DIR . '/pixplugin/include/meta_boxes.php' );

            add_action( 'init', array( $this, 'pix_init_plugin' ) );
            add_action( 'admin_enqueue_scripts', array($this, 'pix_admin_enqueue_scripts') );
            add_action( 'customize_save_after', array($this, 'pix_generate_dynamic_style') );
            add_action( 'admin_init', array( $this, 'pix_permalinks_init' ) );
            add_action( 'admin_init', array( $this, 'pix_permalinks_save' ) );

            if( !isset($_COOKIE["device_pixel_ratio"]) ) {
                add_action('wp_enqueue_scripts', array($this, 'pixtheme_retina'));
            } else {
                $this->is_retina = true;
            }
        
            add_action('wp_enqueue_scripts', array($this, 'pix_enqueue_dynamic_style'));

        }

        public function pixtheme_retina(){
            wp_enqueue_script( 'pix-retina', PIX_PLUGIN_URL . '/assets/js/pix-retina.js', array(), null, false );
        }
        
        public function pix_generate_dynamic_style(){
            if ( file_exists(get_template_directory() . '/pixtheme/functions/dynamic-styles.php') && file_exists(get_template_directory() . '/css/dynamic-style.css') ) {
                ob_start();
                include(get_template_directory() . '/pixtheme/functions/dynamic-styles.php');
                $style = ob_get_contents();
                ob_end_clean();
        
                $file = get_template_directory() . '/css/dynamic-style.css';
                if($open = fopen( $file, "w+" )) {
                    $write = fputs($open, $style);
                    fclose($open);
                }
            }
        }
        
        public function pix_enqueue_dynamic_style(){
            if ( $this->settings->get_setting('pix-dynamic-style') == 'on' && file_exists(get_template_directory() . '/css/dynamic-style.css') ) {
                remove_action('wp_ajax_dynamic_styles', 'pixtheme_dynamic_styles');
                remove_action('wp_ajax_nopriv_dynamic_styles', 'pixtheme_dynamic_styles');
                wp_deregister_style('pixtheme-dynamic-styles');
                wp_enqueue_style('pixtheme-dynamic-styles', get_template_directory_uri() . '/css/dynamic-style.css');
            }
            wp_enqueue_style('pix-styles', PIX_PLUGIN_URL . '/assets/css/pix-styles.css');
            if($this->settings->get_setting('pix-calculator') == 'on') {
                
                // vanillaSelectBox
                wp_enqueue_style('vanillaSelectBox', PIX_PLUGIN_URL . '/assets/lib/vanillaSelectBox/vanillaSelectBox.css');
                wp_enqueue_style('pixVanillaSelectBox', PIX_PLUGIN_URL . '/assets/lib/vanillaSelectBox/pixVanillaSelectBox.css');
                wp_enqueue_script('vanillaSelectBox', PIX_PLUGIN_URL . '/assets/lib/vanillaSelectBox/vanillaSelectBox.js', array() , null, false);
                
                wp_enqueue_script( 'pix-script', PIX_PLUGIN_URL . '/assets/js/pix-script.js', array('jquery'), null, false );
            }
        }
        
        public function pix_permalinks_init() {
            
            if($this->settings->get_setting('pix-team') == 'on') {
                add_settings_field(
                    'pix_team_slug',
                    esc_html__( 'Team base', 'pixsettings' ),
                    array( $this, 'pix_team_slug_input' ),
                    'permalink',
                    'optional'
                );
    
                add_settings_field(
                    'pix_team_cat_slug',
                    esc_html__( 'Specialty base', 'pixsettings' ),
                    array( $this, 'pix_team_cat_slug_input' ),
                    'permalink',
                    'optional'
                );
            }
    
            if($this->settings->get_setting('pix-portfolio') == 'on') {
                add_settings_field(
                    'pix_portfolio_slug',
                    esc_html__( 'Portfolio base', 'pixsettings' ),
                    array( $this, 'pix_portfolio_slug_input' ),
                    'permalink',
                    'optional'
                );
        
                add_settings_field(
                    'pix_portfolio_cat_slug',
                    esc_html__( 'Portfolio category base', 'pixsettings' ),
                    array( $this, 'pix_portfolio_cat_slug_input' ),
                    'permalink',
                    'optional'
                );
            }
    
            if($this->settings->get_setting('pix-service') == 'on') {
                add_settings_field(
                    'pix_service_slug',
                    esc_html__( 'Service base', 'pixsettings' ),
                    array( $this, 'pix_service_slug_input' ),
                    'permalink',
                    'optional'
                );
        
                add_settings_field(
                    'pix_service_cat_slug',
                    esc_html__( 'Department base', 'pixsettings' ),
                    array( $this, 'pix_service_cat_slug_input' ),
                    'permalink',
                    'optional'
                );
            }
            
            $this->permalinks = wp_parse_args( (array) get_option( 'pix_permalinks', array() ), array(
                'team_base'           => '',
                'team_category_base'          => '',
                'portfolio_base'               => '',
                'portfolio_category_base'         => '',
                'service_base'               => '',
                'service_category_base'         => '',
            ) );
            
        }
        
        
        public function pix_team_slug_input() {
            ?>
            <input name="pix_team_slug" type="text" class="regular-text code" value="<?php echo esc_attr( $this->permalinks['team_base'] ); ?>" placeholder="<?php echo esc_attr_x( 'team', 'slug', 'pixsettings' ); ?>" />
            <?php
        }
        
        public function pix_team_cat_slug_input() {
            ?>
            <input name="pix_team_cat_slug" type="text" class="regular-text code" value="<?php echo esc_attr( $this->permalinks['team_category_base'] ); ?>" placeholder="<?php echo esc_attr_x( 'specialty', 'slug', 'pixsettings' ); ?>" />
            <?php
        }
        
        public function pix_portfolio_slug_input() {
            ?>
            <input name="pix_portfolio_slug" type="text" class="regular-text code" value="<?php echo esc_attr( $this->permalinks['portfolio_base'] ); ?>" placeholder="<?php echo esc_attr_x( 'portfolio', 'slug', 'pixsettings' ); ?>" />
            <?php
        }
        
        public function pix_portfolio_cat_slug_input() {
            ?>
            <input name="pix_portfolio_cat_slug" type="text" class="regular-text code" value="<?php echo esc_attr( $this->permalinks['portfolio_category_base'] ); ?>" placeholder="<?php echo esc_attr_x( 'portfolio-category', 'slug', 'pixsettings' ); ?>" />
            <?php
        }
        
        public function pix_service_slug_input() {
            ?>
            <input name="pix_service_slug" type="text" class="regular-text code" value="<?php echo esc_attr( $this->permalinks['service_base'] ); ?>" placeholder="<?php echo esc_attr_x( 'services', 'slug', 'pixsettings' ); ?>" />
            <?php
        }
        
        public function pix_service_cat_slug_input() {
            ?>
            <input name="pix_service_cat_slug" type="text" class="regular-text code" value="<?php echo esc_attr( $this->permalinks['service_category_base'] ); ?>" placeholder="<?php echo esc_attr_x( 'departments', 'slug', 'pixsettings' ); ?>" />
            <?php
        }
        
        public function pix_permalinks_save() {
            if ( ! is_admin() ) {
                return;
            }
            
            // We need to save the options ourselves; settings api does not trigger save for the permalinks page.
            if ( isset($_POST['permalink_structure'] ) ) {
                
                $permalinks                         = (array) get_option( 'pix_permalinks', array() );
                $permalinks['team_base']            = trim( wp_unslash($_POST['pix_team_slug']) );
                $permalinks['team_category_base']   = trim( wp_unslash($_POST['pix_team_cat_slug']) );
                $permalinks['portfolio_base']            = trim( wp_unslash($_POST['pix_portfolio_slug']) );
                $permalinks['portfolio_category_base']   = trim( wp_unslash($_POST['pix_portfolio_cat_slug']) );
                $permalinks['service_base']            = trim( wp_unslash($_POST['pix_service_slug']) );
                $permalinks['service_category_base']   = trim( wp_unslash($_POST['pix_service_cat_slug']) );
                
                update_option( 'pix_permalinks', $permalinks );
                
            }
        }
        
        

        public function pix_init_plugin() {
    
            $permalinks = wp_parse_args( (array) get_option( 'pix_permalinks', array() ), array(
                'team_base'           => '',
                'team_category_base'          => '',
                'portfolio_base'               => '',
                'portfolio_category_base'         => '',
                'service_base'               => '',
                'service_category_base'         => '',
            ) );
            
            $team_slug = !isset($permalinks['team_base']) || empty($permalinks['team_base']) ? 'team' : $permalinks['team_base'];
            $team_cat_slug = !isset($permalinks['team_category_base']) || empty($permalinks['team_category_base']) ? 'specialty' : $permalinks['team_category_base'];
            $portfolio_slug = !isset($permalinks['portfolio_base']) || empty($permalinks['portfolio_base']) ? 'portfolio' : $permalinks['portfolio_base'];
            $portfolio_cat_slug = !isset($permalinks['portfolio_category_base']) || empty($permalinks['portfolio_category_base']) ? 'portfolio_category' : $permalinks['portfolio_category_base'];
            $service_slug = !isset($permalinks['service_base']) || empty($permalinks['service_base']) ? 'services' : $permalinks['service_base'];
            $service_cat_slug = !isset($permalinks['service_category_base']) || empty($permalinks['service_category_base']) ? 'departments' : $permalinks['service_category_base'];
            

            if($this->settings->get_setting('pix-team') == 'on') {

                register_post_type('pix-team',
                    array(
                        'label' => __('Team', 'pixsettings'),
                        'singular_label' => __('Team', 'pixsettings'),
                        'exclude_from_search' => false,
                        'publicly_queryable' => true,
                        'menu_position' => null,
                        'show_ui' => true,
                        'public' => true,
                        'show_in_menu' => true,
                        'menu_icon' => 'dashicons-id-alt',
                        'query_var' => true,
                        'rewrite' => array('slug' => $team_slug),
                        'capability_type' => 'page',
                        'has_archive' => true,
                        'hierarchical' => false,
                        'edit_item' => __('Edit', 'pixsettings'),
                        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'comments')
                    )
                );

                register_taxonomy('pix-team-cat',
                    'pix-team',
                    array('hierarchical' => true,
                        'label' => __('Specialties', 'pixsettings'),
                        'singular_label' => __('Specialty', 'pixsettings'),
                        'public' => true,
                        'show_tagcloud' => false,
                        'query_var' => true,
                        'rewrite' => array('slug' => $team_cat_slug, 'with_front' => false)
                    )
                );

                add_filter('manage_edit-pix-team_columns', 'pixtheme_pixteam_edit_columns');
                add_action('manage_pix-team_posts_custom_column', 'pixtheme_pixteam_custom_columns');

                function pixtheme_pixteam_edit_columns($columns)
                {
                    $columns = array(
                        'cb' => '<input type="checkbox" />',
                        'title' => __('Title', 'pixsettings'),
                        'team_image' => __('Featured Image', 'pixsettings'),
                        'id' => __('ID', 'pixsettings'),
                        'team_category' => __('Category', 'pixsettings'),
                    );

                    return $columns;
                }

                function pixtheme_pixteam_custom_columns($column)
                {
                    global $post;
                    switch ($column) {
                        case "team_category":
                            echo get_the_term_list($post->ID, 'pix-team-cat', '', ', ', '');
                            break;

                        case 'id':
                            echo $post->ID;
                            break;

                        case 'team_description':
                            the_excerpt();
                            break;

                        case 'team_image':
                            the_post_thumbnail(array(70,70));
                            break;
                    }
                }

            }


            if($this->settings->get_setting('pix-portfolio') == 'on') {

                register_post_type('pix-portfolio',
                    array(
                        'label' => __('Portfolio', 'pixsettings'),
                        'singular_label' => __('Portfolio', 'pixsettings'),
                        'exclude_from_search' => false,
                        'publicly_queryable' => true,
                        'menu_position' => null,
                        'show_ui' => true,
                        'public' => true,
                        'show_in_menu' => true,
                        'menu_icon' => 'dashicons-portfolio',
                        'query_var' => true,
                        'rewrite' => array('slug' => $portfolio_slug),
                        'capability_type' => 'page',
                        'has_archive' => true,
                        'hierarchical' => false,
                        'edit_item' => __('Edit', 'pixsettings'),
                        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'comments')
                    )
                );

                register_taxonomy('pix-portfolio-cat',
                    'pix-portfolio',
                    array('hierarchical' => true,
                        'label' => __('Categories', 'pixsettings'),
                        'singular_label' => __('Category', 'pixsettings'),
                        'public' => true,
                        'show_tagcloud' => false,
                        'query_var' => true,
                        'rewrite' => array('slug' => $portfolio_cat_slug, 'with_front' => false)
                    )
                );

                add_filter('manage_edit-pix-portfolio_columns', 'pixtheme_portfolio_edit_columns');
                add_action('manage_pix-portfolio_posts_custom_column', 'pixtheme_portfolio_custom_columns');

                function pixtheme_portfolio_edit_columns($columns) {
                    $columns = array(
                        'cb' => '<input type="checkbox" />',
                        'title' => __('Title', 'pixsettings'),
                        'portfolio_image' => __('Featured Image', 'pixsettings'),
                        'id' => __('ID', 'pixsettings'),
                        'portfolio_category' => __('Category', 'pixsettings'),

                    );

                    return $columns;
                }

                function pixtheme_portfolio_custom_columns($column) {
                    global $post;
                    switch ($column) {
                        case "portfolio_category":
                            echo get_the_term_list($post->ID, 'pix-portfolio-cat', '', ', ', '');
                            break;

                        case 'id':
                            echo $post->ID;
                            break;

                        case 'portfolio_description':
                            the_excerpt();
                            break;

                        case 'portfolio_image':
                            the_post_thumbnail(array(70,70));
                            break;
                    }
                }
                
                
                add_filter('manage_edit-pix-portfolio-cat_columns', 'pixtheme_portfolio_category_columns');
                add_filter('manage_pix-portfolio-cat_custom_column', 'pixtheme_portfolio_category_custom_column', 10, 3);

                function pixtheme_portfolio_category_columns($columns) {
                    $columns = array(
                        'cb' => '<input type="checkbox" />',
                        'image' => __('Image', 'pixsettings'),
                        'name' => __('Name', 'pixsettings'),
                        'description' => __('Description', 'pixsettings'),
                        'section' => __('Pix Section', 'pixsettings'),
                    );

                    return $columns;
                }

                function pixtheme_portfolio_category_custom_column($c, $column_name, $term_id) {
                    $term = get_term_by('term_taxonomy_id', $term_id, 'pix-portfolio-cat');
                    $t_slug = $term->slug;
                    $cat_meta = get_option("pix-portfolio-cat-$t_slug");
                    switch ($column_name) {
                        case 'image':
                            if (isset($cat_meta['pix_image']) && $cat_meta['pix_image']) {
                                ?>
                                <img width="70px" src="<?php echo esc_url($cat_meta['pix_image']) ?>">
                                <?php
                            }
                            break;

                        case 'section':
                            if (isset($cat_meta['pix_section']) && $cat_meta['pix_section']) {
                                echo($cat_meta['pix_section']);
                            }
                            break;

                        default:
                            break;
                    }

                }

            }


            if($this->settings->get_setting('pix-service') == 'on') {

                register_post_type('pix-service',
                    array(
                        'label' => __('Services', 'pixsettings'),
                        'singular_label' => __('Service', 'pixsettings'),
                        'exclude_from_search' => false,
                        'publicly_queryable' => true,
                        'menu_position' => null,
                        'show_ui' => true,
                        'public' => true,
                        'show_in_menu' => true,
                        'menu_icon' => 'dashicons-cloud',
                        'query_var' => true,
                        'rewrite' => array('slug' => $service_slug),
                        'capability_type' => 'page',
                        'hierarchical' => false,
                        'edit_item' => __('Edit Work', 'pixsettings'),
                        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'comments')
                    )
                );

                register_taxonomy('pix-service-cat',
                    'pix-service',
                    array('hierarchical' => true,
                        'label' => __('Departments', 'pixsettings'),
                        'singular_label' => __('Department', 'pixsettings'),
                        'public' => true,
                        'show_tagcloud' => false,
                        'query_var' => true,
                        'rewrite' => array('slug' => $service_cat_slug)
                    )
                );

                add_filter('manage_edit-pix-service_columns', 'pixtheme_services_edit_columns');
                add_action('manage_pix-service_posts_custom_column', 'pixtheme_services_custom_columns');

                function pixtheme_services_edit_columns($columns) {
                    $columns = array(
                        'cb' => '<input type="checkbox" />',
                        'title' => __('Title', 'pixsettings'),
                        'services_image' => __('Featured Image', 'pixsettings'),
                        'services_category' => __('Department', 'pixsettings'),
                        'services_description' => __('Description', 'pixsettings'),

                    );

                    return $columns;
                }

                function pixtheme_services_custom_columns($column) {
                    global $post;
                    switch ($column) {
                        case "services_category":
                            echo get_the_term_list($post->ID, 'pix-service-cat', '', ', ', '');
                            break;

                        case 'services_description':
                            the_excerpt();
                            break;

                        case 'services_image':
                            the_post_thumbnail(array(70,70));
                            break;
                    }
                }

                add_filter('manage_edit-pix-service-cat_columns', 'pixtheme_services_category_columns');
                add_filter('manage_pix-service-cat_custom_column', 'pixtheme_services_category_custom_column', 10, 3);

                function pixtheme_services_category_columns($columns) {
                    $columns = array(
                        'cb' => '<input type="checkbox" />',
                        'image' => __('Image', 'pixsettings'),
                        'name' => __('Name', 'pixsettings'),
                        'description' => __('Description', 'pixsettings'),
                        'icon' => __('Icon', 'pixsettings'),
                        'posts' => __('Count', 'pixsettings'),
                    );

                    return $columns;
                }

                function pixtheme_services_category_custom_column($c, $column_name, $term_id) {
                    $term = get_term_by('term_taxonomy_id', $term_id, 'pix-service-cat');
                    $t_slug = $term->slug;
                    $cat_meta = get_option("pix-service-cat-$t_slug");
                    switch ($column_name) {
                        case "image":
                            if (isset($cat_meta['pix_image']) && $cat_meta['pix_image']) {
                                ?>
                                <img width="150px" src="<?php echo esc_url($cat_meta['pix_image']) ?>">
                                <?php
                            }
                            break;

                        case "icon":
                            if (isset($cat_meta['pix_icon']) && $cat_meta['pix_icon']) {
                                if (filter_var($cat_meta['pix_icon'], FILTER_VALIDATE_URL)) {
                                    ?>
                                    <img width="50px" src="<?php echo esc_url($cat_meta['pix_icon']) ?>">
                                    <?php
                                } else {
                                    echo($cat_meta['pix_icon']);
                                }
                            }
                            break;

                        default:
                            break;
                    }

                }

            }


			$labels = array(
					'name'               => _x( 'Footer & Sections', 'post type general name', 'pixsettings' ),
					'singular_name'      => _x( 'Footer & Section', 'post type singular name', 'pixsettings' ),
					'menu_name'          => _x( 'Footer & Sections', 'admin menu', 'pixsettings' ),
					'name_admin_bar'     => _x( 'Footer & Section', 'add new on admin bar', 'pixsettings' ),
					'add_new'            => _x( 'Add New', 'book', 'pixsettings' ),
					'add_new_item'       => __( 'Add New Section', 'pixsettings' ),
					'new_item'           => __( 'New Section', 'pixsettings' ),
					'edit_item'          => __( 'Edit Section', 'pixsettings' ),
					'view_item'          => __( 'View Section', 'pixsettings' ),
					'all_items'          => __( 'All Sections', 'pixsettings' ),
					'search_items'       => __( 'Search Section', 'pixsettings' ),
					'parent_item_colon'  => __( 'Parent Section:', 'pixsettings' ),
					'not_found'          => __( 'No sections found.', 'pixsettings' ),
					'not_found_in_trash' => __( 'No sections found in Trash.', 'pixsettings' )
			);

			$args = array(
					'labels'             => $labels,
					'public'             => true,
					'publicly_queryable' => true,
					'show_ui'            => true,
					'show_in_menu'       => true,
					'query_var'          => true,
					'rewrite'            => array( 'slug' => 'pixsection' ),
					'capability_type'    => 'post',
					'has_archive'        => true,
					'hierarchical'       => false,
					'supports'           => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'comments' ),
					'menu_icon'			 => 'dashicons-layout'
			);


			register_post_type( 'pix-section', $args );

		}

		//Load Admin Scripts
        public function pix_admin_enqueue_scripts() {
            wp_enqueue_style( 'pix-admin', PIX_PLUGIN_URL . '/assets/css/pix-admin.css' );
            wp_enqueue_script( 'pix-admin', PIX_PLUGIN_URL . '/assets/js/pix-admin.js', array(), null, false );
        }

	}
	

				
		
		
		
    if(!function_exists('pixtheme_sections_get')) {
        function pixtheme_sections_get () {
            $return_array = array();
            $args = array( 'post_type' => 'pix-section', 'posts_per_page' => 30);
            $myposts = get_posts( $args );
            $i=0;
            foreach ( $myposts as $post ) {
                $i++;
                $return_array[$i]['label'] = get_the_title($post->ID);
                $return_array[$i]['value'] = $post->ID;
            }
            wp_reset_postdata();
            return $return_array;
        }
    }


    if(!function_exists('pixtheme_sections_show')) {
        function pixtheme_sections_show ($id = false) {
            echo pixtheme_sections_single($id);
        }
    }


    if(!function_exists('pixtheme_sections_single')) {
        function pixtheme_sections_single($id = false) {
            if(!$id) return;

            $output = false;

            $output = wp_cache_get( $id, 'pixtheme_sections_single' );

            if ( !$output ) {

                $args = array( 'include' => $id,'post_type' => 'pix-section', 'posts_per_page' => 1);
                $output = '';
                $myposts = get_posts( $args );
                foreach ( $myposts as $post ) {
                    setup_postdata($post);

                    $output = do_shortcode(get_the_content($post->ID));

                    $shortcodes_custom_css = get_post_meta( $post->ID, '_wpb_shortcodes_custom_css', true );
                    if ( ! empty( $shortcodes_custom_css ) ) {
                        $output .= '<style type="text/css" data-type="vc_shortcodes-custom-css">';
                        $output .= $shortcodes_custom_css;
                        $output .= '</style>';
                    }
                }
                wp_reset_postdata();

                wp_cache_add( $id, $output, 'pixtheme_sections_single' );
            }

            return $output;
       }
    }
    
    function pixtheme_get_sections(){
        $args = array(
            'post_type'        => 'pix-section',
            'post_status'      => 'publish',
        );
        $pix_sections = array();
        $pix_sections['global'] = esc_html__('Global Settings','pixsettings');
        $pix_sections_data = get_posts( $args );
        foreach($pix_sections_data as $pix_section){
            $pix_sections[$pix_section->ID] =  $pix_section->post_title;
        }
        
        return $pix_sections;
    }
    
    
    
    add_action( 'add_meta_boxes', 'pix_custom_posts_init' );
    function pix_custom_posts_init(){
        add_meta_box('team_fields', __('Information', 'pixsettings'), 'pixtheme_team_info', 'pix-team', 'advanced', 'high');
        //add_meta_box('portfolio_layout_options', __('Book an Appointment', 'pixsettings'), 'pixtheme_portfolio_layout_options', 'pix-portfolio', 'side', 'low');
        add_meta_box('post_formats', esc_html__('Post Format Settings', 'pixsettings'), 'pixtheme_post_formats', array('post'), 'advanced', 'high');
        add_meta_box('pixtheme_layout_side', esc_html__('Page Settings', 'pixsettings'), 'pixtheme_layout_side_content', array('post', 'page', 'pix-portfolio', 'pix-service', 'pix-team'), 'side', 'default' );
        add_meta_box('sidebar_options', esc_html__('Page Layout', 'pixsettings'), 'pixtheme_sidebar_options', array('post', 'page', 'pix-portfolio', 'pix-service'), 'side', 'low');
        //add_meta_box( 'pixtheme_header_style', esc_html__('Header Style', 'pixsettings'), 'pixtheme_header_style_content', array('page'), 'side', 'default' );
        function pix_default_hidden_meta_boxes( $hidden, $screen ) {
            // Grab the current post type
            $post_type = $screen->post_type;
            // If we're on a 'post'...
            if ( $post_type != '' ) {
                // Define which meta boxes we wish to hide
                $hidden = array(
                    'slugdiv',
                    'mymetabox_revslider_0'
                );
                // Pass our new defaults onto WordPress
                return $hidden;
            }
            // If we are not on a 'post', pass the
            // original defaults, as defined by WordPress
            return $hidden;
        }
        add_action( 'default_hidden_meta_boxes', 'pix_default_hidden_meta_boxes', 10, 2 );
    }
    
    
    
    add_action('admin_init', 'pix_category_custom_fields', 1);
    function pix_category_custom_fields(){
        add_action( 'pix-portfolio-cat_add_form_fields', 'pix_portfolio_cat_custom_fields_add_form');
        add_action( 'pix-portfolio-cat_edit_form_fields', 'pix_portfolio_cat_custom_fields_form');
        add_action( 'created_pix-portfolio-cat', 'pix_portfolio_cat_custom_fields_save');
        add_action( 'edited_pix-portfolio-cat', 'pix_portfolio_cat_custom_fields_save');
        
        add_action( 'edited_pix-service-cat', 'pix_service_cat_custom_fields_save');
        add_action( 'pix-service-cat_edit_form_fields', 'pix_service_cat_custom_fields_form');
        add_action( 'pix-service-cat_add_form_fields', 'pix_service_cat_custom_fields_add_form');
        add_action( 'created_pix-service-cat', 'pix_service_cat_custom_fields_save');
    }
    

    function pix_portfolio_cat_custom_fields_form($tag){
        $t_slug = $tag->slug;
        $cat_meta = get_option("pix-portfolio-cat_$t_slug");
        
        $pix_sections = pixtheme_get_sections();
    ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="tag-pix-portfolio-cat_section"><?php _e('Pix Section', 'pixsettings'); ?></label></th>
            <td>
                <select name="pix-portfolio-cat_section" id="tag-pix-portfolio-cat_section">
                <?php
                    foreach($pix_sections as $id => $section){
                        if($id == $cat_meta['pix_cat_section']){
                            echo "<option value='".esc_attr($id)."' selected>".esc_attr($section)."</option>\n";
                        }else{
                            echo "<option value='".esc_attr($id)."'>".esc_attr($section)."</option>\n";
                        }
                    }
                ?>
                </select>
                <p class="pix-field-description"><?php _e('Custom content', 'pixsettings'); ?></p>
            </td>
        </tr>
    <?php
    }

    function pix_portfolio_cat_custom_fields_add_form($tag) {
        $pix_sections = pixtheme_get_sections();
    ?>
        <div class="form-field">
            <label for="tag-pix-portfolio-cat_section"><?php _e('Pix Section', 'pixsettings'); ?></label>
            <select name="pix-portfolio-cat_section" id="tag-pix-portfolio-cat_section">
            <?php
                foreach($pix_sections as $id => $section){
                    echo "<option value='".esc_attr($id)."'>".esc_attr($section)."</option>\n";
                }
            ?>
            </select>
            <p><?php _e('Custom content', 'pixsettings'); ?></p>
        </div>

        <?php
    }

    function pix_portfolio_cat_custom_fields_save($term_id) {
        
        $term = get_term_by( 'term_taxonomy_id', $term_id, 'pix-portfolio-cat' );
        $t_slug = $term->slug;
        $cat_meta = get_option("pix-portfolio-cat_$t_slug");

        if (isset($_POST['pix-portfolio-cat_section'])) {
            $cat_meta['pix_cat_section'] = $_POST['pix-portfolio-cat_section'];

            //save the option array
            update_option("pix-portfolio-cat_$t_slug", $cat_meta);
        }
    }
    
    

    function pix_service_cat_custom_fields_form($tag){
            $t_slug = $tag->slug;
            $cat_meta = get_option("pix-service-cat_$t_slug");
            
            $pix_sections = pixtheme_get_sections();
    ?>
            <th scope="row" valign="top"><label for="tag-pix-service-cat_section"><?php _e('Pix Section', 'pixsettings'); ?></label></th>
            <td>
                <select name="pix-service-cat_section" id="tag-pix-service-cat_section">
                <?php
                    foreach($pix_sections as $id => $section){
                        if($id == $cat_meta['pix_cat_section']){
                            echo "<option value='".esc_attr($id)."' selected>".esc_attr($section)."</option>\n";
                        }else{
                            echo "<option value='".esc_attr($id)."'>".esc_attr($section)."</option>\n";
                        }
                    }
                ?>
                </select>
                <p class="pix-field-description"><?php _e('Custom content', 'pixsettings'); ?></p>
            </td>
<!--            <tr class="form-field">-->
<!--                <th scope="row" valign="top"><label for="tag-pix_icon">--><?php //_e('Icon', 'pixsettings'); ?><!--</label></th>-->
<!--                <td>-->
<!--                    <input type="text" name="pix_icon" id="tag-pix_icon" size="25" style="width:60%;" value="--><?php //echo esc_attr($cat_meta['pix_icon']) ? esc_attr($cat_meta['pix_icon']) : ''; ?><!--">-->
<!--                    <button data-input="tag-pix_icon" class="btn pix-image-upload pix-btn-icon"><i class="fas fa-image"></i></button>-->
<!--                    <button type="button" class="btn pix-reset pix-btn-icon"><i class="fas fa-trash-alt"></i></button>-->
<!--                    --><?php //if(isset($cat_meta['pix_icon']) && filter_var($cat_meta['pix_icon'], FILTER_VALIDATE_URL)){ ?>
<!--                        <p class="pix-bg"> <img width="60px" src="--><?php //echo esc_url($cat_meta['pix_icon']) ?><!--" alt="--><?php //esc_attr_e('Department Icon', 'pixsettings') ?><!--"> </p>-->
<!--                    --><?php //} ?>
<!--                    <p class="pix-field-description">--><?php //_e('svg, png or icon class', 'pixsettings'); ?><!--</p>-->
<!--                </td>-->
<!--            </tr>-->
            <tr class="form-field">
                <th scope="row" valign="top"><label for="tag-pix_image"><?php _e('Image', 'pixsettings'); ?></label></th>
                <td>
                    <input type="text" name="pix_image" id="tag-pix_image" style="width:60%;" value="<?php echo isset($cat_meta['pix_image']) ? esc_url($cat_meta['pix_image']) : ''; ?>" />
                    <button data-input="tag-pix_image" class="btn pix-image-upload pix-btn-icon"><i class="fas fa-image"></i></button>
                    <button type="button" class="btn pix-reset pix-btn-icon"><i class="fas fa-trash-alt"></i></button>
                    <?php if(isset($cat_meta['pix_image']) && $cat_meta['pix_image']){ ?><p class="pix-bg"> <img src="<?php echo esc_url($cat_meta['pix_image']) ?>" alt="<?php esc_attr_e('Department Image', 'pixsettings') ?>"> </p><?php } ?>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row" valign="top"><label for="tag-pix_serv_url"><?php _e('Link', 'pixsettings'); ?></label></th>
                <td>
                    <input type="text" name="pix_serv_url" id="tag-pix_serv_url" size="25" style="width:60%;" value="<?php echo esc_attr($cat_meta['pix_serv_url']) ? esc_attr($cat_meta['pix_serv_url']) : ''; ?>">
                    <p class="pix-field-description"><?php _e('Url', 'pixsettings'); ?></p>
                </td>
            </tr>
            <?php
        }

    function pix_service_cat_custom_fields_add_form($tag) {
        $pix_sections = pixtheme_get_sections();
    ?>
        <div class="form-field">
            <label for="tag-pix-service-cat_section"><?php _e('Pix Section', 'pixsettings'); ?></label>
            <select name="pix-service-cat_section" id="tag-pix-service-cat_section">
            <?php
                foreach($pix_sections as $id => $section){
                    echo "<option value='".esc_attr($id)."'>".esc_attr($section)."</option>\n";
                }
            ?>
            </select>
            <p><?php _e('Custom content', 'pixsettings'); ?></p>
        </div>
<!--        <div class="form-field">-->
<!--            <label for="tag-pix_icon">--><?php //_e('Icon', 'pixsettings'); ?><!--</label>-->
<!--            <input type="text" name="pix_icon" id="tag-pix_icon" size="40" value="">-->
<!--            <button data-input="tag-pix_icon" class="btn pix-image-upload pix-btn-icon"><i class="fas fa-image"></i></button>-->
<!--            <button type="button" class="btn pix-reset pix-btn-icon"><i class="fas fa-trash-alt"></i></button>-->
<!--            <p>--><?php //_e('svg, png or icon class', 'pixsettings'); ?><!--</p>-->
<!--        </div>-->
        <div class="form-field">
            <label for="tag-pix_image"><?php _e('Image', 'pixsettings'); ?></label>
            <input type="text" name="pix_image" id="tag-pix_image" value="">
            <button data-input="tag-pix_image" class="btn pix-image-upload pix-btn-icon"><i class="fas fa-image"></i></button>
            <button type="button" class="btn pix-reset pix-btn-icon"><i class="fas fa-trash-alt"></i></button>
        </div>
        <div class="form-field">
            <label for="tag-pix_serv_url"><?php _e('Link', 'pixsettings'); ?></label>
            <input type="text" name="pix_serv_url" id="tag-pix_serv_url" size="40" value="">
            <br />
            <p><?php _e('Url', 'pixsettings'); ?></p>
        </div>

        <?php
    }

    function pix_service_cat_custom_fields_save($term_id) {
        if (isset($_POST['pix_image']) || isset($_POST['pix-service-cat_section']) || isset($_POST['pix_serv_url'])) {
            $term = get_term_by( 'term_taxonomy_id', $term_id, 'pix-service-cat' );
            $t_slug = $term->slug;
            $cat_meta = get_option("pix-service-cat_$t_slug");
            if (isset($_POST['pix_image'])) {
                $cat_meta['pix_image'] = $_POST['pix_image'];
            }
            if (isset($_POST['pix_icon'])) {
                $cat_meta['pix_icon'] = $_POST['pix_icon'];
            }
            if (isset($_POST['pix_serv_url'])) {
                $cat_meta['pix_serv_url'] = $_POST['pix_serv_url'];
            }
            if (isset($_POST['pix-service-cat_section'])) {
                $cat_meta['pix_cat_section'] = $_POST['pix-service-cat_section'];
            }
            //save the option array
            update_option("pix-service-cat_$t_slug", $cat_meta);
        }
    }


    function pixtheme_post_type_link_filter_function( $post_link, $id = 0, $leavename = FALSE ) {
        if ( strpos('%pix-portfolio-cat%', $post_link)  < 0 ) {
          return $post_link;
        }
        $post = get_post($id);
        if ( !is_object($post) || $post->post_type != 'pix-portfolio' ) {
          return $post_link;
        }
        $terms = wp_get_object_terms($post->ID, 'pix-portfolio-cat');
        if ( !$terms ) {
          return str_replace('portfolio/category/%pix-portfolio-cat%/', '', $post_link);
        }
        return str_replace('%pix-portfolio-cat%', $terms[0]->slug, $post_link);
    }

    add_filter('post_type_link', 'pixtheme_post_type_link_filter_function', 1, 3);

    function pixtheme_services_link_filter_function( $post_link, $id = 0, $leavename = FALSE ) {
        if ( strpos('%pix-service-cat%', $post_link)  < 0 ) {
          return $post_link;
        }
        $post = get_post($id);
        if ( !is_object($post) || $post->post_type != 'pix-service' ) {
          return $post_link;
        }
        $terms = wp_get_object_terms($post->ID, 'pix-service-cat');
        if ( !$terms ) {
          return str_replace('service/category/%pix-service-cat%/', '', $post_link);
        }
        return str_replace('%pix-service-cat%', $terms[0]->slug, $post_link);
    }

    add_filter('post_type_link', 'pixtheme_services_link_filter_function', 2, 3);

		
endif;

global $pix_settings;
$pix_settings = new PixThemeSettings();

function pix_get_svg_content($url){
    if( empty($url) )
        return '';
    else
        return file_get_contents($url);
}

function pix_out($out){
    echo $out;
}


?>