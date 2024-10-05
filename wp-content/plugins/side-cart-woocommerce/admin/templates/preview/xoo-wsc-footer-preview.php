<?php

$subtotal = wc_price(100);

?>

<div class="xoo-wsc-ft-totals">

	<# if ( data.footer.subtotal ) { #>
	
	<div class="xoo-wsc-ft-amt">
		<span class="xoo-wsc-ft-amt-label">{{data.footer.subtotalLabel}}</span>
		<span class="xoo-wsc-ft-amt-value"><?php echo $subtotal ?></span>
	</div>

	<# } #>

</div>

<# if ( data.footer.footerTxt ) { #>
<span class="xoo-wsc-footer-txt">{{{data.footer.footerTxt}}}</span>
<# } #>


<div class="xoo-wsc-ft-buttons-cont">

	<# _.each( data.footer.buttonsPosition, function( key ) { #>
		<# if( data.footer.buttonsText[key] ){ #>
			<a href="#" class="xoo-wsc-ft-btn">{{{data.footer.buttonsText[key]}}} <# if( key === 'checkout' && data.footer.checkoutTotal === 'yes' ){ #> - <?php echo $subtotal; ?> <# } #></a>
		<# } #>
	<# }) #>

</div>

