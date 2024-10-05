<?php

namespace Pixtheme_Elementor;

class Products_Filter_Control extends \Elementor\Base_Data_Control {

	public function get_type() {
		return 'products_filter';
	}

	public function enqueue() {
        wp_enqueue_style( 'products_filter' , get_template_directory_uri() . '/pixtheme/elementor/controls/css/products_filter.css' );
        wp_enqueue_script( 'sortable', get_template_directory_uri() . '/assets/Sortable/Sortable.min.js', [], '' );
        wp_enqueue_script( 'products_filter', get_template_directory_uri() . '/pixtheme/elementor/controls/js/products_filter.js', ['jquery'], '' );
	}
 
	protected function get_default_settings() {
	    
	    $title_arr = array(
            'price' => array(
                'title' => esc_html__('Price', 'solutech'),
                'placeholder' => esc_html__('Price', 'solutech'),
            ),
            'cars' => array(
                'title' => esc_html__('Cars', 'solutech'),
                'placeholder' => esc_html__('Car Make', 'solutech'),
            ),
        );
	
	    $woo_pa = wc_get_attribute_taxonomies();
	    $woo_key = $woo_pa_visible = [];
	    
	    $attrs = get_option('cars');
		if(isset($attrs['filter-visible']) && $attrs['filter-visible'] != 'hide') {
		    $woo_key[] = 'cars';
			$woo_pa_visible[] = 'cars';
		}
	    $attrs = get_option('price');
		if(isset($attrs['filter-visible']) && $attrs['filter-visible'] != 'hide') {
		    $woo_key[] = 'price';
			$woo_pa_visible[] = 'price';
		}
	    
        foreach($woo_pa as $key => $val) {
            $attrs = get_option($val->attribute_name);
            if(isset($attrs['filter-visible']) && $attrs['filter-visible'] != 'hide'){
                $woo_key[] = $val->attribute_name;
	            $label = isset($attrs['filter-label']) && $attrs['filter-label'] != '' ? $attrs['filter-label'] : $val->attribute_label;
	            $title_arr[$val->attribute_name] = array(
		            'title' => $label,
		            'placeholder' => $label,
	            );
	            $woo_pa_visible[] = $val->attribute_name;
            }
            else {
	            unset($woo_pa[$key]);
            }
        }
        $cars = array(
            'attribute_name' => 'cars',
            'attribute_label' => esc_html__('Cars', 'solutech'),
        );
        $price = array(
            'attribute_name' => 'price',
            'attribute_label' => esc_html__('Price', 'solutech'),
        );
        
        array_unshift($woo_pa, (object)$cars);
        array_unshift($woo_pa, (object)$price);
	    
        //return implode(';', $woo_pa_visible).'<br>'.implode(';', $woo_key);
        
        $values = [];
        foreach($woo_pa as $key => $val) {
            $values[] = array(
                'id' => $val->attribute_name,
                'name' => $val->attribute_label,
                'row' => '1',
                'show' => true,
            );
        }
        $value = json_encode($values);
        
		return [
			'label_block' => true,
            'titles' => $title_arr,
			'filters' => $value,
		];
	}
	
	public function content_template() {
	 
		$control_uid = $this->get_control_uid();
		
		$title_arr = array(
            'price' => array(
                'title' => esc_html__('Price', 'solutech'),
                'placeholder' => esc_html__('Price', 'solutech'),
            ),
            'cars' => array(
                'title' => esc_html__('Cars', 'solutech'),
                'placeholder' => esc_html__('Car Make', 'solutech'),
            ),
        );
	
	    $woo_pa = wc_get_attribute_taxonomies();
	    $woo_key = $woo_pa_visible = [];
	    
	    $attrs = get_option('cars');
		if(isset($attrs['filter-visible']) && $attrs['filter-visible'] != 'hide') {
		    $woo_key[] = 'cars';
			$woo_pa_visible[] = 'cars';
		}
	    $attrs = get_option('price');
		if(isset($attrs['filter-visible']) && $attrs['filter-visible'] != 'hide') {
		    $woo_key[] = 'price';
			$woo_pa_visible[] = 'price';
		}
	    
        foreach($woo_pa as $key => $val) {
            $attrs = get_option($val->attribute_name);
            if(isset($attrs['filter-visible']) && $attrs['filter-visible'] != 'hide'){
                $woo_key[] = $val->attribute_name;
	            $label = isset($attrs['filter-label']) && $attrs['filter-label'] != '' ? $attrs['filter-label'] : $val->attribute_label;
	            $title_arr[$val->attribute_name] = array(
		            'title' => $label,
		            'placeholder' => $label,
	            );
	            $woo_pa_visible[] = $val->attribute_name;
            } else {
	            unset($woo_pa[$key]);
            }
        }
        $cars = array(
            'attribute_name' => 'cars',
            'attribute_label' => esc_html__('Cars', 'solutech'),
        );
        $price = array(
            'attribute_name' => 'price',
            'attribute_label' => esc_html__('Price', 'solutech'),
        );
        
        array_unshift($woo_pa, (object)$cars);
        array_unshift($woo_pa, (object)$price);
	    
        //return implode(';', $woo_pa_visible).'<br>'.implode(';', $woo_key);
        
        $values = array();
        $keys = '';
        if( !isset($value) || empty($value) ){
            foreach($woo_pa as $key => $val) {
                $values[] = array(
                    'id' => $val->attribute_name,
                    'name' => $val->attribute_label,
                    'row' => '1',
                    'show' => true,
                );
            }
            $value = json_encode($values);
        } else {
            $values_temp = [];
            $values = json_decode(html_entity_decode($value), true);
            foreach($values as $k => $v) {
                if(!in_array($v['id'], $values_temp)){
                    $values_temp[] = $v['id'];
                } else {
                    unset($values[$k]);
                }
            }
            foreach($woo_pa as $key => $val) {
                if( !in_array($val->attribute_name, $values_temp) ){
                    $values[] = array(
                        'id' => $val->attribute_name,
                        'name' => $val->attribute_label,
                        'row' => '1',
                        'show' => false,
                    );
                }
            }
        }
        
        ?>
        
		<div class="elementor-control-field">
			<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper pix-el-products-filter">
                <ul class="pix-widget-sortable filter">
                <#
                    var filters = {};
                    if( data.controlValue.length > 0 ){
                        filters = JSON.parse(data.controlValue);
                    } else {
                        filters = JSON.parse(data.filters);
                    }
                    _.each( filters, function( filter, key ) {
                        var checked = ( filter.show ) ? 'checked' : '',
                            checked_row1 = ( filter.row === '1' ) ? 'checked' : '',
                            checked_row2 = ( filter.row === '2' ) ? 'checked' : '';
                #>
                    <li class="pix-widget-option" data-field="{{filter.id}}">
                        
                        <label>{{data.titles[filter.id]['title']}}: <br><input type="text" placeholder="{{data.titles[filter.id]['placeholder']}}" value="{{filter.name}}" <# checked === 'checked' ? '' : 'disabled' #> /></label>
                        
                        <span class="pix-el-segmented-button">
                            <span><?php esc_html_e('Row', 'solutech') ?></span>
                            <input id="{{filter.id}}1" name="{{filter.id}}" value="1" type="radio" class="pix-segmented-button-field" {{checked_row1}} <# checked === 'checked' ? '' : 'disabled' #>><label class="first" for="{{filter.id}}1">1</label>
                            <input id="{{filter.id}}2" name="{{filter.id}}" value="2" type="radio" class="pix-segmented-button-field" {{checked_row2}} <# checked === 'checked' ? '' : 'disabled' #>><label class="last" for="{{filter.id}}2">2</label>
                        </span>
        
                        <label class="switch switch-green">
                            <input type="checkbox" class="switch-input" {{checked}} />
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                        </label>
                        
                    </li>
                <# } ); #>
                </ul>
                <input id="<?php echo esc_attr( $control_uid ); ?>" type="text" name="{{ data.name }}'" class="pix-input-el-filter hidden-field-value" value=""/>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}

}