<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Calculator extends Base {

    public function get_name() {
        return 'pixtheme-calculator';
    }

    public function get_title() {
        return esc_html__( 'Calculator', 'solutech' );
    }

    public function get_icon() {
        return 'eicon-table';
    }

    public function get_keywords() {
        return [ 'calculator', 'form' ];
    }

    protected function register_controls() {
        $this->add_section_content();

    }

    private function add_section_content() {
    	
    	$args = [ 'post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1 ];
        $forms = get_posts($args);
        $cf7_calculator = [0 => esc_html__('Without Contact Form', 'solutech')];
        if(empty($forms['errors'])){
            foreach($forms as $form){
                $cf7_calculator[$form->ID] = $form->post_title;
            }
        }
        
        $categories = get_terms( [
			'taxonomy' => 'pix-calculator',
			'hide_empty' => true,
		] );
        $calculators = [0 => esc_html__('Default', 'solutech')];
        if(!empty($categories) && !is_wp_error($categories)){
            foreach($categories as $category){
                $calculators[$category->slug] = $category->name;
            }
        }
    	
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Calculator', 'solutech' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        
		$this->add_control(
			'calc_id',
			[
                'label' => esc_html__( 'Calculator', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'description' => esc_html__( 'Select contact form to show', 'solutech' ),
                'default' => 0,
                'options' => $calculators,
            ]
		);
		$this->add_control(
			'form_id',
			[
                'label' => esc_html__( 'Contact Form', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'description' => esc_html__( 'Select contact form to show', 'solutech' ),
                'default' => 0,
                'options' => $cf7_calculator,
            ]
		);
        $this->add_control(
            'calc_title',
            [
                'label' => esc_html__( 'Title', 'solutech' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Default title', 'solutech' ),
                'placeholder' => esc_html__( 'Type your title here', 'solutech' ),
            ]
        );
        $this->add_control(
            'currency',
            [
                'label' => esc_html__( 'Currency', 'solutech' ),
                'type' => Controls_Manager::TEXT,
                'default' => '$',
            ]
        );
        $this->add_control(
			'position',
			[
                'label' => esc_html__( 'Position', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'text-default',
                'options' => [
                    'left'   =>  esc_html__( 'Left', 'solutech' ),
					'right'  =>  esc_html__( 'Right', 'solutech' ),
                ],
            ]
		);
        $this->add_control(
			'decimals',
			[
                'label' => esc_html__( 'Decimals', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    '0' =>  '0',
					'1' =>  '1',
                    '2' =>  '2',
					'3' =>  '3',
                ],
            ]
		);
        $this->add_control(
			'tone',
			[
                'label' => esc_html__( 'Tone', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'text-default',
                'options' => [
                    'text-default'   =>  esc_html__( 'Dark', 'solutech' ),
					'text-white'  =>  esc_html__( 'Light', 'solutech' ),
                ],
            ]
		);
        $this->add_control(
			'shadow',
			[
				'label' => esc_html__( 'Shadow', 'solutech' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'on',
                'default' => 'on',
			]
		);
        $this->add_control(
			'titles',
			[
				'label' => esc_html__( 'Show Field Titles', 'solutech' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'on',
                'default' => 'on',
			]
		);
        $this->add_control(
            'price_text',
            [
                'label' => esc_html__( 'Price Text', 'solutech' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => esc_html__( 'price text', 'solutech' ),
            ]
        );
        $this->add_control(
            'btntext',
            [
                'label' => esc_html__( 'Button Text', 'solutech' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'order service', 'solutech' ),
                'placeholder' => esc_html__( 'button text', 'solutech' ),
            ]
        );
		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'solutech' ),
				'type' => Controls_Manager::URL,
				'description' => esc_html__( 'Button link', 'solutech' ),
				'placeholder' => 'https://your-link.com',
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

        $this->end_controls_section();
        
    }

    protected function render() {
    	
        $pix_el = $this->get_settings_for_display();
        
        $calc_id = $pix_el['calc_id'];
		$form_id = $pix_el['form_id'];
        $calc_title = $pix_el['calc_title'];
        $currency = $pix_el['currency'];
        $position = $pix_el['position'];
		$decimals = $pix_el['decimals'];
        $tone = $pix_el['tone'];
        $shadow = $pix_el['shadow'];
		$titles = $pix_el['titles'];
		$price_text = isset($pix_el['price_text']) ? '<div class="pix-calc-text">'.$pix_el['price_text'].'</div>' : '';
		$btntext = $pix_el['btntext'];
		
		$args = $attributes = [];
  
		//parse link
		$link = ( '||' === $pix_el['link'] ) || $form_id > 0 ? '' : $pix_el['link'];
		$use_link = false;
		if ( isset($link['url']) && strlen( $link['url'] ) > 0 ) {
		    $use_link = true;
		    $a_href = $link['url'];
		    $a_target = $link['is_external'] ? 'target="_blank"' : '';
		    $a_rel = $link['nofollow'] ? 'rel="nofollow"' : '';
		}
		
		if ( $use_link ) {
		    $attributes[] = 'href="' . esc_url( trim( $a_href ) ) . '"';
		    if ( ! empty( $a_target ) ) {
		        $attributes[] = $a_target;
		    }
		    if ( ! empty( $a_rel ) ) {
		        $attributes[] = $a_rel;
		    }
		}
		
		$attributes = implode( ' ', $attributes );
		
		
		$shadow = $shadow != 'off' ? 'pix-shadow' : '';
		$calc_title = $calc_title == '' ? '' : '<h3 class="widget__title">'.$calc_title.'</h3>';
		
		$out = '
		    <section class="pix-calculator '.esc_attr($tone).' '.esc_attr($shadow).'">
		        '.wp_kses($calc_title, 'post');
		
		if($calc_id != '0' && $calc_id != ''){
		    $args = array(
		        'post_type' => 'pix-calculator-field',
		        'orderby' => 'menu_order',
		        'tax_query' => array(
		            array(
		                'taxonomy' => 'pix-calculator',
		                'field'    => 'slug',
		                'terms'    => $calc_id
		            )
		        ),
		        'posts_per_page' => -1,
		        'order' => 'ASC',
		    );
		} else {
		    $args = array(
		        'post_type' => 'pix-calculator-field',
		        'orderby' => 'menu_order',
		        'tax_query' => array(
		            array(
		                'taxonomy' => 'pix-calculator',
		                'field'    => 'slug',
		                'operator' => 'NOT EXISTS'
		            )
		        ),
		        'posts_per_page' => -1,
		        'order' => 'ASC',
		    );
		}
		
		$wp_query = new \WP_Query( $args );
		
		if ( $wp_query->have_posts() ) {
		
		    $out .= '
		        <div class="pix-calculator-fields">
		    ';
		
		    $i = $offset = 0;
		    while ( $wp_query->have_posts() ) :
		        $wp_query->the_post();
		        $i++;
		
		        $post_slug = get_post_field( 'post_name', get_the_ID() );
		        $field_type = get_post_meta( get_the_ID(), 'pix-field-type', true );
		        $field_empty = get_post_meta( get_the_ID(), 'pix-field-empty', true );
		        $operation = get_post_meta( get_the_ID(), 'pix-operation-type', true );
		        $field_values = get_post_meta( get_the_ID(), 'pix-field-values', true );
		        $dependence_values = get_post_meta( get_the_ID(), 'pix-dependence-values', true );
		        $description = get_the_excerpt(get_the_ID()) ? '<span>'.get_the_excerpt(get_the_ID()).'</span>' : '';
		        
		        $data = '';
		        if(isset($dependence_values['title'])) {
		            foreach ($dependence_values['title'] as $key => $field ) {
		                $value = isset($dependence_values['value'][$key]) ? $dependence_values['value'][$key] : '';
		                $data = 'data-dependency="'.esc_attr($field).'" data-dependency-val="'.esc_attr($value).'"';
		            }
		        }
		        
		        
		        $out_values = '';
		        if(isset($field_values['title'])) {
		            foreach ($field_values['title'] as $key => $title ) {
		                $price = isset($field_values['price'][$key]) ? $field_values['price'][$key] : '0';
		                $price_html = '';//$price < -1 ? '  ($'.esc_attr($price).')' : '';
		                switch ($field_type) {
		                    case 'select' :
		                        $out_values .= '<option value="'.esc_attr($title).'" data-price="'.esc_attr($price).'">'.esc_html($title).esc_attr($price_html).'</option>';
		                        break;
		                        
		                    case 'multiselect' :
		                        $out_values .= '<option value="'.esc_attr($title).'" data-price="'.esc_attr($price).'">'.esc_html($title).esc_attr($price_html).'</option>';
		                        break;
		
		                    case 'check' :
		                        $out_values .= '<label><input name="'.esc_attr($post_slug).'" type="checkbox" class="pix-calc-value" value="'.esc_attr($title).'" data-title="'.esc_attr(get_the_title()).'" data-operation="'.esc_attr($operation).'" data-price="'.esc_attr($price).'" '.wp_kses($data, 'post').'>'.esc_html($title).esc_attr($price_html).'</label>';
		                        break;
		
		                    case 'radio' :
		                        $out_values .= '<label><input name="'.esc_attr($post_slug).'" type="radio" class="pix-calc-value" value="'.esc_attr($title).'" data-title="'.esc_attr(get_the_title()).'" data-operation="'.esc_attr($operation).'" data-price="'.esc_attr($price).'" '.wp_kses($data, 'post').'>'.esc_html($title).esc_attr($price_html).'</label>';
		                        break;
		                }
		            }
		        }
		        if(isset($field_values['formula'])) {
		            foreach ($field_values['formula'] as $key => $formula ) {
		                $price = isset($field_values['price'][$key]) ? $field_values['price'][$key] : '0';
		                $price_html = '';//$price < -1 ? '  ($'.esc_attr($price).')' : '';
		                switch ($field_type) {
		                    case 'number' :
		                        $out_values .= '<input name="'.esc_attr($post_slug).'" type="number" step="any" placeholder="'.esc_attr($field_empty).'" class="pix-calc-value" value="" data-formula="'.($formula).'" data-title="'.esc_attr(get_the_title()).'" data-operation="'.esc_attr($operation).'" data-price="'.esc_attr($price).'" '.wp_kses($data, 'post').'>';
		                        break;
		                }
		            }
		        }
		        
		        if($field_type == 'select'){
		            $out_values = '
		                <select name="'.esc_attr($post_slug).'" data-title="'.esc_attr(get_the_title()).'" data-operation="'.esc_attr($operation).'" class="pix-calc-value" '.wp_kses($data, 'post').'>
		                    <option value="" data-price="0">'.esc_html($field_empty).'</option>
		                    '.($out_values).'
		                </select>';
		        } elseif($field_type == 'multiselect'){
		            $out_values = '
		                <select id="'.esc_attr($post_slug).'" name="'.esc_attr($post_slug).'" multiple data-placeholder="'.esc_attr(get_the_title()).'" data-title="'.esc_attr(get_the_title()).'" data-operation="'.esc_attr($operation).'" class="pix-multi-select pix-calc-value" '.wp_kses($data, 'post').'>
		                    '.($out_values).'
		                </select>';
		        }
		        $field_title = $titles != 'off' || $field_type == 'number' ? get_the_title() : '';
		
		        $out .= '
		            <div class="pix-calculator-field">
		                <div class="pix-calc-title">
		                    '.esc_html($field_title).'
		                    '.wp_kses($description, 'post').'
		                </div>
		                <div class="pix-calc-values '.esc_attr($field_type).'">
		                    ' . ($out_values) . '
		                </div>
		            </div>';
		
		    endwhile;
		    
		    $zero = $decimals > 0 ? '0.' : '0';
		    for($d = 0; $d < $decimals; $d++){
		        $zero .= '0';
		    }
		    $total = $position == 'left' ? esc_attr( $currency ).'<span>'.esc_attr($zero).'</span>' : '<span>'.esc_attr($zero).'</span>'.esc_attr( $currency );
		
		    $out .= '
		            <div class="pix-calc-total">
		            	'.$price_text.'
		                <div class="pix-calc-total-price" data-decimals="'.esc_attr($decimals).'">
		                    ' . ( $total ) . '
		                </div>
		                <div class="pix-calc-total-btn">
		                    <a ' . wp_kses( $attributes, 'post' ) . ' class="btn btn-black">' . esc_html( $btntext ) . '<i class="pix-icon-arrow"></i></a>
		                </div>
		            </div>
		
		        </div>
		    ';
		}
		
		if(isset($form_id) && $form_id > 0){
		   $out .= '<div class="pix-form-container">'.do_shortcode('[contact-form-7 id="'.esc_attr($form_id).'"]').'</div>';
		}
		
		$out .= '
		    </section>';
		
		
		wp_reset_postdata();
		
		
		pixtheme_out( $out );

    }

}
