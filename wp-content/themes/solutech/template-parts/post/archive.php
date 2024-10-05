<?php
if ( have_posts() ) :

    // Start the Loop.
    while ( have_posts() ) : the_post();

        get_template_part( 'template-parts/post/content' );

    endwhile;

else:
    // If no content, include the "No posts found" template.
    get_template_part( 'template-parts/content', 'none' );

endif;

the_posts_pagination( array(
    'prev_text' => '<i class="pix-icon-left-arrow"></i>',
    'next_text' => '<i class="pix-icon-right-arrow"></i>',
) );
