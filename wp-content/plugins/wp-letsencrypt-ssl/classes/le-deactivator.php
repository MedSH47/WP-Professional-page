<?php

/**
 * @package WP Encryption
 *
 * @author     Go Web Smarty
 * @copyright  Copyright (C) 2019-2024, Go Web Smarty
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link       https://gowebsmarty.com
 * @since      Class available since Release 1.0.0
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
class WPLE_Deactivator {
    public static function deactivate() {
        $opts = ( get_option( 'wple_opts' ) === FALSE ? array(
            'expiry' => '',
        ) : get_option( 'wple_opts' ) );
        //disable ssl forcing
        $opts['force_ssl'] = 0;
        update_option( 'wple_opts', $opts );
        // retained - wple_opts, wple_show_reminder, wple_send_usage, wple_error, wple_complete, wple_failed_verification, wple_mixed_issues, wple_priv_key
        $opts_to_delete = array(
            'wple_backup_suggested',
            'wple_show_review',
            'wple_have_cpanel',
            'wple_plan_choose',
            'wple_no_pricing',
            'wple_mx',
            'wple_http_valid',
            'wple_email_certs',
            'wple_ssl_errors',
            'wple_ssl_valid',
            'wple_version',
            'wple_backend',
            'wple_last_error',
            'wple_ldebug_lasthttp',
            'wple_ldebug_lastdns',
            'wple_mixed_issues_disabled',
            'wple_show_review_disabled',
            'wple_error',
            'wple_ssl_screen',
            'wple_sectigo',
            'wple_failed_verification',
            'wple_sourceip',
            'wple_order_refreshed',
            'wple_sourceip_enable',
            'wple_parent_reachable'
        );
        foreach ( $opts_to_delete as $optname ) {
            delete_option( $optname );
        }
        delete_transient( 'wple_ssllabs' );
        //clear reminder cron
        if ( wp_next_scheduled( 'wple_ssl_reminder_notice' ) ) {
            wp_clear_scheduled_hook( 'wple_ssl_reminder_notice' );
        }
        //clear daily vuln scan
        if ( wp_next_scheduled( 'wple_init_vulnerability_scan' ) ) {
            wp_clear_scheduled_hook( 'wple_init_vulnerability_scan' );
        }
        //clear daily ssl scan
        if ( wp_next_scheduled( 'wple_ssl_expiry_update' ) ) {
            wp_clear_scheduled_hook( 'wple_ssl_expiry_update' );
        }
        //remove debug log
        if ( file_exists( WPLE_DEBUGGER . 'debug.log' ) ) {
            @unlink( WPLE_DEBUGGER . 'debug.log' );
        }
        //clean force https rules in htaccess
        if ( is_writable( ABSPATH . '.htaccess' ) ) {
            $htaccess = file_get_contents( ABSPATH . '.htaccess' );
            $group = "/#\\s?BEGIN\\s?WP_Encryption_Force_SSL.*?#\\s?END\\s?WP_Encryption_Force_SSL/s";
            if ( preg_match( $group, $htaccess ) ) {
                $modhtaccess = preg_replace( $group, "", $htaccess );
                //insert_with_markers(ABSPATH . '.htaccess', '', $modhtaccess);
                file_put_contents( ABSPATH . '.htaccess', $modhtaccess );
            }
        }
    }

}
