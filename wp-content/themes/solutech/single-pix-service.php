 <?php /* Template Name: Single Service */
    
$pix_layout = pixtheme_get_layout(get_post_type(), get_the_ID());
$pix_width_class = pixtheme_get_layout_width( get_post_type() );

get_header();
?>

<section class="blog service">
    <div class="container <?php echo esc_attr($pix_width_class)?>">
        <div class="row">
      
		<?php pixtheme_show_sidebar( 'left', $pix_layout['layout'], $pix_layout['sidebar'] ); ?>
        
            <div class="<?php if ( $pix_layout['layout'] != 1 ) : ?>col-xl-9 col-lg-8<?php endif; ?> col-12 <?php echo esc_attr($pix_layout['class']); ?>">
                <div class="rtd">
                <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; ?>
                </div>
		    </div>

		<?php pixtheme_show_sidebar( 'right', $pix_layout['layout'], $pix_layout['sidebar'] ); ?>

		</div>
	</div>
</section>

<?php get_footer();?>