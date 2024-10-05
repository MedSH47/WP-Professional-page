<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php the_content(); ?>

    <?php
    wp_link_pages( array(
        'before'      => '<div class="more-page">' . esc_html__( 'Pages:', 'solutech' ),
        'after'       => '</div>',
        'link_before' => '<span class="page-number">',
        'link_after'  => '</span>',
    ) );
    ?>

</div>
