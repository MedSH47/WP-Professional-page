<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Isotope
 */
$shadows_arr = array();
$style = $filter = $filter_style = $image_size = $img_proportions = '';
$out = $out_filter_top = $out_filter = $out_content = '';
$filter_all = esc_html__('All', 'solutech');
$filter_title = esc_html__('Services', 'solutech');
$cat = $count = $col = $box_gap = $greyscale = $radius = $is_animate = $css_animation = $animate = $animate_data = $post_type = $taxonomy = $tax_label = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$shadows_arr = pixtheme_vc_get_params_array($atts, 'shadow');
extract( $atts );

$style = $style != '' ? $style : 'bottom-info';
$col = $col != '' ? $col : '3';
$filter = $filter == '' ? 'pix-text-right' : $filter;
$shadow_class = pixtheme_get_shadow($shadows_arr);
$greyscale = ($greyscale == 'off') ? '' : 'pix-img-greyscale';

$css_classes = array(
	$radius,
	$greyscale,
	vc_shortcode_custom_css_class( $css ),
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( array_unique( $css_classes ) ) ), $this->settings['base'], $atts );

$image_size = $img_proportions;
if($col == 3){
    $image_size .= '-col-3';
} elseif($col > 3) {
    $image_size .= '-col-4';
}
$image_size .= pixtheme_retina() ? '-retina' : '';

$args = array();

if($post_type == 'pix-team') {
    $taxonomy = 'pix-team-cat';
    $cat = $team_cat;
    $args = array(
        'post_type' => 'pix-team',
        'orderby' => 'menu_order',
        'tax_query' => array(
            array(
                'taxonomy' => 'pix-team-cat',
                'field'    => 'slug',
                'terms'    => explode(',', $team_cat)
            )
        ),
        'order' => 'ASC'
    );
} elseif($post_type == 'pix-service') {
    $taxonomy = 'pix-service-cat';
    $cat = $service_cat;
    $args = array(
        'post_type' => 'pix-service',
        'orderby' => 'menu_order',
        'tax_query' => array(
            array(
                'taxonomy' => 'pix-service-cat',
                'field'    => 'slug',
                'terms'    => explode(',', $service_cat )
            )
        ),
        'order' => 'ASC'
    );
} elseif($post_type == 'product') {
    $taxonomy = 'product_cat';
    $cat = $product_cat;
    $args = array(
        'post_type' => 'product',
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );
    if( !empty($product_cat) ){
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => explode(',', $product_cat )
            )
        );
    }

} else {
    $taxonomy = 'pix-portfolio-cat';
    $cat = $portfolio_cat;
    $args = array(
        'post_type' => 'pix-portfolio',
        'orderby' => 'menu_order',
        'tax_query' => array(
            array(
                'taxonomy' => 'pix-portfolio-cat',
                'field'    => 'slug',
                'terms'    => explode(',', $portfolio_cat )
            )
        ),
        'order' => 'ASC',

    );
}

if ( is_numeric( $count ) && $count > 0 ) {
    $args['posts_per_page'] = $count;
}
else {
    $args['posts_per_page'] = -1;
}


$wp_query = new WP_Query( $args );

if ( $wp_query->have_posts() ) {

    if($filter != 'pix-hide') {
        if($filter_style == 'top-filter'){
            $out_filter_top .= '
            <div class="container">
                <div class="col-md-12 ' . esc_attr($filter) . '">
                    <div class="pix-' . esc_attr($filter_style) . ' pix-filter-head">
                        <ul class="pix-filter">';
                $categories = get_terms(array('taxonomy' => $taxonomy, 'slug' => explode(',', $cat)));
                if (!empty($categories)) {
                    $out_filter_top .= '
                            <li class="active"><a href="#" data-filter="*" class="pix-filter-link">' . $filter_all . '</a></li>';
                    foreach ($categories as $category) {
                        $group = $category->slug;
                        $out_filter_top .= '
                            <li><a href="#" data-filter=".' . esc_attr($group) . '" class="pix-filter-link">' . wp_kses_post($category->name) . '</a></li>';
                    }
                }
                $out_filter_top .= '
                        </ul>
                    </div>
                </div>
            </div>';
        } else {
            $out_filter = '
            <div class="pix-sidebar-box pix-' . esc_attr($filter_style) . ' pix-filter-head ' . esc_attr($filter) . '">
                <div class="pix-sidebar-form">
                    <div class="pix-sidebar-box-title">
                        <h3 class="pix-h3">'.$filter_title.'<span class="sep-element"></span></h3>
                    </div>
                    <ul class="pix-filter">';
                    $categories = get_terms(array('taxonomy' => $taxonomy, 'slug' => explode(',', $cat)));
                    if (!empty($categories)) {
                        $out_filter .= '
                        <li class="active"><a href="#" data-filter="*" class="pix-filter-link">' . $filter_all . '</a></li>';
                        foreach ($categories as $category) {
                            $group = $category->slug;
                            $out_filter .= '
                        <li><a href="#" data-filter=".' . esc_attr($group) . '" class="pix-filter-link">' . wp_kses_post($category->name) . '</a></li>';
                        }
                    }
                    $out_filter .= '
                    </ul>
                </div>
            </div>';
        }
    }

    $i = $offset = 0;
    while ( $wp_query->have_posts() ) :
        $wp_query->the_post();
        $i++;

        $cats = wp_get_object_terms(get_the_ID(), $taxonomy);
        $cat_slugs = array();
        if ( ! empty($cats) ) {
            foreach ( $cats as $cat ) {
                $cat_slugs[] = $cat->slug;

                if($cat->parent > 0){
                    $cat_parent = get_term($cat->parent, $taxonomy);
                    if(!in_array($cat_parent->slug, $cat_slugs)){
                        $cat_slugs[] = $cat_parent->slug;
                    }
                }
            }
        }
        $thumbnail = '<div class="pix-img-wrapper">'.get_the_post_thumbnail(get_the_ID(), $image_size, array('class' => 'img-responsive')).'</div>';
        $thumbnail_full = get_the_post_thumbnail_url(get_the_ID(), 'full');

        // potfolio category list linked
        $portfolio_link_term = pixtheme_get_post_terms( array( 'taxonomy' => $taxonomy, 'items_wrap' => '%s' ) );


        if($css_animation != '' && $is_animate == 'on') {
            $animate = 'animated';
            $animate .= !empty($wow_duration) || !empty($wow_delay) || !empty($wow_offset) || !empty($wow_iteration) ? ' wow ' . esc_attr($css_animation) : '';
            $animate_data = ' data-animation="'.esc_attr($css_animation).'"';
            $wow_group = !empty($wow_group) ? $wow_group : 1;
            $wow_group_delay = !empty($wow_group_delay) ? $wow_group_delay : 0;
            $wow_delay = !empty($wow_delay) ? $wow_delay : 0;
            $animate_data .= !empty($wow_duration) ? ' data-wow-duration="'.esc_attr($wow_duration).'s"' : '';
            $animate_data .= !empty($wow_delay) || $wow_group_delay > 0 ? ' data-wow-delay="'.esc_attr($wow_delay + $offset * $wow_group_delay).'s"' : '';
            $animate_data .= !empty($wow_offset) ? ' data-wow-offset="'.esc_attr($wow_offset).'"' : '';
            $animate_data .= !empty($wow_iteration) ? ' data-wow-iteration="'.esc_attr($wow_iteration).'"' : '';

            $offset = $i % $wow_group == 0 ? ++$offset : $offset;

        }
        
        $out_content .= '
                <div class="pix-isotope-item pix-box '.esc_attr($shadow_class).' '. esc_attr(implode(' ', $cat_slugs)) . ' '.esc_attr($animate).'" '.wp_kses_post($animate_data).'>';
        
        if( $style == 'hover-info' ){
            if($post_type == 'product') {
                global $product;

                $sale = '';
                if ( $product->is_on_sale() ) {
                    $sale = '
                    <div class="pix-box-sticker">'.esc_html__('sale', 'solutech').'</div>';
                }

                $out_content .= '
                    <div class="pix-hover-container">
                        <h3><a href="' . esc_url(get_the_permalink()) . '" class="pix-title-link">' . wp_kses_post(get_the_title()) . '</a></h3>
                        <div class="pix-box-price">
                            '. wp_kses_post($product->get_price_html()).'
                        </div>
                        <div class="pix-box-btn">
                        '.apply_filters( 'woocommerce_loop_add_to_cart_link',
                            sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button ajax_add_to_cart %s product_type_%s"><span>%s</span></a>',
                                esc_url( $product->add_to_cart_url() ),
                                esc_attr( $product->get_id() ),
                                esc_attr( $product->get_sku() ),
                                esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                esc_attr( $product->get_type() ),
                                esc_html( $product->add_to_cart_text() )
                            ),
                        $product ).'
                        </div>
                    </div>
                    ' . wp_kses_post($thumbnail) . '
                    ' . wp_kses_post($sale);

            } else {
                $out_content .= '
                    <div class="pix-hover-container">
                        <h3><a href="' . esc_url(get_the_permalink()) . '" class="pix-title-link">' . wp_kses_post(get_the_title()) . '</a></h3>
                        <p>' . wp_kses_post($portfolio_link_term) . '</p>
                    </div>
                    ' . wp_kses_post($thumbnail);
            }
            
        } elseif($style == 'bottom-desc') {

            if($post_type == 'product') {
                global $product;

                $sale = '';
                if ( $product->is_on_sale() ) {
                    $sale = '<div class="pix-box-sticker">'.esc_html__('sale', 'solutech').'</div>';
                }

                $out_content .= '
                    <div class="pix-box-img">
                        <a href="' . esc_url(get_the_permalink()) . '" class="pix-image-link">
                            ' . wp_kses_post($thumbnail) . '
                            ' . wp_kses_post($sale) . '
                        </a>
                    </div>
                    <div class="pix-box-name">
                        <a href="' . esc_url(get_the_permalink()) . '" class="pix-title-link">' . wp_kses_post(get_the_title()) . '</a>
                    </div>
                    <div class="pix-box-footer">
                        <div class="pix-box-buy">
                            '.
                        apply_filters( 'woocommerce_loop_add_to_cart_link',
                            sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button ajax_add_to_cart %s product_type_%s"><span>%s</span></a>',
                                esc_url( $product->add_to_cart_url() ),
                                esc_attr( $product->get_id() ),
                                esc_attr( $product->get_sku() ),
                                esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                esc_attr( $product->get_type() ),
                                esc_html( $product->add_to_cart_text() )
                            ),
                        $product ).'
                        </div>
                        <div class="pix-box-price">
                            '. wp_kses_post($product->get_price_html()).'
                        </div>
                    </div>';
            } else {
                $out_content .= '
                    <div class="pix-box-img">
                        <a href="' . esc_url(get_the_permalink()) . '" class="pix-image-link">
                            <div class="pix-img-wrapper">' . wp_kses_post($thumbnail) . '</div>
                        </a>
                    </div>
                    <div class="pix-box-text">
                        <div class="pix-box-name">
                            <a href="' . esc_url(get_the_permalink()) . '" class="pix-title-link">' . wp_kses_post(get_the_title()) . '</a>
                        </div>
                        '.pixtheme_limit_words(get_the_excerpt(), 20, 'p').'
                    </div>
                    <span class=""><a href="'.esc_url(get_permalink(get_the_ID())).'" class="pix-more-link"></a></span>';
            }
        } else {

            if($post_type == 'product') {
                global $product;
                
                $sale = '';
                if ( $product->is_on_sale() ) {
                    $sale = '<div class="pix-box-sticker">'.esc_html__('sale', 'solutech').'</div>';
                }

                $out_content .= '
                    <div class="pix-box-img">
                        <a href="' . esc_url(get_the_permalink()) . '" class="pix-image-link">
                            ' . wp_kses_post($thumbnail) . '
                            ' . wp_kses_post($sale) . '
                        </a>
                    </div>
                    <div class="pix-box-name">
                        <a href="' . esc_url(get_the_permalink()) . '" class="pix-title-link">' . wp_kses_post(get_the_title()) . '</a>
                    </div>
                    <div class="pix-box-footer">
                        <div class="pix-box-buy">
                            '.
                        apply_filters( 'woocommerce_loop_add_to_cart_link',
                            sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button ajax_add_to_cart %s product_type_%s"><span>%s</span></a>',
                                esc_url( $product->add_to_cart_url() ),
                                esc_attr( $product->get_id() ),
                                esc_attr( $product->get_sku() ),
                                esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                esc_attr( $product->get_type() ),
                                esc_html( $product->add_to_cart_text() )
                            ),
                        $product ).'
                        </div>
                        <div class="pix-box-price">
                            '. wp_kses_post($product->get_price_html()).'
                        </div>
                    </div>';
            } else {
                $out_content .= '
                    <div class="pix-box-img">
                        <a href="' . esc_url(get_the_permalink()) . '" class="pix-image-link">
                            ' . wp_kses_post($thumbnail) . '
                        </a>
                    </div>
                    <div class="pix-box-name">
                        <a href="' . esc_url(get_the_permalink()) . '" class="pix-title-link">' . wp_kses_post(get_the_title()) . '</a>
                    </div>';
            }
        }
        $out_content .= '
                </div>';

    endwhile;

}

if($filter != 'pix-hide' && $filter_style == 'sidebar-out-filter') {
    $right_filter = $left_filter = '';
    $filter_content = '
        <div class="col pix-filter-sidebar-out pix-col-' . esc_attr($col) . ' pix-gap-' . esc_attr($box_gap) . ' ' . esc_attr($filter) . '">
        ' . wp_kses_post($out_filter) . '
        </div>';
    if($filter == 'pix-text-right'){
        $right_filter = $filter_content;
    } else {
        $left_filter = $filter_content;
    }
$out = '
<section class="pix-isotope pix-' . esc_attr($post_type) . ' ' . esc_attr($css_class) . '">
    <div class="row no-gutters">
        ' . wp_kses_post($left_filter) . '
        <div class="col pix-isotope-items pix-' . esc_attr($style) . ' '.esc_attr($img_proportions).' pix-col-' . esc_attr($col-1) . ' pix-gap-' . esc_attr($box_gap) . '">
            <div class="pix-gutter-sizer"></div>
            ' . wp_kses_post($out_content) . '
        </div>
        ' . wp_kses_post($right_filter) . '
    </div>
</section>';
} else {
$out = '
<section class="pix-isotope pix-' . esc_attr($post_type) . ' ' . esc_attr($css_class) . '">
    ' . wp_kses_post($out_filter_top) . '
    <div class="pix-isotope-items pix-' . esc_attr($style) . ' '.esc_attr($img_proportions).' pix-col-' . esc_attr($col) . ' pix-gap-' . esc_attr($box_gap) . '">
        <div class="pix-gutter-sizer"></div>
        ' . wp_kses_post($out_filter) . '
        ' . wp_kses_post($out_content) . '
    </div>
</section>';
}

$out .= $this->endBlockComment('common_isotope');

wp_reset_postdata();

if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo wp_kses_post($out);
}