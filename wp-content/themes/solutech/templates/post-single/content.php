<?php
$comments = wp_count_comments($post->ID);
$categories = wp_get_post_categories($post->ID,array('fields' => 'all'));
$tags = get_the_tags($post->ID);
$pixtheme_img_class = !has_post_thumbnail() ? 'no-image' : '';
$pixtheme_format  = get_post_format();
$separator = ', ';
$pixtheme_cat = '';
if( pixtheme_get_setting('pix-blog-categories', 'on') == 'on' ){
    $pixtheme_categories = get_the_category(get_the_ID());
    if($pixtheme_categories){
        foreach($pixtheme_categories as $category) {
            $pixtheme_cat .= '<a href="'.esc_url(get_category_link( $category->term_id )).'" class="pix-button pix-round pix-h-s pix-v-xs pix-font-s">'.$category->cat_name.'</a>';
        }
    }
    if( !empty($pixtheme_cat) ){
        $pixtheme_cat = '<div class="pix-overlay-item pix-top pix-left">'.$pixtheme_cat.'</div>';
    }
}
?>


        <div class="post-image pix-box-img pix-overlay-container pix-no-overlay <?php echo esc_attr($pixtheme_img_class); ?> pix-<?php echo esc_attr($pixtheme_format); ?>">
            <?php
                $pixtheme_format = !in_array($pixtheme_format, array('gallery', 'video', 'quote')) ? 'standared' : $pixtheme_format;
                get_template_part( 'templates/post-single/blog', $pixtheme_format);
            ?>
            <?php echo wp_kses_post($pixtheme_cat)?>
        </div>

        <!-- === BLOG TEXT === -->
        <div class="post-content rtd">
            <?php the_content()?>
            <?php
            $args_pl = array(
                'before'           => '<p class="pix-link-pages"><span>'.esc_html__('Pages:', 'solutech').'</span>',
                'after'            => '</p>'
            );
            wp_link_pages($args_pl);
            ?>
        </div>

        <div class="post-footer">
            <!-- === BLOG TAGS === -->
            <div class="footer-meta blog-footer-tags">
            <?php if ($tags && pixtheme_get_option('blog_settings_tags', 1)):?>

                    <span class="blog-footer-title"><i class="fas fa-hashtag"></i></span>
                    <?php
                    $echo_tags = '';
                    foreach($tags as $tag){
                        $echo_tags .= '<a href="'.esc_url(get_tag_link( $tag->term_id )).'" class="entry-meta__link">'.esc_attr($tag->name).'</a>'. wp_kses_post($separator);
                    }
                    echo trim( $echo_tags, $separator );
                    ?>

            <?php endif;?>
            </div>
            <!-- === BLOG SHARE === -->
            <?php if(shortcode_exists( 'share' ) && pixtheme_get_option('blog_settings_share', 1) && function_exists('pix_display_format')) : ?>
                <?php echo pix_display_format('[share]'); ?>
            <?php endif ?>

        </div>
        

        <?php
            $pixtheme_prev_thumb = $pixtheme_next_thumb = $out_prev = $out_next = '';
            $pixtheme_next_post = get_next_post();
            $pixtheme_prev_post = get_previous_post();
            $label_next = '<div class="label-next"><a href="'.esc_url(get_the_permalink($pixtheme_next_post)).'"><span>'.esc_html__('next', 'solutech').'</span></a></div>';
            $label_prev = '<div class="label-prev"><a href="'.esc_url(get_the_permalink($pixtheme_prev_post)).'"><span>'.esc_html__('previous', 'solutech').'</span></a></div>';

            $out_next = '<div class="col-6 pix-news-next">';
            if(isset($pixtheme_next_post->ID)) {
                $out_next .= wp_kses_post($label_next).'
                        <h4><a href="'.esc_url(get_the_permalink($pixtheme_next_post)).'">'.wp_kses_post(get_the_title($pixtheme_next_post)).'</a></h4>
                ';
            }
            $out_next .= '</div>';

            $out_prev = '<div class="col-6 pix-news-prev">';
            if(isset($pixtheme_prev_post->ID)) {
                $out_prev .= wp_kses_post($label_prev).'
                        <h4><a href="'.esc_url(get_the_permalink($pixtheme_prev_post)).'">'.wp_kses_post(get_the_title($pixtheme_prev_post)).'</a></h4>
                ';
            }
            $out_prev .= '</div>';
        ?>
        <div class="row blog-article__related">
            <?php
                if(function_exists('pix_out')){
                    pix_out($out_prev.$out_next);
                } else {
                    echo wp_kses_post($out_prev.$out_next);
                }
            ?>
        </div>
        <!--blog-post-->

     
		<?php comments_template(); ?>

