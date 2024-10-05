<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Tabs
 */
 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );



$out = '';

preg_match_all( '/common_tab_content([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
$tab_titles = array();
/**
 * vc_tabs
 *
 */
if ( isset( $matches[1] ) ) {
	$tab_titles = $matches[1];
}


$tabs_nav = '<ul class="nav nav-tabs">';
$i=0;
foreach ( $tab_titles as $tab ) {
	$i++;
	$tab_atts = shortcode_parse_atts( $tab[0] );
	if ( isset( $tab_atts['label'] ) ) {
		$class = $i==1 ? 'active show' : '';
		$aria = $i==1 ? 'true' : 'false';
		$tabs_nav .= '
		<li>
			<a class="'.esc_attr($class).'" href="#tab-' . ( isset( $tab_atts['tab_id'] ) ? $tab_atts['tab_id'] : sanitize_title( $tab_atts['label'] ) ) . '" data-toggle="tab" aria-expanded="'.esc_attr($aria).'">' . $tab_atts['label'] . '</a>
		</li>';
	}
}
$tabs_nav .= '</ul>' . "\n";

$section_cont = explode( '[/common_tab_content]', $content );
array_pop($section_cont);
if( is_array( $section_cont ) && !empty( $section_cont ) ){
	$i=0;
	$out_cont = '';
	foreach( $section_cont as $option ){
		$i++;
		$out_cont .= $i==1 ? str_replace('tab-pane', 'tab-pane active', do_shortcode($option.'[/common_tab_content]')) : do_shortcode($option.'[/common_tab_content]');
	}		         
}

$out .= '
		<div class="pix-tabs">
			' . $tabs_nav . '
			<div class="tab-content inner-offset">
				'. $out_cont .'
			</div>
		</div>
	';

echo $out;