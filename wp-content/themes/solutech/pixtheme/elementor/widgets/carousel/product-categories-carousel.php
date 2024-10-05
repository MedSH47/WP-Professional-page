<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Product_Categories_Carousel extends Base_Carousel {

    public function get_name() {
        return 'pixtheme-product-categories-carousel';
    }

    public function get_title() {
        return esc_html__( 'Product Categories Carousel', 'solutech' );
    }

    public function get_icon() {
        return 'eicon-posts-carousel';
    }

    public function get_keywords() {
        return [ 'woocommerce', 'carousel', 'categories' ];
    }

    public function get_script_depends() {
        return [ 'pixtheme-widgets-carousel' ];
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

        $repeater = new Repeater();

        $attributes_parent_terms = [
            'taxonomy' => 'product_cat',
            'parent' => 0,
            'hide_empty' => false
        ];

        $parents_top_level_categories = get_terms( $attributes_parent_terms );

        $parent_slugs = [];
        foreach ( $parents_top_level_categories as $category ) {
            $parent_slugs[ $category->slug ] = $category->name;
        }

        $repeater->add_control(
            'parent_category',
            [
                'label' => esc_html__( 'Category', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'options' => $parent_slugs,
                'default' => '',
                'label_block' => true,
            ]
        );

        foreach ( $parent_slugs as $parent_slug => $parent_name ) {

            $parent = get_term_by( 'slug', $parent_slug, 'product_cat' );
            if ( isset( $parent->term_id ) ) {
                $parent_id = $parent->term_id;
            }

            $attributes_sub_terms = [
                'taxonomy' => 'product_cat',
                'child_of' => $parent_id,
                'hide_empty' => false
            ];

            $sub_terms_options = [];
            $sub_terms = get_terms( $attributes_sub_terms );

            foreach ( $sub_terms as $sub_term ) {
                $sub_terms_options[ $sub_term->slug ] = $sub_term->name;
            }

            $repeater->add_control(
                'sub_categories_'.$parent_slug,
                [
                    'label' => esc_html__( 'Children Categories', 'solutech' ),
                    'type' => Controls_Manager::SELECT2,
                    'options' => $sub_terms_options,
                    'default' => '',
                    'multiple' => true,
                    'label_block' => true,
                    'condition' => [
                        'parent_category' => "$parent_slug",
                    ],
                ]
            );

        }

        $repeater->add_control(
            'before_title',
            [
                'label' => esc_html__( 'Before Title Text', 'solutech' ),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'solutech' ),
                'description' => esc_html__( 'Leave empty to use original category name', 'solutech' ),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__( 'Image', 'solutech' ),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'slides',
            [
                'label' => esc_html__( 'Slides', 'solutech' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'separator' => 'after',
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
                'type' => Controls_Manager::HIDDEN,
                'default' => '1',
                'tablet_default' => '1',
                'mobile_default' => '1',
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

        $slides_count = count( $settings['slides'] );
        ?>
        <div <?php $this->print_render_attribute_string( 'slider' ); ?>>
            <div class="swiper-container catcarousel">
                <div class="swiper-wrapper">
                    <?php
                    foreach ( $settings['slides'] as $index => $slide ) :
                        $this->slide_prints_count++;
                        $this->print_slide( $slide, $settings, 'slide-' . $index . '-' . $this->slide_prints_count );
                    endforeach;
                    ?>
                </div>
                <?php if ( ! empty( $settings['show_dots'] ) && 'yes' === $settings['show_dots']  ) : ?>
                    <div class="swiper-pagination-wrap"></div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    protected function print_slide( array $slide, array $settings, $element_key ) {

        $parent_term_slug = $slide['parent_category'];

        if ( ! empty( $parent_term_slug ) ) :
            $parent_term = get_term_by( 'slug', $parent_term_slug, 'product_cat' );
            if ( ! is_wp_error( $parent_term ) && ! empty( $parent_term->name ) ) :

                $parent_title = ( ! empty( $slide['title'] ) ) ? $slide['title'] : $parent_term->name;
                $parent_term_link = get_term_link( $parent_term );

                $subterms = [];
                $sub_categories = 'sub_categories_' . $parent_term_slug;
                if ( ! empty( $sub_cats = $slide[$sub_categories] ) ) {

                    $sub_cat_ids = [];
                    foreach ( $sub_cats as $sub_cat ) {
                        $sub_term = get_term_by( 'slug', $sub_cat, 'product_cat' );
                        if ( isset( $sub_term->term_id ) ) {
                            $sub_cat_ids[] = $sub_term->term_id;
                        }
                    }

                    $attributes = [
                        'taxonomy' => 'product_cat',
                        'include' => $sub_cat_ids,
                        'hide_empty' => false
                    ];

                    $subterms = get_terms( $attributes );
                }
                ?>
                <div class="swiper-slide">
                    <div class="catcarousel__item">
                        <div class="catcarousel__itemInner">
                            <div class="catcarousel__itemInfo">
                                <div class="catcarousel__itemOver"><?php echo esc_html( $slide['before_title'] ); ?></div>
                                <h3 class="catcarousel__itemCat"><a href="<?php echo esc_html( $parent_term_link ); ?>"> <?php echo esc_html( $parent_title ); ?></a></h3>
                                <?php if ( ! empty( $subterms ) ) : ?>
                                    <div class="catcarousel__itemCats">
                                        <?php
                                        foreach ( $subterms as $term ) :
                                            $sub_term_name = $term->name;
                                            $sub_term_link = get_term_link( $term );
                                            echo '<a href="' . esc_url( $sub_term_link ) . '">' . esc_attr( $sub_term_name ) . '</a>';
                                        endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if ( $slide['image']['url'] ) : ?>
                            <div class="catcarousel__itemImg">
                                <?php echo wp_get_attachment_image( $slide['image']['id'], 'solutech-thumb-small' ); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php
            endif;
        endif;
    }

}
