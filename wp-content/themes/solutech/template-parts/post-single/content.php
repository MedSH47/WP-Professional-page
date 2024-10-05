<?php
$solutech_get_layout = solutech_get_layout( 'post', get_the_ID() );
$solutech_layout = $solutech_get_layout['layout'];
$solutech_size_thumb = ( 'without-sidebar' === $solutech_layout ) ? 'solutech-post-thumb-large' : 'solutech-post-thumb-medium';
?>
<div class="post">
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post__img">
            <?php the_post_thumbnail( $solutech_size_thumb ); ?>
        </div>
    <?php endif; ?>
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
    <div class="post__text">
        <?php the_content(); ?>
    </div>

    <?php
    wp_link_pages( array(
        'before'      => '<div class="more-page">' . esc_html__( 'Pages:', 'solutech' ),
        'after'       => '</div>',
        'link_before' => '<span class="page-number">',
        'link_after'  => '</span>',
    ) );
    ?>

    <?php if ( solutech_get_option( 'show_post_tags', true ) && has_tag() ) : ?>
    <div class="post__tags"><b><?php echo esc_html__( 'Tagged with:', 'solutech' ); ?></b>
        <?php echo solutech_get_post_terms( array( 'taxonomy' => 'post_tag', 'sep' => '', 'items_wrap' => '%s' ) ); ?>
    </div>
    <?php endif; ?>

    <?php if ( solutech_get_option( 'show_post_author_block', true ) && (bool) get_the_author_meta( 'user_description' ) ) : ?>
    <div class="post__author">
        <div class="post__authorAvatar">
            <?php echo get_avatar( get_the_author_meta( 'user_email' ), 80 ); ?>
        </div>
        <div class="post__authorDescription">
            <div class="post__authorName"><?php the_author_meta( 'display_name' ); ?></div>
            <?php if ( get_the_author_meta( 'user_url' ) != '' ) : ?>
            <div class="post__authorWebsite">
                <?php echo esc_html__( 'Website:', 'solutech' ); ?>
                <a href="<?php esc_url( the_author_meta( 'user_url' ) ); ?>" target="_blank" nofollow="nofollow" noindex="noindex"><?php esc_html( the_author_meta( 'user_url' ) ); ?></a>
            </div>
            <?php endif; ?>
            <p><?php the_author_meta( 'user_description' ); ?></p>
        </div>
    </div>
    <?php endif; ?>

</div>
