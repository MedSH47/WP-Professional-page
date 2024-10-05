<?php
/*** The template for displaying team categories. ***/

$style = 'bottom-desc';

$pix_col = pixtheme_get_setting('pix-col-team-cat', '4');
$pix_gap = '50';

$image_size = $image_class = pixtheme_get_setting('pix-images-team-cat', 'pixtheme-portrait');
if($pix_col == 3){
    $image_size .= '-col-3';
} elseif($pix_col > 3) {
    $image_size .= '-col-4';
}
$image_size .= pixtheme_retina() ? '-retina' : '';


?>

<!-- ========================== -->
<!-- TEAM - CONTENT -->
<!-- ========================== -->

    <div id="team-archive-section" class="pix-col-<?php echo esc_attr($pix_col); ?>">

    <?php


    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $args = array(
        'post_type' => 'pix-team',
        'orderby' => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
        'posts_per_page' => -1,
        //'paged' => $paged
    );

    $wp_query = new WP_Query( $args );

    if ( $wp_query->have_posts() ) : ?>
        
        <div class="pix-isotope pix-team">
            <div class="pix-isotope-items pix-<?php echo esc_attr($style) ?> pix-col-<?php echo esc_attr($pix_col); ?> pix-gap-<?php echo esc_attr($pix_gap); ?> <?php echo esc_attr($image_class); ?>">
                <div class="pix-gutter-sizer"></div>

    <?php
        while ( $wp_query->have_posts() ) :
            $wp_query->the_post();

            $cats = wp_get_object_terms(get_the_id(), 'pix-team-cat');
            $pixtheme_cat_slugs = '';
            if ( ! empty($cats) ) {
                foreach ( $cats as $cat ) {
                    $pixtheme_cat_slugs .= $cat->slug . " ";
                }
            }
            $thumbnail = get_the_post_thumbnail(get_the_ID(), $image_size, array('class' => $image_class.' pix-img-greyscale'));

            // potfolio category list linked
            $pix_linked_list_cats = pixtheme_get_post_terms( array( 'taxonomy' => 'pix-team-cat', 'items_wrap' => '%s' ) );

    ?>

                <div class="pix-isotope-item pix-box">
            
    <?php
            if( $style == 'hover-info' ){
                $out_content = '
                    <div class="pix-hover-container">
                        <h3><a href="' . esc_url(get_the_permalink()) . '">' . wp_kses_post(get_the_title()) . '</a></h3>
                        <p>' . wp_kses_post($pix_linked_list_cats) . '</p>
                    </div>
                    ' . wp_kses_post($thumbnail);
                
            } elseif($style == 'bottom-desc') {
                $out_content = '
                    <div class="pix-box-img">
                        <a href="' . esc_url(get_the_permalink()) . '">
                            <div class="pix-img-wrapper">' . wp_kses_post($thumbnail) . '</div>
                        </a>
                    </div>
                    <div class="pix-box-text">
                        <div class="pix-box-name">
                            <a href="' . esc_url(get_the_permalink()) . '">' . wp_kses_post(get_the_title()) . '</a>
                        </div>
                        '.pixtheme_limit_words(get_the_excerpt(), 20, 'p').'
                    </div>
                    <span class=""><a href="'.esc_url(get_permalink(get_the_ID())).'"></a></span>';
            } else {
                
                $out_content = '
                    <div class="pix-box-img">
                        <a href="' . esc_url(get_the_permalink()) . '">
                            ' . wp_kses_post($thumbnail) . '
                        </a>
                    </div>
                    <div class="pix-box-name">
                        <a href="' . esc_url(get_the_permalink()) . '">' . wp_kses_post(get_the_title()) . '</a>
                    </div>';
            }
            echo wp_kses_post($out_content);
    ?>
            
                </div>

    <?php
        endwhile;
    ?>
            </div>
        </div>

    <?php
    endif;
    ?>
    
    </div>
    