<?php /*** Single PixSection template. */


?>
<?php get_header();?>
    <section class="page-content" >
        <div class="container">
            <div class="row">

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                   <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		                <?php the_content(); ?>

                    <?php endwhile; ?>

                </div>

            </div>
        </div>
    </section>
<?php get_footer(); ?>