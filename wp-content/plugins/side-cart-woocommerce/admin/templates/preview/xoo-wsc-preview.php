<?php

$products = wc_get_products( array(
	'limit' => 3,
) );


$productHTML = empty( $products ) ? 'Please create a product' :  '';

foreach ($products as $product) {

	$variable 	= false;
	$meta 		= '';

	if( $product->is_type('variable') && !empty( $product->get_available_variations() ) ){
		$variation 	= wc_get_product( $product->get_available_variations()[0]['variation_id'] );
		if( $variation ){
			$product 	= $variation;
			$meta 		= wc_get_formatted_variation($product);
		}
		
	}
	
	$qty = rand(1,10);

	$productData = array(
		'product_thumbnail' 	=> $product->get_image(),
		'product_name' 			=> $product->get_title(),
		'product_price' 		=> wc_price( $product->get_price() ),
		'product_sale_price' 	=> $product->get_price_html(),
		'product_quantity' 		=> $qty,
		'product_subtotal' 		=>  wc_price( $qty * (int) $product->get_price() ),
		'product_meta' 			=> $meta
	);


	$productHTML .= xoo_wsc_helper()->get_template( 'xoo-wsc-product-preview.php', $productData, XOO_WSC_PATH.'/admin/templates/preview', true );
}


?>

<div class="xoo-as-preview-style"></div>
<div class="xoo-as-preview"></div>

<script type="text/html" id="tmpl-xoo-as-preview">

	<div class="xoo-wsc-container">

		<div class="xoo-wsc-basket">

			<span class="xoo-wsc-items-count">5</span>
			
			<span class="xoo-wsc-bki {{{data.basketIcon}}}"></span>

		</div>

		<div class="xoo-wsc-header">
			<?php xoo_wsc_helper()->get_template( 'xoo-wsc-header-preview.php', array(), XOO_WSC_PATH.'/admin/templates/preview' ); ?>
		</div>


		<div class="xoo-wsc-body">

			<div class="xoo-wsc-products">
				<?php echo $productHTML; ?>
			</div>

		</div>

		<div class="xoo-wsc-footer">
			<?php xoo_wsc_helper()->get_template( 'xoo-wsc-footer-preview.php', array(), XOO_WSC_PATH.'/admin/templates/preview' ); ?>
		</div>
	</div>

</script>