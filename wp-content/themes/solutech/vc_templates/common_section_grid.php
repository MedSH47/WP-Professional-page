<?php
global $post;
/**
 * Shortcode attributes
 * @var $atts
 * @var $carousel
 * @var $slide_type
 * @var $count
 * @var $models
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Section_Fives
 */
$out = $post_type = $order = $items = $position = $greyscale = '';
$count = 5;
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$style = $style != '' ? $style : 'grid-fives';
$post_type = $post_type != '' ? $post_type : 'services';
$greyscale = ($greyscale == 'off') ? '' : 'pix-img-greyscale';
$args = array();
if($style == 'grid-three'){
    $count = 3;
} elseif($style == 'grid-four'){
    $count = 4;
} elseif($style == 'grid-eight'){
    $count = 8;
}


if( $order == 'ids' ) :

	$args = array(
		'post_type' => $post_type,
		'orderby' => 'post__in',
		'post__in' => explode(',', $items),
		'showposts' => $count,
	);

else :
    
    if($post_type == 'team') {
        $taxonomy = 'pixspecialty';
        $cat = $pixspecialty;
        $args = array(
            'post_type' => 'pixteam',
            'orderby' => 'menu_order',
            'tax_query' => array(
                array(
                    'taxonomy' => 'pixspecialty',
                    'field'    => 'slug',
                    'terms'    => explode(',', $pixspecialty)
                )
            ),
            'order' => 'ASC'
        );
    } elseif($post_type == 'services') {
        $taxonomy = 'services_category';
        $cat = $services_category;
        $args = array(
            'post_type' => 'services',
            'orderby' => 'menu_order',
            'tax_query' => array(
                array(
                    'taxonomy' => 'services_category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $services_category )
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
        $taxonomy = 'portfolio_category';
        $cat = $portfolio_category;
        $args = array(
            'post_type' => 'portfolio',
            'orderby' => 'menu_order',
            'tax_query' => array(
                array(
                    'taxonomy' => 'portfolio_category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $portfolio_category )
                )
            ),
            'order' => 'ASC',
        
        );
    }

    if($post_type == 'portfolio'){
        $args = array(
            'post_type' => 'portfolio',
            'orderby' => 'menu_order',
            'tax_query' => array(
                array(
                    'taxonomy' => 'portfolio_category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $portfolio_category )
                )
            ),
            'order' => 'ASC',

        );
    } else {
        $args = array(
            'post_type' => 'services',
            'orderby' => 'menu_order',
            'tax_query' => array(
                array(
                    'taxonomy' => 'services_category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $services_category )
                )
            ),
            'order' => 'ASC'
        );
    }
    $args['posts_per_page'] = $count;

endif;

$wp_query = new WP_Query( $args );

if ($wp_query->have_posts()):
    
    $i = 0;
    $out_items = array('','','','','');
    while ($wp_query->have_posts()) :

        $wp_query->the_post();

        $cats = $post_type == 'portfolio' ? wp_get_object_terms($post->ID, 'portfolio_category') : wp_get_object_terms($post->ID, 'services_category');
        $cat_titles = '';
        if ( ! empty($cats) ) {
            foreach ( $cats as $cat ) {
                $cat_titles .= $cat->name . ", ";
            }
            $cat_titles = substr($cat_titles, 0, -2);
        }
        $pixtheme_portfolio_linked_list_cats = $post_type == 'portfolio' ? pixtheme_get_post_terms( array( 'taxonomy' => 'portfolio_category', 'items_wrap' => '%s' ) ) : pixtheme_get_post_terms( array( 'taxonomy' => 'services_category', 'items_wrap' => '%s' ) );

        $social_1 = $social_2 = $social_3 = $social_4 = '';
        if( $post_type == 'portfolio' ){
            $social_1 = get_post_meta(get_the_ID(), 'pix_social_1', 1) == '' ? '' : '<li class="social_1"><a href="'.esc_url(get_post_meta(get_the_ID(), 'pix_social_1', 1)).'" target="_blank"><i class="icon-social-facebook"></i></a></li>';
            $social_2 = get_post_meta(get_the_ID(), 'pix_social_2', 1) == '' ? '' : '<li class="social_2"><a href="'.esc_url(get_post_meta(get_the_ID(), 'pix_social_2', 1)).'" target="_blank"><i class="icon-social-twitter"></i></a></li>';
            $social_3 = get_post_meta(get_the_ID(), 'pix_social_3', 1) == '' ? '' : '<li class="social_3"><a href="'.esc_url(get_post_meta(get_the_ID(), 'pix_social_3', 1)).'" target="_blank"><i class="icon-social-youtube"></i></a></li>';
            $social_4 = get_post_meta(get_the_ID(), 'pix_social_4', 1) == '' ? '' : '<li class="social_4"><a href="'.esc_url(get_post_meta(get_the_ID(), 'pix_social_4', 1)).'" target="_blank"><i class="icon-social-instagram"></i></a></li>';
        }

        $link = get_the_permalink($post->ID);
        $thumbnail = get_the_post_thumbnail($post->ID, 'pixtheme-portfolio-thumb', array('class' => 'img-responsive '));
        $thumbnail_main = get_the_post_thumbnail($post->ID, 'large', array('class' => 'img-responsive '));

        if( $i == 0 && $style == 'grid-fives'){
            $out_items[$i] = '
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="grid-big__item-video">
                        <a href="'.esc_url($link).'">
                            <div class="grid-big__item-container"></div>
                        </a>
                        <div class="grid-big__item-text">
                            <h3><a href="'.esc_url($link).'">'.wp_kses_post(get_the_title()).'</a></h3>
                            <span>'.wp_kses_post( $pixtheme_portfolio_linked_list_cats ).'</span>
                            <ul class="pix-social-round">'.wp_kses_post($social_1.$social_2.$social_3.$social_4).'</ul>
                        </div>
                        '.wp_kses_post($thumbnail_main).'
                    </div>
                </div>
            ';

        } else {
            $out_items[$i] = '
                <div class="grid-big__item">
                    <a href="' . esc_url($link) . '">
                        <div class="grid-big__item-container"></div>
                    </a>
                    <div class="grid-big__item-text">
                        <h3><a href="'.esc_url($link).'">'.wp_kses_post(get_the_title()).'</a></h3>
                            <span>'.wp_kses_post( $pixtheme_portfolio_linked_list_cats ).'</span>
                        <ul class="pix-social-round">'.wp_kses_post($social_1.$social_2.$social_3.$social_4).'</ul>
                    </div>
                    ' . wp_kses_post($thumbnail) . '
                </div>
            ';
        }

        $i++;
    endwhile;

    if($style == 'grid-fives') {

        if ($position == 'left') {
            $out = '
    <div class="grid-big animated fadeIn ' . esc_attr($greyscale) . '" style="opacity: 1;">
        <div class="row">
            ' . wp_kses_post($out_items[0]) . '
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        ' . wp_kses_post($out_items[1]) . '
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        ' . wp_kses_post($out_items[2]) . '
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        ' . wp_kses_post($out_items[3]) . '
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        ' . wp_kses_post($out_items[4]) . '
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    ';
        } elseif ($position == 'center') {
            $out = '
    <div class="grid-big animated fadeIn ' . esc_attr($greyscale) . '" style="opacity: 1;">
        <div class="row">
            <div class="col-lg-3 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-6">
                        ' . wp_kses_post($out_items[1]) . '
                    </div>
                    <div class="col-lg-12 col-md-6 col-sm-6">
                        ' . wp_kses_post($out_items[2]) . '
                    </div>
                </div>
            </div>
            ' . wp_kses_post($out_items[0]) . '
            <div class="col-lg-3 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-6">
                        ' . wp_kses_post($out_items[3]) . '
                    </div>
                    <div class="col-lg-12 col-md-6 col-sm-6">
                        ' . wp_kses_post($out_items[4]) . '
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    ';
        } else {
            $out = '
    <div class="grid-big animated fadeIn ' . esc_attr($greyscale) . '" style="opacity: 1;">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        ' . wp_kses_post($out_items[1]) . '
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        ' . wp_kses_post($out_items[2]) . '
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        ' . wp_kses_post($out_items[3]) . '
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        ' . wp_kses_post($out_items[4]) . '
                    </div>
                </div>
            </div>
            ' . wp_kses_post($out_items[0]) . '
        </div>
    </div>
    ';
        }
    } elseif($style == 'grid-three'){
        $out = '
    <div class="grid-big animated fadeIn ' . esc_attr($greyscale) . '">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                ' . wp_kses_post($out_items[0]) . '
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                ' . wp_kses_post($out_items[1]) . '
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                ' . wp_kses_post($out_items[2]) . '
            </div>
        </div>
    </div>
    ';
    } elseif($style == 'grid-four'){
        $out = '
    <div class="grid-big animated fadeIn ' . esc_attr($greyscale) . '">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12">
                ' . wp_kses_post($out_items[0]) . '
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                ' . wp_kses_post($out_items[1]) . '
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                ' . wp_kses_post($out_items[2]) . '
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                ' . wp_kses_post($out_items[3]) . '
            </div>
        </div>
    </div>
    ';
    }

endif;

wp_reset_postdata();

if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo wp_kses_post($out);
}