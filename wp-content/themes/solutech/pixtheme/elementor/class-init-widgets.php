<?php

namespace Pixtheme_Elementor;

use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Init {

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct() {
        add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );

        // Registered Widgets.
        add_action( 'elementor/widgets/register', [ $this, 'init_widgets' ] );
        add_action( 'elementor/widgets/register', [ $this, 'remove_unnecessary_widgets' ], 15 );

        add_filter( 'elementor/utils/get_the_archive_title', [ $this, 'change_portfolio_archive_title' ] );

        require_once get_template_directory() . '/pixtheme/elementor/widgets/native/section.php';
        
        add_action( 'elementor/element/section/section_layout/after_section_start', [ $this, 'pix_inject_section_controls' ], 10, 2 );

    }

    /**
     * Add category.
     *
     * @since  1.0.0
     *
     * @access public
     *
     * @param \Elementor\Elements_Manager $elements_manager
     */
    public function add_elementor_widget_categories( $elements_manager ) {
        $elements_manager->add_category(
            'pixtheme',
            [
                'title' => esc_html__( 'Pix-Theme', 'solutech' ),
                'icon' => 'fa fa-plug',
                'active' => true,
            ]
        );
        
        $reorder_cats = function(){
            uksort($this->categories, function($keyOne, $keyTwo){
                if(substr($keyOne, 0, 3) == 'pix'){
                return -1;
            }
            if(substr($keyTwo, 0, 3) == 'pix'){
                return 1;
            }
            return 0;
        });

        };
        $reorder_cats->call($elements_manager);
    }

    /**
     * Init Widgets
     *
     * Include widgets files and register them
     *
     * @since  1.0.0
     *
     * @access public
     */
    public function init_widgets() {

        // Include Widget files.
        require_once get_template_directory() . '/pixtheme/elementor/modules/module-query-custom.php';
        require_once get_template_directory() . '/pixtheme/elementor/widgets/base.php';
        require_once get_template_directory() . '/pixtheme/elementor/widgets/carousel/base-carousel.php';
        require_once get_template_directory() . '/pixtheme/elementor/widgets/carousel/base-posts-carousel.php';
        require_once get_template_directory() . '/pixtheme/elementor/widgets/posts/base-posts.php';

        require_once get_template_directory() . '/pixtheme/elementor/widgets/title.php';
        require_once get_template_directory() . '/pixtheme/elementor/widgets/banner.php';
        require_once get_template_directory() . '/pixtheme/elementor/widgets/social-icons.php';
        require_once get_template_directory() . '/pixtheme/elementor/widgets/button.php';
        require_once get_template_directory() . '/pixtheme/elementor/widgets/cform7.php';
        require_once get_template_directory() . '/pixtheme/elementor/widgets/mc4wp.php';
        require_once get_template_directory() . '/pixtheme/elementor/widgets/video.php';
        require_once get_template_directory() . '/pixtheme/elementor/widgets/calculator.php';
        require_once get_template_directory() . '/pixtheme/elementor/widgets/pix_points.php';
        if ( class_exists( 'booked_plugin' ) ) {
	        require_once get_template_directory() . '/pixtheme/elementor/widgets/booking.php';
        }

        require_once get_template_directory() . '/pixtheme/elementor/widgets/carousel/logos-carousel.php';
        require_once get_template_directory() . '/pixtheme/elementor/widgets/carousel/posts-carousel.php';
        require_once get_template_directory() . '/pixtheme/elementor/widgets/carousel/team-double-block-carousel.php';
        require_once get_template_directory() . '/pixtheme/elementor/widgets/carousel/testimonials-carousel.php';
        require_once get_template_directory() . '/pixtheme/elementor/widgets/carousel/team-carousel.php';
        require_once get_template_directory() . '/pixtheme/elementor/widgets/carousel/items-carousel.php';


        // Register Widgets.
        Plugin::instance()->widgets_manager->register( new Widget_Title() );

        Plugin::instance()->widgets_manager->register( new Widget_Logos_Carousel() );
        Plugin::instance()->widgets_manager->register( new Widget_Posts_Carousel() );
        Plugin::instance()->widgets_manager->register( new Widget_Team_Double_Block_Carousel() );
        Plugin::instance()->widgets_manager->register( new Widget_Testimonials_Carousel() );
        Plugin::instance()->widgets_manager->register( new Widget_Team_Carousel() );
        Plugin::instance()->widgets_manager->register( new Widget_Items_Carousel() );

        Plugin::instance()->widgets_manager->register( new Widget_Banner() );
        Plugin::instance()->widgets_manager->register( new Widget_Social_Icons() );
        Plugin::instance()->widgets_manager->register( new Widget_Button() );
        Plugin::instance()->widgets_manager->register( new Widget_Cform7() );
        Plugin::instance()->widgets_manager->register( new Widget_MC4WP() );
        Plugin::instance()->widgets_manager->register( new Widget_Video() );
        Plugin::instance()->widgets_manager->register( new Widget_Calculator() );
        Plugin::instance()->widgets_manager->register( new Widget_Points() );
        if ( class_exists( 'booked_plugin' ) ) {
	        Plugin::instance()->widgets_manager->register( new Widget_Booking() );
        }

        if ( pixtheme_use_woo() ) {
            require_once get_template_directory() . '/pixtheme/elementor/widgets/carousel/products-extended-carousel.php';
            require_once get_template_directory() . '/pixtheme/elementor/widgets/carousel/products-vcards-carousel.php';
            require_once get_template_directory() . '/pixtheme/elementor/widgets/carousel/products-hcards-carousel.php';
            require_once get_template_directory() . '/pixtheme/elementor/widgets/carousel/products-double-block-carousel.php';
            require_once get_template_directory() . '/pixtheme/elementor/widgets/carousel/product-categories-carousel.php';

            Plugin::instance()->widgets_manager->register( new Widget_Products_Extended_Carousel() );
            Plugin::instance()->widgets_manager->register( new Widget_Products_Vcards_Carousel() );
            Plugin::instance()->widgets_manager->register( new Widget_Products_Hcards_Carousel() );
            Plugin::instance()->widgets_manager->register( new Widget_Products_Double_Block_Carousel() );
            Plugin::instance()->widgets_manager->register( new Widget_Product_Categories_Carousel() );
        }

        if ( pixtheme_use_portfolio() ) {
            require_once get_template_directory() . '/pixtheme/elementor/widgets/posts/projects.php';
            require_once get_template_directory() . '/pixtheme/elementor/widgets/carousel/projects-extended-carousel.php';
            require_once get_template_directory() . '/pixtheme/elementor/widgets/carousel/items-extended-carousel.php';

            Plugin::instance()->widgets_manager->register( new Widget_Projects() );
            Plugin::instance()->widgets_manager->register( new Widget_Projects_Extended_Carousel() );
            Plugin::instance()->widgets_manager->register( new Widget_Items_Extended_Carousel() );
        }

        if ( pixtheme_use_service() ) {
            require_once get_template_directory() . '/pixtheme/elementor/widgets/posts/services.php';
            require_once get_template_directory() . '/pixtheme/elementor/widgets/carousel/services-extended-carousel.php';

            Plugin::instance()->widgets_manager->register( new Widget_Services() );
            Plugin::instance()->widgets_manager->register( new Widget_Services_Extended_Carousel() );
        }
    }

    function remove_unnecessary_widgets( $widgets_manager ) {
        $elementor_unnecessary_widgets_list =
            [
                'woocommerce-menu-cart',
            ];

        foreach ( $elementor_unnecessary_widgets_list as $widget_name ) {
            $widgets_manager->unregister( $widget_name );
        }
    }

    public function change_portfolio_archive_title( $title ) {
        if ( is_tax( 'pix-portfolio-category' ) || is_post_type_archive( 'pix-portfolio' ) ) {
            $title = solutech_get_option( 'header_archive_portfolio_title', esc_html__( 'Portfolio', 'solutech' ) );
        }

        return $title;
    }
    
    public function pix_inject_section_controls( $element, $args ) {

		$element->add_control(
			'section_boxed',
			[
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label' => esc_html__( 'Boxed Theme Style', 'solutech' ),
                'default' => 'no',
                'label_off' => esc_html__( 'Off', 'solutech' ),
                'label_on' => esc_html__( 'On', 'solutech' ),
				'prefix_class' => 'pix-container-boxed-'
			]
		);
	
	}
}

Widget_Init::instance();
