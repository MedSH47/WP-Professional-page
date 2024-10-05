<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 *
 */
    
$pix_layout = pixtheme_get_layout(get_post_type(), get_the_ID());
$pix_width_class = pixtheme_get_layout_width( get_post_type() );

?>

<?php get_header();?>
    <section class="blog" >
        <div class="container <?php echo esc_attr($pix_width_class)?>">
            <div class="row">
            
                <?php pixtheme_show_sidebar( 'left', $pix_layout['layout'], $pix_layout['sidebar'] ); ?>

				<div class="<?php if ( $pix_layout['layout'] != 1 ) : ?>col-xl-9 col-lg-8 <?php endif; ?> col-12 <?php echo esc_attr($pix_layout['class'])?>">

                    <div class="rtd"> <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                    <?php $pixtheme_page_com_id = $post; ?>
                    <?php the_content(); ?>
                    <?php
                        $args = array(
                            'before' => '<p class="pix-link-pages"><span>'.esc_html__('Pages:', 'solutech').'</span>',
                            'after'  => '</p>',
                        );
                        wp_link_pages($args);
                    ?>
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