<?php
/**
 * The template includes blog post format audio.
 *
 * @package Pix-Theme
 * @since 1.0
 */

$image_size = array(860, 460);
if( pixtheme_retina() ){
    $image_size = array(1720, 920);
}

$video_url = get_post_meta( get_the_ID(), 'pix_post_video_url', true );

?>

    <a class="pix-video-popup" href="<?php echo esc_url($video_url)?>">
        <div class="item-pulse"><img class="play" src="<?php echo get_template_directory_uri()?>/images/play.svg" alt="<?php esc_attr_e('Play', 'solutech')?>"></div>
    </a>
    <?php the_post_thumbnail($image_size, array('class' => 'img-responsive')); ?>


