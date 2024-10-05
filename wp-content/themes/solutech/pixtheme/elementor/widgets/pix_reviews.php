<?php

namespace PixTheme_Elementor;

use Elementor\Controls_Manager;

class PixTheme_Reviews extends Base {
	
	public function get_name() {
		return 'pix-reviews';
	}
	
	public function get_title() {
		return esc_html__( 'Reviews', 'solutech' );
	}
	
	public function get_icon() {
		return 'eicon-review';
	}
	
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'solutech' ),
                'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'style',
			[
				'label' => esc_html__( 'Style', 'solutech' ),
				'type' => 'radio_images',
                'default' => 'pix-testimonials',
				'options' => [
					'pix-testimonials' => 'reviews_testimonials.png',
                    'news-card-people' => 'reviews_people.png',
                    'news-card-feedback' => 'reviews_feedback.png',
                    'news-card-message' => 'reviews_message.png',
                    'news-card-profile' => 'reviews_profile.png',
                    'pix-testimonials-people' => 'reviews_people_2.png',
				]
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
			'color',
			[
                'label' => esc_html__( 'Fill Color', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-main-color',
                'options' => [
                    'pix-main-color'        =>  esc_html__( 'Main', 'solutech' ),
                    'pix-additional-color'  =>  esc_html__( 'Additional', 'solutech' ),
                    'pix-gradient-color'    =>  esc_html__( 'Gradient', 'solutech' ),
	                'pix-black-color'       =>  esc_html__( 'Black', 'solutech' ),
                ],
                'condition' => [
                    'style' => ['news-card-people', 'news-card-profile'],
                ]
            ]
		);
		$this->add_control(
			'hover',
			[
                'label' => esc_html__( 'Hover Effect', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-change-color',
                'options' => [
                    'pix-change-color'  =>  esc_html__( 'Change Color', 'solutech' ),
                    'pix-transform'     =>  esc_html__( 'Transform', 'solutech' ),
                ],
                'condition' => [
                    'style' => 'pix-testimonials',
                ]
            ]
		);
		$this->add_control(
			'title_size',
			[
                'label' => esc_html__( 'Name Style', 'solutech' ),
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
			'content',
			[
				'label' => esc_html__( 'Content', 'solutech' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Text about...' , 'solutech' ),
				'show_label' => false,
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
		$repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'solutech' ),
				'type' => Controls_Manager::URL,
				'placeholder' => 'https://your-link.com',
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);
		$this->add_control(
			'reviews',
			[
				'label' => esc_html__( 'Reviews', 'solutech' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
			]
		);
		
		$this->end_controls_section();
		
		
		$this->start_controls_section(
            'carousel_section',
            [
                'label' => esc_html__( 'Carousel', 'solutech' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->end_controls_section();
		
	}
	
	protected function render() {

        $pix_el = $this->get_settings_for_display();
        
        $icon_shape = $href_container_before = $href_container_after = $href_before = $href_after = $fill_color = $hover_class = $content_position = '';
		$border = $filled = $no_padding = 'off';
		$link_type = $pix_el['link_type'] == '' ? 'overlay' : $pix_el['link_type'];
		$icon_size = $pix_el['icon_size'] == '' ? 'pix-icon-l' : $pix_el['icon_size'];
		$icon_color = $pix_el['icon_color'] == '' ? 'pix-icon-color' : $pix_el['icon_color'];
		$icon_bg_color = $pix_el['icon_bg_color'] == '' ? 'pix-icon-bg-main-color' : $pix_el['icon_bg_color'];
		$title = $pix_el['title'];
		$title_size = $pix_el['title_size'] == '' ? 'pix-title-l' : $pix_el['title_size'];
		$icon_type = $pix_el['icon_type'];
		$position = $position_with_center = $position_no_center = 'pix-text-left';
		
		$href = $pix_el['link'];
		$target = $pix_el['link']['is_external'] ? ' target="_blank"' : '';
		$nofollow = $pix_el['link']['nofollow'] ? ' rel="nofollow"' : '';
		
		$style = !isset($pix_el['style']) || $pix_el['style'] == '' ? 'pix-ibox-top' : $pix_el['style'];
		$radius = ($pix_el['radius'] != '') ? $pix_el['radius'] : 'pix-global';
		
		$color = 'pix-main-color';
		$title_size = 'pix-title-l';
		$nav_class = '';
		$swiper_arr = pixtheme_get_params_array($pix_el, 'swiper');
		
		$style = !isset($style) || $style == '' ? 'pix-testimonials' : $style;
		
		$image_size = array(200, 200);
		if( pixtheme_retina() ){
		    $image_size = array(400, 400);
		}
		
		
		$reviews = $pix_el['reviews'];
		$reviews_out = array();
		$count = 1;
		$cnt = count($reviews);
		$i = $offset = 0;
		foreach($reviews as $key => $item){
		
		    $image = '';
		
		    $class = $count == 1 ? 'active' : '';
		
		    $href = isset($item['link']) ? vc_build_link( $item['link'] ) : '';
		    $blank = empty($href['target']) ? '_self' : $href['target'];
		    $href = empty($href['url']) ? '#' : $href['url'];
		
		
		    if( isset($item['image']) && $item['image'] != ''){
		        $img = wp_get_attachment_image_src( $item['image'], $image_size );
		        $img_output = isset($img[0]) ? $img[0] : '';
		        $image = $style == 'news-card-profile' ? '<img src="'.esc_url($img_output).'" alt="'.esc_attr($item['name']).'">' : '<div class="'.esc_attr($style).'__image"><img src="'.esc_url($img_output).'" alt="'.esc_attr($item['name']).'"></div>';
		    }
		    $position = isset($item['position']) && $item['position'] != '' ? $item['position'] : '';
		    $facebook = isset($item['facebook']) && $item['facebook'] != '' ? '<a href="'.esc_url($item['facebook']).'" class="pix-socials"><i class="fab fa-facebook"></i></a>' : '';
		    $twitter = isset($item['twitter']) && $item['twitter'] != '' ? '<a href="'.esc_url($item['twitter']).'" class="pix-socials"><i class="fab fa-twitter"></i></a>' : '';
		    $instagram = isset($item['instagram']) && $item['instagram'] != '' ? '<a href="'.esc_url($item['instagram']).'" class="pix-socials"><i class="fab fa-instagram"></i></a>' : '';
		
		    if ($style == 'news-card-people') {
		        $reviews_out[] = '
		            <div class="pix-equal-height pix-animation-container swiper-slide '.esc_attr($animate).'" '.($animate_data).'>
		                <div class="news-card-people">
		                    <div class="pix-overlay '.esc_attr($color).'"></div>
		                    '.($image).'
		                    <div class="pix-block-content">
		                        <div class="pix-block-title '.esc_attr($title_size).'">'.($item['name']).' <span>'.($position).'</span></div>
		                        <p>'.($item['content_d']).'</p>
		                        '.($facebook).'
		                        '.($twitter).'
		                        '.($instagram).'
		                    </div>
		                </div>
		            </div>
		        ';
		    } elseif ($style == 'pix-testimonials-people') {
		        $reviews_out[] = '
		            <div class="pix-animation-container swiper-slide '.esc_attr($animate).'" '.($animate_data).'>
		                <div class="pix-testimonials-people news-card-people">
		                    '.($image).'
		                    <div class="pix-block-content">
		                        <div class="pix-block-title '.esc_attr($title_size).'">'.($item['name']).' <span>'.($position).'</span></div>
		                        <p>'.($item['content_d']).'</p>
		                        '.($facebook).'
		                        '.($twitter).'
		                        '.($instagram).'
		                    </div>
		                </div>
		            </div>
		        ';
		    } elseif ($style == 'news-card-profile') {
		        $reviews_out[] = '
		            <div class="pix-animation-container swiper-slide '.esc_attr($animate).'" '.($animate_data).'>
		                <div class="news-card-profile">
		                    <div class="news-card-profile__header">
		                        '.($image).'
		                    </div>
		                    <div class="pix-block-content">
		                        <div class="pix-overlay '.esc_attr($color).'"></div>
		                        <div class="news-card-profile__text">
		                            <h5><a target="'.esc_attr($blank).'" href="'.esc_url($href).'">'.($item['name']).'</a>'.pixtheme_echo_if_not_empty('<span>'.($position).'</span>', $position).'</h5>
		                            <p>'.($item['content_d']).'</p>
		                            <div class="news-card-profile__header-social">
		                                '.($facebook).'
		                                '.($twitter).'
		                                '.($instagram).'
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>';
		    } elseif ($style == 'news-card-message') {
		        $reviews_out[] = '
		            <div class="pix-animation-container swiper-slide '.esc_attr($animate).'" '.($animate_data).'>
		                <div class="news-card-message">
		                    <div class="news-card-message__text">
		                        <div class="pix-block-title '.esc_attr($title_size).'">'.($item['name']).'<span>'.($position).'</span></div>
		                        <p>'.($item['content_d']).'</p>
		                        <div class="pix-border-shadow-overlay"></div>
		                    </div>
		                    '.($image).'
		                </div>
		            </div>
		        ';
		    } elseif ($style == 'news-card-feedback') {
		        $reviews_out[] = '
		            <div class="news-card-feedback__user swiper-slide '.esc_attr($class).' '.esc_attr($animate).'" '.($animate_data).'>
		                '.($image).'
		                <div class="pix-block-title '.esc_attr($title_size).'">'.($item['name']).' <span>'.($position).'</span></div>
		                <p>'.($item['content_d']).'</p>
		                '.($facebook).'
		                '.($twitter).'
		                '.($instagram).'
		            </div>
		        ';
		    } else {
		        $class_red = $count % 2 == 0 ? 'pix-red-box' : '';
		        $class_hover = isset($hover) ? $hover : 'pix-change-color';
		        $reviews_out[] = '
		            <div class="pix-testimonial swiper-slide '.esc_attr($class_hover).' '.esc_attr($class).' '.esc_attr($animate).'" '.($animate_data).'>
		                <div class="pix-testimonial-img">
		                    '.($image).'
		                </div>
		                <div class="pix-testimonial-job '.esc_attr($class_red).'">
		                    <span>'.($position).'</span>
		                </div>
		                <div class="pix-testimonial-info">
		                    <div class="pix-testimonial-name '.esc_attr($title_size).'">'.($item['name']).'</div>
		                    <div class="pix-testimonial-text">
		                        <p>'.($item['content_d']).'</p>
		                    </div>
		                </div>
		            </div>
		        ';
		    }
		
		    $count ++;
		}
		
		
		$swiper_options_arr = pixtheme_get_swiper($swiper_arr, '');
		$data_swiper = empty($swiper_options_arr) ? '' : 'data-swiper-options=\''.json_encode($swiper_options_arr).'\'';
		$nav_enable = isset($swiper_options_arr['navigation']) && !$swiper_options_arr['navigation'] ? 'disabled' : '';
		$page_enable = isset($swiper_options_arr['pagination']) && !$swiper_options_arr['pagination'] ? 'disabled' : '';
		$cols = isset($swiper_options_arr['slidesPerView']) != '' ? $swiper_options_arr['slidesPerView'] : 3;
		$swiper_class = !empty($swiper_options_arr) ? 'swiper-container' : 'pix-col-'.esc_attr($cols);
		
		
		if($style == 'news-card-feedback'){
		    $out = '
		    <div class="pix-swiper col-md-10 col-offset-1 offset-md-1 news-card-feedback-container '.esc_attr($radius).'">
		        <div class="news-card-feedback '.esc_attr($swiper_class).'" '.($data_swiper).'>
		            <div class="feedback__users swiper-wrapper '.esc_attr($nav_enable).'">
		                '.implode( "\n", $reviews_out ).'
		            </div>
		            <div class="pix-nav side-right vertical '.esc_attr($page_enable).'">
				        <div class="swiper-button-prev"></div>
				        <div class="swiper-button-next"></div>
				    </div>
		        </div>
		    </div>';
		} else {
		    $out = '
		    <div class="pix-swiper">
			    <div class="'.esc_attr($style).'__carousel '.esc_attr($swiper_class).' '.esc_attr($nav_class).' '.esc_attr($radius).' " '.($data_swiper).'>
					<div class="swiper-wrapper">
			            '.implode( "\n", $reviews_out ).'
					</div>
			    </div>
			    <div class="pix-nav left-right '.esc_attr($style).'-nav '.esc_attr($nav_enable).'">
			        <div class="swiper-button-prev"></div>
			        <div class="swiper-button-next"></div>
			    </div>
			    <div class="pix-swiper-pagination swiper-pagination '.esc_attr($style).'-paging '.esc_attr($page_enable).'"></div>
		    </div>';
		}
		
		
		pixtheme_out($out);

		
	}
	
	protected function _content_template() {

    }
	
	
}