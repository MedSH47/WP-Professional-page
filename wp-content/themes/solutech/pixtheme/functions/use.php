<?php

function pixtheme_use_portfolio() {
    return pixtheme_get_setting('pix-portfolio', 'off') == 'on';
}

function pixtheme_use_service() {
    return pixtheme_get_setting('pix-service', 'off') == 'on';
}

function pixtheme_use_section() {
    return class_exists( 'Pix_Section' );
}

function pixtheme_use_template() {
    return class_exists( 'Pix_Templates' );
}

function pixtheme_use_woo() {
    return class_exists( 'WooCommerce' );
}

function pixtheme_use_wishlist() {
    return class_exists( 'WPCleverWoosw' );
}

function pixtheme_use_compare() {
    return class_exists( 'WPCleverWoosc' );
}

function pixtheme_use_custom_plugin() {
    return class_exists( 'Pix_Settings' );
}
