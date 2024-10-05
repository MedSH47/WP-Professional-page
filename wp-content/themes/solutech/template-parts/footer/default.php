<?php
$post_ID = isset( $wp_query ) ? $wp_query->get_queried_object_id() : ( get_the_ID() > 0 ? get_the_ID() : '' );

$footer_section_id = false;
$footer_section_id = ( in_array( get_post_meta( $post_ID, 'solutech_page_footer', true ), array( 'global', '' ) ) || $post_ID == '' ) ? solutech_get_option( 'footer_block', 'default' ) : get_post_meta( $post_ID, 'solutech_page_footer', true );

if(has_filter('wpml_object_id')) {
    $footer_section_id = apply_filters( 'wpml_object_id', $footer_section_id, 'pix-section', true );
}

?>
<?php if ( solutech_use_section() && $footer_section_id && ( $footer_section_id != 'empty' || $footer_section_id != 'default' ) ) : ?>

<footer class="footer">
    <?php if( solutech_get_option( 'use_bg_parallax', true ) ) : ?>
    <div id="parallax-footer" class="parallax-levels in-footer">
        <div class="level1">
            <div class="parallax-item-1 h-3 parallax-item left"></div>
            <div class="parallax-item-4 h-5 parallax-item right"></div>
        </div>
        <div class="level2">
            <div class="parallax-item-3 h-4 parallax-item left"></div>
            <div class="parallax-item-7 h-6 parallax-item left"></div>
        </div>
        <div class="level3">
            <div class="parallax-item-5 h-4 parallax-item left"></div>
        </div>
    </div>
    <?php endif; ?>
    <div class="container">
        <?php solutech_get_section_content( $footer_section_id ); ?>
    </div>
</footer>
<?php endif; ?>

<?php if ( ! $footer_section_id || ! solutech_use_section() || 'default' === $footer_section_id ) : ?>
<footer class="footer">
    <div class="container">
        <div class="py-40 text-center">
            <div class="footer__copyright">
                <?php $solutech_copyright_text = solutech_get_option( 'footer_copyright_text', sprintf( esc_html__( '© %s Solutech Company ltd', 'solutech' ), date( 'Y' ) ) ); ?>
                <?php echo wp_kses( $solutech_copyright_text, 'solutech-default' ); ?>
            </div>
        </div>
    </div>
</footer>
<?php endif;
