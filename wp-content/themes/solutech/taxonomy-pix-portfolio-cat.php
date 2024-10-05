<?php
/*** The template for displaying portfolio categories. ***/

$pix_layout = pixtheme_get_layout('portfolio-cat');
$pix_width_class = pixtheme_get_layout_width( 'portfolio-cat' );

$style = 'bottom-desc';

$pix_col = pixtheme_get_setting('pix-col-portfolio-cat', '2');
$pix_gap = '50';

$image_size = $image_class = pixtheme_get_setting('pix-images-portfolio-cat', '');
if($pix_col == 3){
    $image_size .= '-col-3';
} elseif($pix_col > 3) {
    $image_size .= '-col-4';
}
$image_size .= pixtheme_retina() ? '-retina' : '';

$pix_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );


get_header();

?>

<!-- ========================== -->
<!-- TAXONOMY - CONTENT -->
<!-- ========================== -->
<section class="blog pix-taxonomy">
    <div class="container <?php echo esc_attr($pix_width_class)?>">
        <div class="row">

			<?php pixtheme_show_sidebar( 'left', $pix_layout['layout'], $pix_layout['sidebar'] ); ?>

			<div class="<?php if ( $pix_layout['layout'] != 1 ) : ?>col-xl-9 col-lg-8<?php endif; ?> col-12 <?php echo esc_attr($pix_layout['class']); ?>">

				<div id="portfolio-category-section" class="pix-col-<?php echo esc_attr($pix_col); ?>">

				<?php $pix_category_description = get_term_field( 'description', $pix_term->term_id, 'pix-portfolio-cat' );
				if( !is_wp_error( $pix_category_description ) && $pix_category_description != '' ) :
				?>
					<div class="section-heading text-center">
						<div class="section-subtitle"><?php echo wp_kses_post($pix_category_description);?></div>
					</div>

				<?php
				endif;

                $pix_categories = get_objects_in_term( $pix_term->term_id, 'pix-portfolio-cat');

                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                $args = array(
                    'post_type' => 'pix-portfolio',
                    'orderby' => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
                    'post__in' => $pix_categories,
                    'posts_per_page' => -1,
                    //'paged' => $paged
                );

                $wp_query = new WP_Query( $args );

                if ( $wp_query->have_posts() ) : ?>
                    
                    <div class="pix-isotope pix-portfolio">
                        <div class="pix-isotope-items pix-<?php echo esc_attr($style) ?> pix-col-<?php echo esc_attr($pix_col); ?> pix-gap-<?php echo esc_attr($pix_gap); ?>">
                            <div class="pix-gutter-sizer"></div>

                <?php
                    while ( $wp_query->have_posts() ) :
                        $wp_query->the_post();

                        $cats = wp_get_object_terms(get_the_id(), 'pix-portfolio-cat');
                        $pixtheme_cat_slugs = '';
                        if ( ! empty($cats) ) {
                            foreach ( $cats as $cat ) {
                                $pixtheme_cat_slugs .= $cat->slug . " ";
                            }
                        }
                        $thumbnail = get_the_post_thumbnail(get_the_ID(), $image_size, array('class' => $image_class.' pix-img-greyscale'));

                        // potfolio category list linked
                        $pix_linked_list_cats = pixtheme_get_post_terms( array( 'taxonomy' => 'pix-portfolio-cat', 'items_wrap' => '%s' ) );

                ?>

                            <div class="pix-isotope-item pix-box">
                        
                <?php
                        if( $style == 'hover-info' ){
                            $out_content = '
                                <div class="pix-hover-container">
                                    <h3><a href="' . esc_url(get_the_permalink()) . '">' . wp_kses_post(get_the_title()) . '</a></h3>
                                    <p>' . wp_kses_post($pix_linked_list_cats) . '</p>
                                </div>
                                ' . wp_kses_post($thumbnail);
                            
                        } elseif($style == 'bottom-desc') {
                            $out_content = '
                                <div class="pix-box-img">
                                    <a href="' . esc_url(get_the_permalink()) . '">
                                        <div class="pix-img-wrapper">' . wp_kses_post($thumbnail) . '</div>
                                    </a>
                                </div>
                                <div class="pix-box-text">
                                    <div class="pix-box-name">
                                        <a href="' . esc_url(get_the_permalink()) . '">' . wp_kses_post(get_the_title()) . '</a>
                                    </div>
                                    '.pixtheme_limit_words(get_the_excerpt(), 20, 'p').'
                                </div>
                                <span class=""><a href="'.esc_url(get_permalink(get_the_ID())).'"></a></span>';
                        } else {
                            
                            $out_content = '
                                <div class="pix-box-img">
                                    <a href="' . esc_url(get_the_permalink()) . '">
                                        ' . wp_kses_post($thumbnail) . '
                                    </a>
                                </div>
                                <div class="pix-box-name">
                                    <a href="' . esc_url(get_the_permalink()) . '">' . wp_kses_post(get_the_title()) . '</a>
                                </div>';
                        }
                        echo wp_kses_post($out_content);
                ?>
                        
                            </div>

                <?php
                    endwhile;
                ?>
                        </div>
                    </div>

                <?php
                endif;
				?>
    
                <?php
                $t_slug = $pix_term->slug;
                $cat_meta = get_option("pix-portfolio-cat_$t_slug");
                $pix_section_id = in_array($cat_meta['pix_cat_section'], array('global', '')) ? '' : $cat_meta['pix_cat_section'];
                if(function_exists('icl_object_id')) {
                    $pix_section_id = icl_object_id ($pix_section_id,'pix-section',true);
                }
                if ( $pix_section_id )  {
                    pixtheme_get_section_content($pix_section_id);
                }
                ?>

			</div>

			<?php pixtheme_show_sidebar( 'right', $pix_layout['layout'], $pix_layout['sidebar'] ); ?>

		</div>
	</div>
</section>

<?php get_footer(); ?>