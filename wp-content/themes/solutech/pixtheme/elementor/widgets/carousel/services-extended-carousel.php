<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Services_Extended_Carousel extends Base_Posts_Carousel {

    public function get_name() {
        return 'pixtheme-services-extended-carousel';
    }

    public function get_title() {
        return esc_html__( 'Services Carousel with Filter', 'solutech' );
    }

    public function get_icon() {
        return 'eicon-posts-carousel';
    }

    public function get_keywords() {
        return [ 'services', 'carousel' ];
    }

    public function get_script_depends() {
        return [
            'pixtheme-widgets-carousel',
            'pixtheme-widgets-services-filter'
        ];
    }

    protected function get_post_type() {
        return 'pix-service';
    }

    protected function get_taxonomy() {
        return 'pix-service-cat';
    }

    protected function register_controls() {
        $this->add_section_content();
        //$this->add_image_size_section();
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
                'label' => esc_html__( 'Projects per row', 'solutech' ),
                'description' => esc_html__( 'How many projects should be shown per row?', 'solutech' ),
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
                'description' => esc_html__( 'The width of the loaded portfolio preview must be at least the base width of the image (see Appearance->Customize->Portfolio->Image Size)', 'solutech' ),
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
		    'class' => ['pix-extended-projects-container']
		];

		$slider_settings = array_merge_recursive( $default_settings, $slider_settings );

        $this->add_render_attribute( 'slider', $slider_settings );
        
        $terms = [];
        if ( 'yes' === $settings['show_filter'] ){
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
        }
        
        
        ?>

        <div <?php $this->print_render_attribute_string( 'slider' ); ?>>
            <?php if ( ! empty( $title = $settings['title'] ) || 'yes' === $settings['show_filter'] ) : ?>
            <div class="section__title">
                <?php if ( ! empty( $title = $settings['title'] ) ) : ?>
                    <h2><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>
                <?php if ( 'yes' === $settings['show_filter'] ) : ?>
                <div class="pix-project-categories-container section__titleFilter">
                    <a class="active" data-project-type="all" href="#"><?php echo esc_html__( 'All', 'solutech' ); ?></a>
                    <?php
                    foreach ( $terms as $term ) :
                        $term_name = $term->name;
                        $term_id = $term->term_id;
                        echo '<a data-term-id="' . esc_attr( $term_id ) . '" href="#">' . esc_attr( $term_name ) . '</a>';
                    endforeach;
                    ?>
                </div>
                <?php endif; ?>
                <div class="arrows"></div>
            </div>
            <?php endif; ?>

            <div class="row overflow-hidden">
                <div class="col-12">
                    <?php
                    $this->query_posts();

                    $posts_query = $this->get_query();

	                $solutech_extended_projects_query_vars = htmlspecialchars( wp_json_encode( $this->get_query_args() ) );
	                ?>

                    <div class="swiper-container topproducts" data-query="<?php echo esc_attr( $solutech_extended_projects_query_vars ); ?>" data-taxonomy="<?php echo esc_attr( $this->get_taxonomy() ); ?>">
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
        set_query_var( 'settings', $settings );

        get_template_part( 'template-parts/service/content' );
    }

}
