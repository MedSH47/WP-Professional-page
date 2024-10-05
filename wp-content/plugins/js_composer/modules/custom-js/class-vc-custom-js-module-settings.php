<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Module settings.
 * @since 7.7
 */
class Vc_Custom_Js_Module_Settings
{
	/**
	 * Init point.
	 *
	 * @since 7.7
	 */
	public function init() {
		add_filter( 'vc_settings_tabs', [$this, 'set_setting_tab'], 14 );

		add_action( 'vc_settings_set_sections', [$this, 'add_settings_section'] );

		add_action( 'vc-settings-render-tab-vc-custom_js', [$this, 'load_page_settings_custom_js'] );
	}

	/**
	 * Add module tab to settings.
	 *
	 * since 7.7
	 * @param array $tabs
	 * @return array
	 */
	public function set_setting_tab( $tabs ) {
		if ( vc_settings()->showConfigurationTabs() ) {
			if ( ! vc_is_as_theme() || apply_filters( 'vc_settings_page_show_design_tabs', false ) ) {
				$tabs['vc-custom_js'] = esc_html__( 'Custom JS', 'js_composer' );
			}
		}

		return $tabs;
	}

	/**
	 * Add sections to plugin settings tab.
	 */
	public function add_settings_section() {
		$tab = 'custom_js';
		vc_settings()->addSection( $tab );
		vc_settings()->addField( $tab, esc_html__( 'JavaScript in <head>', 'js_composer' ), 'custom_js_header', array(
			$this,
			'sanitize_custom_js_header_callback',
		), array(
			$this,
			'custom_js_header_field_callback',
		) );
		vc_settings()->addField( $tab, esc_html__( 'JavaScript before </body>', 'js_composer' ), 'custom_js_footer', array(
			$this,
			'sanitize_custom_js_footer_callback',
		), array(
			$this,
			'custom_js_footer_field_callback',
		) );
	}

	/**
	 * Sanitize custom js header.
	 *
	 * @since 7.7
	 * @param string $js
	 * @return string
	 */
	public function sanitize_custom_js_header_callback( $js ) {
		return $js;
	}

	/**
	 * Sanitize custom js footer.
	 *
	 * @since 7.7
	 * @param string $js
	 * @return string
	 */
	public function sanitize_custom_js_footer_callback( $js ) {
		return $js;
	}

	/**
	 * Load script for a custom js on our setting page.
	 *
	 * since 7.7
	 */
	public function load_page_settings_custom_js() {
		wp_enqueue_script( 'ace-editor', vc_asset_url( 'lib/vendor/node_modules/ace-builds/src-min-noconflict/ace.js' ), array( 'jquery-core' ), WPB_VC_VERSION, true );
	}

	/**
	 * Output custom js editor field for header tag.
	 *
	 * since 7.7
	 */
	public function custom_js_header_field_callback() {
		$value = get_option( vc_settings()::$field_prefix . 'custom_js_header' );
		if ( empty( $value ) ) {
			$value = '';
		}

		vc_include_template(
			'editors/vc-settings/custom-js.tpl.php',
			[
				'value' => $value,
				'field_prefix' => vc_settings()::$field_prefix,
				'area' => 'header',
			]
		);
	}

	/**
	 * Output custom js editor field for footer tag.
	 *
	 * since 7.7
	 */
	public function custom_js_footer_field_callback() {
		$value = get_option( vc_settings()::$field_prefix . 'custom_js_footer' );
		if ( empty( $value ) ) {
			$value = '';
		}

		vc_include_template(
			'editors/vc-settings/custom-js.tpl.php',
			[
				'value' => $value,
				'field_prefix' => vc_settings()::$field_prefix,
				'area' => 'footer',
			]
		);
	}
}
