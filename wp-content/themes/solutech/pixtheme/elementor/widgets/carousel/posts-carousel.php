<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Posts_Carousel extends Base_Posts_Carousel {

    public function get_name() {
        return 'pixtheme-posts-carousel';
    }

    public function get_title() {
        return esc_html__( 'Posts Carousel', 'solutech' );
    }

    public function get_icon() {
        return 'eicon-posts-carousel';
    }

    public function get_keywords() {
        return [ 'posts', 'carousel' ];
    }

    public function get_script_depends() {
        return [ 'pixtheme-widgets-carousel' ];
    }

    protected function get_post_type() {
        return 'post';
    }

    protected function get_taxonomy() {
        return 'category';
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
                'default' => esc_html__( 'Our news', 'solutech' ),
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
            'show_desc',
            [
                'type' => Controls_Manager::SWITCHER,
                'label' => esc_html__( 'Post Description', 'solutech' ),
                'default' => 'no',
                'label_off' => esc_html__( 'Hide', 'solutech' ),
                'label_on' => esc_html__( 'Show', 'solutech' ),
            ]
        );

        $this->add_control(
            'show_date',
            [
                'type' => Controls_Manager::SWITCHER,
                'label' => esc_html__( 'Post Date', 'solutech' ),
                'default' => 'no',
                'label_off' => esc_html__( 'Hide', 'solutech' ),
                'label_on' => esc_html__( 'Show', 'solutech' ),
            ]
        );

        $this->add_control(
            'show_author',
            [
                'type' => Controls_Manager::SWITCHER,
                'label' => esc_html__( 'Post Author', 'solutech' ),
                'default' => 'no',
                'label_off' => esc_html__( 'Hide', 'solutech' ),
                'label_on' => esc_html__( 'Show', 'solutech' ),
            ]
        );

        $this->add_control(
            'show_categories',
            [
                'type' => Controls_Manager::SWITCHER,
                'label' => esc_html__( 'Post Categories', 'solutech' ),
                'default' => 'no',
                'label_off' => esc_html__( 'Hide', 'solutech' ),
                'label_on' => esc_html__( 'Show', 'solutech' ),
            ]
        );

        $this->add_control(
            'show_bg',
            [
                'type' => Controls_Manager::SWITCHER,
                'label' => esc_html__( 'Info Background', 'solutech' ),
                'default' => 'no',
                'label_off' => esc_html__( 'Hide', 'solutech' ),
                'label_on' => esc_html__( 'Show', 'solutech' ),
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
        
        $default_settings = [
		    'class' => ['pix-news-container']
		];
		$slider_settings = array_merge_recursive( $default_settings, $slider_settings );
		
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

            <div class="swiper-container news">
                <div class="swiper-wrapper">
                    <?php if ( $posts_query->have_posts() ) : ?>
                        <?php while ( $posts_query->have_posts() ) : $posts_query->the_post(); ?>
                            <?php $this->print_slide( $settings ); ?>
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
        $title_class = !in_array('yes', [$settings['show_date'], $settings['show_author'], $settings['show_categories'], $settings['show_desc']]) ? 'mb-0' : '';
        $bg_class = empty( $settings['show_bg'] ) || 'no' === $settings['show_bg'] ? 'pix-no-bg' : '';
        ?>
        <div class="swiper-slide">
            <div class="news__item">
                <div class="news__itemInner">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="news__itemImg">
                            <?php solutech_get_elementor_attachment_image_html( $settings, get_post_thumbnail_id(), 'solutech-post-thumb-small' ); ?>
                            <span class="news__itemIcon"><i class="pix-icon-eye-2"></i></span>
                            <a href="<?php the_permalink(); ?>"></a>
                            <?php if ( in_array('yes', [$settings['show_date'], $settings['show_author'], $settings['show_categories']]) ) : ?>
                            <div class="news__itemInfo">
                                <span>
                                    <?php if ( ! empty( $settings['show_date'] ) && 'yes' === $settings['show_date'] ) : ?>
                                    <?php echo get_the_date(); ?>
                                    <?php endif; ?>
                                </span>
                                <div>
                                    <?php if ( ! empty( $settings['show_author'] ) && 'yes' === $settings['show_author'] ) : ?>
                                    <?php the_author_posts_link(); ?>
                                    <?php endif; ?>
                                    <?php if ( ! empty( $settings['show_categories'] ) && 'yes' === $settings['show_categories'] ) : ?>
                                        <?php echo solutech_get_post_terms( array( 'taxonomy' => 'category', 'sep' => '<span class="comma">, </span>' ) ); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="news__itemBody <?php echo esc_attr( $bg_class ) ?>">
                        <h5 class="news__itemTitle <?php echo esc_attr( $title_class ) ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                        <?php if ( ! empty( $settings['show_desc'] ) && 'yes' === $settings['show_desc'] ) : ?>
                        <div class="news__itemText">
                            <?php the_excerpt(); ?>
                        </div>
                        <?php endif; ?>
                        
                        <?php /*if ( in_array('yes', [$settings['show_date'], $settings['show_author'], $settings['show_categories']]) ) : ?>
                        <div class="news__itemInfo">
                            <span>
                                <?php if ( ! empty( $settings['show_date'] ) && 'yes' === $settings['show_date'] ) : ?>
                                <?php echo get_the_date(); ?>
                                <?php endif; ?>
                            </span>
                            <div>
                                <?php if ( ! empty( $settings['show_author'] ) && 'yes' === $settings['show_author'] ) : ?>
                                <?php the_author_posts_link(); ?>
                                <?php endif; ?>
                                <?php if ( ! empty( $settings['show_categories'] ) && 'yes' === $settings['show_categories'] ) : ?>
                                    <?php echo solutech_get_post_terms( array( 'taxonomy' => 'category', 'sep' => '<span class="comma">, </span>' ) ); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; */ ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

}
