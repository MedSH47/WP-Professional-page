<?php

namespace PixTheme_Elementor;

use Elementor\Widget_Base;

class PixTheme_EL_Pix_Team extends Widget_Base {
	
	public function get_name() {
		return 'pix-team';
	}
	
	public function get_title() {
		return 'Team';
	}
	
	public function get_icon() {
		return 'fas fa-users';
	}
	
	public function get_categories() {
		return [ 'pixtheme' ];
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
                'default' => 'pix-team-long',
				'options' => [
                    'pix-team-long' => 'team_long.png',
                    'pix-team-square' => 'team_square.png',
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
		$this->add_control(
			'members',
			[
				'label' => esc_html__( 'Members', 'solutech' ),
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
		
		$style = !isset($pix_el['style']) || $pix_el['style'] == '' ? 'pix-team-long' : $pix_el['style'];
		$radius = ($pix_el['radius'] != '') ? $pix_el['radius'] : 'pix-global';
		$title_size = $pix_el['title_size'] == '' ? 'pix-title-l' : $pix_el['title_size'];
		$swiper_arr = pixtheme_get_params_array($pix_el, 'swiper');
		
		$image_size = array(350, 350);
		if( pixtheme_retina() ){
		    $image_size = array(700, 700);
		}
		
		$members = $pix_el['members'];
		$members_out = array();
		$count = 1;
		$cnt = count($members);
		$i = $offset = 0;
		foreach($members as $key => $item){
		    $image = '';
			
		    $image = '';
//            $href = $item['link']['url'] ? $item['link'] : '';
//            $target = $item['link']['is_external'] ? ' target="_blank"' : '';
//            $nofollow = $item['link']['nofollow'] ? ' rel="nofollow"' : '';
		
		    if( isset($item['image']) && $item['image']['url'] != ''){
		        $img = wp_get_attachment_image_src( $item['image']['id'], $image_size );
		        $image =  '<img src="'.esc_url($img[0]).'" alt="'.esc_attr($item['name']).'">';
		    }
		    $position = isset($item['position']) && $item['position'] != '' ? $item['position'] : '';
		    $phone = isset($item['phone']) && $item['phone'] != '' ? '<a href="tel:'.esc_attr($item['phone']).'" title="'.esc_attr($item['phone']).'"><i class="icon-phone"></i></a>' : '';
		    $email = isset($item['email']) && $item['email'] != '' ? '<a href="mailto:'.esc_attr($item['email']).'" title="'.esc_attr($item['email']).'"><i class="icon-envelope"></i></a>' : '';
		    $skype = isset($item['skype']) && $item['skype'] != '' ? '<a href="'.esc_url($item['skype']).'"><i class="icon-social-skype"></i></a>' : '';
		    $facebook = isset($item['facebook']) && $item['facebook'] != '' ? '<a href="'.esc_url($item['facebook']).'"><i class="icon-social-facebook"></i></a>' : '';
		    $twitter = isset($item['twitter']) && $item['twitter'] != '' ? '<a href="'.esc_url($item['twitter']).'"><i class="icon-social-twitter"></i></a>' : '';
		    $instagram = isset($item['instagram']) && $item['instagram'] != '' ? '<a href="'.esc_url($item['instagram']).'"><i class="icon-social-instagram"></i></a>' : '';
		    $linkedin = isset($item['linkedin']) && $item['linkedin'] != '' ? '<a href="'.esc_url($item['linkedin']).'"><i class="icon-social-linkedin"></i></a>' : '';
		    
		    $desc = isset($item['desc']) ? $item['desc'] : '';
		    
		    
		    if($style == 'pix-team-square') {
		        $class_red = $count % 2 == 0 ? 'pix-red-box' : '';
		        $members_out[] = '
		        <div class="pix-team-item swiper-slide">
		            <div class="pix-team-item-img">
		                ' . wp_kses($image, 'post') . '
		            </div>
		            <div class="pix-team-item-bottom ' . esc_attr($class_red) . '">
		                <div class="pix-team-item-info">
		                    <div class="pix-team-item-name">' . wp_kses($item['name'], 'post') . '</div>
		                    <div class="pix-team-item-job">' . wp_kses($position, 'post') . '</div>
		                </div>
		                <div class="pix-team-item-social">
		                    ' . wp_kses($phone, 'post') . '
		                    ' . wp_kses($email, 'post') . '
		                    ' . wp_kses($skype, 'post') . '
		                    ' . wp_kses($facebook, 'post') . '
		                    ' . wp_kses($twitter, 'post') . '
		                    ' . wp_kses($instagram, 'post') . '
		                    ' . wp_kses($linkedin, 'post') . '
		                </div>
		            </div>
		        </div>';
		    } else {
		        $phone = isset($item['phone']) && $item['phone'] != '' ? '<a class="btn btn-danger btn-sm btn-round" href="tel:'.esc_attr($item['phone']).'" title="'.esc_attr($item['phone']).'"><i class="fa fa-phone-alt"></i><span class="d-none d-xx-inline"> '.esc_html__('call', 'solutech').'</span></a>' : '';
		        $email = isset($item['email']) && $item['email'] != '' ? '<a class="btn btn-gray btn-sm btn-round" href="mailto:'.esc_attr($item['email']).'" title="'.esc_attr($item['email']).'"><i class="fa fa-envelope"></i></a>' : '';
		        $skype = isset($item['skype']) && $item['skype'] != '' ? '<a class="btn btn-gray btn-sm btn-round" href="'.esc_url($item['skype']).'"><i class="fab fa-skype"></i></a>' : '';
		        $facebook = isset($item['facebook']) && $item['facebook'] != '' ? '<a class="btn btn-gray btn-sm btn-round" href="'.esc_url($item['facebook']).'"><i class="fab fa-facebook-f"></i></a>' : '';
		        $twitter = isset($item['twitter']) && $item['twitter'] != '' ? '<a class="btn btn-gray btn-sm btn-round" href="'.esc_url($item['twitter']).'"><i class="fab fa-twitter"></i></a>' : '';
		        $instagram = isset($item['instagram']) && $item['instagram'] != '' ? '<a class="btn btn-gray btn-sm btn-round" href="'.esc_url($item['instagram']).'"><i class="fab fa-instagram"></i></a>' : '';
		        $linkedin = isset($item['linkedin']) && $item['linkedin'] != '' ? '<a class="btn btn-gray btn-sm btn-round" href="'.esc_url($item['linkedin']).'"><i class="fab fa-linkedin"></i></a>' : '';
		        
		        $members_out[] = '
		        <div class="pix__teamItem swiper-slide">
		              <div class="pix__teamItemInner">
		                <div class="pix__teamItemImg">
		                  <div class="pix__teamItemImgInner">' . wp_kses($image, 'post') . '</div>
		                </div>
		                <div class="pix__teamItemInfo">
		                  <div class="pix__teamItemName">
		                        <div class="'.esc_attr($title_size).'">' . wp_kses($item['name'], 'post') . '</div>
		                        <span>' . wp_kses($position, 'post') . '</span>
		                  </div>
		                  <div class="pix__teamItemText pix-text-overflow">
		                    ' . wp_kses($desc, 'post') . '
		                  </div>
		                  <div class="pix__teamItemContacts">
		                    ' . wp_kses($phone, 'post') . '
		                    ' . wp_kses($email, 'post') . '
		                    ' . wp_kses($skype, 'post') . '
		                    ' . wp_kses($facebook, 'post') . '
		                    ' . wp_kses($twitter, 'post') . '
		                    ' . wp_kses($instagram, 'post') . '
		                    ' . wp_kses($linkedin, 'post') . '
		                  </div>
		                </div>
		              </div>
		            </div>';
		    }
		
		    $count ++;
		}
		
		$swiper_options_arr = pixtheme_get_swiper($swiper_arr, '');
		$data_swiper = empty($swiper_options_arr) ? '' : 'data-swiper-options=\''.json_encode($swiper_options_arr).'\'';
		$nav_enable = isset($swiper_options_arr['navigation']) && !$swiper_options_arr['navigation'] ? 'disabled' : '';
		$page_enable = isset($swiper_options_arr['pagination']) && !$swiper_options_arr['pagination'] ? 'disabled' : '';
		$col = isset($swiper_options_arr['items']) ? $swiper_options_arr['items'] : 4;
		$swiper_class = !empty($swiper_options_arr) ? 'swiper-container' : 'pix-col-'.esc_attr($col);
		
		
		$out = '
		<div class="pix-swiper">
			<div class="pix-team-slider pix__teamList '.($swiper_class).' '.esc_attr($radius).' " '.($data_swiper).'>
				<div class="swiper-wrapper">
			        '.implode( "\n", $members_out ).'
				</div>
			</div>
			<div class="pix-nav left-right pix-team-slider-nav '.esc_attr($nav_enable).'">
		        <div class="swiper-button-prev"></div>
		        <div class="swiper-button-next"></div>
		    </div>
		    <div class="pix-swiper-pagination swiper-pagination pix-team-slider-paging '.esc_attr($page_enable).'"></div>
		</div>';
		
		
		pixtheme_out($out);
		
	}
	
	protected function _content_template() {

    }
	
	
}