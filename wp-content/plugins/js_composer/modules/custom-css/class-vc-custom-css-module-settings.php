<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Module settings.
 * @since 7.7
 */
class Vc_Custom_Css_Module_Settings
{
	/**
	 * Init point.
	 *
	 * @since 7.7
	 */
	public function init() {
		add_filter( 'vc_settings_tabs', [$this, 'set_setting_tab'], 13 );

		add_action( 'vc_settings_set_sections', [$this, 'add_settings_section'] );

		add_action( 'vc-settings-render-tab-vc-custom_css', [$this, 'load_page_settings_custom_css'] );
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
				$tabs['vc-custom_css'] = esc_html__( 'Custom CSS', 'js_composer' );
			}
		}

		return $tabs;
	}

	/**
	 * Add sections to plugin settings tab.
	 */
	public function add_settings_section() {
		$tab = 'custom_css';
		vc_settings()->addSection( $tab );
		vc_settings()->addField( $tab, esc_html__( 'Paste your CSS code', 'js_composer' ), 'custom_css', array(
			$this,
			'sanitize_custom_css_callback',
		), array(
			$this,
			'custom_css_field_callback',
		), array(
			'info' => esc_html__( 'Add custom CSS code to the plugin without modifying files.', 'js_composer' )
		) );
	}

	/**
	 * Sanitize custom css.
	 *
	 * @since 7.7
	 * @param string $css
	 * @return string
	 */
	public function sanitize_custom_css_callback( $css ) {
		return wp_strip_all_tags( $css );
	}

	/**
	 * Output custom css editor field.
	 *
	 * since 7.7
	 */
	public function custom_css_field_callback() {
		$value = get_option( vc_settings()::$field_prefix . 'custom_css' );
		if ( empty( $value ) ) {
			$value = '';
		}

		vc_include_template(
			'editors/vc-settings/custom-css.tpl.php',
			[
				'value' => $value,
				'field_prefix' => vc_settings()::$field_prefix,
			]
		);
	}

	/**
	 * Load script for a custom css on our setting page.
	 *
	 * since 7.7
	 */
	public function load_page_settings_custom_css() {
		wp_enqueue_script( 'ace-editor', vc_asset_url( 'lib/vendor/node_modules/ace-builds/src-min-noconflict/ace.js' ), array( 'jquery-core' ), WPB_VC_VERSION, true );
	}
}
