jQuery(document).ready(function($){

	var Customizer = {

		$form: '',
		$styleTag: $('.xoo-as-preview-style'),
		previewTemplate: '',
		formValues: {},
		getPreviewCSS: function() {},
		getPreviewHTMLData: function() {},

		init: function(){
			this.initColorPicker();
			this.initSortable();
			this.initTemplates();
			this.events();
			this.build();
		},

		events: function(){
			$( Customizer.$form ).on('change', this.onFormChange );
		},

		initTemplates: function(){
			this.previewTemplate = wp.template('xoo-as-preview');
		},

		initColorPicker: function(){
			$('.xoo-as-color-input').wpColorPicker({
				change: function(event, ui){
					$(event.target).val(ui.color.toString()).trigger('change')
				}
			});
		},

		initSortable: function(){
			$('.xoo-as-sortable-list').sortable({
				update: function(){
					Customizer.build();
				}
			});
		},

		onFormChange: function(e){
			Customizer.build();
		},


		setFormValues: function(){
			var values 		= this.$form.serializeArray();
			this.formValues = this.objectifyForm(values);
		},

		build: function(){

			this.setFormValues();
			this.buildHTML();
			this.buildCSS();

		},


		buildCSS: function(){

			var css = '';

			$.each( Customizer.getPreviewCSS(), function( selector, properties ){
				css += selector+'{';
				$.each( properties, function(property, value){
					css += property+': '+value+';';
				} );
				css += '}';
			} );

			Customizer.$styleTag.html('<style>'+css+'</style>')	
		},

		buildHTML: function(){
			$('.xoo-as-preview').html(Customizer.previewTemplate(Customizer.getPreviewHTMLData()));

		},

		objectifyForm(inp){

			var rObject = {};

			for (var i = 0; i < inp.length; i++){
				if(inp[i]['name'].substr(inp[i]['name'].length - 2) == "[]"){
					var tmp = inp[i]['name'].substr(0, inp[i]['name'].length-2);
					if(Array.isArray(rObject[tmp])){
						rObject[tmp].push(inp[i]['value']);
					} else{
						rObject[tmp] = [];
						rObject[tmp].push(inp[i]['value']);
					}
				} else{
					rObject[inp[i]['name']] = inp[i]['value'];
				}
			}
			return rObject;
		}
	}


	var SideCart = {

		settingsInPreview: ['xoo-wsc-gl-options[scb-show][]', 'xoo-wsc-gl-options[sch-show][]', 'xoo-wsc-gl-options[scf-show][]', 'xoo-wsc-sy-options[scf-button-pos][]'],
		previewSettingsRecorded: false,

		init: function(){
			this.initCustomizer();
			this.events();
			this.toggle('show');
		},


		initCustomizer: function(){
			Customizer.$form 		=  $('form.xoo-as-form');
			Customizer.getPreviewCSS = this.getPreviewCSS;
			Customizer.getPreviewHTMLData = this.getPreviewHTMLData;
			Customizer.init()
		},

		events: function(){
			$(document.body).on( 'click', '.xoo-wsc-basket', this.toggle );
			$(document.body).on( 'click', '.xoo-wsch-close', this.toggle );
		},

		sy: function( key, unit = '' ){
			var value = this.option( 'xoo-wsc-sy-options', key );
			return unit ? value + unit : value;
		},

		gl: function( key ){
			return this.option( 'xoo-wsc-gl-options', key );
		},

		option: function( option, key ){
			if( !this.previewSettingsRecorded ){
				this.settingsInPreview.push( option+'['+key+']' )
			}
			return Customizer.formValues[ option+'['+key+']' ];
		},


		getPreviewCSS: function(){
			return SideCart.setPreviewCSS();
		},

		setPreviewCSS: function(){

			var basketPosition = this.sy('sck-count-pos');

			var basket = {
				[this.sy('sck-position')]: 	this.sy('sck-offset','px'),	
				'right':  					this.sy('sck-hoffset', 'px'),									
				'background-color': 		this.sy('sck-basket-bg'),
				'color': 					this.sy('sck-basket-color'),
				'box-shadow': 				this.sy('sck-basket-sh'),
				'border-radius': 			this.sy('sck-shape') === 'round' ? '50%' : '14px',
				'width': 					this.sy('sck-bk-size','px'),
				'height':  					this.sy('sck-bk-size','px'),
			};

			var basketActive = {
				'right': this.sy('scm-width', 'px')
			}

			var basketActiveRTL = {
				'left': this.sy('scm-width', 'px'),
				'right': 'auto'
			}

			var basketIcon = {
				'font-size': this.sy('sck-size','px')
			}

			var basketCount = {
				'display': 	 		this.sy('sck-show-count') === 'yes' ? 'block' : 'none',
				'background-color': this.sy('sck-count-bg'),
				'color': 			this.sy('sck-count-color'),
				[basketPosition === 'top_right' || basketPosition === 'top_left' ? 'top' : 'bottom']: '-12px',
				[basketPosition === 'top_right' || basketPosition === 'bottom_right' ? 'right' : 'left']: '-12px'
			}

			var container = {
				'max-width': 				this.sy('scm-width','px'),
				'right': 					'-'+this.sy('scm-width','px'),
				'font-family': 				this.sy('scm-font'),
				[this.sy('sck-position')]: 	'0'
			}

			if( this.sy('scm-height') === 'full' ){
				container['top'] = '0';
				container['bottom'] = '0';
			}
			else{
				container['max-height'] = '100vh';
			}


			var header = {
				'background-color': this.sy('sch-bgcolor'),
				'color': 			this.sy('sch-txtcolor'),
				'border-bottom': 	this.sy('sch-border')
			}

			var headerTxt = {
				'font-size': this.sy('sch-head-fsize','px')
			}

			var headerCloseIcon = {
				'font-size': 					this.sy('sch-close-fsize','px'),
				[this.sy('sch-close-align')]: 	'10px'
			}

			var headerTop = {
				'justify-content': this.sy('sch-head-align')
			}

			var body = {
				'background-color': this.sy('scb-bgcolor'),
			}

			var bodyText = {
				'font-size': 	this.sy('scb-fsize','px'),
				'color': 		this.sy('scb-txtcolor')
			}

			var footerBtn = {
				'padding': 				this.sy('scf-btn-padding'),
				'background-color': 	this.sy('scf-btn-bgcolor'),
				'color': 				this.sy('scf-btn-txtcolor'),
				'border': 				this.sy('scf-btn-border'),
			}

			var footerBtnHover = {
				'background-color': 	this.sy('scf-btnhv-bgcolor'),
				'color': 				this.sy('scf-btnhv-txtcolor'),
				'border': 				this.sy('scf-btnhv-border'),
			}

			var footer = {
				'padding': 				this.sy('scf-padding'),
				'background-color': 	this.sy('scf-bgcolor'),
				'color': 				this.sy('scf-txtcolor'),
				'box-shadow': 			this.sy('scf-shadow'),
			}

			var footerFSize = {
				'font-size': 			this.sy('scf-fsize', 'px'),
			}

			var product =  {
				'padding': 				this.sy('scbp-padding'),
				'background-color': 	this.sy('scbp-bgcolor'),
				'margin':  				this.sy('scbp-margin'),
				'border-radius': 		this.sy('scbp-bradius', 'px'),
				'box-shadow': 			this.sy('scbp-shadow'),
			}

			var productImgCol = {
				'width': this.sy('scbp-imgw', '%')
			}


			if( this.sy('scf-stick') !== 'yes' ){
				footer['flex-grow'] 	= 1;
				body['flex-grow'] 		= 0;
				body['overflow'] 		= 'unset';
				container['overflow'] 	= 'auto';
			}



			var selectors = {
				'.xoo-wsc-basket': basket,
				'.xoo-wsc-cart-active .xoo-wsc-basket': basketActive,
				'body.rtl.xoo-wsc-cart-active .xoo-wsc-basket': basketActiveRTL,
				'.xoo-wsc-bki': basketIcon,
				'.xoo-wsc-items-count': basketCount,
				'.xoo-wsc-container,.xoo-wsc-slider': container,
				'.xoo-wsc-header': header,
				'.xoo-wsch-text': headerTxt,
				'span.xoo-wsch-close': headerCloseIcon,
				'.xoo-wsch-top': headerTop,
				'.xoo-wsc-body': body,
				'.xoo-wsc-body, .xoo-wsc-body span.amount, .xoo-wsc-body a': bodyText,
				'.xoo-wsc-ft-buttons-cont a.xoo-wsc-ft-btn, .xoo-wsc-container .xoo-wsc-btn': footerBtn,
				'.xoo-wsc-ft-buttons-cont a.xoo-wsc-ft-btn:hover, .xoo-wsc-container .xoo-wsc-btn:hover': footerBtnHover,
				'.xoo-wsc-footer': footer,
				'.xoo-wsc-footer, .xoo-wsc-footer a, .xoo-wsc-footer .amount': footerFSize,
				'.xoo-wsc-product': product,
				'.xoo-wsc-img-col': productImgCol
			}

			var gridCols = 'auto';

			if( this.sy('scf-btns-row') === 'three' ){
				gridCols = '1fr 1fr 1fr';
			}
			else if( this.sy('scf-btns-row') === 'two_one' ){
				gridCols = '2fr 2fr';
				selectors['a.xoo-wsc-ft-btn:nth-child(3)'] = {
					'grid-column': '1/-1'
				}
			}
			else if( this.sy('scf-btns-row') === 'one_two' ){
				gridCols = '2fr 2fr';
				selectors['a.xoo-wsc-ft-btn:nth-child(1)'] = {
					'grid-column': '1/-1'
				}
			}
			

			selectors['.xoo-wsc-ft-buttons-cont'] = {
				'grid-template-columns': gridCols
			}


			if( this.sy('scbp-display') === 'stretched' ){
				selectors['.xoo-wsc-sm-info'] = {
					'flex-grow': '1',
    				'align-self': 'stretch'
				}
				selectors['.xoo-wsc-sm-left'] = {
					'justify-content': 'space-evenly'
				}
			}
			else{
				selectors['.xoo-wsc-sum-col'] = {
					'justify-content': this.sy('scbp-display')
				}
			}


			var sideCartwidth = parseInt(this.sy('scm-width')) + 100;

			selectors['.xoo-wsc-cart-active .xoo-settings-container'] = {
				'width': 'calc( 100% - '+sideCartwidth+'px )'
			}


			selectors['.xoo-wsc-product dl.variation'] = {
				'display': this.sy('scbp-var-format') === 'one_line' ? 'flex' : 'block'
			}

			if( !this.previewSettingsRecorded ){
				$.each( this.settingsInPreview, function( index, name ){
					var $input = $('[name="'+name+'"]').parents('.xoo-as-setting');
					if( !$input.length ) return true;
					$input.addClass( 'xoo-as-has-preview' );
				} );
				this.previewSettingsRecorded = true;
			}
		
			return selectors;

		},

		getPreviewHTMLData: function(){
			return SideCart.setPreviewHTMLData();
		},

		setPreviewHTMLData: function(){
			var data = {
				basketIcon: 					this.sy('sck-basket-icon'),
				header: {
					showBasketIcon: 			this.gl('sch-show').includes('basket'),
					showCloseIcon: 				this.gl('sch-show').includes('close'),
					closeIcon: 					this.sy('sch-close-icon'),
					heading: 					this.gl('sct-cart-heading')
				},
				product: {
					showPImage: 			this.gl('scb-show').includes('product_image'),
					showPname: 				this.gl('scb-show').includes('product_name'),
					showPdel: 				this.gl('scb-show').includes('product_del'),
					showPtotal: 			this.gl('scb-show').includes('product_total'),
					showPmeta: 				this.gl('scb-show').includes('product_meta'),
					showPprice: 			this.gl('scb-show').includes('product_price'),
					showPqty: 				this.gl('scb-show').includes('product_qty'),
					qtyPriceDisplay: 		this.gl('scbp-qpdisplay'),
					deletePosition: 		this.sy('scbp-delpos'),
					deleteText: 			this.gl('sct-delete'),
					deleteType: 			this.sy('scbp-deltype'),
					deleteIcon:  			this.sy('scb-del-icon'),
					priceType:  			this.gl('scb-prod-price')

				},
				footer: {
					subtotal: 			this.gl('scf-show').includes('subtotal'),
					subtotalLabel: 		this.gl('sct-subtotal'),
					footerTxt: 			this.gl('sct-footer'),
					checkoutTotal: 		this.gl('scf-chkbtntotal-en'),
					buttonsPosition: 	this.sy('scf-button-pos'),
					buttonsText: 		{
						cart: this.gl('sct-ft-cartbtn'),
						checkout: this.gl('sct-ft-chkbtn'),
						continue: this.gl('sct-ft-contbtn')
					}
				}
			}

			data.product.oneLiner = data.product.qtyPriceDisplay === 'one_liner' && data.product.showPqty && data.product.showPprice && data.product.showPtotal;

			return data;
		},

		toggle: function( type ){

			var $activeEls 	= $('body'),
				activeClass = 'xoo-wsc-cart-active';

			if( type === 'show' ){
				$activeEls.addClass(activeClass);
			}
			else if( type === 'hide' ){
				$activeEls.removeClass(activeClass);
			}
			else{
				$activeEls.toggleClass(activeClass);
			}

		}
	}

	SideCart.init();


	function barToggleShipButton(){

		var hasFreeShipping = false,
			$button 		= $('button.xoo-scbchk-add.xoo-scbhk-add-ship');

		$('.xoo-scbhk-chkcont').each(function(index,el){
			if( $(el).find( '.xoo-scb-type select' ).val() === 'freeshipping' ){
				hasFreeShipping = true;
				return true;
			}
		})

		if( hasFreeShipping ){
			$button.hide();
		}
		else{
			$button.show();
		}
	}

	barToggleShipButton();


	$('button.xoo-scbchk-add').click( function(){
		var $cont = $('.xoo-bar-points-cont').append( $('.xoo-bar-points-cont .xoo-scbhk-chkcont:last-child').clone() );
		
		var $addedCheckpoint 	= $cont.find( '.xoo-scbhk-chkcont:last-child' ),
			$pointType 			= $addedCheckpoint.find('.xoo-scb-type select');

		$pointType.find('option').removeAttr('selected');	

		if( $(this).hasClass('xoo-scbhk-add-ship') ){
			$addedCheckpoint.addClass('xoo-scbhk-shipcont');
			$pointType.find('option[value="freeshipping"]').attr('selected', 'selected');
		}
		else{
			$addedCheckpoint.removeClass('xoo-scbhk-shipcont');
			$pointType.find('option:first-child').attr('selected', 'selected');
		}
		$pointType.trigger('change');
		barToggleShipButton();
	} );


	$('body').on( 'click', '.xoo-scbh-del', function(){
		$(this).closest('.xoo-scbhk-chkcont').remove();
		barToggleShipButton();
	} );


	$('body').on( 'change', '.xoo-scb-type select', function(){

		var $giftField = $(this).closest('.xoo-scbar-chkpoint').find('.xoo-scbhk-gift');

		if( $(this).val() === 'gift' ){
			$giftField.show();
		}
		else{
			$giftField.hide();
		}

	} );

	$('.xoo-scb-type select').trigger('change');


	$('select[name="xoo-wsc-gl-options[m-ajax-atc]"]').on( 'change', function(){

		var $catSetting = $(this).closest('.xoo-as-setting').next();

		if( $(this).val() === 'cat_yes' || $(this).val() === 'cat_no' ){
			$catSetting.show();
		}
		else{
			$catSetting.hide();
		}
	} ).trigger('change');


	//Install login popup plugin
	$('.xoo-wsc-el-install').click(function(e){

		e.preventDefault();
		var $cont = $(this).closest('.xoo-wsc-el-links');
		$cont.html( 'Installing.. Please wait..' );

		$.ajax({
			url: xoo_wsc_admin_params.adminurl,
			type: 'POST',
			data: {
				action: 'xoo_wsc_el_install',
				xoo_wsc_nonce: xoo_wsc_admin_params.nonce
			},
			success: function( response ){

				if( response.firsttime_download ){
					$.post(xoo_wsc_admin_params.adminurl, {
						'action': 'xoo_wsc_el_request_just_to_init_save_settings'
					},function(result){
						if( response.notice ){
							$cont.html(response.notice)
						}
					})
				}
				else{
					if( response.notice ){
						$cont.html(response.notice)
					}
				}
				
			}
		})
	})

	
})