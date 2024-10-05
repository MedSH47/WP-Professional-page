<?php header("Content-type: text/css; charset: UTF-8");

$page_id = isset($_REQUEST['pageID']) ? $_REQUEST['pageID'] : 0;

function pix_hash($val){
    return esc_attr(str_replace('#', '%23', $val));
}

$pixtheme_customize = get_option( 'pixtheme_customize_options' );


$pixtheme_font = pixtheme_get_option('font', get_option('pixtheme_default_font'));
$pixtheme_font_weight = pixtheme_get_option('font_weight', get_option('pixtheme_default_font_weight'));
$pixtheme_font_size = pixtheme_get_option('font_size', get_option('pixtheme_default_font_size'));
$pixtheme_font_line_height = pixtheme_get_option('font_line_height', get_option('pixtheme_default_font_line_height'));
$line_height = round($pixtheme_font_size * $pixtheme_font_line_height);
$line_height_em = round($line_height / $pixtheme_font_size, 3);
$pixtheme_font_ratio = pixtheme_get_option('font_ratio', get_option('pixtheme_default_font_ratio'));
$large_size = $pixtheme_font_size + 2;
$small_size = round(1 / $pixtheme_font_ratio, 3);
$h5_size = round(1 * $pixtheme_font_ratio, 3);
$h4_size = round($h5_size * $pixtheme_font_ratio, 3);
$h3_size = round($h4_size * $pixtheme_font_ratio, 3);
$h2_size = round($h3_size * $pixtheme_font_ratio, 3);
$h1_size = round($h2_size * $pixtheme_font_ratio, 3);
$pixtheme_font_color = pixtheme_get_option('font_color', get_option('pixtheme_default_font_color'));
$pixtheme_font_color_light = pixtheme_get_option('font_color_light', get_option('pixtheme_default_font_color_light'));

$pixtheme_title = pixtheme_get_option('title_font', get_option('pixtheme_default_title_font'));
$pixtheme_title_weight = pixtheme_get_option('title_font_weight', get_option('pixtheme_default_title_weight'));
$pixtheme_title_size = pixtheme_get_option('title_font_size', get_option('pixtheme_default_title_size'));
$pixtheme_title_style = pixtheme_get_option('title_font_style', 'normal');
$pixtheme_title_color = pixtheme_get_option('title_font_color', get_option('pixtheme_default_title_color'));
$pixtheme_title_letter_spacing = pixtheme_get_option('title_letter_spacing', '0');

$pixtheme_subtitle = pixtheme_get_option('subtitle_font', get_option('pixtheme_default_subtitle_font'));
$pixtheme_subtitle_weight = pixtheme_get_option('subtitle_font_weight', get_option('pixtheme_default_subtitle_weight'));
$pixtheme_subtitle_size = pixtheme_get_option('subtitle_font_size', get_option('pixtheme_default_subtitle_size'));
$pixtheme_subtitle_style = pixtheme_get_option('subtitle_font_style', 'normal');
$pixtheme_subtitle_color = pixtheme_get_option('subtitle_font_color', get_option('pixtheme_default_subtitle_color'));
$pixtheme_subtitle_letter_spacing = pixtheme_get_option('subtitle_letter_spacing', '0');

$pixtheme_hlink = pixtheme_get_option('link_font', get_option('pixtheme_default_link_font'));
$pixtheme_hlink_weight = pixtheme_get_option('link_font_weight', get_option('pixtheme_default_link_weight'));
$pixtheme_hlink_size = pixtheme_get_option('link_font_size', get_option('pixtheme_default_link_size'));
$pixtheme_hlink_style = pixtheme_get_option('link_font_style', 'normal');
$pixtheme_hlink_color = pixtheme_get_option('link_font_color', get_option('pixtheme_default_link_color'));

$pixtheme_main_color = pixtheme_get_option('style_settings_main_color', get_option('pixtheme_default_main_color'));
$pixtheme_gradient_color = pixtheme_get_option('style_settings_gradient_color', get_option('pixtheme_default_gradient_color'));
$pixtheme_gradient_direction = pixtheme_get_option('gradient_direction', get_option('pixtheme_default_gradient_direction'));
$pixtheme_additional_color = pixtheme_get_option('style_settings_additional_color', get_option('pixtheme_default_additional_color'));
$pixtheme_black_color = pixtheme_get_option('style_settings_black_color', get_option('pixtheme_default_black_color'));
$pixtheme_dark = pixtheme_get_option('style_theme_tone', '') == '' ? '#333' : '#fff';

$page_color = get_post_meta($page_id, 'page_main_color', 1);
$page_additional_color = get_post_meta($page_id, 'page_additional_color', 1);
if($page_color){
	$pixtheme_main_color = $page_color;
}
if($page_additional_color){
	$pixtheme_additional_color = $page_additional_color;
}

$page_layout = get_post_meta($page_id, 'page_layout', 1) != '' ? get_post_meta($page_id, 'page_layout', 1) : pixtheme_get_option('style_general_settings_layout', 'normal');
$page_bg_image = get_post_meta($page_id, 'boxed_bg_image', 1) != '' ? get_post_meta($page_id, 'boxed_bg_image', 1) : pixtheme_get_option('general_settings_bg_image', '');
$page_bg_color = get_post_meta($page_id, 'page_bg_color', 1) != '' ? get_post_meta($page_id, 'page_bg_color', 1) : pixtheme_get_option('style_settings_bg_color', '');

$tab_bg_image_size = pixtheme_get_option('tab_bg_image_size', 'cover');
$tab_bg_image_repeat = pixtheme_get_option('tab_bg_image_repeat', 'no-repeat');
$tab_bg_image_horizontal_pos = pixtheme_get_option('tab_bg_image_horizontal_pos', '50');
$tab_bg_image_vertical_pos = pixtheme_get_option('tab_bg_image_vertical_pos', '50');
$tab_bg_image_fixed = pixtheme_get_option('tab_bg_image_fixed', '');
$tab_bg_color = pixtheme_get_option('tab_bg_color', get_option('pixtheme_default_tab_bg_color')); //pixtheme_hex2rgb(pixtheme_get_option('tab_bg_color', '#000000'));
$tab_bg_color_gradient = pixtheme_get_option('tab_bg_color_gradient', get_option('pixtheme_default_tab_bg_color_gradient'));
$tab_gradient_direction = pixtheme_get_option('tab_gradient_direction', get_option('pixtheme_default_tab_gradient_direction'));
$tab_bg_opacity = pixtheme_get_option('tab_bg_opacity', get_option('pixtheme_default_tab_bg_opacity'))/100;
$tab_padding_top = pixtheme_get_option('tab_padding_top', get_option('pixtheme_default_tab_padding_top'));
$tab_padding_top_levels = pixtheme_get_option('general_settings_logo_height', get_option('pixtheme_default_logo_height')) + 120;
$tab_padding_bottom = pixtheme_get_option('tab_padding_bottom', get_option('pixtheme_default_tab_padding_bottom'));
$tab_margin_bottom = pixtheme_get_option('tab_margin_bottom', get_option('pixtheme_default_tab_margin_bottom'));

$gradient_direction = $tab_gradient_direction == '' ? 'to right' : $tab_gradient_direction;
$pix_directions_arr = array(
    'to right' => array('-webkit' => 'left', '-o-linear' => 'right', '-moz-linear' => 'right', 'linear' => 'to right',),
    'to left' => array('-webkit' => 'right', '-o-linear' => 'left', '-moz-linear' => 'left', 'linear' => 'to left',),
    'to bottom' => array('-webkit' => 'top', '-o-linear' => 'bottom', '-moz-linear' => 'bottom', 'linear' => 'to bottom',),
    'to top' => array('-webkit' => 'bottom', '-o-linear' => 'top', '-moz-linear' => 'top', 'linear' => 'to top',),
    'to bottom right' => array('-webkit' => 'left top', '-o-linear' => 'bottom right', '-moz-linear' => 'bottom right', 'linear' => 'to bottom right',),
    'to bottom left' => array('-webkit' => 'right top', '-o-linear' => 'bottom left', '-moz-linear' => 'bottom left', 'linear' => 'to bottom left',),
    'to top right' => array('-webkit' => 'left bottom', '-o-linear' => 'top right', '-moz-linear' => 'top right', 'linear' => 'to top right',),
    'to top left' => array('-webkit' => 'right bottom', '-o-linear' => 'top left', '-moz-linear' => 'top left', 'linear' => 'to top left',),
    //'angle' => array('-webkit' => $gradient_angle.'deg', '-o-linear' => $gradient_angle.'deg', '-moz-linear' => $gradient_angle.'deg', 'linear' => $gradient_angle.'deg',),
);
$pix_reverse_directions_arr = array(
    'to right' => array('-webkit' => 'right', '-o-linear' => 'left', '-moz-linear' => 'left', 'linear' => 'to left',),
    'to left' => array('-webkit' => 'left', '-o-linear' => 'right', '-moz-linear' => 'right', 'linear' => 'to right',),
    'to bottom' => array('-webkit' => 'bottom', '-o-linear' => 'top', '-moz-linear' => 'top', 'linear' => 'to top',),
    'to top' => array('-webkit' => 'top', '-o-linear' => 'bottom', '-moz-linear' => 'bottom', 'linear' => 'to bottom',),
    'to bottom right' => array('-webkit' => 'bottom right', '-o-linear' => 'left top', '-moz-linear' => 'left top', 'linear' => 'to left top',),
    'to bottom left' => array('-webkit' => 'bottom left', '-o-linear' => 'right top', '-moz-linear' => 'right top', 'linear' => 'to right top',),
    'to top right' => array('-webkit' => 'top right', '-o-linear' => 'left bottom', '-moz-linear' => 'left bottom', 'linear' => 'to left bottom',),
    'to top left' => array('-webkit' => 'top left', '-o-linear' => 'right bottom', '-moz-linear' => 'right bottom', 'linear' => 'to right bottom',),
    //'angle' => array('-webkit' => $gradient_angle.'deg', '-o-linear' => $gradient_angle.'deg', '-moz-linear' => $gradient_angle.'deg', 'linear' => $gradient_angle.'deg',),
);

$decor_show = pixtheme_get_option('decor_show', get_option('pixtheme_default_decor'));
$decor_img = pixtheme_get_option('decor_img', '');
$decor_width = pixtheme_get_option('decor_width', '40');
$decor_height = pixtheme_get_option('decor_height', '20');

$buttons_border = pixtheme_get_option('buttons_border', get_option('pixtheme_default_button_border'));
$buttons_font = pixtheme_get_option('buttons_font', get_option('pixtheme_default_button_font'));
$buttons_font_size = pixtheme_get_option('buttons_font_size', get_option('pixtheme_default_button_font_size'));
$buttons_font_weight = pixtheme_get_option('buttons_font_weight', get_option('pixtheme_default_button_font_weight'));
$buttons_font_style = pixtheme_get_option('buttons_font_style', 'normal');
$buttons_text_transform = pixtheme_get_option('buttons_text_transform', 'none');
$buttons_letter_spacing = pixtheme_get_option('buttons_letter_spacing', '0');
$buttons_shadow = pixtheme_get_option('buttons_shadow', '1');
$buttons_shadow_color = $pixtheme_main_color;
$buttons_color = pixtheme_get_option('buttons_color', get_option('pixtheme_default_button_color'));

$loader_img = pixtheme_get_option('loader_img', '');

$header_border = pixtheme_get_option('header_border', '0');

?>
:root{
    --pix-header-transparent: <?php echo esc_attr(pixtheme_get_option('header_transparent', '0')/100)?>;
    --pix-header-menu-transparent: <?php echo esc_attr(pixtheme_get_option('header_menu_transparent', '100')/100)?>;
    --pix-header-height: <?php echo esc_attr(pixtheme_get_option('general_settings_logo_height', get_option('pixtheme_default_logo_height')))?>px;
    --pix-header-height-levels: <?php echo esc_attr(pixtheme_get_option('general_settings_logo_height', get_option('pixtheme_default_logo_height'))+38)?>px;
    --pix-top-bar-transparent: <?php echo esc_attr(pixtheme_get_option('top_bar_transparent', '100')/100)?>;

    --pix-main-color: <?php echo esc_attr($pixtheme_main_color)?>;
    --pix-main-color-lighter: <?php echo pixtheme_lighten_darken_color($pixtheme_main_color, 12)?>;
    --pix-main-color-lighter-2x: <?php echo pixtheme_lighten_darken_color($pixtheme_main_color, 24)?>;
    --pix-main-color-darker: <?php echo pixtheme_lighten_darken_color($pixtheme_main_color, -24)?>;
    --pix-main-color-hex: <?php echo esc_attr(pixtheme_hex2rgb($pixtheme_main_color))?>;
    --pix-gradient-color: <?php echo esc_attr($pixtheme_gradient_color)?>;
    --pix-gradient-direction-webkit: <?php echo esc_attr($pix_directions_arr[$pixtheme_gradient_direction]['-webkit'])?>;
    --pix-gradient-direction-o: <?php echo esc_attr($pix_directions_arr[$pixtheme_gradient_direction]['-o-linear'])?>;
    --pix-gradient-direction-moz: <?php echo esc_attr($pix_directions_arr[$pixtheme_gradient_direction]['-moz-linear'])?>;
    --pix-gradient-direction: <?php echo esc_attr($pix_directions_arr[$pixtheme_gradient_direction]['linear'])?>;
    --pix-gradient-reverse-direction-webkit: <?php echo esc_attr($pix_reverse_directions_arr[$pixtheme_gradient_direction]['-webkit'])?>;
    --pix-gradient-reverse-direction-o: <?php echo esc_attr($pix_reverse_directions_arr[$pixtheme_gradient_direction]['-o-linear'])?>;
    --pix-gradient-reverse-direction-moz: <?php echo esc_attr($pix_reverse_directions_arr[$pixtheme_gradient_direction]['-moz-linear'])?>;
    --pix-gradient-reverse-direction: <?php echo esc_attr($pix_reverse_directions_arr[$pixtheme_gradient_direction]['linear'])?>;
    --pix-additional-color: <?php echo esc_attr($pixtheme_additional_color)?>;
    --pix-additional-color-rgb: <?php echo esc_attr(pixtheme_hex2rgb($pixtheme_additional_color))?>;
    --pix-white-color: #ffffff;
    --pix-black-color: <?php echo esc_attr($pixtheme_black_color)?>;
    --pix-black-color-hex: <?php echo esc_attr(pixtheme_hex2rgb($pixtheme_black_color))?>;
    --pix-black-color-lighter: <?php echo pixtheme_lighten_darken_color($pixtheme_black_color, 24)?>;
    --pix-black-color-lighter-2x: <?php echo pixtheme_lighten_darken_color($pixtheme_black_color, 48)?>;

    --pix-shadow: 0 0px 5px rgba(0,0,0,.1), 0 5px 20px rgba(0,0,0,0.1);
    --pix-text-shadow: none; /*1px 1px 0 rgba(0,0,0,.18);*/

<?php if($buttons_color == 'main') : ?>
        --pix-button-color: <?php echo esc_attr($pixtheme_main_color)?>;
        --pix-button-color-lighter: <?php echo pixtheme_lighten_darken_color($pixtheme_main_color, 24)?>;
        --pix-button-color-darker: <?php echo pixtheme_lighten_darken_color($pixtheme_main_color, 12)?>;
        --pix-button-color-hex: <?php echo esc_attr(pixtheme_hex2rgb($pixtheme_main_color))?>;
<?php elseif($buttons_color == 'additional') :?>
        --pix-button-color: <?php echo esc_attr($pixtheme_additional_color)?>;
        --pix-button-color-lighter: <?php echo pixtheme_lighten_darken_color($pixtheme_additional_color, 34)?>;
        --pix-button-color-darker: <?php echo pixtheme_lighten_darken_color($pixtheme_additional_color, 12)?>;
        --pix-button-color-hex: <?php echo esc_attr(pixtheme_hex2rgb($pixtheme_additional_color))?>;
        <?php $buttons_shadow_color = $pixtheme_additional_color; ?>
<?php elseif($buttons_color == 'black') :?>
        --pix-button-color: <?php echo esc_attr($pixtheme_black_color)?>;
        --pix-button-color-hex: <?php echo esc_attr(pixtheme_hex2rgb($pixtheme_black_color))?>;
<?php elseif($buttons_color == 'white') :?>
        --pix-button-color: #ffffff;
        --pix-button-color-hex: <?php echo esc_attr(pixtheme_hex2rgb('ffffff'))?>;
<?php else :?>
        --pix-button-color: <?php echo esc_attr($pixtheme_main_color)?>;
        --pix-button-color-hex: <?php echo esc_attr(pixtheme_hex2rgb($pixtheme_main_color))?>;
<?php endif; ?>

    --pix-main-font: <?php echo esc_attr($pixtheme_font)?>;
    --pix-font-size: <?php echo esc_attr($pixtheme_font_size)?>px;
    --pix-font-size-larger: <?php echo esc_attr($large_size)?>px;
    --pix-font-size-smaller: 0.8em;
    --pix-font-line-height: <?php echo esc_attr($pixtheme_font_line_height)?>;
    --pix-font-line-height-px: <?php echo esc_attr($line_height)?>px;
    --pix-font-line-height-em: <?php echo esc_attr($line_height_em)?>em;
    --pix-font-weight: <?php echo esc_attr($pixtheme_font_weight)?>;
    --pix-font-color: <?php echo esc_attr($pixtheme_font_color)?>;
    --pix-font-color-light: <?php echo esc_attr($pixtheme_font_color_light)?>;

    --pix-h1-size: <?php echo esc_attr($h1_size)?>em;
    --pix-h2-size: <?php echo esc_attr($h2_size)?>em;
    --pix-h3-size: <?php echo esc_attr($h3_size)?>em;
    --pix-h4-size: <?php echo esc_attr($h4_size)?>em;
    --pix-h5-size: <?php echo esc_attr($h5_size)?>em;
    --pix-h6-size: 1em;

    --pix-title-font: <?php echo esc_attr($pixtheme_title)?>;
    --pix-title-size: <?php echo esc_attr($pixtheme_title_size)?>px;
    --pix-title-weight: <?php echo esc_attr($pixtheme_title_weight)?>;
    --pix-title-style: <?php echo esc_attr($pixtheme_title_style)?>;
    --pix-title-color: <?php echo esc_attr($pixtheme_title_color)?>;
    --pix-title-letter-spacing: <?php echo esc_attr($pixtheme_title_letter_spacing)?>;

    --pix-subtitle-font: <?php echo esc_attr($pixtheme_subtitle)?>;
    --pix-subtitle-size: <?php echo esc_attr($pixtheme_subtitle_size)?>px;
    --pix-subtitle-weight: <?php echo esc_attr($pixtheme_subtitle_weight)?>;
    --pix-subtitle-style: <?php echo esc_attr($pixtheme_subtitle_style)?>;
    --pix-subtitle-color: <?php echo esc_attr($pixtheme_subtitle_color)?>;
    --pix-subtitle-letter-spacing: <?php echo esc_attr($pixtheme_subtitle_letter_spacing)?>;

    --pix-hlink-font: <?php echo esc_attr($pixtheme_hlink)?>;
    --pix-hlink-size: <?php echo esc_attr($pixtheme_hlink_size)?>px;
    --pix-hlink-weight: <?php echo esc_attr($pixtheme_hlink_weight)?>;
    --pix-hlink-style: <?php echo esc_attr($pixtheme_hlink_style)?>;
    --pix-hlink-color: <?php echo esc_attr($pixtheme_hlink_color)?>;

    --pix-buttons-border: <?php echo esc_attr($buttons_border)?>px;
    --pix-buttons-font: <?php echo esc_attr($buttons_font)?>;
    --pix-buttons-font-size: <?php echo esc_attr($buttons_font_size)?>px;
    --pix-buttons-font-weight: <?php echo esc_attr($buttons_font_weight)?>;
    --pix-buttons-font-style: <?php echo esc_attr($buttons_font_style)?>;
    --pix-buttons-text-transform: <?php echo esc_attr($buttons_text_transform)?>;
    --pix-buttons-letter-spacing: <?php echo esc_attr($buttons_letter_spacing)?>px;
    --pix-buttons-shadow: <?php echo !$buttons_shadow ? 'none' : esc_attr(pixtheme_get_option('buttons_shadow_h', '0')).'px '.esc_attr(pixtheme_get_option('buttons_shadow_v', '5')).'px '.esc_attr(pixtheme_get_option('buttons_shadow_blur', '15')).'px '.esc_attr(pixtheme_get_option('buttons_shadow_spread', '0')).'px rgba('.esc_attr(pixtheme_hex2rgb(pixtheme_get_option('buttons_shadow_color', '#000'))).','.esc_attr(pixtheme_get_option('buttons_shadow_opacity', '15')/100).')' ?>;

    --pix-hover-gradient: rgba(0,0,0,.4);

    --pix-tab-overlay-color: <?php echo esc_attr($tab_bg_color)?>;
    --pix-tab-overlay-gradient: <?php echo esc_attr($tab_bg_color_gradient)?>;
    --pix-tab-gradient-direction-webkit: <?php echo esc_attr($pix_directions_arr[$gradient_direction]['-webkit'])?>;
    --pix-tab-gradient-direction-o: <?php echo esc_attr($pix_directions_arr[$gradient_direction]['-o-linear'])?>;
    --pix-tab-gradient-direction-moz: <?php echo esc_attr($pix_directions_arr[$gradient_direction]['-moz-linear'])?>;
    --pix-tab-gradient-direction: <?php echo esc_attr($pix_directions_arr[$gradient_direction]['linear'])?>;
    --pix-tab-overlay-opacity: <?php echo esc_attr($tab_bg_opacity)?>;

    --pix-svg-search: url(<?php echo get_template_directory_uri().'/images/svg/search-white.svg'; ?>);
    --pix-svg-loader: url(<?php if($loader_img == '') { echo get_template_directory_uri().'/images/decor.svg'; } else { echo esc_url($loader_img); } ?>);

    --pix-decor-img: url(<?php if($decor_img){ echo esc_url($decor_img); } else { echo get_template_directory_uri().'/images/decor.svg'; } ?>);


}


<?php if($decor_show) : ?>
html .sep-element{
    <?php if($decor_img) : ?>
    background: var(--pix-decor-img);
    width: <?php echo esc_attr($decor_width)?>px;
    height: <?php echo esc_attr($decor_height)?>px;
    border: none !important;
    <?php else : ?>
    background-image: var(--pix-decor-img);
    width: 42px;
    height: 42px;
    <?php endif; ?>
    background-repeat: no-repeat;
    background-size: contain;
}
<?php else : ?>
html .sep-element{
	display: none;
}
<?php endif; ?>


<?php if($header_border == 'top') : ?>
.pix-header:not(.header-topbar-view) {
    border-top-width: 1px;
}
.pix-header.header-topbar-view .pix-top-bar{
    border-bottom-width: 1px;
}
<?php elseif($header_border == 'bottom') : ?>
.pix-header {
    border-bottom-width: 1px;
}
<?php elseif($header_border == 'both') : ?>
.pix-header:not(.header-topbar-view) {
    border-width: 1px 0;
}
.pix-header, .pix-header.header-topbar-view .pix-top-bar{
    border-bottom-width: 1px;
}
<?php endif; ?>



<?php
		/*   PAGE HEADER BACKGROUND   */
?>
<?php
if($tab_bg_color != '' && $tab_bg_color_gradient != ''){
	$gradient_angle = $tab_bg_color_gradient == '' ? '90' : $tab_bg_color_gradient;

	?>

	html .custom-header span.vc_row-overlay{
		background: var(--pix-tab-overlay-color); /* For browsers that do not support gradients */
		background: -webkit-linear-gradient(var(--pix-tab-gradient-direction-webkit), var(--pix-tab-overlay-color), var(--pix-tab-overlay-gradient)); /*Safari 5.1-6*/
		background: -o-linear-gradient(var(--pix-tab-gradient-direction-o), var(--pix-tab-overlay-color), var(--pix-tab-overlay-gradient)); /*Opera 11.1-12*/
		background: -moz-linear-gradient(var(--pix-tab-gradient-direction-moz), var(--pix-tab-overlay-color), var(--pix-tab-overlay-gradient)); /*Fx 3.6-15*/
		background: linear-gradient(var(--pix-tab-gradient-direction), var(--pix-tab-overlay-color), var(--pix-tab-overlay-gradient)); /*Standard*/
		opacity: var(--pix-tab-overlay-opacity);
	}

	<?php
} else {
?>
html .custom-header span.vc_row-overlay{
	background-color: var(--pix-tab-overlay-color) !important;
	opacity: var(--pix-tab-overlay-opacity);
}
<?php
}
?>




<?php
		/*   GRADIENT   */
?>
<?php
if($pixtheme_main_color != '' && $pixtheme_gradient_color != '' && $pixtheme_main_color != $pixtheme_gradient_color){

	?>

	html .pix-gradient,
    html .pix-header-menu.gradient .container,
    html .pix-header-menu.gradient nav ul li ul.submenu,
    html .pix-item-review .round,
    html .pix-item-left .round,
    html .pix-item-default .round,
    html .news-card-price__header,
    html .pix-progress-bar,
    html .news-card-centered__image .overlay,
    <?php if($buttons_color == 'gradient') : ?>
        html .pix-button,
    <?php endif; ?>
    html .pix-overlay.pix-gradient-color,
    html .pix-block-content .round.pix-icon-bg-gradient-color
    {
		background: var(--pix-main-color); /* For browsers that do not support gradients */
		background: -webkit-linear-gradient(var(--pix-gradient-direction-webkit), var(--pix-main-color), var(--pix-gradient-color)); /*Safari 5.1-6*/
		background: -o-linear-gradient(var(--pix-gradient-direction-o), var(--pix-main-color), var(--pix-gradient-color)); /*Opera 11.1-12*/
		background: -moz-linear-gradient(var(--pix-gradient-direction-moz), var(--pix-main-color), var(--pix-gradient-color)); /*Fx 3.6-15*/
		background: linear-gradient(var(--pix-gradient-direction), var(--pix-main-color), var(--pix-gradient-color)); /*Standard*/
	}
    
    <?php if($buttons_color == 'gradient') : ?>
        html .pix-button:hover
        {
            background: var(--pix-main-color); /* For browsers that do not support gradients */
            background: -webkit-linear-gradient(var(--pix-gradient-reverse-direction-webkit), var(--pix-main-color), var(--pix-gradient-color)); /*Safari 5.1-6*/
            background: -o-linear-gradient(var(--pix-gradient-reverse-direction-o), var(--pix-main-color), var(--pix-gradient-color)); /*Opera 11.1-12*/
            background: -moz-linear-gradient(var(--pix-gradient-reverse-direction-moz), var(--pix-main-color), var(--pix-gradient-color)); /*Fx 3.6-15*/
            background: linear-gradient(var(--pix-gradient-reverse-direction), var(--pix-main-color), var(--pix-gradient-color)); /*Standard*/
        }
    <?php endif; ?>

    html .transparent.pix-icon-gradient .icon span,
    html .news-item-price-long__price .icon-message span
    {
        background: -webkit-linear-gradient(var(--pix-gradient-direction-webkit), var(--pix-main-color), var(--pix-gradient-color)); /*Safari 5.1-6*/
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
	}
    
    html .round.pix-icon-gradient
    {
        background: -webkit-linear-gradient(var(--pix-gradient-direction-webkit), var(--pix-main-color), var(--pix-gradient-color)); /*Safari 5.1-6*/
        background: linear-gradient(var(--pix-gradient-direction), var(--pix-main-color), var(--pix-gradient-color)); /*Standard*/
    }

	<?php
}
?>




<?php
		/*   DECOR   */
?>

html .custom-header{
	padding: <?php echo esc_attr($tab_padding_top)?>px 0 <?php echo esc_attr($tab_padding_bottom)?>px;
	margin-bottom: <?php echo esc_attr($tab_margin_bottom)?>px;
    background-size: <?php echo esc_attr($tab_bg_image_size)?>;
    background-repeat: <?php echo esc_attr($tab_bg_image_repeat)?>;
    background-position: <?php echo esc_attr($tab_bg_image_horizontal_pos)?>% <?php echo esc_attr($tab_bg_image_vertical_pos)?>%;
    <?php if($tab_bg_image_fixed != '') : ?>
    background-attachment: fixed;
    <?php endif; ?>
    /*box-shadow: 0 -18px 18px -18px rgba(0,0,0,.3) inset, 0 18px 18px -18px rgba(0,0,0,.3) inset;*/
}

html .pix-header.pix-levels.transparent + .custom-header{
    padding-top: <?php echo esc_attr(max($tab_padding_top, $tab_padding_top_levels))?>px;
}

html .pix-header.pix-levels.header-topbar-view + .custom-header{
    padding-top: <?php echo esc_attr(max($tab_padding_top, $tab_padding_top_levels) + 50)?>px;
}

/*html .header-topbar-view + .custom-header{
    padding-top: <?php echo esc_attr($tab_padding_top + 50)?>px;
}*/

section.pix-page-no-padding{
    margin-top: -<?php echo esc_attr($tab_margin_bottom)?>px;
}


@media screen and (max-width: 1024px) {
    html .header-topbar-view + .custom-header{
        padding-top: <?php echo esc_attr($tab_padding_top)?>px;
    }
}

@media screen and (max-width: 575px) {
    html .header-topbar-view + .custom-header{
        padding-top: <?php echo esc_attr($tab_padding_top / 2)?>px;
        padding-bottom: <?php echo esc_attr($tab_padding_bottom / 2 + 50)?>px;
    }
}

<?php
		/*   IMAGE FILTER   */
?>
<?php
if(pixtheme_get_option('img_filter', '') == 'pix-filter-mist'){

	?>

	html .news-card-gradient img,
    html .rtd .wpb_single_image:not(.pix-no-filter) img
    {
		-webkit-filter: sepia(10%) brightness(80%) contrast(65%);
		filter: sepia(10%) brightness(80%) contrast(65%);
	}

    html .woocommerce img,
    html .woocommerce-page img,
    html .news-card-profile__header img,
    html .news-card-people__image img,
    html .news-card-feedback__image img,
    html .wpb_single_image img
    {
        -webkit-filter: sepia(10%) saturate(70%);
		filter: sepia(15%) saturate(70%);
	}

	<?php
}
?>
