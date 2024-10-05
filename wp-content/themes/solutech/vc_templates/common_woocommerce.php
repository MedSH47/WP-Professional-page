<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $count
 * @var $cats
 * @var $carousel
 * @var $controls
 * @var $min_slides
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Woocommerce
 */

$args = array();
$carousel_arr = array();
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$carousel_arr = pixtheme_vc_get_params_array($atts, 'carousel');
extract( $atts );

$per_page = is_numeric($per_page) ? $per_page : 3;

if( $cats == '' ):
	$out = '<p>'.esc_html__('No categories selected. To fix this, please login to your WP Admin area and set the categories you want to show by editing this shortcode and setting one or more categories in the multi checkbox field "Categories".', 'solutech');
else: 

$options_arr = pixtheme_get_carousel($carousel_arr, '');
$data_carousel = empty($options_arr) ? '' : 'data-owl-options=\''.json_encode($options_arr).'\'';
$carousel_class = !empty($options_arr) ? 'owl-carousel owl-theme' : 'disable-owl-carousel pix-col-'.esc_attr($per_page);

$out = '	
	<div class="woocommerce '.esc_attr($carousel_class).' owl-theme" '.wp_kses_post($data_carousel).'>
	';

if($select_type != 'ids'){
	$product_cat_to_query = get_objects_in_term( explode( ",", $cats ), 'product_cat');
	$args = array(
        'post_type' => 'product',
        'orderby' => 'menu_order',
        'post__in' => $product_cat_to_query,
        'order' => 'ASC',
    );
	if( is_numeric($count) )
		$args['showposts'] = $count;
	else
		$args['posts_per_page'] = -1;
} else {
    $args = array(
        'post_type' => 'product',
        'post__in' => $items,
        'orderby' => 'post__in',
        'posts_per_page' => -1
    );
}
	
$wp_query = new WP_Query( $args );
				 					
if ($wp_query->have_posts()):
    while ($wp_query->have_posts()) :
        $wp_query->the_post();
        global $product;

        $cats = wp_get_object_terms(get_the_ID(), 'product_cat');

        if ($cats){
            $cat_slugs = '';
            $cat_names = '';
            foreach( $cats as $cat ){
                $cat_slugs .= $cat->slug . " ";
                $cat_names .= $cat->name . ", ";
            }
            $cat_names = substr($cat_names, 0, -2);
        }

        $link = get_the_permalink($product->get_id());
        $thumbnail = get_the_post_thumbnail(get_the_ID(), 'shop_catalog', array('class' => 'cover'));

        $attach_ids = $product->get_gallery_image_ids();
        $attachment_count = count( $product->get_gallery_image_ids() );
        if($attachment_count > 0){
            $image_link = wp_get_attachment_url( $attach_ids[0] );
            $default_attr = array(
                'class'	=> "slider_img",
                'alt'   => get_the_title($product->get_id()),
            );
            $image = wp_get_attachment_image( $attach_ids[0], 'shop_catalog', false, $default_attr);

        }
$out .= '
    <div class="pix-product">
        <div class="woo-item-grid">
            <a href="'.esc_url($link).'">
                '.$thumbnail.'
            </a>';
            $out .= apply_filters( 'woocommerce_loop_add_to_cart_link',
                sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button ajax_add_to_cart %s product_type_%s"><span>%s</span></a>',
                    esc_url( $product->add_to_cart_url() ),
                    esc_attr( $product->get_id() ),
                    esc_attr( $product->get_sku() ),
                    esc_attr( isset( $quantity ) ? $quantity : 1 ),
                    $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                    esc_attr( $product->get_type() ),
                    esc_html( $product->add_to_cart_text() )
                ),
            $product );
        $out .= '
        </div>	
        <div class="woo-item-footer">
            <div class="product-name"><a href="'.esc_url($link).'">'.wp_kses_post(get_the_title($product->get_id())).'</a></div>
	        <span class="price">'. wp_kses_post($product->get_price_html()).'</span>
        </div>		
    </div>						
    ';

    endwhile;
endif;

wp_reset_postdata();

$out .= '            
	</div>
	';

endif;

if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo wp_kses_post($out);
}