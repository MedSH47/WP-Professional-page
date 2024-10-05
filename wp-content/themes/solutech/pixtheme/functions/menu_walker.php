<?php

function pixtheme_get_nav_menu_item_children( $parent_id, $nav_menu_items, $lvl=0, $depth = true ) {
    $nav_menu_item_list = array( 'lvl' => $lvl, 'items' => array() );
    foreach ( (array) $nav_menu_items as $nav_menu_item ) {
        if ( $nav_menu_item->menu_item_parent == $parent_id ) {
            $nav_menu_item_list['items'][] = $nav_menu_item;
            if ( $depth ) {
                if ( $children = pixtheme_get_nav_menu_item_children( $nav_menu_item->ID, $nav_menu_items, ($lvl+1) ) ) {
                    $nav_menu_item_list['lvl'] = $children['lvl'];
                    $nav_menu_item_list['items'] = array_merge($nav_menu_item_list['items'], $children['items']);
                }
            }
        }
    }
    return $nav_menu_item_list;
}

class PixTheme_Walker_Menu extends Walker_Nav_Menu {

	// add classes to ul sub-menus
	public function start_lvl( &$output, $depth = 0, $args = array() ) {

		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"submenu js-menu\">\n";
	}

	// add main/sub classes to li's and links
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		if(isset($item->ID))
		    $classes[] = 'menu-item-' . $item->ID;
		
		
		if($depth == 0) {
		    $menu = wp_get_nav_menu_object( $args->menu );
		    if ( $menu && ! is_wp_error($menu) && !isset($menu_items) ) {
		        $menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) );
		        $children = pixtheme_get_nav_menu_item_children($item->ID, $menu_items);
		        if( isset($children['lvl']) && $children['lvl'] > 2 ){
		            $classes[] = 'pix-submenu-vertical';
                }
            }
        }

		if(in_array('menu-item-has-children', $classes))
			$classes[] = 'arrow';

		/**
		 * Filter the CSS class(es) applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth   Depth of menu item. Used for padding.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filter the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param object $item    The current menu item.
		 * @param array  $args    An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth   Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names .'>';

		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		/**
		 * Filter the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param object $item  The current menu item.
		 * @param array  $args  An array of {@see wp_nav_menu()} arguments.
		 * @param int    $depth Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$span_after = '';

		$item_output = '';

        if(is_object($args)){
            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            /** This filter is documented in wp-includes/post-template.php */
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
            $item_output .= '</a>'.$span_after;
            $item_output .= $args->after;
        }else{
            $item_output = '<a'. $attributes .'>';
            /** This filter is documented in wp-includes/post-template.php */
            $item_output .= apply_filters( 'the_title', $item->title, $item->ID ) ;
            $item_output .= '</a>';
        }


		/**
		 * Filter a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string $item_output The menu item's starting HTML output.
		 * @param object $item        Menu item data object.
		 * @param int    $depth       Depth of menu item. Used for padding.
		 * @param array  $args        An array of {@see wp_nav_menu()} arguments.
		 */

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );


	}

	
}



class PixTheme_Walker_Mobile_Menu extends Walker_Nav_Menu {

    // add classes to ul sub-menus
    public function start_lvl( &$output, $depth = 0, $args = array() ) {

        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"mobile-submenu\">\n";
    }

    // add main/sub classes to li's and links
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        if(in_array('menu-item-has-children', $classes))
            $classes[] = 'js-mobile-menu';
        /**
         * Filter the CSS class(es) applied to a menu item's list item element.
         *
         * @since 3.0.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        /**
         * Filter the ID applied to a menu item's list item element.
         *
         * @since 3.0.1
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        /**
         * Filter the HTML attributes applied to a menu item's anchor element.
         *
         * @since 3.6.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array $atts {
         *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
         *
         *     @type string $title  Title attribute.
         *     @type string $target Target attribute.
         *     @type string $rel    The rel attribute.
         *     @type string $href   The href attribute.
         * }
         * @param object $item  The current menu item.
         * @param array  $args  An array of {@see wp_nav_menu()} arguments.
         * @param int    $depth Depth of menu item. Used for padding.
         */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $span_after = '';

        $item_output = '';
        if ($item->object != "staticblocks"){
            if(is_object($args)){
                $item_output = $args->before;
                $item_output .= '<a'. $attributes .'>';
                /** This filter is documented in wp-includes/post-template.php */
                $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                $item_output .= '</a>'.$span_after;
                $item_output .= $args->after;
            }else{
                $item_output = '<a'. $attributes .'>';
                /** This filter is documented in wp-includes/post-template.php */
                $item_output .= apply_filters( 'the_title', $item->title, $item->ID ) ;
                $item_output .= '</a>';
            }

        }else{

            $post = get_post($item->object_id);

            $shortcodes_custom_css = get_post_meta( $post->ID, '_wpb_shortcodes_custom_css', true );
            if ( ! empty( $shortcodes_custom_css ) ) {
                $item_output .= '<style scoped type="text/css" data-type="vc_shortcodes-custom-css">';
                $item_output .= esc_html($shortcodes_custom_css);
                $item_output .= '</style>';
            }

            $item_output .= $post->post_content;

        }

        /**
         * Filter a menu item's starting output.
         *
         * The menu item's starting output only includes `$args->before`, the opening `<a>`,
         * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
         * no filter for modifying the opening and closing `<li>` for a menu item.
         *
         * @since 3.0.0
         *
         * @param string $item_output The menu item's starting HTML output.
         * @param object $item        Menu item data object.
         * @param int    $depth       Depth of menu item. Used for padding.
         * @param array  $args        An array of {@see wp_nav_menu()} arguments.
         */
        if ($item->object == "staticblocks"){
            $output .= $item_output;
        }else{
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }

    }


}