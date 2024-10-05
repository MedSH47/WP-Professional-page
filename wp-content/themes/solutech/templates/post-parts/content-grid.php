<?php
/**
 * This template is for displaying part of Grid blog.
 *
 * @package Pix-Theme
 * @since 1.0
 */

?>
    <div class="pix-blog-article-name pix-h4">
		<a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a>
    </div>
    <div class="pix-blog-article-text">
        <?php echo pixtheme_limit_words(get_the_excerpt(), 30); ?>
    </div>
    <div class="pix-blog-article-footer">
        <?php if ( pixtheme_get_setting('pix-blog-author', 'on' ) == 'on' ) : ?>
            <span class="author"><?php the_author_posts_link(); ?></span>
        <?php endif; ?>
        <?php if ( pixtheme_get_setting('pix-blog-date', 'on' ) == 'on' ) : ?>
            <span><a href="<?php esc_url(the_permalink()); ?>"><?php echo sprintf( '<span>%s</span>', esc_attr( get_the_date() ) ); ?></a></span>
        <?php endif; ?>
    </div>


