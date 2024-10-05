<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="col">
    <div class="productCard productCard-not-found">
        <div class="productCard__img">
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/box.png" alt="<?php echo esc_attr__( 'No products found', 'solutech' ); ?>">
        </div>

        <div class="productCard__info">
            <div class="productCard__infoTitle"><?php echo esc_html__( 'No products found', 'solutech' ); ?></div>
        </div>
    </div>
</div>
