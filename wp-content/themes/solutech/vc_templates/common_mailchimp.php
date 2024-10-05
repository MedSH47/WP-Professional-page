<?php
$out = '';

$out .= '
		<div class="subscribe">
			<div class="form-inline clearfix">
				'.do_shortcode('[mc4wp_form]').'
			</div>
		</div>	
	'; 

if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo wp_kses_post($out);
}
