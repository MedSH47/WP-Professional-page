<?php

function pixtheme_site_menu($class = null) {
    if ( function_exists('wp_nav_menu') && has_nav_menu( 'primary_nav' ) ) {
        wp_nav_menu(array(
            'theme_location' => 'primary_nav',
            'container' => false,
            'menu_class' => $class,
            'walker' => new PixTheme_Walker_Menu(),
        ));
    } else {
        ?>
        <ul class="main-menu nav navbar-nav">
            <li>
                <a target="_blank" href="<?php echo esc_url( admin_url() . 'nav-menus.php#locations-primary_menu' ) ?>">
                    <?php esc_html_e( 'Please, set Primary Menu.', 'solutech' ); ?>
                </a>
            </li>
        </ul>
        <?php
    }
}

function pixtheme_no_notice($var) {
    if (isset($var) && $var != '')
        return 1;
    else
        return 0;
}

function pixtheme_show_breadcrumbs(){
    if ( function_exists( 'pixtheme_breadcrumbs' ) && !is_page_template( 'page-home.php' ) ){
        pixtheme_breadcrumbs();
    }
}

// numbered pagination
function pixtheme_num_pagination( $pages = '', $range = 2 ) {
	 $showitems = ( $range * 2 ) + 1;

	 global $paged;
	 if ( empty( $paged ) )  { $paged = 1; }

	 if ( $pages == '' )
	 {
		 global $wp_query;
		 $pages = $wp_query->max_num_pages;
		 if ( ! $pages ) { $pages = 1; }
	 }

	 if ( 1 != $pages )
	 {
		 echo '<div class="navigation pagination text-center"><ul>';

		 if ( $paged > 1 && $showitems < $pages ) echo '<li><a href="' . esc_url( get_pagenum_link( esc_html( $paged ) - 1 ) ) . '"><i class="fa-chevron-left"></i></a></li>';

		 for ( $i = 1; $i <= $pages; $i++ )
		 {
			 if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) )
			 {
				if ( $paged == $i ) {
				    echo '<li class="page-current	"><a>' . $i . '</a></li>';
                } else {
				    echo '<li><a href="' . esc_url( get_pagenum_link($i) ) . '">' . esc_html( $i ) . '</a></li>';
                }
			 }
		 }

		 if ( $paged < $pages && $showitems < $pages ) echo '<li><a href="' . esc_url( get_pagenum_link( esc_html( $paged ) + 1 ) ) . '"><i class="fa-chevron-right"></i></a></li>';

		 echo '</ul></div>';
	 }
}

function pixtheme_wp_get_attachment( $attachment_id ) {
	$attachment = get_post( $attachment_id );
	return array(
		'alt' => is_object($attachment) ? get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ) : '',
		'caption' => is_object($attachment) ? $attachment->post_excerpt : '',
		'description' => is_object($attachment) ? $attachment->post_content : '',
		'href' => is_object($attachment) ? get_permalink( $attachment->ID ) : '',
		'src' => is_object($attachment) ? $attachment->guid : '',
		'title' => is_object($attachment) ? $attachment->post_title : ''
	);
}

function pixtheme_post_read_more(){
    $btn_name = pixtheme_get_option('blog_settings_readmore');
    $name = ($btn_name) ? $btn_name : esc_html__('Read More','solutech');
    return esc_attr($name);
}

function pixtheme_show_sidebar($type, $layout, $sidebar) {

	$layouts = array(
		1 => 'full',
		2 => 'right',
		3 => 'left',
	);
	
	$padding = pixtheme_get_setting('pix-blog-sidebar', 'no-padding');

	if ( isset($layouts[$layout]) && $type === $layouts[$layout] ) {
		echo '<div class="col-xl-3 col-lg-4 col-md-12 d-xl-block"><div class="pix-sidebar pix-'.esc_attr($padding).'">';
		if ( is_active_sidebar( $sidebar ) ) : dynamic_sidebar( $sidebar ); endif;
		echo '</div></div>';
	} else {
		echo '';
	}

}

function pixtheme_limit_words($string, $word_limit, $wrapper = '') {
    
    $wrapper_start = $wrapper_end = '';
    if(trim($wrapper) != '') {
        $wrapper_start = '<' . $wrapper . '>';
        $wrapper_end = '</' . $wrapper . '>';
    }
    
	// creates an array of words from $string (this will be our excerpt)
	// explode divides the excerpt up by using a space character

	$words = explode(' ', $string);

	// this next bit chops the $words array and sticks it back together
	// starting at the first word '0' and ending at the $word_limit
	// the $word_limit which is passed in the function will be the number
	// of words we want to use
	// implode glues the chopped up array back together using a space character
 	if(trim($string) == '') {
        return '';
    } else {
        return $wrapper_start . implode(' ', array_slice($words, 0, $word_limit)) . '...' . $wrapper_end;
    }
}

function pixtheme_get_post_terms( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id'    => get_the_ID(),
		'taxonomy'   => 'category',
		'text'       => '%s',
		'before'     => '',
		'after'      => '',
		'items_wrap' => '<span>%s</span>',
		'sep'        => _x( ', ', 'taxonomy terms separator', 'solutech' )
	);

	$args = wp_parse_args( $args, $defaults );

	$terms = get_the_term_list( $args['post_id'], $args['taxonomy'], '', $args['sep'], '' );

	if ( !empty( $terms ) ) {
		$html .= $args['before'];
		$html .= sprintf( $args['items_wrap'], sprintf( $args['text'], $terms ) );
		$html .= $args['after'];
	}

	return $html;
}

function pixtheme_hex2rgb($hex) {
    $hex = str_replace("#", "", $hex);

    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
    $rgb = array($r, $g, $b);
    //return $rgb; // returns an array with the rgb values
    return implode(",", $rgb); // returns the rgb values separated by commas
}

function pixtheme_lighten_darken_color($hex, $amt) {
    
    $hex = str_replace("#", "", $hex, $count);
    $usePound = false;
    
    if ($count > 0) {
        $usePound = true;
    }
    
    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
    
    $r = $r + $amt;
    
    if ($r > 255) {
        $r = 255;
    } elseif($r < 0) {
        $r = 0;
    }
    
    $g = $g + $amt;
    
    if ($g > 255) {
        $g = 255;
    } elseif($g < 0) {
        $g = 0;
    }
    
    $b = $b + $amt;
    
    if ($b > 255) {
        $b = 255;
    } elseif($b < 0) {
        $b = 0;
    }
    
    return esc_attr( ($usePound ? "#" : "") . sprintf("%02X%02X%02X", $r, $g, $b) );
    //return esc_attr( ($usePound ? "#" : "") . dechex(($r<<16)|($g<<8)|$b ) );
    
}

function pixtheme_echo_if_not_empty($string, $value){
    if($value != ''){
        return $string;
    } else
        return '';
}


function pixtheme_get_tax_level($id, $tax){
    $ancestors = get_ancestors($id, $tax);
    return count($ancestors)+1;
}


function pixtheme_breadcrumbs() {
	
	/* === Options === */

	$text['home'] = wp_kses_post(__('Home', 'solutech'));
	$text['category'] = esc_html__('Archive "%s"', 'solutech');
	$text['search'] = esc_html__('Search results for "%s"', 'solutech');
	$text['tag'] = esc_html__('Posts with tag "%s"', 'solutech');
	$text['author'] = esc_html__('%s posts', 'solutech');
	$text['404'] = esc_html__('Error 404', 'solutech');
	$text['page'] = esc_html__('Page %s', 'solutech');
	$text['cpage'] = esc_html__('Comments page %s', 'solutech');

	$delimiter = '/';//'<i class="fa fa-angle-right"></i>';
	$delim_before = '&nbsp;&nbsp;';
	$delim_after = '&nbsp;&nbsp;';
	$show_home_link = 1;
	$show_on_home = 1;
	$show_title = 1;
	$show_current = pixtheme_get_option('tab_breadcrumbs_current', 0);
	$before = '';
	$after = '';
	/* === End options === */
	
	global $post;
	$home_link = esc_url(home_url('/'));
	$link_before = '';
	$link_after = '';
	$link_attr = '';
	$link_in_before = '';
	$link_in_after = '';
	$link = $link_before . '<a href="%1$s"' . $link_attr . '>' . $link_in_before . '%2$s' . $link_in_after . '</a>' . $link_after;
	$frontpage_id = get_option('page_on_front');
	$parent_id = isset($post) ? $post->post_parent : '';
	$delimiter = $delim_before . $delimiter . $delim_after;
	
	if ( is_home() || is_front_page() ) {

		if ($show_on_home == 1) echo '<div class="pix-breadcrumbs-path">' . sprintf($link, $home_link, $text['home']) . '</div>';

	} else {

		echo '<div class="pix-breadcrumbs-path">';
		if ( $show_home_link == 1 /*&& (!is_page() && !$parent_id) && !is_404()*/ ) echo sprintf($link, $home_link, $text['home']);

		if ( is_category() ) {
            $cat = get_category(get_query_var('cat'), false);
            if ($cat->parent != 0) {
                $cats = get_category_parents($cat->parent, TRUE, $delimiter);
                $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
                if ($show_title == 0)
                    $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                if ($show_home_link == 1) echo wp_kses_post($delimiter);
                    echo wp_kses_post($cats);
            }
            if ( get_query_var('paged') ) {
                $cat = $cat->cat_ID;
                echo wp_kses_post($delimiter . sprintf($link, get_category_link($cat), get_cat_name($cat)) . $delimiter . $before . sprintf($text['page'], get_query_var('paged')) . $after);
            } else {
                if ($show_current == 1) echo wp_kses_post($delimiter . $before . sprintf($text['category'], single_cat_title('', false)) . $after);
            }

        } elseif ( is_search() ) {
            if ($show_home_link == 1) echo wp_kses_post($delimiter);
            echo wp_kses_post($before . sprintf($text['search'], get_search_query()) . $after);

        } elseif ( is_day() ) {
            if ($show_home_link == 1) echo wp_kses_post($delimiter);
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F')) . $delimiter;
            echo wp_kses_post($before . get_the_time('d') . $after);

        } elseif ( is_month() ) {
            if ($show_home_link == 1) echo wp_kses_post($delimiter);
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo wp_kses_post($before . get_the_time('F') . $after);

        } elseif ( is_year() ) {
            if ($show_home_link == 1) echo wp_kses_post($delimiter);
            echo wp_kses_post($before . get_the_time('Y') . $after);

        } elseif ( is_single() && !is_attachment() ) {
            if ($show_home_link == 1) echo wp_kses_post($delimiter);

            $tax_arr = array(
                'pix-service' => 'pix-service-cat',
                'pix-portfolio' => 'pix-portfolio-cat',
                'pix-team' => 'pix-team-cat',
                'pixcar' => 'pixcar-make'
            );
            
            $tax_page_arr = array(
                'pix-service' => 'pix-service-page',
                'pix-portfolio' => 'pix-portfolio-page',
                'pix-team' => 'pix-team-page',
                'pixcar' => 'cars-page'
            );
            
            $post_type = get_post_type();
            if( array_key_exists( $post_type, $tax_arr ) ){
                
                $term_cats = wp_get_object_terms(get_the_ID(), 'pixcar-cat');
                
                if( !is_wp_error( $term_cats ) && !empty($term_cats) && isset($term_cats[0]->slug) ){
                    global $pixcars;
                    $pix_cat_slug = 'cars-page-'.$term_cats[0]->slug;
                    $pixtheme_all_page = $pixcars->settings->get_setting($pix_cat_slug);
                } elseif($post_type == 'pixcar') {
                    global $pixcars;
                    $pixtheme_all_page = $pixcars->settings->get_setting($tax_page_arr[$post_type]);
                } else {
                    $pixtheme_all_page = pixtheme_get_setting($tax_page_arr[$post_type], '0');
                }
                
                if ( $pixtheme_all_page != 0 ) {
                    echo sprintf($link, get_the_permalink($pixtheme_all_page), get_the_title($pixtheme_all_page)) . $delimiter;
                }
                
                $cats = wp_get_object_terms($post->ID, $tax_arr[$post_type]);

                $cat_href_0 = $cat_href_1 = $cat_href = $delim_0 = $delim_1 = '';
                if (!is_wp_error($cats)){
                    foreach( $cats as $cat ){
                        $current_term_level = pixtheme_get_tax_level( $cat->term_id, $cat->taxonomy );

                        if ($current_term_level == 0) {
                            $cat_href_0 .= '<a href="'.get_term_link( $cat ).'"' . $link_attr . '>' . $link_in_before . $cat->name . $link_in_after . '</a>' . ", ";
                        } else if ($current_term_level == 1) {
                            $cat_href_1 .= '<a href="'.get_term_link( $cat ).'"' . $link_attr . '>' . $link_in_before . $cat->name . $link_in_after . '</a>' . ", ";
                        } else {
                            $cat_href .= '<a href="'.get_term_link( $cat ).'"' . $link_attr . '>' . $link_in_before . $cat->name . $link_in_after . '</a>' . ", ";
                        }
                    }
                }

                $delim_0 = $cat_href_0 != '' && $cat_href_1 != '' ? $delimiter : '';
                $delim_1 = $cat_href_1 != '' && $cat_href != '' ? $delimiter : '';
                echo wp_kses_post($cat_href_0 != '' ? $link_before . substr($cat_href_0, 0, -2) . $link_after . $delim_0 : '');
                echo wp_kses_post($cat_href_1 != '' ? $link_before . substr($cat_href_1, 0, -2) . $link_after . $delim_1 : '');
                echo wp_kses_post($cat_href != '' ? $link_before . substr($cat_href, 0, -2) . $link_after : '');
            } else {
                $cat = get_the_category();
                if(!empty($cat)) {
					$cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, ',');
					$cats = preg_replace("#^(.+),$#", "$1", $cats);
					$cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr . '>' . $link_in_before . '$2' . $link_in_after . '</a>' . $link_after, $cats);
					if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
					echo wp_kses_post($cats);
				} else {
					echo esc_html__('No Categories', 'solutech');
				}
                if ( get_query_var('cpage') ) {
                    echo wp_kses_post($delimiter . sprintf($link, get_permalink(), get_the_title()) . $delimiter . $before . sprintf($text['cpage'], get_query_var('cpage')) . $after);
                } else {
                    if ($show_current == 1) echo wp_kses_post($delimiter . $before . get_the_title() . $after);
                }
            }

        // custom post type
        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
            $post_type = get_post_type_object(get_post_type());
            if(isset($post_type->name)) {
                if ($post_type->name == 'pix-service') {
                    $pixtheme_all_page = pixtheme_get_option('pix-service-page', '0');
                    if ($pixtheme_all_page != 0) {
                        $services = get_post_type_object('services');
                        echo wp_kses_post($delimiter . sprintf($link, get_the_permalink($pixtheme_all_page), $services->label));
                    }
                } elseif ($post_type->name == 'pix-portfolio') {
                    $pixtheme_all_page = pixtheme_get_option('pix-portfolio-page', '0');
                    if ($pixtheme_all_page != 0) {
                        $portfolio = get_post_type_object('portfolio');
                        echo wp_kses_post($delimiter . sprintf($link, get_the_permalink($pixtheme_all_page), $portfolio->label));
                    }
                } elseif ($post_type->name == 'pix-team') {
                    $pixtheme_all_page = pixtheme_get_option('pix-team-page', '0');
                    if ($pixtheme_all_page != 0) {
                        $portfolio = get_post_type_object('portfolio');
                        echo wp_kses_post($delimiter . sprintf($link, get_the_permalink($pixtheme_all_page), $portfolio->label));
                    }
                }
                
            }
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            if ( get_query_var('paged') ) {
                echo wp_kses_post($delimiter . sprintf($link, get_post_type_archive_link($post_type->name), $post_type->label) . $delimiter . $before . sprintf($text['page'], get_query_var('paged')) . $after);
            } else {
                if ($show_current == 1 && is_object($term))
                    echo wp_kses_post($delimiter . $before . $term->name . $after);
            }

        } elseif ( is_attachment() ) {
            if ($show_home_link == 1) echo wp_kses_post($delimiter);
            $parent = get_post($parent_id);
            $cat = get_the_category($parent->ID); $cat = $cat[0];
            if ($cat) {
                $cats = get_category_parents($cat, TRUE, $delimiter);
                $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
                if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                echo wp_kses_post($cats);
            }
            printf($link, get_permalink($parent), $parent->post_title);
            if ($show_current == 1) echo wp_kses_post($delimiter . $before . get_the_title() . $after);

        } elseif ( is_page() && !$parent_id ) {

            if ($show_current == 1) echo wp_kses_post($delimiter . $before . get_the_title() . $after);

        } elseif ( is_page() && $parent_id ) {

            if ($show_home_link == 1) echo wp_kses_post($delimiter);
            if ($parent_id != $frontpage_id) {
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    if ($parent_id != $frontpage_id) {
                        $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                    }
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0; $i < count($breadcrumbs); $i++) {
                    echo wp_kses_post($breadcrumbs[$i]);
                    if ($i != count($breadcrumbs)-1) echo wp_kses_post($delimiter);
                }
            }
            if ($show_current == 1) echo wp_kses_post($delimiter . $before . get_the_title() . $after);

        } elseif ( is_tag() ) {
            if ($show_current == 1) echo wp_kses_post($delimiter . $before . sprintf($text['tag'], single_tag_title('', false)) . $after);

        } elseif ( is_author() ) {
            if ($show_home_link == 1) echo wp_kses_post($delimiter);
            global $author;
            $author = get_userdata($author);
            echo wp_kses_post($before . sprintf($text['author'], $author->display_name) . $after);

        } elseif ( is_404() ) {
            if ($show_current == 1){
                if ($show_home_link == 1) echo wp_kses_post($delimiter);
                echo wp_kses_post($before . $text['404'] . $after);
            }

        } elseif ( has_post_format() && !is_singular() ) {
            if ($show_home_link == 1) echo wp_kses_post($delimiter);
            echo get_post_format_string( get_post_format() );
        }

		echo '</div><!-- .breadcrumbs -->';

 	}
	
} // end pixtheme_breadcrumbs()