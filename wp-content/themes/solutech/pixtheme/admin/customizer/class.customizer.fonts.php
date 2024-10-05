<?php 

if( class_exists( 'WP_Customize_Control' ) ) :
	class PixTheme_Google_Fonts_Loader_Control extends WP_Customize_Control {

		public function render_content() {

		?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
                <input type="text" id="pix-fonts-embed" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ) ?>">
            </label>
        <?php
        if($this->value() != '') :
            $pix_fonts = explode( '|', $this->value() );
            foreach($pix_fonts as $key => $val) :
                $font_arr = explode(':', $val);
                $font = str_ireplace('+', ' ', $font_arr[0]);
                $weights = isset($font_arr[1]) && !empty($font_arr[1]) ? $font_arr[1] : '';
        ?>
            <div class="pix-google-font-wrapper" data-font="<?php echo esc_attr($font) ?>">
                <label class="pix-customize-control-label"><?php echo wp_kses_post($font.':'.$weights) ?></label>
                <input type="hidden" class="pix-google-font-str" value="<?php echo esc_attr($val) ?>" data-font-weights="<?php echo esc_attr($weights) ?>">
                <button type="button" class="btn pix-wrapper-delete"><i class="fas fa-trash-alt"></i></button>
            </div>
        <?php
            endforeach;
        ?>
            <div id="pix-google-font-select" class="pix-google-font-select close" data-font="">
                <input type="text" id="pix-font-weights" class="pix-google-font-weights" value="">
                <button type="button" class="btn pix-wrapper-apply"><i class="fas fa-check"></i></button>
            </div>
        <?php
        endif;
		}
	}
endif;



if( class_exists( 'WP_Customize_Control' ) ) :
	class PixTheme_Segmented_Control extends WP_Customize_Control {

        public $align = '';
		public $type = '';
		public $hide_label = '';

		public function render_content() {

		if ( empty( $this->choices ) )
        return;

		?>
			<label>
				<span class="customize-control-title <?php echo esc_attr( $this->hide_label ) ?>"><?php echo esc_html( $this->label ); ?></span>
            </label>
            <div class="pix-vc-segmented-button <?php echo esc_attr( $this->align ) ?>">
            <?php
                $i=0;
                $cnt = count($this->choices)-1;
                $value = $this->value();
                foreach ( $this->choices as $v => $label ) {
                    $class = '';
                    if( $i == 0 ){
                        $class = 'first';
                    } elseif ( $i == $cnt ){
                        $class = 'last';
                    }
                    $checked = '';
                    if( $value == $v ){
                        $checked = 'checked';
                    }
                    echo '
                        <input id="pixid-' . $v . '" value="' . $v . '" type="radio" class="pix-segmented-button-field" ' . $checked . '>
                        <label class="' . $class . '" for="pixid-' . $v . '"> ' . $label . ' </label>
                    ';
                    $i++;
                }
            ?>
                <input type="text" <?php $this->link(); ?> class="pix-input-vc-segmented-button hidden-field-value <?php echo esc_attr( $this->type ) ?>" value="<?php echo esc_attr( $this->value() ) ?>"/>
            </div>

		<?php
		}
	}
endif;



if( class_exists( 'WP_Customize_Control' ) ) :
	class PixTheme_Google_Font_Control extends WP_Customize_Control {

        public $weight_id = '';

		public function render_content() {

		    $pix_fonts = explode( '|', get_theme_mod( 'pixtheme_fonts_embed' ) );

		?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<select <?php $this->link(); ?> class="pix-google-font" data-value="<?php echo esc_attr( $this->value() ) ?>" data-weight-id="<?php echo esc_attr( $this->weight_id ) ?>">
                <?php
                if(!empty($pix_fonts)) {
                    foreach ($pix_fonts as $key => $val) {
                        $font_arr = explode(':', $val);
                        $font = str_ireplace('+', ' ', $font_arr[0]);
                        $weights = isset($font_arr[1]) && !empty($font_arr[1]) ? $font_arr[1] : '';
                        ?>
                        <option value="<?php echo esc_attr($font) ?>" data-weights="<?php echo esc_attr($weights) ?>"><?php echo wp_kses_post($font) ?></option>
                        <?php
                    }
                    ?>
                    <option disabled><?php esc_html_e('Safe Web Fonts', 'solutech'); ?></option>
                    <option value="Jost" data-weights="100,400,500,600,700">Jost</option>
                    <option value="Arial" data-weights="400,700">Arial</option>
                    <option value="Helvetica" data-weights="400,700">Helvetica</option>
                    <option value="Tahoma" data-weights="400,700">Tahoma</option>
                    <option value="Lucida Sans Unicode" data-weights="400,700">Lucida Sans Unicode</option>
                    <option value="DejaVu Sans" data-weights="400,700">DejaVu Sans</option>
                    <option value="Times New Roman" data-weights="400,700">Times New Roman</option>
                    <option value="Courier" data-weights="400,700">Courier</option>
                    <option value="Courier New" data-weights="400,700">Courier New</option>
                    <option value="Verdana" data-weights="400,700">Verdana</option>
                    <option value="Tahoma" data-weights="400,700">Tahoma</option>
                    <option value="Georgia" data-weights="400,700">Georgia</option>
                    <option value="Palatino" data-weights="400,700">Palatino</option>
                    <option value="Garamond" data-weights="400,700">Garamond</option>
                    <option value="Trebuchet MS" data-weights="400,700">Trebuchet MS</option>
                    <option value="Garamond" data-weights="400,700">Garamond</option>
                    <?php
                }
                ?>
				</select>
			</label>
		<?php
		}
	}
endif;


if( class_exists( 'WP_Customize_Control' ) ) :
	class PixTheme_Google_Font_Weight_Control extends WP_Customize_Control {

		public $weight_id = '';

		public function render_content() {

		?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<select <?php $this->link(); ?> id="<?php echo esc_attr( $this->weight_id ) ?>" class="pix-google-font-weight" data-value="<?php echo esc_attr( $this->value() ) ?>">
					<option value="400">400</option>
				</select>
			</label>
		<?php
		}
	}
endif;


if( class_exists( 'WP_Customize_Control' ) ) :
	class PixTheme_Slider_Single_Control extends WP_Customize_Control {

		public $min = '';
		public $max = '';
		public $step = '';
		public $unit = '';

		public function enqueue() {
            wp_enqueue_script('pixtheme-custom-slider', get_template_directory_uri() . '/library/core/admin/js/custom-slider.js', array('jquery'), false, true);
        }

		public function render_content() {
		?>
			<label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <input type="text" <?php $this->link(); ?> class="range-slider-single" data-unit="<?php echo esc_attr( $this->unit ) ?>" data-step="<?php echo esc_attr( $this->step ) ?>" data-min="<?php echo esc_attr( $this->min ) ?>" data-max="<?php echo esc_attr( $this->max ) ?>" value="<?php echo esc_attr( $this->value() ) ?>">
                <div class="range-values range-single-input">
                    <a class="pix-slider-minus"><i class="fa fa-minus"></i></a>
                    <input data-type="number" class="range-value">
                    <a class="pix-slider-plus"><i class="fa fa-plus"></i></a>
                </div>
            </label>
		<?php
		}
	}
endif;


if( class_exists( 'WP_Customize_Control' ) ) :
	class PixTheme_Slider_Double_Control extends WP_Customize_Control {

		public $min = '';
		public $max = '';

		public function enqueue() {
            wp_enqueue_script('pixtheme-custom-slider', get_template_directory_uri() . '/library/core/admin/js/custom-slider.js', array('jquery'), false, true);
        }

		public function render_content() {
		?>
			<label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <input type="text" <?php $this->link(); ?> class="range-slider-double" data-min="<?php echo esc_attr( $this->min ) ?>" data-max="<?php echo esc_attr( $this->max ) ?>" value="<?php echo esc_attr( $this->value() ) ?>">
                <div class="range-values">
                    <input data-type="number" disabled class="range-value-1">
                    <span>-</span>
                    <input data-type="number" disabled class="range-value-2">
                    <span>-</span>
                    <input data-type="number" disabled class="range-value-3">
                </div>
            </label>
		<?php
		}
	}
endif;


if( class_exists( 'WP_Customize_Control' ) ) :
class PixTheme_Multiple_Select_Control extends WP_Customize_Control {

    public function render_content() {

    if ( empty( $this->choices ) )
        return;

    ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <select <?php $this->link(); ?> multiple="multiple" style="height: 100%;">
                <?php
                    foreach ( $this->choices as $value => $label ) {
                        $selected = ( in_array( $value, $this->value() ) ) ? selected( 1, 1, false ) : '';
                        echo '<option value="' . esc_attr( $value ) . '"' . $selected . '>' . $label . '</option>';
                    }
                ?>
            </select>
        </label>
    <?php }
}
endif;