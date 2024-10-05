<?php
/**
 * The Template for displaying all single posts.
 */

$pix_layout = pixtheme_get_layout(get_post_type(), get_the_ID());
$pix_width_class = pixtheme_get_layout_width( get_post_type() );

get_header();

?>
<section class="blog">
	<div class="container <?php echo esc_attr($pix_width_class)?>">
		<div class="row">
		<?php pixtheme_show_sidebar( 'left', $pix_layout['layout'], $pix_layout['sidebar'] ); ?>
			<div class="<?php if ( $pix_layout['layout'] != 1 ) : ?>col-xl-9 col-lg-8<?php endif; ?> col-12 <?php echo esc_attr($pix_layout['class'])?>">
                <section class="blog-article">
                <?php
                    // Start the loop.
                    while ( have_posts() ) : the_post();

                        /*
                         * Include the post format-specific template for the content. If you want to
                         * use this in a child theme, then include a file called called content-___.php
                         * (where ___ is the post format) and that will be used instead.
                         */
                        get_template_part( 'templates/post-single/content', get_post_format() );

                        // End the loop.
                    endwhile;
                ?>
                </section>
			</div>
		<?php pixtheme_show_sidebar( 'right', $pix_layout['layout'], $pix_layout['sidebar'] ); ?>
		</div>
	</div>
</section>

<?php get_footer();?>
