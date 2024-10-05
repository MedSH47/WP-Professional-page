<?php
/**
 * This template is for displaying part of blog.
 *
 * @package Pix-Theme
 * @since 1.0
 */

?>

    <div class="article-head">
		<div class="post__meta">
            
            <?php if ( pixtheme_get_setting('pix-blog-author', 'on') == 'on' ) : ?>
				<span class="author">
                    <?php if ( pixtheme_get_setting('pix-blog-icons', get_option('pixtheme_default_blog_icons')) == 'on' ) : ?><i class="far fa-user"></i><?php endif; ?>
                    <?php the_author_posts_link(); ?>
                </span>
			<?php endif; ?>
            
            <?php if ( pixtheme_get_setting('pix-blog-date', 'on') == 'on' ) : ?>
                <?php if ( pixtheme_get_setting('pix-blog-author', 'on') == 'on' ) : ?>
                <span class="dash">&mdash;</span>
                <?php endif; ?>
                <span>
                    <?php if ( pixtheme_get_setting('pix-blog-icons', get_option('pixtheme_default_blog_icons')) == 'on' ) : ?><i class="far fa-calendar-check"></i><?php endif; ?>
                    <a href="<?php esc_url(the_permalink()); ?>"><?php echo sprintf( '<span>%s</span>', esc_attr( get_the_date() ) ); ?></a>
                </span>
            <?php endif; ?>
            
			<?php if ( pixtheme_get_setting('pix-blog-comments', 'off') == 'on' && comments_open() ) : ?>
			    <span>
                    <?php if ( pixtheme_get_setting('pix-blog-icons', get_option('pixtheme_default_blog_icons')) == 'on' ) : ?><i class="far fa-comments"></i><?php endif; ?>
                    <?php comments_popup_link( esc_html__( 'Post a Comment', 'solutech' ), esc_html__( '1 comment', 'solutech' ), esc_html__( '% comments', 'solutech' ), "comments-link"); ?>
                </span>
			<?php endif; ?>

		</div>
	</div>

    <h2 class="pix-h4 pix-post-title"><a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h2>

    <div class="article-title">

        <div class="rtd">
            <?php
            if( get_option('rss_use_excerpt') == 0 && !is_search() ) {
                the_content();
            } else {
                the_excerpt();
            }
            ?>
        </div>
        
        <?php
        $args_pl = array(
            'before'           => '<p class="pix-link-pages"><span>'.esc_html__('Pages:', 'solutech').'</span>',
            'after'            => '</p>'
        );
        wp_link_pages($args_pl);
        ?>

    </div>

    <a href="<?php the_permalink(); ?>" class="pix-button"><?php esc_html_e('read more', 'solutech') ?></a>
