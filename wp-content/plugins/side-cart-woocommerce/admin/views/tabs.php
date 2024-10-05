<?php

$tabs = array(


	'general' => array(
		'title'			=> 'General',
		'id' 			=> 'general',
		'option_key' 	=> 'xoo-wsc-gl-options'
	),


	'style' => array(
		'title'			=> 'Style',
		'id' 			=> 'style',
		'option_key' 	=> 'xoo-wsc-sy-options'
	),


	'advanced' => array(
		'title'			=> 'Advanced',
		'id' 			=> 'advanced',
		'option_key' 	=> 'xoo-wsc-av-options'
	),

	'pro' => array(
		'title'			=> 'PRO',
		'id' 			=> 'pro',
		'option_key' 	=> 'xoo-wsc-dummy-pro'
	),
);

return apply_filters( 'xoo_wsc_admin_settings_tabs', $tabs );