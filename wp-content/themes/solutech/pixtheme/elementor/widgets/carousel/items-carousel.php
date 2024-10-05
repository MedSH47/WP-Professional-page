<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}



class Widget_Items_Carousel extends Base_Carousel {

    public function get_name() {
        return 'pixtheme-items-carousel';
    }

    public function get_title() {
        return esc_html__( 'Items Carousel', 'solutech' );
    }

    public function get_icon() {
        return 'eicon-posts-carousel';
    }

    public function get_keywords() {
        return [ 'item', 'icon box', 'icon', 'carousel', 'image' ];
    }

    public function get_script_depends() {
        return [ 'pixtheme-widgets-carousel' ];
    }

    protected function register_controls() {
        $this->add_section_content();
        parent::register_controls();
        $this->update_controls();
    }
    
    public function items_get_template_elementor($type = null) {
        $categories = get_terms( [
			'taxonomy' => 'pix-template-category',
			'hide_empty' => true,
		] );
        $sliders = [0 => esc_html__('Default', 'solutech')];
        if(!empty($categories) && !is_wp_error($categories)){
            foreach($categories as $category){
                $sliders[$category->slug] = $category->name;
            }
        }
        
        return $sliders;
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
			'list_content_template',
			[
				'label' => esc_html__( 'Template', 'solutech' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->items_get_template_elementor(),
			]
		);

        $this->end_controls_section();
    }

    private function update_controls() {
        $this->update_responsive_control(
            'slides_per_view',
            [
                'default' => '6',
                'tablet_default' => '4',
                'mobile_default' => '2',
            ]
        );

        $this->update_responsive_control(
            'slides_per_group',
            [
                'default' => '6',
                'tablet_default' => '4',
                'mobile_default' => '2',
            ]
        );

        $this->update_responsive_control(
            'slides_per_column',
            [
                'default'        => '6',
                'tablet_default' => '4',
                'mobile_default' => '2',
            ]
        );

        $this->update_control(
            'show_arrows',
            [
                'type' => Controls_Manager::HIDDEN,
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
            <div class="swiper-container items-carousel">
                <div class="swiper-wrapper">
                    <?php
                    $slides = get_posts(array(
                        'post_type' => 'pix-template',
                        'numberposts' => -1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'pix-template-category',
                                'field' => 'slug',
                                'terms' => $settings['list_content_template'],
                            )
                        )
                    ));
                    foreach ( $slides as $index => $slide ) :
                        ?>
                        <div class="swiper-slide">
                            <?php if ( isset($slide->ID) ) {
                                pixtheme_get_el_section_content($slide->ID, true);
                            } ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if ( ! empty( $settings['show_dots'] ) && 'yes' === $settings['show_dots']  ) : ?>
                    <div class="swiper-pagination-wrap"></div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

}
