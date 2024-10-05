<?php /*** Portfolio Single Posts template. */
    
$pix_layout = pixtheme_get_layout(get_post_type(), get_the_ID());
$pix_width_class = pixtheme_get_layout_width( get_post_type() );

$pixtheme_portfolio_layout = get_post_meta( get_the_ID(), 'pix_portfolio_layout', true ) == '' ? 'default' : get_post_meta( get_the_ID(), 'pix_portfolio_layout', true );
$pixtheme_all_works_page = pixtheme_get_option('portfolio_settings_link_to_all', '0');
$full_portfolio = '';
if ( $pixtheme_all_works_page != 0 ) {
	$full_portfolio = get_the_permalink($pixtheme_all_works_page);
}

?>
<?php get_header();?>

<section class="blog">
	<div class="container <?php echo esc_attr($pix_width_class)?>">
		<div class="row">
            <?php pixtheme_show_sidebar( 'left', $pix_layout['layout'], $pix_layout['sidebar'] ); ?>

				<div class="<?php if ( $pix_layout['layout'] != 1 ) : ?>col-xl-9 col-lg-8 <?php endif; ?> col-12 <?php echo esc_attr($pix_layout['class'])?>">
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

<?php
if ( pixtheme_get_option( 'portfolio_settings_related_show', 'off' ) == 'on' ) :
	$pixtheme_portfolio_related_title = pixtheme_get_option( 'portfolio_settings_related_title', esc_html__('Related Posts', 'solutech' ) );
	$pixtheme_portfolio_related_desc = pixtheme_get_option( 'portfolio_settings_related_desc' );
	?>
	<!-- ========================== -->
	<!-- PORTFOLIO - RELATE WORKS SECTION -->
	<!-- ========================== -->
	<?php

	$portfolio_taxterms = wp_get_object_terms( $post->ID, 'portfolio_category', array('fields' => 'ids') );
	// arguments
	$args = array(
		'post_type' => 'portfolio',
		'post_status' => 'publish',
		'posts_per_page' => 3,
		'orderby' => 'rand',
		'tax_query' => array(
			array(
				'taxonomy' => 'portfolio_category',
				'field' => 'id',
				'terms' => $portfolio_taxterms
			)
		),
		'post__not_in' => array ($post->ID),
	);

	$the_query = new WP_Query( $args );

	if ( $the_query->have_posts() ) :

	?>
	<section class="portfolio-related-projects-section" id="portfolio_related_posts">
		<div class="container">
			<div class="portfolio-related-projects-section-inner" >
				<div class="section-heading text-center">
					<div class="section-title"><?php echo wp_kses_post($pixtheme_portfolio_related_title); ?></div>
					<div class="section-subtitle"><?php echo wp_kses_post($pixtheme_portfolio_related_desc); ?></div>
					<div class="design-arrow"></div>
				</div>

				<div class="row">
					<div class="list-works clearfix">
						<?php
						while ( $the_query->have_posts() ) :
							$the_query->the_post();

							$pixtheme_portfolio_thumbnail = get_the_post_thumbnail(get_the_ID(), 'pixtheme-portfolio-thumb', array('class' => 'img-responsive'));
							$pixtheme_portfolio_thumbnail_full = get_the_post_thumbnail_url(get_the_ID(), 'full');


						?>
							<div class="col-md-4 col-sm-4 col-xs-6">
								<div class="portfolio-item">
									<div class="portfolio-image">
										<a href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>"><?php echo wp_kses_post($pixtheme_portfolio_thumbnail); ?></a>
										<div class="gallery-item-hover">
                                            <a href="<?php echo esc_url( $pixtheme_portfolio_thumbnail_full ); ?>" class="fancybox">
                                                <span class="item-hover-icon"><i class="fa fa-search"></i></span>
                                            </a>
                                            <a href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>">
                                                <span class="item-hover-icon"><i class="fa fa-link"></i></span>
                                            </a>
                                        </div>
										<div class="portfolio-item-body">
											<div class="name"><?php echo wp_kses_post( get_the_title() ); ?></div>
											<div class="under-name"><?php echo pixtheme_get_post_terms( array( 'taxonomy' => 'portfolio_category', 'items_wrap' => '%s' ) ); ?></div>
										</div>
									</div>
								</div>
							</div>
						<?php
						endwhile;

						?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
	endif;
	wp_reset_postdata();
endif;
?>

<div class="service-page-footer">
	<div class="container">
        <span><?php previous_post_link( '%link', '<i class="fas fa-arrow-left"></i>'.esc_html__('Previous', 'solutech'), false, '', 'pix-portfolio-cat'); ?></span>
        <span class="pix-text-center">
        <?php if ( $full_portfolio != '' ) : ?>
        <a class="service-menu" href="<?php echo esc_url($full_portfolio); ?>"><i class="fas fa-th"></i></a>
        <?php else : ?>
        <a class="service-menu" href="<?php echo esc_url( get_post_type_archive_link( 'pix-portfolio' ) ); ?>"><i class="fas fa-th"></i></a>
        <?php endif; ?>
        </span>
        <span class="pix-text-right"><?php next_post_link( '%link', esc_html__('Next', 'solutech').'<i class="fas fa-arrow-right"></i>', false, '', 'pix-portfolio-cat' ); ?></span>
	</div>
</div>

<?php get_footer();?>