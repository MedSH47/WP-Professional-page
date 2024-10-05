<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Team_Double_Block_Carousel extends Base_Carousel {

    public function get_name() {
        return 'pixtheme-team-double-block-carousel';
    }

    public function get_title() {
        return esc_html__( 'Team Big Double Slider', 'solutech' );
    }

    public function get_icon() {
        return 'eicon-slides';
    }

    public function get_keywords() {
        return [ 'team', 'carousel' ];
    }

    public function get_script_depends() {
        return [ 'pixtheme-widgets-carousel' ];
    }

    protected function register_controls() {
        $this->add_section_content();
        $this->add_section_slides();
        parent::register_controls();
        $this->update_controls();
    }

    private function add_section_content() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Content', 'solutech' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'image_big',
            [
                'label' => esc_html__( 'Choose Image', 'solutech' ),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'video_url',
            [
                'label' => esc_html__( 'Video Url', 'solutech' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://youtu.be/QQMFPjNM3pU', 'solutech' ),
            ]
        );

        $this->end_controls_section();
    }

    private function add_section_slides() {
        $this->start_controls_section(
            'section_slides',
            [
                'label' => esc_html__( 'Slides', 'solutech' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'solutech' ),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'image_member',
            [
                'label' => esc_html__( 'Image', 'solutech' ),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control(
            'name',
            [
                'label' => esc_html__( 'Name', 'solutech' ),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'position',
            [
                'label' => esc_html__( 'Position', 'solutech' ),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'image_sign',
            [
                'label' => esc_html__( 'Image Sign', 'solutech' ),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => esc_html__( 'Description', 'solutech' ),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $repeater->add_control(
            'btn_text',
            [
                'label' => esc_html__( 'Button text', 'solutech' ),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'btn_link',
            [
                'label' => esc_html__( 'Button Link', 'solutech' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'solutech' ),
            ]
        );

        $repeater->add_control(
            'socials_heading',
            [
                'label' => esc_html__( 'Socials', 'solutech' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $repeater->add_control(
            'social_icon_1',
            [
                'label' => esc_html__( 'Icon', 'solutech' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fab fa-twitter',
                    'library' => 'fa-brands',
                ],
                'recommended' => Widget_Options::get_list_recommended_social_icons(),
            ]
        );

        $repeater->add_control(
            'social_link_1',
            [
                'label' => esc_html__( 'Link', 'solutech' ),
                'type' => Controls_Manager::URL,
                'show_external' => true,
                'default' => [
                    'url'         => '',
                    'is_external' => true,
                    'nofollow'    => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'solutech' ),
            ]
        );

        $repeater->add_control(
            'social_icon_2',
            [
                'label' => esc_html__( 'Icon', 'solutech' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fab fa-linkedin',
                    'library' => 'fa-brands',
                ],
                'recommended' => Widget_Options::get_list_recommended_social_icons(),
            ]
        );

        $repeater->add_control(
            'social_link_2',
            [
                'label' => esc_html__( 'Link', 'solutech' ),
                'type' => Controls_Manager::URL,
                'show_external' => true,
                'default' => [
                    'url'         => '',
                    'is_external' => true,
                    'nofollow'    => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'solutech' ),
            ]
        );

        $repeater->add_control(
            'social_icon_3',
            [
                'label' => esc_html__( 'Icon', 'solutech' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fab fa-facebook',
                    'library' => 'fa-brands',
                ],
                'recommended' => Widget_Options::get_list_recommended_social_icons(),
            ]
        );

        $repeater->add_control(
            'social_link_3',
            [
                'label' => esc_html__( 'Link', 'solutech' ),
                'type' => Controls_Manager::URL,
                'show_external' => true,
                'default' => [
                    'url'         => '',
                    'is_external' => true,
                    'nofollow'    => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'solutech' ),
            ]
        );

        $repeater->add_control(
            'social_icon_4',
            [
                'label' => esc_html__( 'Icon', 'solutech' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fab fa-instagram',
                    'library' => 'fa-brands',
                ],
                'recommended' => Widget_Options::get_list_recommended_social_icons(),
            ]
        );

        $repeater->add_control(
            'social_link_4',
            [
                'label' => esc_html__( 'Link', 'solutech' ),
                'type' => Controls_Manager::URL,
                'show_external' => true,
                'default' => [
                    'url'         => '',
                    'is_external' => true,
                    'nofollow'    => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'solutech' ),
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
                'type' => Controls_Manager::HIDDEN,
                'default' => '1',
                'tablet_default' => '1',
                'mobile_default' => '1',
            ]
        );

        $this->update_responsive_control(
            'space',
            [
                'type' => Controls_Manager::HIDDEN,
                'default' => 0,
            ]
        );

        $this->update_responsive_control(
            'slides_per_group',
            [
                'type' => Controls_Manager::HIDDEN,
                'default' => '1',
                'tablet_default' => '1',
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
            'show_dots',
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

        $default_settings = [
            'class' => [
                'section',
                'bg-0',
                'bigSlider'
            ],
        ];

        $slider_settings = array_merge_recursive( $default_settings, $slider_settings );

        $this->add_render_attribute( 'slider', $slider_settings );

        ?>

        <section <?php $this->print_render_attribute_string( 'slider' ); ?>>
            <div class="container mb-60 mb-xl-0">
                <div class="row">
                    <div class="col-xl-6 py-140">
                        <div class="swiper-container bigSliderContainer mr-sm-40 mr-xz-140"> <!--mx-sm-40 mx-md-70 mx-xz-140-->
                            <div class="swiper-wrapper">
                                <?php foreach ( $settings['slides'] as $index => $slide ) :
                                    $this->slide_prints_count++;
                                    ?>
                                    <div class="swiper-slide">
                                        <div class="bigSliderItem">
                                            <?php $this->print_slide( $slide, $settings, 'slide-' . $index . '-' . $this->slide_prints_count ); ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bigSlider__video">
                <?php if ( ! empty( $settings['image_big']['url'] ) ) : ?>
                    <?php echo wp_get_attachment_image( $settings['image_big']['id'], 'full' ); ?>
                <?php endif; ?>
                <?php if ( ! empty( $video_url = $settings['video_url']['url'] ) ) : ?>
                    <a href="<?php echo esc_url( $video_url ); ?>" data-fancybox><i class="pix-icon-play"></i></a>
                <?php endif; ?>
            </div>
            <div class="slideControl"></div>
        </section>

        <?php
    }

    protected function print_slide( array $slide, array $settings, $element_key ) { ?>

        <div class="bigSliderItem">
            <?php if ( $title = $slide['title'] ) : ?>
                <div class="section__title">
                    <h2><?php echo esc_html( $title ); ?></h2>
                </div>
            <?php endif; ?>
            <div class="member">
                <div class="member__head">
                    <?php if ( ! empty( $slide['image_member']['url'] ) ) : ?>
                        <div class="member__photo">
                            <?php echo wp_get_attachment_image( $slide['image_member']['id'], 'solutech-thumb-small' ); ?>
                        </div>
                    <?php endif; ?>
                    <div class="member__info">
                        <?php if ( $name = $slide['name'] ) : ?>
                            <div class="member__name"><?php echo esc_html( $name ); ?></div>
                        <?php endif; ?>
                        <?php if ( $position = $slide['position'] ) : ?>
                            <div class="member__post"><?php echo esc_html( $position ); ?></div>
                        <?php endif; ?>
                        <?php if ( ! empty( $slide['image_sign']['url'] ) ) : ?>
                            <div class="member__sign">
                                <?php echo wp_get_attachment_image( $slide['image_sign']['id'], 'solutech-thumb-limit-height-small' ); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ( $description = $slide['description'] ) : ?>
                    <div class="member__body">
                        <p><?php echo esc_html( $description ); ?></p>
                    </div>
                <?php endif; ?>
                <div class="member__footer">
                    <?php if ( ! empty( $btn_link = $slide['btn_link']['url'] ) && ! empty( $btn_text = $slide['btn_text'] ) ) : ?>
                        <?php
                        $target = $slide['btn_link']['is_external'] ? ' target="_blank"' : '';
                        $nofollow = $slide['btn_link']['nofollow'] ? ' rel="nofollow"' : '';
                        ?>
                        <a class="btn" href="<?php echo esc_url( $btn_link ); ?>"<?php echo wp_kses( $target . $nofollow, 'strip' ); ?>>
                            <span class="pix-button-ripple-title">
                                <span data-text="<?php echo esc_html( $btn_text ); ?>"><?php echo esc_html( $btn_text ); ?><i class="pix-icon-caret-right"></i></span>
                            </span>
                            
                        </a>
                    <?php endif; ?>
                    <?php if ( ! empty( $slide["social_link_1"]['url'] ) || ! empty( $slide["social_link_2"]['url'] ) || ! empty( $slide["social_link_3"]['url'] ) || ! empty( $slide["social_link_4"]['url'] ) ) : ?>
                        <div class="member__social">
                            <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
                                <?php if ( ! empty( $social_link = $slide["social_link_$i"]['url'] ) && ! empty( $slide["social_icon_$i"]['value'] ) ) : ?>
                                    <?php
                                    $target = $slide["social_link_$i"]['is_external'] ? ' target="_blank"' : '';
                                    $nofollow = $slide["social_link_$i"]['nofollow'] ? ' rel="nofollow"' : '';
                                    ?>
                                    <a href="<?php echo esc_url( $social_link ); ?>"<?php echo wp_kses( $target . $nofollow, 'strip' ); ?>><?php Icons_Manager::render_icon( $slide["social_icon_$i"], [ 'aria-hidden' => 'true' ] ); ?></a>
                                <?php endif; ?>
                            <?php endfor;  ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php
    }

}
