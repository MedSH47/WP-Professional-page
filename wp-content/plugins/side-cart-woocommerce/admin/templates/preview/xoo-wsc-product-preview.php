<div class="xoo-wsc-product">

	<div class="xoo-wsc-img-col">

		<# if ( data.product.showPImage ) { #>
			<?php echo $product_thumbnail; ?>
		<# } #>

		<# if ( data.product.showPdel && "image" === data.product.deletePosition ) { #>

			<# if ( "icon" === data.product.deleteType ) { #>
				<span class="xoo-wsc-smr-del {{data.product.deleteIcon}}"></span>
			<# }else{ #>
				<span class="xoo-wsc-smr-del xoo-wsc-del-txt">{{data.product.deleteText}}</span>
			<# } #>

		<# } #>

	</div>



	<div class="xoo-wsc-sum-col">

		<div class="xoo-wsc-sm-info">

			<div class="xoo-wsc-sm-left">

				<# if ( data.product.showPname ) { #>
					<span class="xoo-wsc-pname"><?php echo $product_name; ?></span>
				<# } #>
				
				<# if ( data.product.showPmeta ) { #>
					<?php echo $product_meta ?>
				<# } #>


				<# if ( data.product.oneLiner ) { #>

					<div class="xoo-wsc-qty-price">
						<span><?php echo $product_quantity; ?></span>
						<span>X</span>
						<span>
							<# if( data.product.priceType === "actual" ){ #>
								<?php echo $product_price; ?>
							<# }else{ #>
								<?php echo $product_sale_price ?>
							<# } #>
						</span>
						<span>=</span>
						<span><?php echo $product_subtotal ?></span>
					</div>

				<# }else{ #>

					<# if ( data.product.showPqty ) { #>
						<span class="xoo-wsc-sml-qty"><?php _e( 'Qty:', 'side-cart-woocommerce' ) ?> <?php echo $product_quantity; ?></span>
					<# } #>

					<# if ( data.product.showPprice ) { #>
						<div class="xoo-wsc-pprice">
							<?php echo __( 'Price: ', 'side-cart-woocommerce' ); ?>
								<# if( data.product.priceType === "actual" ){ #>
								<?php echo $product_price; ?>
							<# }else{ #>
								<?php echo $product_sale_price ?>
							<# } #>
						</div>
					<# } #>

				<# } #>


			</div>

			<!-- End Quantity -->


			<div class="xoo-wsc-sm-right">

				<# if ( data.product.showPdel && "default" === data.product.deletePosition ) { #>

					<# if ( "icon" === data.product.deleteType  ) { #>
						<span class="xoo-wsc-smr-del {{data.product.deleteIcon}}"></span>
					<# }else{ #>
						<span class="xoo-wsc-smr-del xoo-wsc-del-txt">{{data.product.deleteText}}</span>
					<# } #>

				<# } #>

				<# if ( data.product.showPtotal && !data.product.oneLiner ) { #>
					<span class="xoo-wsc-smr-ptotal"><?php echo $product_subtotal ?></span>
				<# } #>


			</div>

		</div>

	</div>

</div>