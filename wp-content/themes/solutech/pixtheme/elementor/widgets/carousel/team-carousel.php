<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Icons_Manager;

class Widget_Team_Carousel extends Base_Carousel {
	
	public function get_name() {
		return 'pixtheme-team-carousel';
	}
	
	public function get_title() {
		return esc_html__( 'Team Slider', 'solutech' );
	}
	
	public function get_icon() {
		return 'eicon-person';
	}

    public function get_keywords() {
        return [ 'team', 'carousel' ];
    }

    public function get_script_depends() {
        return [ 'pixtheme-widgets-carousel' ];
    }
	
    protected function register_controls() {
        //$this->add_section_content();
        $this->add_section_slides();
        parent::register_controls();
        $this->update_controls();
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
                'default' => 'pix-team-long',
				'options' => [
                    'pix-team-long' => 'team_long.png',
                    'pix-team-square' => 'team_square.png',
				]
			]
		);
        $this->add_control(
            'title',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__( 'Heading', 'solutech' ),
                'default' => esc_html__( 'Our Team', 'solutech' ),
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
			'radius',
			[
                'label' => esc_html__( 'Box Shape', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-global',
                'options' => [
                    'pix-global'    =>  esc_html__( 'Global', 'solutech' ),
					'pix-square'    =>  esc_html__( 'Square', 'solutech' ),
	                'pix-rounded'   =>  esc_html__( 'Rounded', 'solutech' ),
					'pix-round'     =>  esc_html__( 'Round', 'solutech' ),
                ],
            ]
		);
		$this->add_control(
			'title_size',
			[
                'label' => esc_html__( 'Title Style', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-title-l',
                'options' => [
                    'pix-title-s'    =>  esc_html__( 'Title S', 'solutech' ),
                    'pix-title-m'    =>  esc_html__( 'Title M', 'solutech' ),
                    'pix-title-l'    =>  esc_html__( 'Title L', 'solutech' ),
                    'pix-title-xl'   =>  esc_html__( 'Title XL', 'solutech' ),
                ],
            ]
		);
		
		$repeater = new Repeater();
		$repeater->add_control(
			'image',
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
			'desc',
			[
				'label' => esc_html__( 'Content', 'solutech' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Text about...' , 'solutech' ),
				'show_label' => false,
			]
		);
		$repeater->add_control(
			'phone',
			[
				'label' => esc_html__( 'Phone', 'solutech' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$repeater->add_control(
			'email',
			[
				'label' => esc_html__( 'Email', 'solutech' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$repeater->add_control(
			'skype',
			[
				'label' => esc_html__( 'Skype', 'solutech' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$repeater->add_control(
			'facebook',
			[
				'label' => esc_html__( 'Facebook', 'solutech' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$repeater->add_control(
			'twitter',
			[
				'label' => esc_html__( 'Twitter', 'solutech' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$repeater->add_control(
			'instagram',
			[
				'label' => esc_html__( 'Instagram', 'solutech' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$repeater->add_control(
			'linkedin',
			[
				'label' => esc_html__( 'Linkedin', 'solutech' ),
				'type' => Controls_Manager::TEXT,
			]
		);
//		$repeater->add_control(
//			'link',
//			[
//				'label' => esc_html__( 'Link', 'solutech' ),
//				'type' => Controls_Manager::URL,
//				'placeholder' => 'https://your-link.com',
//				'show_external' => true,
//				'default' => [
//					'url' => '',
//					'is_external' => true,
//					'nofollow' => true,
//				],
//			]
//		);
//		$this->add_control(
//			'members',
//			[
//				'label' => esc_html__( 'Members', 'solutech' ),
//				'type' => Controls_Manager::REPEATER,
//				'fields' => $repeater->get_controls(),
//				'title_field' => '{{{ name }}}',
//			]
//		);
        
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
//        $this->update_responsive_control(
//            'slides_per_view',
//            [
//                'type' => Controls_Manager::HIDDEN,
//                'default' => '4',
//                'tablet_default' => '1',
//                'mobile_default' => '1',
//            ]
//        );

//        $this->update_responsive_control(
//            'space',
//            [
//                'type' => Controls_Manager::HIDDEN,
//                'default' => 0,
//            ]
//        );

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

//        $this->update_control(
//            'show_dots',
//            [
//                'type' => Controls_Manager::HIDDEN,
//                'default' => 'no',
//            ]
//        );
    }
	
    protected function print_slider( array $settings = null ) {
        if ( null === $settings ) {
            $settings = $this->get_settings_for_display();
        }

        $slider_settings = $this->get_slider_settings( $settings );

        $default_settings = [
            'class' => [
                'section',
                'pix-team-list-container',
//                'bg-0',
            ],
        ];

        $slider_settings = array_merge_recursive( $default_settings, $slider_settings );

        $this->add_render_attribute( 'slider', $slider_settings );
        
        $class_col = 'col-xl-12';
        $class_slider = 'pt-10 px-15';
        
//        $swiper_options_arr = pixtheme_get_swiper($swiper_arr, '');
//		$data_swiper = empty($swiper_options_arr) ? '' : 'data-swiper-options=\''.json_encode($swiper_options_arr).'\'';
//		$nav_enable = isset($swiper_options_arr['navigation']) && !$swiper_options_arr['navigation'] ? 'disabled' : '';
//		$page_enable = isset($swiper_options_arr['pagination']) && !$swiper_options_arr['pagination'] ? 'disabled' : '';
//		$col = isset($swiper_options_arr['items']) ? $swiper_options_arr['items'] : 4;
//		$swiper_class = !empty($swiper_options_arr) ? 'swiper-container' : 'pix-col-'.esc_attr($col);
        
        ?>

        <section <?php $this->print_render_attribute_string( 'slider' ); ?>>
            <div class="section__title <?php echo esc_attr( $settings['indent_class'] ); ?>">
                <?php if ( ! empty( $title = $settings['title'] ) ) : ?>
                    <h2><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>
                <div class="arrows"></div>
            </div>
            <div class="container pb-40 mb-60 mb-xl-0">
                <div class="row">
                    
                    <div class="<?php echo esc_attr( $class_col ); ?>">
                        <div class="pix-team-slider pix__teamList swiper-container <?php echo esc_attr( $class_slider ); ?>">
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
<!--                <div class="pix-nav left-right pix-team-slider-nav slideControl sides"></div>-->
            </div>
        </section>

        <?php
    }
    
    protected function print_slide( array $slide, array $settings, $element_key, $count ) {
        $image = '';
        $image_size = [350, 350];
        $desc = isset($slide['desc']) ? $slide['desc'] : '';
        if( isset($slide['image']) && $slide['image']['url'] != ''){
            $img = wp_get_attachment_image_src( $slide['image']['id'], $image_size );
            $image =  '<img src="'.esc_url($img[0]).'" alt="'.esc_attr($slide['name']).'">';
        }
        $position = isset($slide['position']) && $slide['position'] != '' ? $slide['position'] : '';
        $phone = isset($slide['phone']) && $slide['phone'] != '' ? '<a href="tel:'.esc_attr($slide['phone']).'" title="'.esc_attr($slide['phone']).'"><i class="fa fa-phone-alt"></i></a>' : '';
        $email = isset($slide['email']) && $slide['email'] != '' ? '<a href="mailto:'.esc_attr($slide['email']).'" title="'.esc_attr($slide['email']).'"><i class="fa fa-envelope"></i></a>' : '';
        $skype = isset($slide['skype']) && $slide['skype'] != '' ? '<a href="'.esc_url($slide['skype']).'"><i class="fab fa-skype"></i></a>' : '';
        $facebook = isset($slide['facebook']) && $slide['facebook'] != '' ? '<a href="'.esc_url($slide['facebook']).'"><i class="fab fa-facebook-f"></i></a>' : '';
        $twitter = isset($slide['twitter']) && $slide['twitter'] != '' ? '<a href="'.esc_url($slide['twitter']).'"><i class="fab fa-twitter"></i></a>' : '';
        $instagram = isset($slide['instagram']) && $slide['instagram'] != '' ? '<a href="'.esc_url($slide['instagram']).'"><i class="fab fa-instagram"></i></a>' : '';
        $linkedin = isset($slide['linkedin']) && $slide['linkedin'] != '' ? '<a href="'.esc_url($slide['linkedin']).'"><i class="fab fa-linkedin></i></a>' : '';
        
        if( isset($settings['style']) && $settings['style'] == 'pix-team-long' ) :
	        $phone = isset($slide['phone']) && $slide['phone'] != '' ? '<a class="btn btn-danger btn-sm btn-round" href="tel:'.esc_attr($slide['phone']).'" title="'.esc_attr($slide['phone']).'"><i class="fa fa-phone-alt"></i><span class="d-none d-xx-inline"> '.esc_html__('call', 'solutech').'</span></a>' : '';
	        $email = isset($slide['email']) && $slide['email'] != '' ? '<a class="btn btn-gray btn-sm btn-round" href="mailto:'.esc_attr($slide['email']).'" title="'.esc_attr($slide['email']).'"><i class="fa fa-envelope"></i></a>' : '';
	        $skype = isset($slide['skype']) && $slide['skype'] != '' ? '<a class="btn btn-gray btn-sm btn-round" href="'.esc_url($slide['skype']).'"><i class="fab fa-skype"></i></a>' : '';
	        $facebook = isset($slide['facebook']) && $slide['facebook'] != '' ? '<a class="btn btn-gray btn-sm btn-round" href="'.esc_url($slide['facebook']).'"><i class="fab fa-facebook-f"></i></a>' : '';
	        $twitter = isset($slide['twitter']) && $slide['twitter'] != '' ? '<a class="btn btn-gray btn-sm btn-round" href="'.esc_url($slide['twitter']).'"><i class="fab fa-twitter"></i></a>' : '';
	        $instagram = isset($slide['instagram']) && $slide['instagram'] != '' ? '<a class="btn btn-gray btn-sm btn-round" href="'.esc_url($slide['instagram']).'"><i class="fab fa-instagram"></i></a>' : '';
	        $linkedin = isset($slide['linkedin']) && $slide['linkedin'] != '' ? '<a class="btn btn-gray btn-sm btn-round" href="'.esc_url($slide['linkedin']).'"><i class="fab fa-linkedin"></i></a>' : '';
	    ?>
		    <div class="pix__teamItem swiper-slide">
              <div class="pix__teamItemInner">
                <div class="pix__teamItemImg">
                  <div class="pix__teamItemImgInner"><?php echo wp_kses($image, 'post') ?></div>
                </div>
                <div class="pix__teamItemInfo">
                  <div class="pix__teamItemName">
                        <div class="'.esc_attr($title_size).'"><?php echo wp_kses($slide['name'], 'post')?></div>
                        <span><?php echo wp_kses($position, 'post')?></span>
                  </div>
                  <div class="pix__teamItemText pix-text-overflow">
                    <?php echo wp_kses($desc, 'post')?>
                  </div>
                  <div class="pix__teamItemContacts">
                    <?php echo wp_kses($phone, 'post')?>
                    <?php echo wp_kses($email, 'post')?>
                    <?php echo wp_kses($skype, 'post')?>
                    <?php echo wp_kses($facebook, 'post')?>
                    <?php echo wp_kses($twitter, 'post')?>
                    <?php echo wp_kses($instagram, 'post')?>
                    <?php echo wp_kses($linkedin, 'post')?>
                  </div>
                </div>
              </div>
            </div>
        <?php else : ?>
            <div class="pix-team-item swiper-slide">
                <div class="pix-team-item-img">
                    <?php echo wp_kses($image, 'post')?>
                </div>
                <div class="pix-team-item-bottom">
                    <div class="pix-team-item-info">
                        <div class="pix-team-item-name"><?php echo wp_kses($slide['name'], 'post')?></div>
                        <div class="pix-team-item-job"><?php echo wp_kses($position, 'post')?></div>
                    </div>
                    <div class="pix-team-item-desc">
                        <?php echo wp_kses($desc, 'post')?>
                    </div>
                    <div class="pix-team-item-social">
                        <?php echo wp_kses($phone, 'post')?>
                        <?php echo wp_kses($email, 'post')?>
                        <?php echo wp_kses($skype, 'post')?>
                        <?php echo wp_kses($facebook, 'post')?>
                        <?php echo wp_kses($twitter, 'post')?>
                        <?php echo wp_kses($instagram, 'post')?>
                        <?php echo wp_kses($linkedin, 'post')?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php
    }
	
}