<?php
/**
 * This template is for displaying part of blog.
 *
 */

$solutech_get_layout = solutech_get_layout( 'blog' );
$solutech_layout = $solutech_get_layout['layout'];

$solutech_size_thumb = ( 'without-sidebar' === $solutech_layout ) ? 'solutech-post-thumb-large' : 'solutech-post-thumb-medium';
?>

<div id="post-<?php esc_attr( the_ID() ); ?>" <?php post_class( 'post' ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post__img">
            <?php the_post_thumbnail( $solutech_size_thumb ); ?>
            <i class="post__imgIcon"></i>
            <a href="<?php the_permalink(); ?>"></a>
        </div>
	<?php endif; ?>
    <div class="post__body">
        <?php if ( solutech_get_option( 'show_post_date', true ) ) : ?>
        <a class="post__date" href="<?php the_permalink(); ?>"><span><?php echo get_the_time( 'j' ); ?></span><span><?php echo get_the_time( 'M' ); ?></span></a>
        <?php endif; ?>
        <div class="post__text">
            <?php the_title( '<h3 class="post__title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' ); ?>
            <?php if( get_option('rss_use_excerpt') == 0 && !is_search() ) {
                the_content();
            } else {
                the_excerpt();
            } ?>
            <?php
            wp_link_pages( array(
                'before'      => '<div class="more-page">' . esc_html__( 'Pages:', 'solutech' ),
                'after'       => '</div>',
                'link_before' => '<span class="page-number">',
                'link_after'  => '</span>',
            ) );
            ?>
            <div class="post__bot">
                <div class="post__info">
                    <?php if ( solutech_get_option( 'show_post_author', true ) ) : ?>
                        <span><i class="pix-icon-user"></i><?php the_author_posts_link(); ?></span>
                    <?php endif; ?>
                    <?php if ( solutech_get_option( 'show_post_categories', true ) ) : ?>
                        <span><i class="pix-icon-folder"></i><?php echo solutech_get_post_terms( array( 'taxonomy' => 'category', 'items_wrap' => '%s' ) ); ?></span>
                    <?php endif; ?>
                    <?php if ( solutech_get_option( 'show_post_comments', true ) && comments_open() ) : ?>
                        <span><i class="pix-icon-bubble"></i><?php comments_popup_link( esc_html__( 'Post a Comment', 'solutech' ), esc_html__( '1 comment', 'solutech' ), esc_html__( '% comments', 'solutech' ), "comments-link"); ?></span>
                    <?php endif; ?>
                </div>
                <?php if ( solutech_get_option( 'show_post_readmore', true ) ) : ?>
                    <a href="<?php the_permalink(); ?>"><?php echo solutech_get_option( 'post_readmore', esc_html__( 'read more', 'solutech' ) ); ?><i class="pix-icon-arrow"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
