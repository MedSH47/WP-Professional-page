
<?php
/**
 * This template is for displaying part of blog.
 *
 * @package Pix-Theme
 * @since 1.0
 */
$image_size = 'full';//array(950, 460);
if( pixtheme_retina() ){
    $image_size = array(1900, 920);
}

?>
	<?php if ( has_post_thumbnail() ):?>
		<?php the_post_thumbnail($image_size, array('class' => 'img-responsive')); ?>
	<?php endif; ?>
