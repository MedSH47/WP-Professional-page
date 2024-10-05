<?php
/**
 * The main template file
 */

$pix_layout = pixtheme_get_layout('blog');
$pix_width_class = pixtheme_get_layout_width( get_post_type() );

$blog_class = 'pix-blog-'.pixtheme_get_setting('pix-blog-style', 'classic');

?>
<?php get_header();?>

<section class="blog">
	<div class="container <?php echo esc_attr($pix_width_class)?>">
		<div class="row sidebar-type-<?php echo esc_attr($pix_layout['layout']); ?>">
			<?php pixtheme_show_sidebar( 'left', $pix_layout['layout'], $pix_layout['sidebar'] ); ?>

			<div class="<?php if ( $pix_layout['layout'] != 1 ) : ?>col-xl-9 col-lg-8<?php endif; ?> col-12 <?php echo esc_attr($pix_layout['class'])?>">
                <section class="<?php echo esc_attr($blog_class) ?>">
                <?php
                    $wp_query = new WP_Query();
                    $pp = get_option('posts_per_page');
                    $wp_query->query('posts_per_page='.$pp.'&paged='.$paged);
                    get_template_part( 'loop', 'index' );
                ?>
                </section>
                <?php
                    the_posts_pagination( array(
                        'prev_text'          => wp_kses_post(__( '<i class="fas fa-chevron-left"></i>', 'solutech' )),
                        'next_text'          => wp_kses_post(__( '<i class="fas fa-chevron-right"></i>', 'solutech' )),
                        'screen_reader_text' => esc_html__( '&nbsp;', 'solutech'),
                    ) );
                ?>
			</div>
			<!-- end col -->

			<?php pixtheme_show_sidebar( 'right', $pix_layout['layout'], $pix_layout['sidebar'] ); ?>
		</div>
		<!-- end row -->
	</div>
</section>
<?php get_footer(); ?>
