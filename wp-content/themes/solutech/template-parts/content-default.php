<div id="post-<?php esc_attr( the_ID() ); ?>" <?php post_class( 'post' ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post__img">
            <?php the_post_thumbnail( 'solutech-post-thumb-large' ); ?>
            <i class="post__imgIcon"></i>
            <a href="<?php the_permalink(); ?>"></a>
        </div>
	<?php endif; ?>
    <div class="post__body">
        <?php if ( solutech_get_option( 'show_post_date', true ) ) : ?>
        <a class="post__date" href="<?php the_permalink(); ?>"><span><?php echo get_the_time( 'j' ); ?></span><span><?php echo get_the_time( 'M' ); ?></span></a>
        <?php endif; ?>
        <div class="post__text">
            <h3 class="post__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
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
                <div class="post__info"></div>
                <?php if ( solutech_get_option( 'show_post_readmore', true ) ) : ?>
                    <a href="<?php the_permalink(); ?>"><?php echo solutech_get_option( 'post_readmore', esc_html__( 'read more', 'solutech' ) ); ?><i class="pix-icon-right-arrow"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
