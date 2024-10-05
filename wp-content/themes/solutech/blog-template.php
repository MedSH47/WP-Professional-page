<?php
/**
 * The home template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Template Name: Blog Template
 *
 */

$pixtheme_class = array('', 'pix-no-sidebar', 'pix-right-sidebar', 'pix-left-sidebar');
$pixtheme_postpage_id = get_option( 'page_for_posts' );
$pixtheme_frontpage_id = get_option( 'page_on_front' );
$pixtheme_page_id = isset($wp_query) ? $wp_query->get_queried_object_id() : '';

if ( $pixtheme_page_id == $pixtheme_postpage_id && $pixtheme_postpage_id != $pixtheme_frontpage_id ) :
	$pixtheme_custom = isset( $wp_query ) ? get_post_custom( $wp_query->get_queried_object_id() ) : '';
	$pixtheme_layout = isset( $pixtheme_custom['pix_page_layout'] ) ? $pixtheme_custom['pix_page_layout'][0] : '2';
	$pixtheme_sidebar = isset( $pixtheme_custom['pix_selected_sidebar'][0] ) ? $pixtheme_custom['pix_selected_sidebar'][0] : 'sidebar';
else :
	$pixtheme_layout = pixtheme_get_option('blog_settings_sidebar_type', '2');
	$pixtheme_sidebar = pixtheme_get_option('blog_settings_sidebar_content', 'sidebar');
endif;

if ( ! is_active_sidebar($pixtheme_sidebar) ) $pixtheme_layout = '1';

?>
<?php get_header();?>

<section class="blog-content-section" id="main">
<div class="container">
	<div class="row">

		<?php pixtheme_show_sidebar( 'left', $pixtheme_layout, $pixtheme_sidebar ); ?>
		
		<div class="<?php if ( $pixtheme_layout != 1 ) : ?>col-xl-9 col-lg-8<?php endif; ?> col-12 <?php echo esc_attr($pixtheme_class[$pixtheme_layout])?>">
		
			<main class="main-content">
			
				<?php
                    $wp_query = new WP_Query();
                    $pp = get_option('posts_per_page');
                    $wp_query->query('posts_per_page='.$pp.'&paged='.$paged);
                    get_template_part( 'loop', 'index' );
                ?>
                <?php the_posts_pagination( array(
                    'prev_text'          => esc_html__( '&lt;', 'solutech' ),
                    'next_text'          => esc_html__( '&gt;', 'solutech' ),
                    'screen_reader_text' => esc_html__( '&nbsp;', 'solutech'),
                    'type' => 'list'
                ) ); ?>

			</main><!-- end main-content -->
			
		</div><!-- end col -->

		<?php pixtheme_show_sidebar( 'right', $pixtheme_layout, $pixtheme_sidebar ); ?>

	</div><!-- end row -->
</div>
</section>
<?php get_footer(); ?>
