<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Testimonials_Carousel extends Base_Carousel {

    public function get_name() {
        return 'pixtheme-testimonials-carousel';
    }

    public function get_title() {
        return esc_html__( 'Testimonials Slider', 'solutech' );
    }

    public function get_icon() {
        return 'eicon-slides';
    }

    public function get_keywords() {
        return [ 'testimonials', 'carousel' ];
    }

    public function get_script_depends() {
        return [ 'pixtheme-widgets-carousel' ];
    }

    protected function register_controls() {
        //$this->add_section_content();
        $this->add_section_slides();
        parent::register_controls();
        //$this->update_controls();
    }

    private function add_section_slides() {
        $this->start_controls_section(
            'section_slides',
            [
                'label' => esc_html__( 'Slides', 'solutech' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
        
        
		$this->add_control(
			'style',
			[
				'label' => esc_html__( 'Style', 'solutech' ),
				'type' => 'radio_images',
                'default' => 'pix-feedback',
				'options' => [
                    'pix-feedback' => 'reviews_feedback.png',
					'pix-testimonials' => 'reviews_testimonials.png',
				]
			]
		);
        
        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'solutech' ),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater = new Repeater();

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
            'description',
            [
                'label' => esc_html__( 'Description', 'solutech' ),
                'type' => Controls_Manager::TEXTAREA,
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
            ],
        ];

        $slider_settings = array_merge_recursive( $default_settings, $slider_settings );

        $this->add_render_attribute( 'slider', $slider_settings );
        
        $class_col = isset($settings['style']) && $settings['style'] == 'pix-testimonials' ? 'col-xl-12' : 'offset-xl-2 col-xl-8';//'col-xl-12'
        $class_slider = isset($settings['style']) && $settings['style'] == 'pix-testimonials' ? 'pt-10 px-15 pb-60' : 'mx-sm-40 mx-md-70 mx-xz-140';
        ?>

        <section <?php $this->print_render_attribute_string( 'slider' ); ?>>
            <div class="container pt-40 pb-40 mb-60 mb-xl-0">
                <div class="row">
                    <div class="<?php echo esc_attr( $class_col ); ?>">
                        <?php if ( $title = $settings['title'] ) : ?>
                            <div class="text-center mb-40">
                                <h2><?php echo esc_html( $title ); ?></h2>
                            </div>
                        <?php endif; ?>
                        <div class="swiper-container bigSliderContainer <?php echo esc_attr( $class_slider ); ?>">
                            <div class="swiper-wrapper">
                                <?php foreach ( $settings['slides'] as $index => $slide ) :
                                    $this->slide_prints_count++;
                                    ?>
                                    <div class="swiper-slide">
                                        <?php $this->print_slide( $slide, $settings, 'slide-' . $index . '-' . $this->slide_prints_count, $this->slide_prints_count ); ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php if ( ! empty( $settings['show_dots'] ) && 'yes' === $settings['show_dots']  ) : ?>
                                <div class="swiper-pagination-wrap"></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="pix-nav left-right slideControl sides"></div>
            </div>
        </section>

        <?php
    }

    protected function print_slide( array $slide, array $settings, $element_key, $count ) { ?>
        <?php if( isset($settings['style']) && $settings['style'] == 'pix-testimonials' ) : ?>
        <?php
            //$class = $count == 1 ? 'active' : '';
		?>
            <div class="bigSliderItem-testimonial pix-testimonial swiper-slide">
                <div class="member">
                <?php if ( ! empty( $slide['image_member']['url'] ) ) : ?>
                    <div class="member__photo">
                        <?php echo wp_get_attachment_image( $slide['image_member']['id'], [200,200] ); ?>
                    </div>
                <?php endif; ?>
                <div class="member__info">
                    <?php if ( $name = $slide['name'] ) : ?>
                        <div class="member__name"><?php echo esc_html( $name ); ?></div>
                    <?php endif; ?>
                    
                    <?php if ( $position = $slide['position'] ) : ?>
                        <div class="member__post"><?php echo esc_html( $position ); ?></div>
                    <?php endif; ?>
                    
                    <?php if ( $description = $slide['description'] ) : ?>
                    <div class="member__body">
                        <p><?php echo esc_html( $description ); ?></p>
                    </div>
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
        <?php elseif( isset($settings['style']) && $settings['style'] == 'pix-testimonials-pit' ) : ?>
        <?php
            //$class = $count == 1 ? 'active' : '';
		?>
            <div class="pix-testimonial swiper-slide pix-change-color">
                <div class="pix-testimonial-img">
                    <?php echo wp_get_attachment_image( $slide['image_member']['id'], [400,400] ); ?>
                </div>
                <div class="pix-testimonial-job">
                    <?php if ( $position = $slide['position'] ) : ?>
                        <span><?php echo esc_html( $position ); ?></span>
                    <?php endif; ?>
                </div>
                <div class="pix-testimonial-info">
                    <?php if ( $name = $slide['name'] ) : ?>
                        <div class="pix-testimonial-name pix-title-l"><?php echo esc_html( $name ); ?></div>
                    <?php endif; ?>
                    <?php if ( $description = $slide['description'] ) : ?>
                        <div class="pix-testimonial-text">
                            <p><?php echo esc_html( $description ); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else : ?>
        <div class="bigSliderItem-testimonial">
            <div class="member text-center">
                <?php if ( ! empty( $slide['image_member']['url'] ) ) : ?>
                    <div class="member__photo">
                        <?php echo wp_get_attachment_image( $slide['image_member']['id'], 'solutech-thumb-small' ); ?>
                    </div>
                <?php endif; ?>
                <?php if ( $description = $slide['description'] ) : ?>
                    <div class="member__body">
                        <p><?php echo esc_html( $description ); ?></p>
                    </div>
                <?php endif; ?>
                <div class="member__info">
                    <?php if ( $name = $slide['name'] ) : ?>
                        <div class="member__name"><?php echo esc_html( $name ); ?></div>
                    <?php endif; ?>
                    <?php if ( $position = $slide['position'] ) : ?>
                        <div class="member__post"><?php echo esc_html( $position ); ?></div>
                    <?php endif; ?>
                </div>
                <div class="member__footer justify-content-center">
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
        <?php endif; ?>
    <?php
    }

}
