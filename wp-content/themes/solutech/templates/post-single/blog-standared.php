
<?php
/**
 * This template is for displaying part of blog.
 *
 * @package Pix-Theme
 * @since 1.0
 */


?>
	<?php if ( has_post_thumbnail() ):?>
		<?php the_post_thumbnail('pixtheme-landscape', array('class' => 'img-responsive')); ?>
	<?php endif; ?>

