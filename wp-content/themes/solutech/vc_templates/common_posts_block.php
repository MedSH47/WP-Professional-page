<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Posts_Block
 */
$carousel_arr = $shadows_arr = array();
$out = $out_news = $cats = $radius = $greyscale = $count = $col = $img_proportions = $hover_icon = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$carousel_arr = pixtheme_vc_get_params_array($atts, 'carousel');
$shadows_arr = pixtheme_vc_get_params_array($atts, 'shadow');
extract( $atts );



$count = $count == '' ? '3' : $count;
$style = !isset($style) || $style == '' ? 'pix-news-slider' : $style;
$greyscale = ($greyscale == 'off') ? '' : 'pix-img-greyscale';
$shadow_class = pixtheme_get_shadow($shadows_arr);
$hover_icon = ( $hover_icon != '' ) ? 'pix-hover-icon-'.$hover_icon : '';

$col = 3;
$image_size = $img_proportions;
if($col == 3){
    $image_size .= '-col-3';
} elseif($col > 3) {
    $image_size .= '-col-4';
}
$image_size .= pixtheme_retina() ? '-retina' : '';

$args = array(
    'ignore_sticky_posts' => true,
    'showposts' => $count,
);
if($cats != '') {
    $cats = explode(",", $cats);

    $args = array(
        'ignore_sticky_posts' => true,
        'showposts' => $count,
        'post_type' => 'post',
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $cats
            )
        ),
    );
}

$wp_query = new WP_Query( $args );
			 					
if ($wp_query->have_posts()):
    $i=0;
    $cnt = $wp_query->post_count;

    while ($wp_query->have_posts()) :
        $wp_query->the_post();
        $custom = get_post_custom(get_the_ID());
        $i++;
        
        $date = $author = $comments = '';
        
        $cat = array();
        if(pixtheme_get_option('blog_show_category', '1')){
            $categories = get_the_category(get_the_ID());
            if($categories){
                foreach($categories as $category) {
                    if($category->slug != 'uncategorized') {
                        if ($style == 'pix-news-slider') {
                            $cat[] = '<div class="pix-news-btn"><a href="' . esc_url(get_category_link($category->term_id)) . '" class="pix-button pix-cat-link">' . wp_kses_post($category->cat_name) . '</a></div>';
                        } else {
                            $cat[] = '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="pix-button pix-round pix-h-s pix-v-xs pix-font-s">' . wp_kses_post($category->cat_name) . '</a>';
                        }
                    }
                }
            }
        }
        if(pixtheme_get_option('blog_show_date', '1')){
            $date = '<a href="'.esc_url(get_the_permalink()).'">'.wp_kses_post(get_the_date()).'</a>';
        }
        if(pixtheme_get_option('blog_show_author', '1')){
            $author = get_the_author_posts_link();
        }
        
        $num_comments = get_comments_number();
        if ( comments_open() ) {
            if ( $num_comments == 0 ) {
                $comments_text = esc_html__( 'No comments', 'solutech' );
            } elseif ( $num_comments > 1 ) {
                $comments_text = $num_comments . esc_html__( ' comments', 'solutech' );
            } else {
                $comments_text = esc_html__( '1 comment', 'solutech' );
            }
            $comments = '<i class="fas fa-comments"></i> <a href="' . get_comments_link() .'">'. $comments_text.'</a>';
        }

        $thumbnail = get_the_post_thumbnail( get_the_ID() ) != '' ? get_the_post_thumbnail( get_the_ID(), $image_size ) : '<img src="'.esc_url(get_template_directory_uri()).'/images/no_image.png">';

        if($style == 'pix-news-slider'){
        $out_news .= '
            <div class="pix-news-item '.esc_attr($shadow_class).' pix-overlay-container">
                <div class="pix-news-img">
                    '.wp_kses_post($thumbnail).'
                </div>
                <div class="pix-news-info">
                    <div class="pix-news-author-date">'.wp_kses_post($date).'</div>
                    <div class="pix-news-title">
                        <a href="'.esc_url(get_the_permalink()).'" class="pix-shadow-link">'.wp_kses_post(get_the_title()).'</a>
                    </div>
                    <div class="pix-news-text">
                        <p>'.pixtheme_limit_words(get_the_excerpt(), 20).'</p>
                    </div>
                    <div class="pix-hover-item pix-bottom pix-left">
                        '.wp_kses_post(implode($cat)).'
                    </div>
                </div>
            </div>
        ';
        } else {
        $out_news .= '
            <div class="'.esc_attr($style).' '.esc_attr($shadow_class).' pix-overlay-container">';
            if($style == 'news-card-long') {
                $out_news .= '
                    <div class="news-card-long__image ">
                        <a class="icon-zoom" href="'.esc_url(get_the_permalink()).'"></a>
                        <div class="overlay"></div>
                        '.wp_kses_post($thumbnail).'
                    </div>
                    <div class="news-card-long__text">
                        <h3><a href="'.esc_url(get_the_permalink()).'" class="pix-title-link">'.wp_kses_post(get_the_title()).'</a></h3>
                        <span class="news-date">'.wp_kses_post($date).'</span>
                        <p>'.pixtheme_limit_words(get_the_excerpt(), 20).'</p>
                    </div>
                ';
            } elseif($style == 'pix-news-high') {
                $out_news .= '
                    <div class="pix-box-img">
                        <a href="'.esc_url(get_the_permalink()).'">
                            <div class="pix-overlay '.esc_attr($hover_icon).'"></div>
                            '.wp_kses_post($thumbnail).'
                        </a>
                        
                        <div class="pix-hover-item pix-top pix-left pix-translate">'.wp_kses_post(implode($cat)).'</div>
                        <div class="pix-hover-item pix-bottom pix-left pix-translate"><i class="far fa-user"></i> '.wp_kses_post($author).'</div>
                    </div>
                    <div class="news-card-centered__text">
                        <h3><a href="'.esc_url(get_the_permalink()).'" class="pix-main-color-hover-link">'.wp_kses_post(get_the_title()).'</a></h3>
                        <p>'.pixtheme_limit_words(get_the_excerpt(), 18).'</p>
                        <div class="pix-box-footer">
                            <div class="pix-categories"><i class="fas fa-clock"></i> '.wp_kses_post($date).'</div>
                            <div class="pix-comments">'.wp_kses_post( $comments ).'</div>
                        </div>
                    </div>
                ';
            } elseif($style == 'news-card-centered') {
                $out_news .= '
                    <div class="news-card-centered__image">
                        <span class="news-date">'.wp_kses_post($date).'</span>
                        <a href="'.esc_url(get_the_permalink()).'">'.pixtheme_limit_words(get_the_excerpt(), 20).'</a>
                        <div class="overlay"></div>
                        '.wp_kses_post($thumbnail).'
                    </div>
                    <div class="news-card-centered__text">
                        <h3><a href="'.esc_url(get_the_permalink()).'" >'.wp_kses_post(get_the_title()).'</a></h3>
                    </div>
                ';
            } else {
                $out_news .= '
                    <h3><a href="'.esc_url(get_the_permalink()).'" class="pix-title-link">'.wp_kses_post(get_the_title()).'</a></h3>
                    <div class="news-info clearfix">
                        <span class="news-info__category"><i class="far fa-folder"></i>'.wp_kses_post(implode(', ', $cat)).'</span>
                        <span class="news-info__date"><i class="far fa-calendar-check"></i>'.wp_kses_post($date).'</span>
                    </div>
                    '.wp_kses_post($thumbnail).'
                    <div class="gradient-bg"></div>
                ';
            }
        $out_news .= '            
            </div>';
        }

    endwhile;

endif;

wp_reset_postdata();

$options_arr = pixtheme_get_carousel($carousel_arr, '');
$data_carousel = empty($options_arr) ? '' : 'data-owl-options=\''.json_encode($options_arr).'\'';
$carousel_class = !empty($options_arr) ? 'row owl-carousel owl-theme' : 'disable-owl-carousel pix-col-'.esc_attr($count);
$animation_class = !empty($options_arr) && !isset($options_arr['onTranslate']) ? 'animation-off' : '';

$class_container = $style == 'pix-news-slider' ? $style : ($style.'__carousel');

$out = '
<div class="'.esc_attr($class_container).' '.esc_attr($carousel_class).' '.esc_attr($radius).' '.esc_attr($greyscale).'" '.wp_kses_post($data_carousel).'>
    '.wp_kses_post($out_news).'
</div>
';

if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo wp_kses_post($out);
}