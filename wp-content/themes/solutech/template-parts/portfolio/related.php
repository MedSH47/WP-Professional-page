<?php
$image_size = 'solutech-square-thumb';
?>

<div class="relatedProjects__post">
    <div class="relatedProjects__postImg">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( $image_size ); ?>
        <?php endif; ?>
    </div>
    <div class="relatedProjects__postInfo">
        <div class="relatedProjects__postTitle"><?php the_title(); ?></div>
        <div class="relatedProjects__postText"><?php echo solutech_limit_words( get_the_excerpt(), 20 ); ?></div>
        <?php
        $solutech_project_icon_url = ! empty( $solutech_project_icon_id = solutech_get_post_meta( 'project_icon' ) ) ? wp_get_attachment_image_src( $solutech_project_icon_id, 'solutech-thumb-limit-height-small' )[0] : '';
        if ( $solutech_project_icon_url ) :
            ?>
            <div class="relatedProjects__postLogo"><img src="<?php echo esc_url( $solutech_project_icon_url ); ?>" alt="<?php the_title_attribute(); ?>" /></div>
            <?php
        endif;
        ?>
        <a href="<?php the_permalink(); ?>"></a>
    </div>
</div>
