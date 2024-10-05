<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Products_Vcards_Carousel extends Base_Posts_Carousel {

    public function get_name() {
        return 'pixtheme-products-vcard-carousel';
    }

    public function get_title() {
        return esc_html__( 'Products Vertical Cards Carousel', 'solutech' );
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
            'countdown',
            'pixtheme-widgets-countdown',
            'pixtheme-widgets-slider-images'
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
        $this->add_image_size_section();
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

        $this->end_controls_section();
    }

    protected function add_image_size_section() {
        $this->start_controls_section(
            'image_size_section',
            [
                'label' => esc_html__( 'Image Size', 'solutech' ),
            ]
        );

        $this->add_control(
            'image_size_default',
            [
                'label'        => esc_html__( 'Use Default Thumbnail Size', 'solutech' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '1',
                'return_value' => '1',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image_size',
                'default'   => 'full',
                'condition' => [
                    'image_size_default!' => '1',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function update_controls() {

        $this->update_responsive_control(
            'space',
            [
                'default' => 0,
            ]
        );

        $this->update_control(
            'show_dots',
            [
                'default' => 'no',
            ]
        );
    }

    protected function print_slider( array $settings = null ) {
        if ( null === $settings ) {
            $settings = $this->get_settings_for_display();
        }

        $slider_settings = $this->get_slider_settings( $settings );

        $this->add_render_attribute( 'slider', $slider_settings );

        ?>

        <div <?php $this->print_render_attribute_string( 'slider' ); ?>>
            <div class="section__title <?php echo esc_attr( $settings['indent_class'] ); ?>">
                <?php if ( ! empty( $title = $settings['title'] ) ) : ?>
                    <h2><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>
                <div class="arrows"></div>
            </div>
            <?php
            $this->query_posts();

            $posts_query = $this->get_query();
            ?>
                <div class="swiper-container topsales text-center">
                    <div class="swiper-wrapper">
                        <?php if ( $posts_query->have_posts() ) : ?>
                            <?php while ( $posts_query->have_posts() ) : $posts_query->the_post(); ?>
                                <div class="swiper-slide">
                                    <?php $this->print_slide( $settings ); ?>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                    <?php if ( ! empty( $settings['show_dots'] ) && 'yes' === $settings['show_dots']  ) : ?>
                        <div class="swiper-pagination-wrap"></div>
                    <?php endif; ?>
                </div>
        </div>
        <?php wp_reset_postdata(); ?>
        <?php
    }

    protected function print_slide( array $settings ) {
        set_query_var( 'settings', $settings );

        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
        get_template_part( 'template-parts/elementor/woocommerce/content', 'product-vcard' );
    }

}
