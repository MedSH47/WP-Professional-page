<?php

$settings = array(

	/** SIDE CART MAIN **/
	array(
		'callback' 		=> 'number',
		'title' 		=> 'Side Cart Width',
		'id' 			=> 'scm-width',
		'section_id' 	=> 'sc_main',
		'default' 		=> '365',
		'desc' 			=> 'Size in px'
	),

	array(
		'callback' 		=> 'select',
		'title' 		=> 'Side Cart Height',
		'id' 			=> 'scm-height',
		'section_id' 	=> 'sc_main',
		'args' 			=> array(
			'options' 	=> array(
				'full' 		=> 'Full Height',
				'auto' 		=> 'Auto Adjust',
			),
		),
		'default' 	=> 'full'
	),

	array(
		'callback' 		=> 'select',
		'title' 		=> 'Open From',
		'id' 			=> 'scm-open-from',
		'section_id' 	=> 'sc_main',
		'args' 			=> array(
			'options' 	=> array(
				'left' 		=> 'Left',
				'right' 	=> 'Right',
			),
		),
		'default' 	=> 'right'
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Font',
		'id' 			=> 'scm-font',
		'section_id' 	=> 'sc_main',
		'default' 		=> '',
		'desc' 			=> 'Use custom font for side cart',
	),

	/** SIDE CART BASKET **/
	array(
		'callback' 		=> 'select',
		'title' 		=> 'Enable',
		'id' 			=> 'sck-enable',
		'section_id' 	=> 'sc_basket',
		'args' 			=> array(
			'options' 	=> array(
				'always_hide' 	=> 'Always Hide',
				'always_show' 	=> 'Always show',
				'hide_empty' 	=> 'Hide when cart is empty',
			),
		),
		'default' 	=> 'always_show'
	),


	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Show on Mobile',
		'id' 			=> 'sck-show-mobile',
		'section_id' 	=> 'sc_basket',
		'default' 		=> 'yes',
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Shape',
		'id' 			=> 'sck-shape',
		'section_id' 	=> 'sc_basket',
		'args' 			=> array(
			'options' 	=> array(
				'round' 	=> 'Round',
				'square' 	=> 'Square',
			),
		),
		'default' 	=> 'round'
	),


	array(
		'callback' 		=> 'number',
		'title' 		=> 'Icon Size',
		'id' 			=> 'sck-size',
		'section_id' 	=> 'sc_basket',
		'default' 		=> 30,
		'desc' 			=> 'Size in px'
	),

	array(
		'callback' 		=> 'number',
		'title' 		=> 'Basket Size',
		'id' 			=> 'sck-bk-size',
		'section_id' 	=> 'sc_basket',
		'default' 		=> '60',
	),

	
	array(
		'callback' 		=> 'radio',
		'title' 		=> 'Basket Icon',
		'id' 			=> 'sck-basket-icon',
		'section_id' 	=> 'sc_basket',
		'args' 			=> array(
			'options' 	=> array(
				'xoo-wsc-icon-basket1' 		=> 'xoo-wsc-icon-basket1',
				'xoo-wsc-icon-basket2' 		=> 'xoo-wsc-icon-basket2',
				'xoo-wsc-icon-basket3'		=> 'xoo-wsc-icon-basket3',
				'xoo-wsc-icon-basket4' 		=> 'xoo-wsc-icon-basket4',
				'xoo-wsc-icon-basket5' 		=> 'xoo-wsc-icon-basket5',
				'xoo-wsc-icon-basket6' 		=> 'xoo-wsc-icon-basket6',
				'xoo-wsc-icon-cart1' 		=> 'xoo-wsc-icon-cart1',
				'xoo-wsc-icon-cart2' 		=> 'xoo-wsc-icon-cart2',
				'xoo-wsc-icon-bag1' 		=> 'xoo-wsc-icon-bag1',
				'xoo-wsc-icon-bag2' 		=> 'xoo-wsc-icon-bag2',
				'xoo-wsc-icon-shopping-bag1'=> 'xoo-wsc-icon-shopping-bag1',
			),
			'has_asset' 	=> true,
			'asset_type' 	=> 'icon',
			'upload' 		=> 'yes'
		),
		'default' 	=> 'xoo-wsc-icon-basket1',
	),

	array(
		'callback' 		=> 'upload',
		'title' 		=> 'Custom Basket Icon',
		'id' 			=> 'sck-cust-icon',
		'section_id' 	=> 'sc_basket',
		'default' 		=> '',
		'pro' 			=> 'yes'
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Basket Position',
		'id' 			=> 'sck-position',
		'section_id' 	=> 'sc_basket',
		'args' 			=> array(
			'options' 	=> array(
				'top' 		=> 'Top',
				'bottom' 	=> 'Bottom',
			),
		),
		'default' 	=> 'bottom'
	),

	array(
		'callback' 		=> 'number',
		'title' 		=> 'Basket Offset ↨',
		'id' 			=> 'sck-offset',
		'section_id' 	=> 'sc_basket',
		'default' 		=> 12,
		'desc' 			=> 'Shifts basket position vertically'
	),

	array(
		'callback' 		=> 'number',
		'title' 		=> 'Basket Offset ⟷',
		'id' 			=> 'sck-hoffset',
		'section_id' 	=> 'sc_basket',
		'default' 		=> 1,
		'desc' 			=> 'Shifts basket position horizontally ( when side cart is closed )'
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Basket Color',
		'id' 			=> 'sck-basket-color',
		'section_id' 	=> 'sc_basket',
		'default' 		=> '#000000',
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Basket Background Color',
		'id' 			=> 'sck-basket-bg',
		'section_id' 	=> 'sc_basket',
		'default' 		=> '#ffffff',
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Basket Shadow',
		'id' 			=> 'sck-basket-sh',
		'section_id' 	=> 'sc_basket',
		'default' 		=> '0px 0px 15px 2px #0000001a',
		'desc' 			=> xoo_wsc_helper()->box_shadow_desc('0px 0px 15px 2px #0000001a')
	),


	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Show Count',
		'id' 			=> 'sck-show-count',
		'section_id' 	=> 'sc_basket',
		'default' 		=> 'yes',
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Count Position',
		'id' 			=> 'sck-count-pos',
		'section_id' 	=> 'sc_basket',
		'args' 			=> array(
			'options' 	=> array(
				'top_right' 	=> 'Top Right',
				'top_left' 		=> 'Top Left',
				'bottom_right'	=> 'Bottom Right',
				'bottom_left' 	=> 'Bottom Left',
			),
		),
		'default' 	=> 'top_left'
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Count Color',
		'id' 			=> 'sck-count-color',
		'section_id' 	=> 'sc_basket',
		'default' 		=> '#ffffff',
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Count Background Color',
		'id' 			=> 'sck-count-bg',
		'section_id' 	=> 'sc_basket',
		'default' 		=> '#000000',
	),



	/** SIDE CART HEADER **/

	array(
		'callback' 		=> 'select',
		'title' 		=> 'Heading Align',
		'id' 			=> 'sch-head-align',
		'section_id' 	=> 'sc_head',
		'args' 			=> array(
			'options' 	=> array(
				'center' 		=> 'Center',
				'flex-start' 	=> 'Left',
				'flex-end' 		=> 'Right'
			),
		),
		'default' 	=> 'center'
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Close Icon Align',
		'id' 			=> 'sch-close-align',
		'section_id' 	=> 'sc_head',
		'args' 			=> array(
			'options' 	=> array(
				'left' 		=> 'Left',
				'right' 	=> 'Right'
			),
		),
		'default' 	=> 'right'
	),

	array(
		'callback' 		=> 'radio',
		'title' 		=> 'Close Icon',
		'id' 			=> 'sch-close-icon',
		'section_id' 	=> 'sc_head',
		'args' 			=> array(
			'options' 	=> array(
				'xoo-wsc-icon-cross' => 'xoo-wsc-icon-cross',
				'xoo-wsc-icon-arrow-long-right' => 'xoo-wsc-icon-arrow-long-right',
				'xoo-wsc-icon-arrow-thin-right' => 'xoo-wsc-icon-arrow-thin-right',
				'xoo-wsc-icon-del4' => 'xoo-wsc-icon-del4',
				'xoo-wsc-icon-del1' => 'xoo-wsc-icon-del1',
				'xoo-wsc-icon-del2' => 'xoo-wsc-icon-del2',
				'xoo-wsc-icon-del3' => 'xoo-wsc-icon-del3',
				'xoo-wsc-icon-arrow-left' => 'xoo-wsc-icon-arrow-left',
				'xoo-wsc-icon-arrow-thin-left' => 'xoo-wsc-icon-arrow-thin-left',
			),
			'has_asset' 	=> true,
			'asset_type' 	=> 'icon',
			'upload' 		=> 'yes'
		),
		'default' 	=> 'xoo-wsc-icon-cross',
	),

	array(
		'callback' 		=> 'number',
		'title' 		=> 'Close Icon Size',
		'id' 			=> 'sch-close-fsize',
		'section_id' 	=> 'sc_head',
		'default' 		=> '16',
		'desc' 			=> 'Size in px'
	),


	array(
		'callback' 		=> 'number',
		'title' 		=> 'Heading Font Size',
		'id' 			=> 'sch-head-fsize',
		'section_id' 	=> 'sc_head',
		'default' 		=> '20',
		'desc' 			=> 'Size in px'
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Progress Bar Color',
		'id' 			=> 'sch-pbcolor',
		'section_id' 	=> 'sc_head',
		'default' 		=> '#f0f0f0',
		'pro' 			=> 'yes'
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Progress Bar Filled Color',
		'id' 			=> 'sch-pbfillcolor',
		'section_id' 	=> 'sc_head',
		'default' 		=> '#000000',
		'pro' 			=> 'yes'
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Background Color',
		'id' 			=> 'sch-bgcolor',
		'section_id' 	=> 'sc_head',
		'default' 		=> '#ffffff',
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Text Color',
		'id' 			=> 'sch-txtcolor',
		'section_id' 	=> 'sc_head',
		'default' 		=> '#000000',
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Border',
		'id' 			=> 'sch-border',
		'section_id' 	=> 'sc_head',
		'default' 		=> '2px solid #eee',
		'desc' 			=> 'Default: 2px solid #eee'
	),


	/** SIDE CART BODY **/
	array(
		'callback' 		=> 'number',
		'title' 		=> 'Font Size',
		'id' 			=> 'scb-fsize',
		'section_id' 	=> 'sc_body',
		'default' 		=> 16,
		'desc' 			=> 'Size in px'
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Background Color',
		'id' 			=> 'scb-bgcolor',
		'section_id' 	=> 'sc_body',
		'default' 		=> '#f8f9fa',
	),


	array(
		'callback' 		=> 'upload',
		'title' 		=> 'Empty Cart Image',
		'id' 			=> 'scb-empty-img',
		'section_id' 	=> 'sc_body',
		'default' 		=> '',
		'pro' 			=> 'yes'
	),

	array(
		'callback' 		=> 'select',
		'title' 		=> 'Delete Position',
		'id' 			=> 'scbp-delpos',
		'section_id' 	=> 'sc_body',
		'args' 			=> array(
			'options' 	=> array(
				'image' 	=> 'Below Product image',
				'default' 	=> 'Default',
			),
		),
		'default' 		=> 'default',
	),

	array(
		'callback' 		=> 'select',
		'title' 		=> 'Delete Type',
		'id' 			=> 'scbp-deltype',
		'section_id' 	=> 'sc_body',
		'args' 			=> array(
			'options' 	=> array(
				'icon' 		=> 'Icon',
				'text' 		=> 'Text',
			),
		),
		'default' 		=> 'icon',
		'desc' 			=> 'Set text under general -> texts'
	),



	array(
		'callback' 		=> 'radio',
		'title' 		=> 'Delete Icon',
		'id' 			=> 'scb-del-icon',
		'section_id' 	=> 'sc_body',
		'args' 			=> array(
			'options' 	=> array(
				'xoo-wsc-icon-trash' 	=> 'xoo-wsc-icon-trash',
				'xoo-wsc-icon-trash1' 	=> 'xoo-wsc-icon-trash1',
				'xoo-wsc-icon-trash2' 	=> 'xoo-wsc-icon-trash2',
				'xoo-wsc-icon-cross' 	=> 'xoo-wsc-icon-cross',
				'xoo-wsc-icon-del1'  	=> 'xoo-wsc-icon-del1',
				'xoo-wsc-icon-del2'  	=> 'xoo-wsc-icon-del2',
				'xoo-wsc-icon-del3'  	=> 'xoo-wsc-icon-del3',
				'xoo-wsc-icon-del4'  	=> 'xoo-wsc-icon-del4',
			),
			'has_asset'  => true,
			'asset_type' => 'icon'
		),
		'default' 	=> 'xoo-wsc-icon-trash'
	),


	/** Product Row Layout **/

	array(
		'callback' 		=> 'number',
		'title' 		=> 'Image Width',
		'id' 			=> 'scbp-imgw',
		'section_id' 	=> 'scb_product',
		'default' 		=> 28,
		'desc' 			=> 'Value in percentage'
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Background Color',
		'id' 			=> 'scbp-bgcolor',
		'section_id' 	=> 'scb_product',
		'default' 		=> '#ffffff',
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Text Color',
		'id' 			=> 'scb-txtcolor',
		'section_id' 	=> 'scb_product',
		'default' 		=> '#000000',
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Product Padding',
		'id' 			=> 'scbp-padding',
		'section_id' 	=> 'scb_product',
		'default' 		=> '10px 15px',
		'desc' 			=> '↨ ⟷ ( Default: 10px 15px )'
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Product Margin',
		'id' 			=> 'scbp-margin',
		'section_id' 	=> 'scb_product',
		'default' 		=> '10px 15px',
		'desc' 			=> '↨ ⟷ ( Default: 10px 15px )'
	),


	array(
		'callback' 		=> 'number',
		'title' 		=> 'Product Border radius',
		'id' 			=> 'scbp-bradius',
		'section_id' 	=> 'scb_product',
		'default' 		=> '5',
		'desc' 			=> 'Size in px'
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Shadow',
		'id' 			=> 'scbp-shadow',
		'section_id' 	=> 'scb_product',
		'default' 		=> '0 2px 2px #00000005',
		'desc' 			=> xoo_wsc_helper()->box_shadow_desc('0 2px 2px #00000005')
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Variations Format',
		'id' 			=> 'scbp-var-format',
		'section_id' 	=> 'scb_product',
		'args' 			=> array(
			'options' 	=> array(
				'sep_line' 	=> 'Show variations in separate lines',
				'one_line'	=> 'Show variations in single line',
			),
		),
		'default' 	=> 'sep_line',
		'desc' 		=> 'Format for displaying multiple variations.'
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Product Details Display',
		'id' 			=> 'scbp-display',
		'section_id' 	=> 'scb_product',
		'args' 			=> array(
			'options' 	=> array(
				'stretched' 	=> 'Evenly',
				'center' 		=> 'Center',
				'flex-start'	=> 'Top'
			),
		),
		'default' 		=> 'center',
	),

	

	/** SIDE CART BODY Quantity **/

	array(
		'callback' 		=> 'select',
		'title' 		=> 'Quantity Input Style',
		'id' 			=> 'scbq-style',
		'section_id' 	=> 'scb_qty',
		'args' 			=> array(
			'options' 	=> array(
				'square' 	=> 'Square Corners',
				'circle' 	=> 'Round Corners',
			),
		),
		'default' 	=> 'square',
		'pro' 		=> 'yes'
	),

	array(
		'callback' 		=> 'number',
		'title' 		=> 'Box Width',
		'id' 			=> 'scbq-width',
		'section_id' 	=> 'scb_qty',
		'default' 		=> 75,
		'desc' 			=> 'Size in px',
		'pro' 			=> 'yes'
	),


	array(
		'callback' 		=> 'number',
		'title' 		=> 'Box Height',
		'id' 			=> 'scbq-height',
		'section_id' 	=> 'scb_qty',
		'default' 		=> 28,
		'desc' 			=> 'Size in px',
		'pro' 			=> 'yes'
	),

	array(
		'callback' 		=> 'number',
		'title' 		=> 'Border Size',
		'id' 			=> 'scbq-bsize',
		'section_id' 	=> 'scb_qty',
		'default' 		=> 1,
		'desc' 			=> 'Size in px',
		'pro' 			=> 'yes'
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Input Border Color',
		'id' 			=> 'scbq-input-bcolor',
		'section_id' 	=> 'scb_qty',
		'default' 		=> '#000000',
		'desc' 			=> 'Leave empty to remove border',
		'pro' 			=> 'yes'
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Box Border Color',
		'id' 			=> 'scbq-box-bcolor',
		'section_id' 	=> 'scb_qty',
		'default' 		=> '#000000',
		'desc' 			=> 'Leave empty to remove border',
		'pro' 			=> 'yes'
	),

	array(
		'callback' 		=> 'color',
		'title' 		=> 'Input BG Color',
		'id' 			=> 'scbq-input-bgcolor',
		'section_id' 	=> 'scb_qty',
		'default' 		=> '#ffffff',
		'pro' 			=> 'yes'
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Input Text Color',
		'id' 			=> 'scbq-input-txtcolor',
		'section_id' 	=> 'scb_qty',
		'default' 		=> '#000000',
		'pro' 			=> 'yes'
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Buttons BG Color',
		'id' 			=> 'scbq-box-bgcolor',
		'section_id' 	=> 'scb_qty',
		'default' 		=> '#ffffff',
		'pro' 			=> 'yes'
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Buttons Text Color',
		'id' 			=> 'scbq-box-txtcolor',
		'section_id' 	=> 'scb_qty',
		'default' 		=> '#000000',
		'pro' 			=> 'yes'
	),

	/** SIDE CART FOOTER **/

	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Stick to bottom',
		'id' 			=> 'scf-stick',
		'section_id' 	=> 'sc_footer',
		'default' 		=> 'yes',
		'desc' 			=> 'If enabled, footer will be sticked to bottom.'
	),

	array(
		'callback' 		=> 'select',
		'title' 		=> 'Cart Totals Location',
		'id' 			=> 'scf-totals-loc',
		'section_id' 	=> 'sc_footer',
		'args' 			=> array(
			'options' 	=> array(
				'footer'		=> 'Footer',
				'body' 			=> 'Main Body',
				'mobile_body' 	=> 'Main body when on mobile'
			),
		),
		'default' 	=> 'footer',
		'pro' 		=> 'yes',
	),

	array(
		'callback' 		=> 'text',
		'title' 		=> 'Padding',
		'id' 			=> 'scf-padding',
		'section_id' 	=> 'sc_footer',
		'default' 		=> '10px 20px',
		'desc' 			=> '↨ ⟷ ( Default: 10px 20px ), use values'
	),


	array(
		'callback' 		=> 'number',
		'title' 		=> 'Font Size',
		'id' 			=> 'scf-fsize',
		'section_id' 	=> 'sc_footer',
		'default' 		=> '18',
		'desc' 			=> 'Size in px'
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Background Color',
		'id' 			=> 'scf-bgcolor',
		'section_id' 	=> 'sc_footer',
		'default' 		=> '#ffffff',
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Text Color',
		'id' 			=> 'scf-txtcolor',
		'section_id' 	=> 'sc_footer',
		'default' 		=> '#000000',
	),

	array(
		'callback' 		=> 'text',
		'title' 		=> 'Shadow',
		'id' 			=> 'scf-shadow',
		'section_id' 	=> 'sc_footer',
		'default' 		=> '0 -1px 10px #0000001a',
		'desc' 			=> xoo_wsc_helper()->box_shadow_desc('0 -1px 10px #0000001a')
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Display Coupon Form in',
		'id' 			=> 'scf-coup-display',
		'section_id' 	=> 'sc_footer',
		'args' 			=> array(
			'options' 	=> array(
				'slider'		=> 'Slider',
				'main' 			=> 'Main',
			),
		),
		'default' 	=> 'slider',
		'pro' 		=> 'yes'
	),

	array(
		'callback' 		=> 'radio',
		'title' 		=> 'Coupon Icon',
		'id' 			=> 'scf-coup-icon',
		'section_id' 	=> 'sc_footer',
		'args' 			=> array(
			'options' 	=> array(
				'xoo-wsc-icon-coupon' 			=> 'xoo-wsc-icon-coupon',
				'xoo-wsc-icon-coupon-1' 		=> 'xoo-wsc-icon-coupon-1',
				'xoo-wsc-icon-coupon-2' 		=> 'xoo-wsc-icon-coupon-2',
				'xoo-wsc-icon-coupon-3' 		=> 'xoo-wsc-icon-coupon-3',
				'xoo-wsc-icon-coupon-4' 		=> 'xoo-wsc-icon-coupon-4',
				'xoo-wsc-icon-coupon-5' 		=> 'xoo-wsc-icon-coupon-5',
				'xoo-wsc-icon-coupon-6' 		=> 'xoo-wsc-icon-coupon-6',
				'xoo-wsc-icon-coupon-7' 		=> 'xoo-wsc-icon-coupon-7',
				'xoo-wsc-icon-coupon-8' 		=> 'xoo-wsc-icon-coupon-8',
			),
			'has_asset' 	=> true,
			'asset_type' 	=> 'icon',
			'upload' 		=> 'yes'
		),
		'default' 	=> 'xoo-wsc-icon-coupon-8',
		'pro' 		=> 'yes'
	),

	array(
		'callback' 		=> 'sortable',
		'title' 		=> 'Button Position',
		'id' 			=> 'scf-button-pos',
		'section_id' 	=> 'sc_footer',
		'args' 			=> array(
			'options' 		=> array(
				'continue' 	=> 'Continue Shopping',
				'cart' 		=> 'View Cart',
				'checkout'	=> 'Checkout'
			),
			'display' 	=> 'vertical'
		),
		'default' => array( 'cart', 'continue', 'checkout' ),
		'desc' 	=> 'Drag to change order. Leave button text empty under general -> texts to remove button'
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Button Row',
		'id' 			=> 'scf-btns-row',
		'section_id' 	=> 'sc_footer',
		'args' 			=> array(
			'options' 	=> array(
				'one'		=> 'One in a row ( 1+1+1 )',
				'two_one' 	=> 'Two in first row ( 2 + 1 )',
				'one_two' 	=> 'Two in last row ( 1 + 2 )',
				'three' 	=> 'Three in one row( 3 )'
			),
		),
		'default' 	=> 'one'
	),


	array(
		'callback' 		=> 'select',
		'title' 		=> 'Design',
		'id' 			=> 'scf-btns-theme',
		'section_id' 	=> 'sc_button',
		'args' 			=> array(
			'options' 	=> array(
				'theme'		=> 'Use theme button design & colors',
				'custom' 	=> 'Custom',
			),
		),
		'default' 	=> 'custom',
		'desc' 		=> 'If set to theme design, all the below options will be ineffective. Theme button design can be inconsistent and vary from theme to theme.'
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Padding',
		'id' 			=> 'scf-btn-padding',
		'section_id' 	=> 'sc_button',
		'default' 		=> '10px 20px',
		'desc' 			=> '↨ ⟷ ( Default: 10px 20px ), use values'
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Background Color',
		'id' 			=> 'scf-btn-bgcolor',
		'section_id' 	=> 'sc_button',
		'default' 		=> '#000000',
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Text Color',
		'id' 			=> 'scf-btn-txtcolor',
		'section_id' 	=> 'sc_button',
		'default' 		=> '#ffffff',
	),

	array(
		'callback' 		=> 'text',
		'title' 		=> 'Border',
		'id' 			=> 'scf-btn-border',
		'section_id' 	=> 'sc_button',
		'default' 		=> '2px solid #ffffff',
		'desc' 			=> 'Default: 2px solid #000000'
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Hover Background Color',
		'id' 			=> 'scf-btnhv-bgcolor',
		'section_id' 	=> 'sc_button',
		'default' 		=> '#ffffff',
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Hover Text Color',
		'id' 			=> 'scf-btnhv-txtcolor',
		'section_id' 	=> 'sc_button',
		'default' 		=> '#000000',
	),

	array(
		'callback' 		=> 'text',
		'title' 		=> 'Hover Border',
		'id' 			=> 'scf-btnhv-border',
		'section_id' 	=> 'sc_button',
		'default' 		=> '2px solid #000000',
		'desc' 			=> 'Default: 2px solid #000000'
	),



	/** Suggested products **/

	array(
		'callback' 		=> 'select',
		'title' 		=> 'Location',
		'id' 			=> 'scsp-main-location',
		'section_id' 	=> 'sc_sug_products',
		'args' 			=> array(
			'options' 	=> array(
				'drawer' 	=> 'Drawer',
				'before' 	=> 'Before Totals',
				'after' 	=> 'After Totals',
			),
		),
		'default' 	=> 'drawer',
		'pro' 		=> 'yes'
	),


	array(
		'callback' 		=> 'number',
		'title' 		=> 'Drawer Width',
		'id' 			=> 'scs-drawer-width',
		'section_id' 	=> 'sc_sug_products',
		'default' 		=> '350',
		'desc' 			=> 'Size in px',
		'pro' 			=> 'yes'
	),

	array(
		'callback' 		=> 'number',
		'title' 		=> 'Open drawer after seconds',
		'id' 			=> 'scs-drawer-wait',
		'section_id' 	=> 'sc_sug_products',
		'default' 		=> '500',
		'desc' 			=> '1000 = 1 second',
		'pro' 			=> 'yes'
	),

	array(
		'callback' 		=> 'select',
		'title' 		=> 'Style',
		'id' 			=> 'scsp-style',
		'section_id' 	=> 'sc_sug_products',
		'args' 			=> array(
			'options' 	=> array(
				'narrow' 	=> 'Narrow',
				'wide' 		=> 'Wide',
				'column' 	=> 'Column'
			),
		),
		'default' 	=> 'wide',
		'pro' 		=> 'yes'
	),

	array(
		'callback' 		=> 'number',
		'title' 		=> 'Number of products per column',
		'id' 			=> 'scsp-col-items',
		'section_id' 	=> 'sc_sug_products',
		'default' 		=> 2,
		'pro' 			=> 'yes'
	),


	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Slider',
		'id' 			=> 'scsp-slide-en',
		'section_id' 	=> 'sc_sug_products',
		'default' 		=> 'yes',
		'pro' 			=> 'yes'
	),



	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Auto slide',
		'id' 			=> 'scsp-slide-auto',
		'section_id' 	=> 'sc_sug_products',
		'default' 		=> 'yes',
		'pro' 			=> 'yes'
	),


	array(
		'callback' 		=> 'number',
		'title' 		=> 'Slide speed',
		'id' 			=> 'scsp-slide-timer',
		'section_id' 	=> 'sc_sug_products',
		'default' 		=> 5000,
		'desc' 			=> '1000 = 1 second',
		'pro' 			=> 'yes'
	),



	array(
		'callback' 		=> 'number',
		'title' 		=> 'Image Width',
		'id' 			=> 'scsp-imgw',
		'section_id' 	=> 'sc_sug_products',
		'default' 		=> '80',
		'desc' 			=> 'value in px',
		'pro' 			=> 'yes'
	),


	array(
		'callback' 		=> 'number',
		'title' 		=> 'Font Size',
		'id' 			=> 'scsp-fsize',
		'section_id' 	=> 'sc_sug_products',
		'default' 		=> '14',
		'desc' 			=> 'Size in px',
		'pro' 			=> 'yes'
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Container Background Color',
		'id' 			=> 'scsp-bgcolor',
		'section_id' 	=> 'sc_sug_products',
		'default' 		=> '#eee',
		'pro' 			=> 'yes'
	),

	array(
		'callback' 		=> 'color',
		'title' 		=> 'Product Background Color',
		'id' 			=> 'scsp-prd-bgcolor',
		'section_id' 	=> 'sc_sug_products',
		'default' 		=> '#fff',
		'pro' 			=> 'yes'
	),


	/***** Shortcode ****/

	array(
		'callback' 		=> 'number',
		'title' 		=> 'Icon Size',
		'id' 			=> 'shbk-size',
		'section_id' 	=> 'sh_bk',
		'default' 		=> 28,
		'desc' 			=> 'Size in px'
	),

	array(
		'callback' 		=> 'color',
		'title' 		=> 'Icon Color',
		'id' 			=> 'shbk-color',
		'section_id' 	=> 'sh_bk',
		'default' 		=> '#000000',
	),

	array(
		'callback' 		=> 'color',
		'title' 		=> 'Count Color',
		'id' 			=> 'shbk-count-color',
		'section_id' 	=> 'sh_bk',
		'default' 		=> '#ffffff',
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Count Background Color',
		'id' 			=> 'shbk-count-bg',
		'section_id' 	=> 'sh_bk',
		'default' 		=> '#000000',
	),

	array(
		'callback' 		=> 'color',
		'title' 		=> 'Text Color',
		'id' 			=> 'shbk-txt-color',
		'section_id' 	=> 'sh_bk',
		'default' 		=> '#000000',
	),

	/* Product card */

	array(
		'callback' 		=> 'checkbox',
		'title' 		=> 'Enable Card Layout',
		'id' 			=> 'scbp-card-en',
		'section_id' 	=> 'scb_productcard',
		'default' 		=> 'no',
		'desc' 			=> '',
		'pro' 			=> 'yes'
	),


	array(
		'callback' 		=> 'number',
		'title' 		=> 'Number of cards per row',
		'id' 			=> 'scbp-card-count',
		'section_id' 	=> 'scb_productcard',
		'default' 		=> '2',
		'pro' 			=> 'yes'
	),

	
	array(
		'callback' 		=> 'select',
		'title' 		=> 'Show details',
		'id' 			=> 'scbp-card-visible',
		'section_id' 	=> 'scb_productcard',
		'args' 			=> array(
			'options' 	=> array(
				'all_on_front'		=> 'Everything on front',
				'back_hover' 		=> 'Back side on Hover',
				'back_click' 		=> 'Back side on Click',
			),
		),
		'default' 		=> 'back_hover',
		'pro' 			=> 'yes'
	),

	array(
		'callback' 		=> 'checkbox_list',
		'title' 		=> 'Details to show on back of card. <br>If unchecked, will be shown on the front.',
		'id' 			=> 'scbp-card-back',
		'section_id' 	=> 'scb_productcard',
		'args' 			=> array(
			'options' 	=> array(
				'total_sales' 	=> 'Product Sales Count',
				'name' 	=> 'Product Name',
				'price' => 'Product Price',
				'qty' 	=> 'Product Quantity',
				'total' => 'Product Total',
				'meta' 	=> 'Product Meta ( Variations )',
				'link' 	=> 'View Product Link',
			),
		),
		'default' 	=> array(
			'total_sales', 'name', 'link', 'meta', 'price'
		),
		'desc' 		=> 'This only controls back and front display. To enable/disable the detail go to tab general -> Side cart body -> Show and check/uncheck the detail from there.',
		'pro' 			=> 'yes'
	),

	array(
		'callback' 		=> 'select',
		'title' 		=> 'Show details card animation',
		'id' 			=> 'scbp-card-anim-type',
		'section_id' 	=> 'scb_productcard',
		'args' 			=> array(
			'options' 	=> array(
				'openUpLeft'		=> 'openUpLeft',
				'openDownRight'		=> 'openDownRight',
				'openUpLeft'		=> 'openUpLeft',
				'openUpRight'		=> 'openUpRight',
				'perspectiveDown'	=> 'perspectiveDown',
				'perspectiveUp'		=> 'perspectiveUp',
				'perspectiveLeft'	=> 'perspectiveLeft',
				'perspectiveRight'	=> 'perspectiveRight',
				'slideDown' 		=> 'slideDown',
				'slideUp' 			=> 'slideUp',
				'slideLeft' 		=> 'slideLeft',
				'slideRight' 		=> 'slideRight'
			),
		),
		'default' 		=> 'slideUp',
		'pro' 			=> 'yes'
	),

	array(
		'callback' 		=> 'text',
		'title' 		=> 'Animation duration',
		'id' 			=> 'scbp-card-anim-time',
		'section_id' 	=> 'scb_productcard',
		'default' 		=> '0.5',
		'desc' 			=> 'in seconds',
		'pro' 			=> 'yes'
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Image Background Color',
		'id' 			=> 'scbp-card-img-color',
		'section_id' 	=> 'scb_productcard',
		'default' 		=> '#eee',
		'pro' 			=> 'yes'
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Back side details Background Color',
		'id' 			=> 'scbp-card-back-color',
		'section_id' 	=> 'scb_productcard',
		'default' 		=> '#fff',
		'pro' 			=> 'yes'
	),


	array(
		'callback' 		=> 'color',
		'title' 		=> 'Front Details Background Color',
		'id' 			=> 'scbp-card-front-color',
		'section_id' 	=> 'scb_productcard',
		'default' 		=> '#eee',
		'pro' 			=> 'yes'
	),

	array(
		'callback' 		=> 'color',
		'title' 		=> 'Card Text Color',
		'id' 			=> 'scbp-card-txtcolor',
		'section_id' 	=> 'scb_productcard',
		'default' 		=> '#000',
		'pro' 			=> 'yes'
	),


	array(
		'callback' 		=> 'number',
		'title' 		=> 'Image Width',
		'id' 			=> 'scbp-card-imgw',
		'section_id' 	=> 'scb_productcard',
		'default' 		=> 100,
		'desc' 			=> 'Value in percentage',
		'pro' 			=> 'yes'
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Products Spacing',
		'id' 			=> 'scbp-card-padding',
		'section_id' 	=> 'scb_productcard',
		'default' 		=> '10px 10px',
		'desc' 			=> '↨ ⟷ ( Default: 10px 10px )',
		'pro' 			=> 'yes'
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Card Border',
		'id' 			=> 'scbp-card-border',
		'section_id' 	=> 'scb_productcard',
		'default' 		=> '0',
		'desc' 			=> 'Eg: 2px solid #777',
		'pro' 			=> 'yes'
	),

	array(
		'callback' 		=> 'number',
		'title' 		=> 'Card Radius Top',
		'id' 			=> 'scbp-card-radius-top',
		'section_id' 	=> 'scb_productcard',
		'default' 		=> '5',
		'desc' 			=> 'In px',
		'pro' 			=> 'yes'
	),

	array(
		'callback' 		=> 'number',
		'title' 		=> 'Card Radius Bottom',
		'id' 			=> 'scbp-card-radius-btm',
		'section_id' 	=> 'scb_productcard',
		'default' 		=> '5',
		'desc' 			=> 'In px',
		'pro' 			=> 'yes'
	),


	array(
		'callback' 		=> 'text',
		'title' 		=> 'Shadow',
		'id' 			=> 'scbp-card-shadow',
		'section_id' 	=> 'scb_productcard',
		'default' 		=> '0px 10px 15px -12px #0000001a',
		'desc' 			=> xoo_wsc_helper()->box_shadow_desc('0px 10px 15px -12px #0000001a'),
		'pro' 			=> 'yes'
	),

);

return apply_filters( 'xoo_wsc_admin_settings', $settings, 'style' );
?>