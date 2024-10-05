<?php 


function pixtheme_init_sidebars(){
	if ( function_exists('register_sidebar') ){
	    
	    $before_widget  = '<div id="%1$s" class="%2$s pix-sidebar-box widget"><div class="pix-sidebar-form">';
	    $after_widget   = '</div></div>';
        $before_title   = '<div class="pix-sidebar-box-title"><h5 class="pix-h5">';
        $after_title    = '<span class="sep-element"></span></h5></div>';

		register_sidebar(array(
			'name' => esc_html__('WP Default Sidebar', 'solutech'),
			'id'	=> 'sidebar',
			'before_widget' => $before_widget,
			'after_widget' => $after_widget,
			'before_title' => $before_title,
			'after_title' => $after_title,
		));
	
		register_sidebar(array(
			'name' => esc_html__('Blog Sidebar', 'solutech'),
			'id' => 'blog-sidebar',
            'before_widget' => $before_widget,
            'after_widget' => $after_widget,
            'before_title' => $before_title,
            'after_title' => $after_title,
		));
        
        if(pixtheme_get_setting('pix-team', 'on') == 'on'){
            register_sidebar(array(
                'name' => esc_html__('Team Sidebar', 'solutech'),
                'id' => 'team-sidebar',
                'before_widget' => $before_widget,
                'after_widget' => $after_widget,
                'before_title' => $before_title,
                'after_title' => $after_title,
            ));
        }
        
        if(pixtheme_get_setting('pix-portfolio', 'on') == 'on'){
            register_sidebar(array(
                'name' => esc_html__('Portfolio Sidebar', 'solutech'),
                'id' => 'portfolio-sidebar',
                'before_widget' => $before_widget,
                'after_widget' => $after_widget,
                'before_title' => $before_title,
                'after_title' => $after_title,
            ));
		}
        
        if(pixtheme_get_setting('pix-services', 'on') == 'on'){
            register_sidebar(array(
                'name' => esc_html__('Services Sidebar', 'solutech'),
                'id' => 'service-sidebar',
                'before_widget' => $before_widget,
                'after_widget' => $after_widget,
                'before_title' => $before_title,
                'after_title' => $after_title,
            ));
		}

		register_sidebar(array(
			'name' => esc_html__('Shop sidebar', 'solutech'),
			'id'	=> 'shop-sidebar',
            'before_widget' => $before_widget,
            'after_widget' => $after_widget,
            'before_title' => $before_title,
            'after_title' => $after_title,
		));

		register_sidebar(array(
			'name' => esc_html__('Product sidebar', 'solutech'),
			'id'	=> 'product-sidebar',
            'before_widget' => $before_widget,
            'after_widget' => $after_widget,
            'before_title' => $before_title,
            'after_title' => $after_title,
		));

		register_sidebar(array(
			'name' => esc_html__('Custom Area', 'solutech'),
			'id'	=> 'custom-area',
            'before_widget' => $before_widget,
            'after_widget' => $after_widget,
            'before_title' => $before_title,
            'after_title' => $after_title,
		));
		
		
		
	}
}


add_action('widgets_init','pixtheme_init_sidebars');