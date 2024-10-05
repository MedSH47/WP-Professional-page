<?php

/**
 * @package WP Encryption
 *
 * @author     Go Web Smarty
 * @copyright  Copyright (C) 2019-2024, Go Web Smarty
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link       https://gowebsmarty.com
 * @since      Class available since Release 4.3.0
 *
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 */
class WPLE_Activator {
    public static function activate( $networkwide ) {
        $opts = ( get_option( 'wple_opts' ) === FALSE ? array(
            'expiry' => '',
        ) : get_option( 'wple_opts' ) );
        update_option( 'wple_opts', $opts );
        update_option( 'wple_version', WPLE_PLUGIN_VER );
        WPLE_Trait::wple_cpanel_identity();
        if ( isset( $opts['expiry'] ) && $opts['expiry'] != '' ) {
            do_action( 'cert_expiry_updated' );
        }
        wp_schedule_single_event( time() + 10, 'wple_init_ssllabs' );
        delete_option( 'wple_error' );
        delete_option( 'wple_sectigo' );
        delete_option( 'wple_ssl_screen' );
        // wp_redirect(admin_url('/admin.php?page=wp_encryption'), 302); //causes ajax activation error msg
    }

}
