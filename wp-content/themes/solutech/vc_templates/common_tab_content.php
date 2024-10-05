<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $tab_id
 * @var $label
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Tab
 */
 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
			
$out = '
		<div class="tab-pane" id="tab-' . esc_attr(( empty( $tab_id ) ? sanitize_title( $label ) : $tab_id )) . '">
			<div class="row">
				<div class="col-sm-12 text-block">
					'.do_shortcode($content).'
				</div>
			</div>
		</div>
	';

echo $out;