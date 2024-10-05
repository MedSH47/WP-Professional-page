<?php
	global $post;
	// get meta options/values
	$pixtheme_content = get_post_meta($post->ID, 'pix_post_quote_content', 1);
	$pixtheme_source = get_post_meta($post->ID, 'pix_post_quote_source', 1) == '' ? '' : '<div class="blog-quote-source">'.wp_kses_post(get_post_meta($post->ID, 'pix_post_quote_source', 1)).'</div>';

	if($pixtheme_content != '') :
?>

    <blockquote>
        <?php echo wp_kses_post($pixtheme_content); ?>
        <?php echo wp_kses_post($pixtheme_source)?>
    </blockquote>

<?php endif; ?>