<?php
/**
 * The template for displaying a "No posts found" message
 *
 */
?>

<div class="alert alert-danger mb-40" role="alert">
    <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
        <b><?php echo esc_html__( 'Ready to publish your first post?', 'solutech' ); ?>
        <br><?php printf( '<a href="%1$s">' . esc_html__( 'Get started here', 'solutech' ) . '</a>', esc_url( admin_url( 'post-new.php' ) ) ); ?></b>
    <?php elseif ( is_search() ) : ?>
        <b><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'solutech' ); ?></b>
    <?php else : ?>
        <b><?php esc_html_e( 'It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'solutech' ); ?></b>
    <?php endif; ?>
</div>
<img class="ml-xl-150 mr-xl-150 mb-0" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/ooops.svg" alt="<?php echo esc_attr__( 'No posts found', 'solutech' ); ?>">
