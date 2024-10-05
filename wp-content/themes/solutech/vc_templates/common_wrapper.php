<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Wrapper
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


$out = '
<div class="pix-wrap">

    '.do_shortcode($content).'

</div>';


if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo wp_kses_post($out);
}
