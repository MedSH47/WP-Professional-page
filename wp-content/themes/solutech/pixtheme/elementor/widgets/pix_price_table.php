<?php

namespace PixTheme_Elementor;

use Elementor\Widget_Base;

class PixTheme_EL_Pix_Price_Table extends Widget_Base {
	
	public function get_name() {
		return 'pix-price-table';
	}
	
	public function get_title() {
		return 'Price Table';
	}
	
	public function get_icon() {
		return 'fas fa-money-bill-wave';
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
                'default' => 'pix-price-table',
				'options' => [
                    'pix-price-table'   => 'price_table_compare.png',
					'pix-price-box'     => 'price_table_default.png',
                    'pix-price-long'    => 'price_table_long.png',
				]
			]
		);
		$this->add_control(
			'type_table',
			[
                'label' => esc_html__( 'Boxes Type', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'single',
                'options' => [
                    'single'  =>  esc_html__( 'Single', 'solutech' ),
					'double'  =>  esc_html__( 'Double', 'solutech' ),
                ],
                'condition' => [
                    'style' => ['pix-price-box', 'pix-price-long'],
                ]
            ]
		);
		$this->add_control(
			'first_text',
			[
				'label' => esc_html__( 'First Selector', 'solutech' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'First tab button text', 'solutech' ),
                'condition' => [
                    'type_table' => 'double',
                ]
			]
		);
		$this->add_control(
			'second_text',
			[
				'label' => esc_html__( 'Second Selector', 'solutech' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Second tab button text', 'solutech' ),
                'condition' => [
                    'type_table' => 'double',
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
                'condition' => [
                    'style' => ['pix-price-box', 'pix-price-long'],
                ]
            ]
		);
		$this->add_control(
			'currency',
			[
				'label' => esc_html__( 'Currency', 'solutech' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Change currency', 'solutech' ),
                'default' => '$',
			]
		);
		$this->add_control(
			'btntext',
			[
				'label' => esc_html__( 'Button Text', 'solutech' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$this->add_control(
			'btn_position',
			[
                'label' => esc_html__( 'Button Position', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pix-footer',
                'options' => [
                    'pix-header'    =>  esc_html__( 'Header', 'solutech' ),
					'pix-footer'    =>  esc_html__( 'Footer', 'solutech' ),
                ],
                'condition' => [
                    'style' => 'pix-price-table',
                ]
            ]
		);
		$this->add_control(
			'box_gap',
			[
                'label' => esc_html__( 'Boxes Gap', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => '0',
                'options' => [
                    0 => '0',
                    1 => '1',
					2 => '2',
					5 => '5',
                    10 => '10',
					15 => '15',
					20 => '20',
					30 => '30',
					50 => '50',
                ],
                'condition' => [
                    'style' => ['pix-price-box', 'pix-price-long'],
                ]
            ]
		);
		$this->add_control(
			'features_subtitle',
			[
				'label' => esc_html__( 'Features Title', 'solutech' ),
				'type' => Controls_Manager::TEXT,
                'condition' => [
                    'style' => 'pix-price-table',
                ]
			]
		);
		$this->add_control(
			'features_subtitle',
			[
				'label' => esc_html__( 'Features Subtitle', 'solutech' ),
				'type' => Controls_Manager::TEXT,
                'condition' => [
                    'style' => 'pix-price-table',
                ]
			]
		);
		$this->add_control(
			'compare_features',
			[
				'label' => esc_html__( 'Features for Comparison', 'solutech' ),
				'type' => Controls_Manager::TEXTAREA,
                'description' => esc_html__( 'This Features is compared with every box options and set enable/disable', 'solutech' ),
			]
		);
		
		$repeater = new Repeater();
		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'solutech' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Column title', 'solutech' ),
			]
		);
		$repeater->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'solutech' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Column title', 'solutech' ),
			]
		);
		$repeater->add_control(
			'btntext_box',
			[
				'label' => esc_html__( 'Button Text', 'solutech' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Change Global button text', 'solutech' ),
			]
		);
		$repeater->add_control(
			'first_price',
			[
				'label' => esc_html__( 'First Price', 'solutech' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$repeater->add_control(
			'second_price',
			[
				'label' => esc_html__( 'Second Price', 'solutech' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		$repeater->add_control(
			'price_text',
			[
				'label' => esc_html__( 'Price Subtext', 'solutech' ),
				'type' => Controls_Manager::TEXT,
                'description' => esc_html__( 'Text after price', 'solutech' ),
			]
		);
		$repeater->add_control(
			'is_popular',
			[
				'label' => esc_html__( 'Popular', 'solutech' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'off',
                'default' => 'off',
			]
		);
		$repeater->add_control(
			'icon_type',
			[
                'label' => esc_html__( 'Icon Type', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'font',
                'options' => [
                    'image' =>  esc_html__( 'Image', 'solutech' ),
                    'font'  =>  esc_html__( 'Font Icon/SVG', 'solutech' ),
                ],
            ]
		);
		$repeater->add_control(
			'image',
			[
                'label' => esc_html__( 'Image', 'solutech' ),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'icon_type' => 'image'
                ]
            ]
		);
		$repeater->add_control(
			'font',
			[
                'label' => esc_html__( 'Icon', 'solutech' ),
                'type' => Controls_Manager::ICONS,
                'condition' => [
                    'icon_type' => 'font'
                ]
            ]
		);
		$repeater->add_control(
			'price_features', [
				'label' => esc_html__( 'Features', 'solutech' ),
				'type' => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'The list of Features' , 'solutech' ),
			]
		);
		$repeater->add_control(
			'price_content', [
				'label' => esc_html__( 'Additional Information', 'solutech' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Enter information' , 'solutech' ),
			]
		);
		$repeater->add_control(
			'id_product',
			[
				'label' => esc_html__( 'Product ID', 'solutech' ),
				'type' => Controls_Manager::TEXT,
                'description' => esc_html__( 'Redirect to checkout', 'solutech' ),
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
			'prices',
			[
				'label' => esc_html__( 'Price Boxes', 'solutech' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
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
		$border_class = $pix_el['border'] == 'on' ? 'pix-has-border' : '';
		$filled_class = $pix_el['filled'] == 'on' ? 'pix-hover-filled' : '';
		$overlay = $pix_el['filled'] == 'on' ? '<div class="pix-overlay '.esc_attr($fill_color).'"></div>' : '';
		$no_padding_class = $pix_el['no_padding'] == 'on' ? 'pix-no-padding' : '';
		
		$style = $compare_features = $features_title = $features_subtitle = $btn_position = $btntext = $radius = $is_animate = $css_animation = $animate = $animate_data = $box_gap = '';
		
		$compare_features = isset($compare_features) ? explode("\n", strip_tags($compare_features)) : array();
		$prices = $pix_el['prices'];
		$prices_out = array();
		$count = 1;
		$cnt = count($prices);
		$i = $offset = 0;
		if( $style != 'pix-price-table' || count($compare_features) == 0 ) {
		    foreach ($prices as $key => $item) {
		        
		        if ($css_animation != '' && $is_animate == 'on') {
		            $animate = 'animated';
		            $animate .= !empty($wow_duration) || !empty($wow_delay) || !empty($wow_offset) || !empty($wow_iteration) ? ' wow ' . esc_attr($css_animation) : '';
		            $animate_data = ' data-animation="' . esc_attr($css_animation) . '"';
		            $wow_group = !empty($wow_group) ? $wow_group : 1;
		            $wow_group_delay = !empty($wow_group_delay) ? $wow_group_delay : 0;
		            $wow_delay = !empty($wow_delay) ? $wow_delay : 0;
		            $animate_data .= !empty($wow_duration) ? ' data-wow-duration="' . esc_attr($wow_duration) . 's"' : '';
		            $animate_data .= !empty($wow_delay) || $wow_group_delay > 0 ? ' data-wow-delay="' . esc_attr($wow_delay + $offset * $wow_group_delay) . 's"' : '';
		            $animate_data .= !empty($wow_offset) ? ' data-wow-offset="' . esc_attr($wow_offset) . '"' : '';
		            $animate_data .= !empty($wow_iteration) ? ' data-wow-iteration="' . esc_attr($wow_iteration) . '"' : '';
		            
		            $offset = $i % $wow_group == 0 ? ++$offset : $offset;
		        }
		        
		        $image = '';
		        
		        $class = isset($item['is_popular']) && $item['is_popular'] == 'on' ? 'pix-price-box-big' : '';
		        $class_button = isset($item['is_popular']) && $item['is_popular'] == 'on' ? 'pix-dark' : '';
		        
		        $href = isset($item['link']) ? vc_build_link($item['link']) : '';
		        $url = empty($href['url']) ? '#' : $href['url'];
		        $target = empty($href['target']) ? '' : 'target="' . esc_attr($href['target']) . '"';
		        $id_product = isset($item['id_product']) && is_numeric($item['id_product']) != '' ? (int)$item['id_product'] : '';
		        
		        $show_icon = '';
		        if($style == 'pix-price-long') {
		            $icon_type = $item['type'];
		            $icon = isset( $item['icon_'.$icon_type] ) ? $item['icon_'.$icon_type] : '';
		            if ($item['icon_type'] == 'image' && isset($item['image']) && $item['image'] != '') {
		                $img_id = preg_replace('/[^\d]/', '', $item['image']);
		                $img_path = wp_get_attachment_image_src($img_id, 'thumbnail');
		                $show_icon = '<div class="pix-icon"><img src="' . esc_url($img_path[0]) . '" alt="' . esc_attr($item['title']) . '"></div>';
		            } else {
		                $show_icon = '<div class="pix-icon"><span class="' . esc_attr($icon) . '" ></span></div>';
		            }
		        }
		        
		        $title = isset($item['title']) && $item['title'] != '' ? '<p>' . ($item['title']) . '</p>' : '';
		        $subtitle = isset($item['subtitle']) && $item['subtitle'] != '' ? '<span>' . ($item['subtitle']) . '</span>' : '';
		        $price = isset($item['first_price']) && $item['first_price'] != '' ? ($item['first_price']) : '';
		        $price_text = isset($item['price_text']) && $item['price_text'] != '' ? '<span class="pix-span-period"> / ' . ($item['price_text']) . '</span>' : '';
		        $currency_sign = isset($item['first_price']) && is_numeric($item['first_price']) ? '<span class="pix-span-small">' . ($currency) . '</span>' : '';
		        $btntext_box = isset($item['btntext_box']) && $item['btntext_box'] != '' ? $item['btntext_box'] : $btntext;
		        if($id_product > 0){
		            $button = $btntext_box != '' && $url != '' ? '<a class="pix-button pix-h-l ' . esc_attr($class_button) . '" ' . ($target) . ' href="' . esc_url(get_permalink( wc_get_page_id( 'checkout' ) ).'?add-to-cart='.$id_product) . '">' . ($btntext_box) . '</a>' : '';
		        } else {
		            $button = $btntext_box != '' && $url != '' ? '<a class="pix-button pix-h-l ' . esc_attr($class_button) . '" ' . ($target) . ' href="' . esc_url($url) . '">' . ($btntext_box) . '</a>' : '';
		        }
		        $price_features = isset($item['price_features']) ? explode("\n", strip_tags($item['price_features'])) : array();
		        $price_features = array_map('trim', $price_features);
		        $price_features_html = '';
		        
		        if (count($compare_features) > 0 && $compare_features[0] != '' && count($price_features) > 0) {
		            foreach ($compare_features as $val_comp) {
		                if (!empty($val_comp)) {
		                    $enable_class = in_array(trim($val_comp), $price_features) ? 'pix-enable' : 'pix-disable';
		                    $price_features_html .= '<li class="' . esc_attr($enable_class) . '">' . ($val_comp) . '</li>';
		                }
		            }
		            $price_features_html = '<ul class="pix-table-price-content-list pix-compare">' . ($price_features_html) . '</ul>';
		        } elseif (count($price_features) > 1) {
		            foreach ($price_features as $val) {
		                if (!empty($val)) $price_features_html .= '<li>' . ($val) . '</li>';
		            }
		            $price_features_html = '<ul class="pix-table-price-content-list">' . ($price_features_html) . '</ul>';
		        } elseif(isset($price_features[0])) {
		            $price_features_html = '<p>' . ($price_features[0]) . '</p>';
		        }
		        $price_content_html = isset($item['price_content']) ? '<p class="pix-price-table-features-info">' . $item['price_content'] . '</p>' : '';
		        
		        if ($style != 'pix-price-long') {
		            
		            $prices_out[] = '
		            <div class="pix-price-box ' . esc_attr($class) . ' ' . esc_attr($animate) . '" ' . ($animate_data) . ' >
		                <div class="pix-price-box-inner">
		                    <div class="pix-price-box-top">
		                        ' . ($title) . '
		                        ' . ($subtitle) . '
		                    </div>
		                    <div class="pix-price-box-month">
		                        ' . ($currency_sign) . ' <span class="pix-span-big">' . ($price) . '</span>' . ($price_text) . '
		                    </div>
		                    <div class="pix-price-box-text">
		                        ' . ($price_features_html) . '
		                        ' . ($price_content_html) . '
		                    </div>
		                    <div class="pix-price-box-footer">
		                        ' . ($button) . '
		                    </div>
		                </div>
		            </div>';
		            
		        } else {
		            
		            $prices_out[] = '
		            <div class="pix-price-box ' . esc_attr($class) . ' ' . esc_attr($animate) . '" ' . ($animate_data) . ' >
		                <div class="pix-price-box-inner">
		                    <div class="pix-price-box-left">
		                        ' . ($title) . '
		                        ' . ($subtitle) . '
		                        ' . ($price_features_html) . '
		                        ' . ($price_content_html) . '
		                    </div>
		                    <div class="pix-price-box-right">
		                        <div class="pix-price-header">
		                            <div class="pix-price">' . ($currency_sign) . ' <span class="pix-span-big">' . ($price) . '</span>' . ($price_text) . '</div>
		                            '.($show_icon).'
		                        </div>
		                        ' . ($button) . '
		                    </div>
		                </div>
		            </div>';
		            
		        }
		        
		        $count++;
		    }
		    
		    $style = $style == 'pix-price-box' ? 'pix-price-box-container' : $style;
		    $out = '
		    <div class="' . esc_attr($style) . ' row no-gutters pix-gap-' . esc_attr($box_gap) . ' ' . esc_attr($radius) . '">
		        ' . implode("\n", $prices_out) . '
		    </div>';
		    
		} else {
		    
		    $table_arr = $table_mobile_arr = array();
		    $i = 0;
		    $table_head = $table_body = $table_foot = $mobile_select = '';
		    
		    foreach ($prices as $key => $item) {
		        
		        $class = isset($item['is_popular']) && $item['is_popular'] == 'on' ? 'pix-price-box-big' : '';
		        $class_title = isset($item['is_popular']) && $item['is_popular'] == 'on' ? 'pix-popular' : '';
		        $class_button = isset($item['is_popular']) && $item['is_popular'] == 'on' ? '' : 'pix-dark';
		        $mobile_selected = isset($item['is_popular']) && $item['is_popular'] == 'on' ? 'selected="selected"' : '';
		        $mobile_cell_class = isset($item['is_popular']) && $item['is_popular'] == 'on' ? '' : 'pix-hide-mobile';
		    
		        $href = isset($item['link']) ? vc_build_link($item['link']) : '';
		        $url = empty($href['url']) ? '#' : $href['url'];
		        $target = empty($href['target']) ? '' : 'target="' . esc_attr($href['target']) . '"';
		        $id_product = isset($item['id_product']) && is_numeric($item['id_product']) != '' ? (int)$item['id_product'] : '';
		    
		        $title = isset($item['title']) && $item['title'] != '' ? '<div class="pix-price-table-col-title ' . esc_attr($class_title) . '">' . ($item['title']) . '</div>' : '';
		        $title_mobile = isset($item['title']) && $item['title'] != '' ? $item['title'] : '';
		        $price = isset($item['first_price']) && $item['first_price'] != '' ? ($item['first_price']) : '';
		        $price_text = isset($item['price_text']) && $item['price_text'] != '' ? '<span class="pix-span-period"> / ' . ($item['price_text']) . '</span>' : '';
		        $price_text_mobile = isset($item['price_text']) && $item['price_text'] != '' ? ' / ' . ($item['price_text']) : '';
		        $currency_sign = isset($item['first_price']) && is_numeric($item['first_price']) ? '<span class="pix-span-small">' . ($currency) . '</span>' : '';
		        $currency_sign_mobile = isset($item['first_price']) && is_numeric($item['first_price']) ? $currency : '';
		        $btntext_box = isset($item['btntext_box']) && $item['btntext_box'] != '' ? $item['btntext_box'] : $btntext;
		        
		        if($id_product > 0){
		            $button = $btntext_box != '' && $url != '' ? '<a class="pix-button ' . esc_attr($class_button) . '" ' . ($target) . ' href="' . esc_url(get_permalink( wc_get_page_id( 'checkout' ) ).'?add-to-cart='.$id_product) . '">' . ($btntext_box) . '</a>' : '';
		        } else {
		            $button = $btntext_box != '' && $url != '' ? '<a class="pix-button ' . esc_attr($class_button) . '" ' . ($target) . ' href="' . esc_url($url) . '">' . ($btntext_box) . '</a>' : '';
		        }
		        $price_features = isset($item['price_features']) ? explode("\n", strip_tags($item['price_features'])) : array();
		        $price_features = array_map('trim', $price_features);
		        
		        if( $btn_position == 'pix-header' ) {
		            $button = $btntext_box != '' && $url != '' ? '<a class="pix-button pix-v-s pix-h-s ' . esc_attr($class_button) . '" ' . ($target) . ' href="' . esc_url($url) . '">' . ($btntext_box) . '</a>' : '';
		            $table_arr[$features_title][$i] =
		                '<div class="pix-price-table-header with-button ' . esc_attr($class_title) . '">
		                    ' . ($currency_sign) . ' <span class="pix-span-big">' . ($price) . '</span>' . ($price_text) . '
		                </div>'
		                .$title
		                .$button;
		        } else {
		            $table_arr[$features_title][$i] =
		                '<div class="pix-price-table-header ' . esc_attr($class_title) . '">
		                    ' . ($currency_sign) . ' <span class="pix-span-big">' . ($price) . '</span>' . ($price_text) . '
		                </div>'
		                .$title;
		        }
		        
		        $mobile_select .= '<option value="'.esc_attr($i+1).'" '.($mobile_selected).'>'.($title_mobile.' - '.$currency_sign_mobile.$price.$price_text_mobile).'</option>';
		        $table_mobile_arr[$i] = $mobile_cell_class;
		    
		        if (count($price_features) > 0) {
		            foreach ($compare_features as $val_comp) {
		                if (!empty($val_comp)) {
		                    $enable_class = in_array(trim($val_comp), $price_features) ? 'pix-enable' : 'pix-disable';
		                    $table_arr[$val_comp][$i] = '<span class="' . esc_attr($enable_class) . '"></span>';
		                }
		            }
		        }
		        
		        if( $btn_position != 'pix-header' ) {
		            $table_arr['buttons'][$i] = $button;
		        }
		    
		        $i++;
		    
		    }
		    
		    $i = 0;
		    foreach($table_arr as $key => $val){
		        if($i == 0){
		            $table_head .= '<tr>';
		            $table_head .= '
		                <th class="pix-hide-mobile-cell">
		                    <div class="pix-price-table-header">
		                        <span class="pix-span-big">'.$key.'</span>
		                    </div>
		                    <div class="pix-price-table-col-title">
		                        ' . ($features_subtitle) . '
		                    </div>
		                </th>';
		            $j = 0;
		            foreach($val as $key_td => $val_td){
		                $table_head .= '<th colspan="1" class="'.esc_attr($table_mobile_arr[$j]).'">'.$val_td.'</th>';
		                $j++;
		            }
		            $table_head .= '</tr>';
		        } elseif($key == 'buttons') {
		            $table_foot .= '<tfoot><tr>';
		            $table_foot .= '<td class="pix-hide-mobile-cell"></td>';
		            $j = 0;
		            foreach($val as $key_td => $val_td){
		                $table_foot .= '<td colspan="1" class="'.esc_attr($table_mobile_arr[$j]).'">'.$val_td.'</td>';
		                $j++;
		            }
		            $table_foot .= '</tr></tfoot>';
		        } else {
		            $table_body .= '<tr>';
		            $table_body .= '<td>'.$key.'</td>';
		            $j = 0;
		            foreach($val as $key_td => $val_td){
		                $table_body .= '<td class="'.esc_attr($table_mobile_arr[$j]).'">'.$val_td.'</td>';
		                $j++;
		            }
		            $table_body .= '</tr>';
		        }
		        
		        $i++;
		    }
		        
		        $out = '
		    <div class="pix-table-viewport ' . esc_attr($radius) . '">
		        <div class="pix-compare-table">
		            <select class="pix-mobile-table-select">' . ($mobile_select) . '</select>
		            <table class="pix-price-compare-table">
		                <thead>
		                ' . ($table_head) . '
		                </thead>
		                <tbody>
		                ' . ($table_body) . '
		                </tbody>
		                ' . ($table_foot) . '
		            </table>
		        </div>
		    </div>';
		
		}
		
		
		pixtheme_out($out);
		
	}
	
	protected function _content_template() {

    }
	
	
}