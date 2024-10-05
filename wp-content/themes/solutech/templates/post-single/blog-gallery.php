<?php
/**
 * The template includes blog post format gallery.
 *
 * @package Pix-Theme
 * @since 1.0
 */
	global $post;
	// get the gallery images
	$gallery = get_post_meta($post->ID, 'pix_post_gallery_ids', 1);
 
	$argsThumb = array(
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'orderby' => 'post__in',
		'include' => $gallery
	);
	$attachments = get_posts($argsThumb);

?>


<?php
if ($gallery && $attachments){
?>

<div class="service-page__carousel-1 owl-carousel owl-theme">
    <?php
    if ($attachments) {
        foreach ($attachments as $attachment) {
            $gallery_image = wp_get_attachment_image_src($attachment->ID, 'pixtheme-blog-thumb');
            if(isset($gallery_image[0])) {
                echo '<div class="service-page__carousel-item">
                    <img src="' . esc_url($gallery_image[0]) . '" alt="' . esc_attr(get_post_meta($attachment->ID, '_wp_attachment_image_alt', true)) . '" title="' . esc_attr(get_post_meta($attachment->ID, '_wp_attachment_image_title', true)) . '" />
                  </div>';
            }
        }
    }
    ?>
</div>
<?php } else { ?>
    <?php if ( has_post_thumbnail() ):?>
          <?php the_post_thumbnail('pixtheme-blog-thumb'); ?>
    <?php endif; ?>
<?php } ?>

