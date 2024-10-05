<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/** @var bool $is_about_page */
?>
<img class="vc-featured-img" src="<?php echo esc_url( vc_asset_url( 'vc/wpb-7-7-about.png' ) ); ?>"/>

<div class="vc-feature-text">
	<h3><?php esc_html_e( 'Module Manager, AI in the Classic Editor & Element Caching', 'js_composer' ); ?></h3>

	<p><?php esc_html_e( 'Manage which modules (like Custom Code, Skin Builder, Shortcode Mapper, etc.) are loaded and available in the editor. Use WPBakery AI in the Classic Editor to generate, improve, and translate texts, and enjoy improved editor performance with element caching after every edit.', 'js_composer' ); ?></p>
	<ul>
		<li><?php esc_html_e( 'Control modules with Module Manager', 'js_composer' ); ?></li>
		<li><?php esc_html_e( 'Utilize WPBakery AI in the Classic Editor', 'js_composer' ); ?></li>
		<li><?php esc_html_e( 'Caching for Element Settings ', 'js_composer' ); ?></li>
	</ul>
	<?php
	$tabs = vc_settings()->getTabs();
	$is_license_tab_access = isset( $tabs['vc-updater'] ) && vc_user_access()->part( 'settings' )->can( 'vc-updater-tab' )->get();
	if ( $is_about_page && ! vc_license()->isActivated() && $is_license_tab_access ) : ?>
		<div class="vc-feature-activation-section">
			<?php $url = 'admin.php?page=vc-updater'; ?>
			<a href="<?php echo esc_attr( is_network_admin() ? network_admin_url( $url ) : admin_url( $url ) ); ?>" class="vc-feature-btn" id="vc_settings-updater-button" data-vc-action="activation"><?php esc_html_e( 'Activate License', 'js_composer' ); ?></a>
			<p class="vc-feature-info-text">
				<?php esc_html_e( 'Direct plugin activation only.', 'js_composer' ); ?>
				<a href="https://wpbakery.com/wpbakery-page-builder-license/?utm_source=wpdashboard&utm_medium=wpb-settings-about-whats-new&utm_content=text" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Don\'t have a license?', 'js_composer' ); ?></a>
			</p>
		</div>
	<?php endif; ?>
</div>
