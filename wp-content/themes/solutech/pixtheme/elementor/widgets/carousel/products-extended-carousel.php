<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Products_Extended_Carousel extends Base_Posts_Carousel {

    public function get_name() {
        return 'pixtheme-products-extended-carousel';
    }

    public function get_title() {
        return esc_html__( 'Products Carousel with Filter', 'solutech' );
    }

    public function get_icon() {
        return 'eicon-posts-carousel';
    }

    public function get_keywords() {
        return [ 'products', 'woocommerce', 'carousel' ];
    }

    public function get_script_depends() {
        return [
            'pixtheme-widgets-carousel',
            'pixtheme-widgets-products-filter'
        ];
    }

    protected function get_post_type() {
        return 'product';
    }

    protected function get_taxonomy() {
        return 'product_cat';
    }

    protected function register_controls() {
        $this->add_section_content();
        parent::register_controls();
        $this->update_controls();
    }

    private function add_section_content() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Content', 'solutech' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__( 'Heading', 'solutech' ),
                'default' => esc_html__( 'Products', 'solutech' ),
            ]
        );

        $this->add_control(
            'indent_class',
            [
                'label' => esc_html__( 'Title left indent', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__( 'No indent', 'solutech' ),
                    'ml-xl-70 ml-xz-140' => esc_html__( 'Indented', 'solutech' ),
                ],
            ]
        );
        
        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Product Style', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'icons_left',
                'options' => [
                    'icons_left' => esc_html__( 'Icons Left', 'solutech' ),
                    'icons_center' => esc_html__( 'Icons Center', 'solutech' ),
                ],
            ]
        );

        $this->add_control(
            'show_categories',
            [
                'label' => esc_html__( 'Show Categories Block', 'solutech' ),
                'description' => esc_html__( 'By default, all top-level categories will be shown. If you want to display only some product categories, select them in the section Query', 'solutech' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'solutech' ),
                'label_off' => esc_html__( 'Hide', 'solutech' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_top_filter',
            [
                'label' => esc_html__( 'Show Top Filter', 'solutech' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'solutech' ),
                'label_off' => esc_html__( 'Hide', 'solutech' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'top_filter_type',
            [
                'label' => esc_html__( 'Top Filter Type', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__( 'Labels', 'solutech' ),
                    'cats' => esc_html__( 'Categories', 'solutech' ),
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function update_controls() {

        $this->update_responsive_control(
            'slides_per_view',
            [
                'default'        => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
            ]
        );

        $this->update_responsive_control(
            'slides_per_group',
            [
                'default'        => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
            ]
        );

        $this->update_responsive_control(
            'slides_per_column',
            [
                'default'        => '2',
                'tablet_default' => '2',
                'mobile_default' => '1',
            ]
        );

        $this->update_control(
            'show_dots',
            [
                'default' => 'no',
            ]
        );

        $this->update_control(
            'query_type',
            [
                'type' => Controls_Manager::HIDDEN,
                'default' => 'custom_query',
            ]
        );

        $this->update_control(
            'product_type',
            [
                'type' => Controls_Manager::HIDDEN,
                'default' => 'all',
            ]
        );
    }

    protected function print_slider( array $settings = null ) {
        if ( null === $settings ) {
            $settings = $this->get_settings_for_display();
        }

        $slider_settings = $this->get_slider_settings( $settings );

        $default_settings = [
		    'class' => ['pix-extended-product-container']
		];

		$slider_settings = array_merge_recursive( $default_settings, $slider_settings );

        $this->add_render_attribute( 'slider', $slider_settings );

        $indicator_featured = Module_Query_Custom::get_indicator_availability_featured_product_in_catalog( $settings );
        $indicator_onsale = Module_Query_Custom::get_indicator_availability_sale_product_in_catalog( $settings );
        $indicator_new = Module_Query_Custom::get_indicator_availability_new_product_in_catalog( $settings );
        
        $show_categories = ( 'yes' === $settings['show_categories'] ) ? true : false;
        $top_filter_type = ( 'cats' === $settings['top_filter_type'] ) ? 'cats' : '';
        if ( $show_categories || $top_filter_type == 'cats' ){
            $terms = [];
            $attributes = [];
            $term_ids = [];
            if ( ! empty( $term_slugs = $settings['include_term_slugs'] ) ) :
                foreach( $term_slugs as $slug ) {
                    $term = get_term_by( 'slug', $slug, 'product_cat' );
                    if ( isset( $term->term_id ) ) {
                        $term_ids[] = $term->term_id;
                    }
                }
                $attributes = [
                    'taxonomy' => 'product_cat',
                    'include' => $term_ids
                ];
            else :
                $attributes = [
                    'taxonomy' => 'product_cat',
                    'parent' => '0',
                ];
            endif;
            $terms = get_terms( $attributes );
        }
        
        
        ?>

        <div <?php $this->print_render_attribute_string( 'slider' ); ?>>
            <div class="section__title <?php echo esc_attr( $settings['indent_class'] ); ?>">
                <?php if ( ! empty( $title = $settings['title'] ) ) : ?>
                    <h2><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>
                <?php if ( 'yes' === $settings['show_top_filter'] ) : ?>
                    <?php $cat_class = $top_filter_type == 'cats' ? 'pix-product-categories-container' : 'pix-product-filter-container'; ?>
                <div class="<?php echo esc_attr($cat_class);?> section__titleFilter">
                    <a class="active" data-product-type="all" href="#"><?php echo esc_html__( 'All', 'solutech' ); ?></a>
                    <?php if ( $top_filter_type == 'cats' ) : ?>
                        <?php
                        foreach ( $terms as $term ) :
                            $term_name = $term->name;
                            $term_id = $term->term_id;
                            echo '<a data-term-id="' . esc_attr( $term_id ) . '" href="#">' . esc_attr( $term_name ) . '</a>';
                        endforeach;
                        ?>
                    <?php else : ?>
                        <?php if ( $indicator_featured && $indicator_featured > 0 ) : ?>
                        <a data-product-type="featured" href="#"><?php echo esc_html__( 'Popular', 'solutech' ); ?></a>
                        <?php endif; ?>
                        <?php if ( $indicator_onsale && $indicator_onsale > 0 ) : ?>
                        <a data-product-type="onsale" href="#"><?php echo esc_html__( 'Sale', 'solutech' ); ?></a>
                        <?php endif; ?>
                        <?php if ( $indicator_new && $indicator_new > 0 ) : ?>
                        <a data-product-type="new" href="#"><?php echo esc_html__( 'Newest', 'solutech' ); ?></a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <div class="arrows"></div>
            </div>

            <?php
            
            $add_product_section_class = ( $show_categories ) ? 'col-xx-9 col-lg-8' : 'col-12';
            $add_product_section_class .= $settings['style'] == 'icons_center' ? ' icons-center' : '';
            ?>

            <div class="row overflow-hidden">
                <?php if ( $show_categories ) : ?>
                    <div class="col-xx-3 col-lg-4 mb-60 mb-lg-0">
                        <aside class="sidebar">
                            <div class="pix-product-categories-container widget widget-categories unorder">
                                <ul class="pix-product-category-container font-weight-bolder ml-xz-60">
                                    <?php
                                    foreach ( $terms as $term ) :
                                        $term_name = $term->name;
                                        $term_id = $term->term_id;
                                        echo '<li><a data-term-id="' . esc_attr( $term_id ) . '" href="#">' . esc_attr( $term_name ) . '</a></li>';
                                    endforeach;
                                    ?>
                                    <li><a class="active" data-term-id="all" href="#"><?php echo esc_html__( 'All', 'solutech' ); ?></a></li>
                                </ul>
                            </div>
                        </aside>
                    </div>
                <?php endif; ?>
                <div class="<?php echo esc_attr( $add_product_section_class ); ?>">
                    <?php
                    $this->query_posts();

                    $posts_query = $this->get_query();

	                $solutech_extended_products_query_vars = htmlspecialchars( wp_json_encode( $this->get_query_args() ) );
	                ?>

                    <div class="swiper-container topproducts" data-query="<?php echo esc_attr( $solutech_extended_products_query_vars ); ?>" data-taxonomy="<?php echo esc_attr( $this->get_taxonomy() ); ?>">
                        <div class="swiper-wrapper">
                            <?php if ( $posts_query->have_posts() ) : ?>
                                <?php while ( $posts_query->have_posts() ) : $posts_query->the_post(); ?>
                                    <div class="swiper-slide">
                                        <?php $this->print_slide( $settings ); ?>
                                    </div>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                        <div class="topproductsLoader">
                            <div></div>
                        </div>
                        <?php if ( ! empty( $settings['show_dots'] ) && 'yes' === $settings['show_dots']  ) : ?>
                            <div class="swiper-pagination-wrap"></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php wp_reset_postdata(); ?>
        <?php
    }

    protected function print_slide( array $settings ) {
        if($settings['style'] == 'icons_center'){
            get_template_part( 'template-parts/woocommerce/content-product', 'icons-center' );
        } else {
            wc_get_template_part( 'content', 'product' );
        }
    }

}
