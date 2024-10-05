<?php
$post_ID = isset ($wp_query) ? $wp_query->get_queried_object_id() : (get_the_ID()>0 ? get_the_ID() : '');
$custom =  get_post_custom($post_ID);
$layout = isset ($custom['_page_layout']) ? $custom['_page_layout'][0] : '1';
$i=0;

$blog_class_item = pixtheme_get_setting('pix-blog-style', 'classic') == 'classic' ? 'blog-list__article' : '';

?>

<?php if ( ! have_posts() ) : ?>
    <div  class="post error404 not-found">
        <h1 class="entry-title"><?php esc_html_e( 'Not Found', 'solutech' ); ?></h1>
        <div class="entry-content">
            <p><?php esc_html_e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'solutech' ); ?></p>
            <?php get_search_form(); ?>
        </div><!-- .entry-content -->
    </div><!-- #post-0 -->
<?php endif; ?>


	<?php while ( have_posts() ) : the_post(); ?>
        <?php
            $pixtheme_format  = get_post_format();
            $pixtheme_format = !in_array($pixtheme_format, array("quote", "gallery", "video")) ? 'standared' : $pixtheme_format;

			$pixtheme_img_class = !has_post_thumbnail() ? 'no-image' : '';
			$pixtheme_post_class = get_option('rss_use_excerpt') == 0 ? 'pix-full-post-content' : '';
			$pixtheme_blog_item = get_post_format() ? get_post_format() : 'standared';
			$classes = array($blog_class_item, 'blog-item-'.$pixtheme_blog_item, $pixtheme_img_class, $pixtheme_post_class);
			
			$pixtheme_cat = '';
            if( pixtheme_get_setting('pix-blog-categories', 'on') == 'on' ){
                $pixtheme_categories = get_the_category(get_the_ID());
                if($pixtheme_categories){
                    foreach($pixtheme_categories as $category) {
                        if($category->slug != 'uncategorized') {
                            $pixtheme_cat .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="pix-button pix-round pix-h-s pix-v-xs pix-font-s">' . $category->cat_name . '</a>';
                        }
                    }
                }
                if( !empty($pixtheme_cat) ){
                    $pixtheme_cat = '<div class="pix-overlay-item pix-top pix-left">'.$pixtheme_cat.'</div>';
                }
            }

			if(pixtheme_get_setting('pix-blog-style') == 'grid') :

                $classes = array($blog_class_item, 'blog-item-'.$pixtheme_blog_item, $pixtheme_img_class, 'fadeInUp wow');
                
        ?>
            <div id="post-<?php esc_attr(the_ID()); ?>" <?php post_class($classes); ?>>
                <div class="pix-blog-article pix-overlay-container pix-no-overlay">
                    <?php if(has_post_thumbnail()) : ?>
                    <div class="pix-blog-img pix-box-img">
                        <?php if( $pixtheme_format == 'standared' ) : ?>
                            <a href="<?php esc_url(the_permalink())?>">
                        <?php endif; ?>
                                <div class="pix-overlay"></div>
                        <?php get_template_part( 'templates/post-parts/blog', get_post_format() ); ?>
                        <?php if( $pixtheme_format == 'standared' ) : ?>
                            </a>
                        <?php endif; ?>
                        
                        <?php echo wp_kses_post($pixtheme_cat); ?>
                    </div>
                    <?php endif; ?>
                    <div class="pix-blog-article-info">
                        <?php get_template_part( 'templates/post-parts/content', 'grid' ); ?>
                    </div>
                </div>
            </div>
        <?php
            else :
        ?>
            <div id="post-<?php esc_attr(the_ID()); ?>" <?php post_class($classes); ?>>
                <?php
                    $img_class = has_post_thumbnail() ? '' : 'pix-no-image';
                ?>
                <div class="pix-box-img <?php echo esc_attr($img_class)?> pix-overlay-container pix-scale">
                    <?php if( $pixtheme_format == 'standared' ) : ?>
                    <a href="<?php esc_url(the_permalink())?>">
                    <?php endif; ?>
                        <div class="pix-overlay pix-black"></div>
                        <div class="blog-list__article-image">
                            <?php get_template_part( 'templates/post-parts/blog', $pixtheme_format); ?>
                        </div>
                    <?php if( $pixtheme_format == 'standared' ) : ?>
                    </a>
                    <?php endif; ?>
                    <?php echo wp_kses_post($pixtheme_cat)?>
                </div>
                <div class="blog-list__article-text">
                    <?php get_template_part( 'templates/post-parts/content', get_post_format()); ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endwhile;?>

