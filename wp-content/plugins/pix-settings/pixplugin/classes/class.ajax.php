<?php


class PixCustom_Ajax {

	public $autos_per_page;

	public $order;

	public $orderby;

	public $metakey;

	protected static $orderby_arr = array('date', 'title');
	/**
	 * Class Constructor
	 * =================
	 * @since 1.0
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'init_plugin' ) );
        add_action( 'wp_ajax_pixcustom', array( $this, 'pixcustom' ) );
        add_action( 'wp_ajax_nopriv_pixcustom', array( $this, 'pixcustom' ) );
	}


	public function init_plugin() {
        wp_enqueue_script(
            'ajax_script',
            PIX_PLUGIN_URL . '/assets/js/pixtheme-ajax.js',
            array('jquery'),
            TRUE
        );
        wp_localize_script(
            'ajax_script',
            'pixcustomAjax',
            array(
                'url'   => admin_url( 'admin-ajax.php' ),
                'nonce' => wp_create_nonce( "pixcustom_nonce" ),
            )
        );
    }

    public function pixcustom() {
	    $data = array_map( 'esc_attr', $_POST );

        check_ajax_referer( 'pixcustom_nonce', 'nonce' );

        if( true && isset($data['department']) ){
            $out = '<option value="">'.esc_html__( 'Select Doctor', 'pixcustom' ).'</option>';
            $pix_portfolio = get_objects_in_term( $data['department'], 'pix-portfolio-cat' );
            $args_port = array(
                'post_type' => 'portfolio',
                'posts_per_page' => -1,
                'orderby' => 'menu_order',
                'post__in' => $pix_portfolio,
                'order' => 'ASC'
            );
            $portfolio = get_posts($args_port);
            if(empty($portfolio['errors'])){
                foreach($portfolio as $port_card){
                    $calendar_id = get_post_meta($port_card->ID, 'pix_portfolio_calendar', true);
                    if($calendar_id != '') {
                        $out .= '<option class="level-0" value="' . esc_attr($calendar_id) . '">' . wp_kses_post($port_card->post_title) . '</option>';
                    }
                }
            }
			wp_send_json_success($out);

        } else {
            wp_send_json_error(array('error' => $custom_error));
        }
    }

}
global $PixCustom_Ajax;
$PixCustom_Ajax = new PixCustom_Ajax();
?>