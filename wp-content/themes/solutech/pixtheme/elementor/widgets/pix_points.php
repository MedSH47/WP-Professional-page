<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;
use Elementor\Repeater;

class Widget_Points extends Base {
	
	public function get_name() {
		return 'pixtheme-points';
	}
	
	public function get_title() {
		return esc_html__( 'Image Points', 'solutech' );
	}
	
	public function get_icon() {
		return 'eicon-info-circle-o';
	}
	
	public function get_keywords() {
        return [ 'popup' ];
    }
	
	protected function register_controls() {
        $this->add_section_content();
    }
    
    private function add_section_content() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'solutech' ),
                'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'image',
			[
                'label' => esc_html__( 'Image', 'solutech' ),
                'type' => Controls_Manager::MEDIA,
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
			'unit',
			[
                'label' => esc_html__( 'Point Units', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-text-review-left',
                'options' => [
                    '%'    =>  esc_html__( 'Percent', 'solutech' ),
	                'px'   =>  esc_html__( 'Pixels', 'solutech' ),
                ],
            ]
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'top_pos',
			[
				'label' => esc_html__( 'Top Position', 'solutech' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$repeater->add_control(
			'left_pos',
			[
				'label' => esc_html__( 'Left Position', 'solutech' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$repeater->add_control(
			'content', [
				'label' => esc_html__( 'Popup Text', 'solutech' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Click to enter text' , 'solutech' ),
			]
		);
		$this->add_control(
			'points',
			[
				'label' => esc_html__( 'Points', 'solutech' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ top_pos }}}',
			]
		);
		
		$this->end_controls_section();
		
	}
	
	protected function render() {

        $pix_el = $this->get_settings_for_display();
        
//        $icon_shape = $href_container_before = $href_container_after = $href_before = $href_after = $fill_color = $hover_class = $content_position = '';
//		$border = $filled = $no_padding = 'off';
//		$link_type = $pix_el['link_type'] == '' ? 'overlay' : $pix_el['link_type'];
//		$icon_size = $pix_el['icon_size'] == '' ? 'pix-icon-l' : $pix_el['icon_size'];
//		$icon_color = $pix_el['icon_color'] == '' ? 'pix-icon-color' : $pix_el['icon_color'];
//		$icon_bg_color = $pix_el['icon_bg_color'] == '' ? 'pix-icon-bg-main-color' : $pix_el['icon_bg_color'];
//		$title = $pix_el['title'];
//		$title_size = $pix_el['title_size'] == '' ? 'pix-title-l' : $pix_el['title_size'];
//		$icon_type = $pix_el['icon_type'];
//		$position = $position_with_center = $position_no_center = 'pix-text-left';
		
		$out = $image = '';

		if(isset($pix_el['image']) && $pix_el['image']['url'] != '') {
            $img_path = wp_get_attachment_image_src($pix_el['image']['id'], 'large');
            $image = '<img src="'.esc_url($img_path[0]).'" alt="'.esc_attr__('Points', 'solutech').'">';
        }
		$unit = $pix_el['unit'] == '' ? 'px' : $pix_el['unit'];
		$radius = $pix_el['radius'];
		$points = $pix_el['points'];
		$points_out = array();
		foreach($points as $key => $item){
		    $points_out[] = '
		        <div class="pix-car-repair-point" style="top: '.esc_attr($item['top_pos'].$unit).'; left: '.esc_attr($item['left_pos'].$unit).';">
		            <div class="pix-car-repair-point-text">
		                <p>'.($item['content']).'</p>
		            </div>
		        </div>';
		}

		$out = '
		<div class="pix-car-repair-box '.esc_attr($radius).'">
		    <div class="pix-car-repair-img">
		        '.($image).'
		    </div>
		    <div class="pix-car-repair-points">
		        '.implode( "\n", $points_out ).'
		    </div>
		</div>';

		pixtheme_out ($out);
		
	}
	
}