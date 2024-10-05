<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Services extends Base_Posts {

    public function get_name() {
        return 'pixtheme-services';
    }

    public function get_title() {
        return esc_html__( 'Services', 'solutech' );
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_keywords() {
        return [ 'services' ];
    }

    protected function get_post_type() {
        return 'pix-service';
    }

    protected function get_taxonomy() {
        return 'pix-service-caty';
    }

    public function get_script_depends() {
        return [
            'pixtheme-widgets-isotope'
        ];
    }

    protected function register_controls() {
        $this->add_section_content();
        $this->add_image_size_section();
        parent::register_controls();
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
                'default' => esc_html__( 'Projects', 'solutech' ),
            ]
        );

        $this->add_control(
            'show_filter',
            [
                'type' => Controls_Manager::SWITCHER,
                'label' => esc_html__( 'Show filter', 'solutech' ),
                'default' => 'yes',
                'label_off' => esc_html__( 'Hide', 'solutech' ),
                'label_on' => esc_html__( 'Show', 'solutech' ),
            ]
        );

        $this->add_control(
            'cols',
            [
                'label' => esc_html__( 'Services per row', 'solutech' ),
                'description' => esc_html__( 'How many services should be shown per row?', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    '2' => esc_html__( '2 columns', 'solutech' ),
                    '3' => esc_html__( '3 columns', 'solutech' ),
                    '4' => esc_html__( '4 columns', 'solutech' ),
                ),
                'default' => '3',
            ]
        );

        $this->add_control(
            'image_proportions',
            [
                'label' => esc_html__( 'Image proportions', 'solutech' ),
                'description' => esc_html__( 'The width of the loaded service preview must be at least the base width of the image (see Appearance->Customize->Portfolio->Image Size)', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'square' => esc_html__( 'Square', 'solutech' ),
                    'landscape' => esc_html__( 'Landscape', 'solutech' ),
                    'portrait' => esc_html__( 'Portrait', 'solutech' ),
                    'original' => esc_html__( 'Original', 'solutech' ),
                ),
                'default' => 'square',
            ]
        );

        $this->add_control(
            'show_button',
            [
                'type' => Controls_Manager::SWITCHER,
                'label' => esc_html__( 'Show button', 'solutech' ),
                'default' => 'yes',
                'label_off' => esc_html__( 'Hide', 'solutech' ),
                'label_on' => esc_html__( 'Show', 'solutech' ),
            ]
        );

        $this->add_control(
            'btn_text',
            [
                'label' => esc_html__( 'Button text', 'solutech' ),
                'default' => esc_html__( 'more services', 'solutech' ),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'show_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'btn_link',
            [
                'label' => esc_html__( 'Button Link', 'solutech' ),
                'description' => esc_html__( 'Leave empty to use all services link', 'solutech' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'solutech' ),
                'condition' => [
                    'show_button' => 'yes',
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

    protected function print_items( array $settings = null ) {
        if ( null === $settings ) {
            $settings = $this->get_settings_for_display();
        }
        ?>

        <div class="widget-projects-isotope">
            <div class="projects__top">
                <?php if ( ! empty( $title = $settings['title'] ) ) : ?>
                <div class="projects__title">
                    <h2><?php echo esc_html( $title ); ?></h2>
                </div>
                <?php endif; ?>
                <?php if ( ! empty( $settings['show_filter'] ) && 'yes' === $settings['show_filter'] ) : ?>
                    <?php
                    $terms = [];
                    $attributes = [
                        'taxonomy' => 'pix-service-cat',
                    ];
                    $term_ids = [];
                    if ( ! empty( $term_slugs = $settings['include_term_slugs'] ) ) :
                        foreach( $term_slugs as $slug ) {
                            $term = get_term_by( 'slug', $slug, 'pix-service-cat' );
                            if ( isset( $term->term_id ) ) {
                                $term_ids[] = $term->term_id;
                            }
                        }
                        $attributes['include'] = $term_ids;
                    endif;
                    $terms = get_terms( $attributes );
                    ?>
                    <ul class="projects__filter projects__filter-isotope">
                        <li class="active"><a href="#" data-filter="*"><?php echo esc_html__( 'All', 'solutech' ); ?></a></li>
                        <?php
                        foreach ( $terms as $term ) :
                            $term_name = $term->name;
                            $term_slug = $term->slug;
                            echo '<li><a data-filter=".' . esc_attr( $term_slug ) . '" href="#">' . esc_attr( $term_name ) . '</a></li>';
                        endforeach;
                        ?>
                    </ul>
                <?php endif; ?>
            </div>
            <?php
            $this->query_posts();

            $posts_query = $this->get_query();
            ?>
            <?php if ( $posts_query->have_posts() ) : ?>
                <?php
                $solutech_add_class = '';
                $cols = $settings['cols'];
                if ( '2' === $cols ) {
                    $solutech_add_class = 'row-cols-lg-2';
                } elseif ( '3' === $cols ) {
                    $solutech_add_class = 'row-cols-lg-2 row-cols-xl-3';
                } elseif ( '4' === $cols ) {
                    $solutech_add_class = 'row-cols-md-2 row-cols-lg-3 row-cols-xy-4';
                }
                ?>
                <div class="projects__container row mb-n30 row-cols-1 <?php echo esc_attr( $solutech_add_class ); ?>">
                    <?php while ( $posts_query->have_posts() ) : $posts_query->the_post(); ?>
                        <?php $this->print_item( $settings ); ?>
                    <?php endwhile; ?>
                </div>
                <?php if ( ! empty( $settings['show_button'] ) && 'yes' === $settings['show_button'] && ! empty( $btn_text = $settings['btn_text'] )  ) : ?>
                    <?php
                    $solutech_all_services_id = solutech_get_option( 'archive_portfolio_page', 'default' );
                    ?>
                    <div class="projects__btn">
                        <?php if ( ! empty( $btn_link = $settings['btn_link']['url'] ) ) : ?>
                            <?php
                            $target = $settings['btn_link']['is_external'] ? ' target="_blank"' : '';
                            $nofollow = $settings['btn_link']['nofollow'] ? ' rel="nofollow"' : '';
                            ?>
                            <a class="btn btn-black" href="<?php echo esc_url( $btn_link ); ?>"<?php echo wp_kses( $target . $nofollow, 'strip' ); ?>><?php echo esc_html( $btn_text ); ?><i class="pix-icon-caret-right"></i></a>
                            <?php else : ?>
                                <?php if ( $solutech_all_services_id && $solutech_all_services_id != 'default' ) :
                                    if ( function_exists( 'icl_object_id' ) ) :
                                        $solutech_all_services_id = icl_object_id( $solutech_all_services_id, 'page', true );
                                    endif; ?>
                                    <a class="btn btn-black" href="<?php echo esc_url( get_page_link( $solutech_all_services_id ) ); ?>"><?php echo esc_html( $btn_text ); ?><i class="pix-icon-caret-right"></i></a>
                                <?php else : ?>
                                    <a class="btn btn-black" href="<?php echo get_post_type_archive_link( 'pix-service' ); ?>"><?php echo esc_html( $btn_text ); ?><i class="pix-icon-caret-right"></i></a>
                                <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php wp_reset_postdata(); ?>
        <?php
    }

    protected function print_item( array $settings ) {
        set_query_var( 'settings', $settings );

        get_template_part( 'template-parts/service/content' );
    }

}
