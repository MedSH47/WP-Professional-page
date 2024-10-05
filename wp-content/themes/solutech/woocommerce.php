<?php
/* Woocommerce template. */

if ( is_product() ) {
    $pix_layout = pixtheme_get_layout(get_post_type(), get_the_ID());
} elseif( is_shop() ){
    $pix_layout = pixtheme_get_layout('shop');
} elseif( is_product_category() || is_product_tag() ) {
    $pix_layout = pixtheme_get_layout('product-cat');
}
$pix_width_class = pixtheme_get_layout_width( get_post_type() );

get_header(); ?>


<section class="blog" >
    <div class="container  <?php echo esc_attr($pix_width_class)?>">
		<div class="row">

            <?php pixtheme_show_sidebar( 'left', $pix_layout['layout'], $pix_layout['sidebar'] ); ?>

            <div class="rtd <?php if ( $pix_layout['layout'] != 1 ) : ?>col-xl-9 col-lg-8<?php endif; ?> col-12 <?php echo esc_attr($pix_layout['class'])?>">

                <?php  woocommerce_content(); ?>

            </div>

            <?php pixtheme_show_sidebar( 'right', $pix_layout['layout'], $pix_layout['sidebar'] ); ?>

		</div>
	</div>
</section>

<?php get_footer();?>
