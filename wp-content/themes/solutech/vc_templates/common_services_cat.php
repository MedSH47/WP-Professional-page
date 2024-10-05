<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $cats
 * @var $per_row
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Banner
 */

$href_before = $href_before_line = $href = $href_after = '';
$icon_size = 'pix-icon-l';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$out = $class = '';

if( $cats == '' ):
	$out .= '<p>'.esc_html__('No departments selected. To fix this, please login to your WP Admin area and set the departments you want to show by editing this shortcode and setting one or more departments in the multi checkbox field "Departments".', 'solutech');
else:
    $style = $style != 'service-box-3' && $style != '' ? $style : 'service-box-3';

    $include = array();
    foreach(explode(',', $cats) as $val){
        $term = get_term_by('slug', $val, 'services_category');
        if( isset($term->term_id) ){
            $include[] = $term->term_id;
        }
    }
    $args = array( 'taxonomy' => 'services_category', 'hide_empty' => '0', 'include' => implode(',', $include));
    $categories = get_categories ($args);
    if( $categories ) :
        foreach($categories as $cat) :
            $t_slug = $cat->slug;
            $cat_meta = get_option("services_category_$t_slug");
            $subtitle = !isset($cat_meta['pix_serv_add_title']) || $cat_meta['pix_serv_add_title'] == '' ? '' : '<span>'.wp_kses_post($cat_meta['pix_serv_add_title']).'</span>';
            $link = !isset($cat_meta['pix_serv_url']) || $cat_meta['pix_serv_url'] == '' ? get_term_link( $cat ) : $cat_meta['pix_serv_url'];
            $icon = '';
            if($links != 'off'){
                $href_before = '<a href="'.esc_url($link).'">';
                $href_before_line = '<a href="'.esc_url($link).'" class="link-centerline">';
                $href = 'href="'.esc_url($link).'"';
                $href_after = '</a>';
            }
            if(isset($cat_meta['pix_icon']) && filter_var($cat_meta['pix_icon'], FILTER_VALIDATE_URL)) {
                if (function_exists('pix_get_svg_content')) {
                    $icon = '<div class="icon">'.pix_get_svg_content($cat_meta['pix_icon']).'</div>';
                } else {
                    $icon = '<div class="icon"><img src="'.esc_url($cat_meta['pix_icon']).'" alt="'.esc_attr($title).'">'.'</div>';
                }
            } elseif(isset($cat_meta['pix_icon']) && $cat_meta['pix_icon']) {
                $icon = '<i class="glyph-icon icon fa '.esc_attr($icon).'" ></i>';
            }
            $image = '';
            if(isset($cat_meta['pix_image']) && $cat_meta['pix_image'] != '') {
                $image = wp_get_attachment_image_src(attachment_url_to_postid($cat_meta['pix_image']), array(555,555));
                $image = $image[0];
            };
            $icon_html = $image_html = $overlay_html = '';
            $cat_description = $cat->description == '' ? '' : '<div class="pix-service-box__text"><p>' . pixtheme_limit_words($cat->description, 20) . '</p></div>';

            if( $style == 'service-box-3' ) {
                if(isset($flip) && $flip == 'on'){
                $out .= '
                    <div class="col-md-4">
                        <div class="flip">
                            <div class="service-box-3">
                                <div class="service-box-3__container '.esc_attr($icon_size).'">
                                    '.($icon).'
                                    <h2>'.wp_kses_post($cat->name).'</h2>
                                </div>
                                <img src="'.esc_url($image).'" alt="'.esc_attr($cat->name).'">
                            </div>
                            <div class="service-box-3 under">
                                '.wp_kses_post($href_before).'
								<div class="service-box-3__container two">
									<h2>'.wp_kses_post($cat->name).'</h2>
									'.wp_kses_post($cat_description).'
								</div>
								'.wp_kses_post($href_after).'
								<img src="'.esc_url($image).'" alt="'.esc_attr($cat->name).'">
							</div>
						</div>
                    </div>
                    ';
                } else {
                $out .= '
                    <div class="col-md-4">
                        <div class="service-box-3">
                            '.wp_kses_post($href_before).'
                            <div class="service-box-3__container '.esc_attr($icon_size).'">
                                '.($icon).'
                                <h2>'.wp_kses_post($cat->name).'</h2>
                            </div>
                            '.wp_kses_post($href_after).'
                            <img src="'.esc_url($image).'" alt="'.esc_attr($cat->name).'">
                        </div>
                    </div>
                    ';
                }
            } elseif( $style == 'service-box-4' ) {
                $out .= '
                    <div class="col-md-6">
                        <div class="service-box-4">
                            <div class="service-box-4__image">
                                <h2>'.wp_kses_post($href_before_line.$cat->name.$href_after.$subtitle).'</h2>
                                <div class="overlay"></div>
                                <img src="'.esc_url($image).'" alt="'.esc_attr($cat->name).'">
                            </div>
                            <div class="service-box-4__text">
                                <p>' . pixtheme_limit_words($cat->description, 20) . '</p>
                            </div>
                        </div>
                    </div>
                    ';
            } else {
                $out .= '
                    <div class="col-md-6">
                        <div class="service-box-7">
                            '.wp_kses_post($href_before).'<button>'.wp_kses_post($cat->name).'</button>'.wp_kses_post($href_after).'
                            <div class="overlay"></div>
                            <img src="'.esc_url($image).'" alt="'.esc_attr($cat->name).'">
                        </div>
                    </div>
                    ';
            }
		 endforeach;
	endif;

endif;

echo '<div class="row">'.($out).'</div>';