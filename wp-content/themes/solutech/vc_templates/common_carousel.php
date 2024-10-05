<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Carousel
 */
$shadows_arr = array();
$out = $style = $cat = $count = $col = $box_gap = $navigation = $greyscale = $radius = $css_animation = $animate = $animate_data = $taxonomy = $tax_label = $img_proportions = $hover_icon = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$shadows_arr = pixtheme_vc_get_params_array($atts, 'shadow');
extract( $atts );

$args = array();

$style = $style != '' ? $style : 'hover-info';
$col = $col != '' ? $col : '3';
$shadow_class = pixtheme_get_shadow($shadows_arr);
$greyscale = ($greyscale == 'off') ? '' : 'pix-img-greyscale';
$hover_icon = ( $hover_icon != '' ) ? 'pix-hover-icon-'.$hover_icon : '';
$filter_class = '';

$image_size = $img_proportions;
if($col == 3){
    $image_size .= '-col-3';
} elseif($col > 3) {
    $image_size .= '-col-4';
}
$image_size .= pixtheme_retina() ? '-retina' : '';

$out = '
    <section class="pix-carousel pix-gallery '.esc_attr($post_type).' pix-' . esc_attr($style) . '-container '.esc_attr($radius).' '.esc_attr($greyscale).'">
';

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

$tax = get_taxonomy($taxonomy);

$wp_query = new WP_Query( $args );


if ( $wp_query->have_posts() ) {
    
    if($navigation == 'nav') {
        $filter_cats = '';
        $filter_class = 'pix-filter';
        if ( ! empty($cat) ) {
            foreach ( explode(',', $cat ) as $slug ) {
                $term = get_term_by( 'slug', $slug, $taxonomy );
                $filter_cats .= '<a href="#" class="item" data-owl-filter=".'.esc_attr($slug).'">'.$term->name.'</a>';
            }
        }
        $out .= '
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="pix-section-top-line">
                        <div class="pix-section-title text-left">
                            <h2 class="pix-title-h2">' . wp_kses_post($title) . '</h2>
                        </div>
                        <div class="pix-gallery-cats owl-filter-bar">
                            <a href="#" class="item pix-active" data-owl-filter="*">'.esc_html__('All', 'solutech').'</a>
                            ' . wp_kses_post($filter_cats) . '
                        </div>
                        <div class="pix-gallery-slider-controls">
                            <div class="pix-slider-prev"></div>
                            <div class="pix-slider-next"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }
    $out .= '
        <div class="pix-gallery-slider '.esc_attr($filter_class).' owl-carousel" data-col="'.esc_attr($col).'" data-gap="'.esc_attr($box_gap).'" data-nav="'.esc_attr($navigation).'">
    ';

    $i = $offset = 0;
    while ( $wp_query->have_posts() ) :
        $wp_query->the_post();
        $i++;

        $cats = wp_get_object_terms(get_the_ID(), $taxonomy);
        $cat_titles = $cat_titles_span = '';
        $cat_slugs = array();
        if ( ! empty($cats) ) {
            foreach ( $cats as $cat ) {
                $cat_titles .= '<a href="'.get_term_link($cat).'" class="pix-button pix-round pix-h-s pix-v-xs pix-font-s">'.$cat->name.'</a>';
                $cat_titles_span .= '<span>'.$cat->name.'</span>';
                
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

        // category list linked
        $terms_links = pixtheme_get_post_terms( array( 'taxonomy' => $taxonomy, 'items_wrap' => '%s' ) );

        if($css_animation != '') {
            //$animate = 'class="';
            $animate = 'animated';
            $animate .= !empty($wow_duration) || !empty($wow_delay) || !empty($wow_offset) || !empty($wow_iteration) ? ' wow ' . esc_attr($css_animation) : '';
            //$animate .= '"';
            $animate_data .= ' data-animation="'.esc_attr($css_animation).'"';
            $wow_group = !empty($wow_group) ? $wow_group : 1;
            $wow_group_delay = !empty($wow_group_delay) ? $wow_group_delay : 0;
            $animate_data .= !empty($wow_duration) ? ' data-wow-duration="'.esc_attr($wow_duration).'s"' : '';
            $animate_data .= !empty($wow_delay) ? ' data-wow-delay="'.esc_attr($wow_delay + $offset * $wow_group_delay).'s"' : '';
            $animate_data .= !empty($wow_offset) ? ' data-wow-offset="'.esc_attr($wow_offset).'"' : '';
            $animate_data .= !empty($wow_iteration) ? ' data-wow-iteration="'.esc_attr($wow_iteration).'"' : '';

            $offset = $i % $wow_group == 0 ? ++$offset : $offset;
        }
        $out .= '
            <div class="pix-gallery-item pix-' . esc_attr($style) . ' ' . esc_attr($post_type) . ' pix-overlay-container '. esc_attr(implode(' ', $cat_slugs)) . '">';
        if( $style == 'hover-info' ) {
            $out .= '
                <div class="pix-box-img">
                    <a href="' . esc_url(get_the_permalink()) . '" class="pix-image-link">
                        <div class="pix-overlay '.esc_attr($hover_icon).'"></div>
                        ' . wp_kses_post($thumbnail) . '
                    </a>
                    <div class="pix-hover-item pix-top pix-translate">' . wp_kses_post($cat_titles) . '</div>
                    <div class="pix-hover-item pix-bottom pix-gallery-item-name pix-translate"><a class="pix-shadow-link" href="' . esc_url(get_the_permalink()) . '">' . wp_kses_post(get_the_title()) . '</a></div>
                </div>
            ';
        } elseif($style == 'bottom-desc') {
            $out .= '
                <div class="pix-box-img">
                    <a href="' . esc_url(get_the_permalink()) . '" class="pix-image-link">
                        <div class="pix-overlay '.esc_attr($hover_icon).'"></div>
                        ' . wp_kses_post($thumbnail) . '
                    </a>
                    <div class="pix-hover-item pix-top pix-translate">' . wp_kses_post($cat_titles) . '</div>
                    <div class="pix-hover-item pix-bottom pix-gallery-item-name pix-translate"><a class="pix-shadow-link" href="' . esc_url(get_the_permalink()) . '">' . wp_kses_post(get_the_title()) . '</a></div>
                </div>
            ';
        } else {
            if($post_type == 'product') {
                global $product;

                $sale = '';
                if ( $product->is_on_sale() ) {
                    $sale = '<div class="pix-box-sticker">'.esc_html__('sale', 'solutech').'</div>';
                }

                $out .= '
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
                $out .= '
                    <div class="pix-box-img">
                        <a href="' . esc_url(get_the_permalink()) . '" class="pix-image-link">
                            <div class="pix-overlay '.esc_attr($hover_icon).'"></div>
                            ' . wp_kses_post($thumbnail) . '
                        </a>
                        <div class="pix-hover-item pix-top pix-translate">' . wp_kses_post($cat_titles) . '</div>
                        <div class="pix-hover-item pix-bottom pix-translate"><p>'.pixtheme_limit_words(get_the_excerpt(), 15).'</p></div>
                    </div>
                    <div class="pix-box-name">
                        <a class="pix-title-link" href="' . esc_url(get_the_permalink()) . '">' . wp_kses_post(get_the_title()) . '</a>
                    </div>
                ';
            }
            
        }
        
        $out .= '
            </div>';

    endwhile;

    $out .= '
        </div>
    ';
}

$out .= '
    </section>';


wp_reset_postdata();

if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo wp_kses_post($out);
}