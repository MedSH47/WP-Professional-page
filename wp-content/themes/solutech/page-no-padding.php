<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Template Name: Page No Padding
 *
 */
    
$pix_layout = pixtheme_get_layout(get_post_type(), get_the_ID());

?>

<?php get_header();?>
    <section class="blog pix-page-no-padding" >
        <div class="container">
            <div class="row">
            
                <?php pixtheme_show_sidebar( 'left', $pix_layout['layout'], $pix_layout['sidebar'] ); ?>

				<div class="<?php if ( $pix_layout['layout'] == 1 ) : ?>col-lg-12 col-md-12<?php else : ?>col-lg-8 col-md-8 left-column sidebar-type-<?php echo esc_attr($pix_layout['class']); ?><?php endif; ?> col-sm-12 col-xs-12">

                    <div class="rtd"> <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                    <?php $pixtheme_page_com_id = $post; ?>
                    <?php the_content(); ?>
                    <?php
                    if('open' == $pixtheme_page_com_id->comment_status) {
                        comments_template();
                    }
                    ?>
                    <?php endwhile; ?>
                    </div>
                </div>
                
                <?php pixtheme_show_sidebar( 'right', $pix_layout['layout'], $pix_layout['sidebar'] ); ?>
                
            </div>
        </div>
    </section>
<?php get_footer(); ?>