<?php

// prevent direct file access
if( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}



class PixThemeSettings_PixSection_Widget extends WP_Widget {


    function __construct() {
		// Create the widget.
		parent::__construct('pixtheme_section_widget', esc_html__('PixSection', 'pixsettings') , array( 'description' => esc_html__('Displays your custom Section', 'pixsettings'), ));
	}

    public function widget( $args, $instance ) {

        $blockId = isset( $instance['block_id'] ) ? $instance['block_id'] : 0;

        echo $args['before_widget'];

        $html = '<div class="pix-section-container">';

        $html .= pixtheme_get_section_content($blockId);

        $html .= '</div>';

        echo $html;

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $blockId = isset( $instance['block_id'] ) ? $instance['block_id'] : '';
        $blocks = $this->get_all_sections();


        ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'block_id' ); ?>"><?php _e( 'Pix Section:', 'pixsettings' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'block_id' ); ?>" name="<?php echo $this->get_field_name( 'block_id' ); ?>">
                <?php foreach ($blocks as $block):?>
                    <option <?php if ($blockId == $block->ID):?>selected="selected"<?php endif;?> value=<?php echo $block->ID?>""><?php echo $block->post_title?></option>
                <?php endforeach?>
            </select>
        </p>

        <?php
    }


    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['block_id'] = ( ! empty( $new_instance['block_id'] ) ) ? sanitize_text_field( $new_instance['block_id'] ) : '';
        return $instance;
    }

    private function get_all_sections(){
        $args = array(
            'post_type'        => 'pixsections',
            'post_status'      => 'publish',
        );

        $blocks = get_posts($args);

        return $blocks;
    }

}


class PixThemeSettings_Taxonomy_Widget extends WP_Widget {

	// Widget setup.
	function __construct() {

		// Widget settings.
		$widget_ops = array(
			'classname' => 'pix-widget-taxonomy-category',
			'description' => esc_html__('Display Custom Categories', 'pixsettings')
		);

		// Create the widget.
		parent::__construct('PixThemeSettings_Taxonomy_Widget', esc_html__('Pix Taxonomy Categories', 'pixsettings') , $widget_ops);
	}

	// Display the widget on the screen.
	function widget($args, $instance) {
		global $post;
		extract($args);
		
		$permalinks = wp_parse_args( (array) get_option( 'pix_permalinks', array() ), array(
            'team_base'           => '',
            'team_category_base'          => '',
            'portfolio_base'               => '',
            'portfolio_category_base'         => '',
            'service_base'               => '',
            'service_category_base'         => '',
        ) );
		$permalinks_arr = array();
        $permalinks_arr['pix-team-cat'] = !isset($permalinks['team_category_base']) || empty($permalinks['team_category_base']) ? 'specialty' : $permalinks['team_category_base'];
        $permalinks_arr['pix-portfolio-cat'] = !isset($permalinks['portfolio_category_base']) || empty($permalinks['portfolio_category_base']) ? 'portfolio_category' : $permalinks['portfolio_category_base'];
        $permalinks_arr['pix-service-cat'] = !isset($permalinks['service_category_base']) || empty($permalinks['service_category_base']) ? 'departments' : $permalinks['service_category_base'];
		$title = apply_filters('widget_title', $instance['pix_title']);
		$pix_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		$all_page = pixtheme_get_option('services_settings_page', '');
		if ( '' != $all_page ) {
			$all_services = get_the_permalink($all_page);
		} else {
		    $all_services = '';//get_bloginfo( 'url' ) . '/' . $permalinks_arr[$instance['pix_taxonomy']];
        }

		echo wp_kses_post($before_widget);
		if ($title) echo wp_kses_post($before_title . $title . $after_title);
  
		
		$args = array( 'taxonomy' => $instance['pix_taxonomy'], 'hide_empty' => '0');
		$categories = get_categories($args);
		echo '<div class="pix-categories"><ul>';
		echo '' == $all_services ? '' : '<li><a href="'. esc_url($all_services) .'">'. wp_kses_post($instance['pix_all_title']) .'</a></li>';

		foreach($categories as $category){
			$class = isset($pix_term->slug) && ($pix_term->slug == $category->slug) ? 'class="active"' : '';
			?>
			<li <?php echo wp_kses_post($class)?>><a href="<?php echo esc_url(get_category_link( $category->term_id )); ?>"><?php echo wp_kses_post($category->name); ?></a></li>
            <?php
		}
		echo '</ul></div>';
		echo wp_kses_post($after_widget);
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['pix_taxonomy'] = strip_tags($new_instance['pix_taxonomy']);
		$instance['pix_title'] = strip_tags($new_instance['pix_title']);
		$instance['pix_all_title'] = strip_tags($new_instance['pix_all_title']);
		return $instance;
	}

	function form($instance) {
	    global $pix_settings;
		$defaults = array(
            'pix_taxonomy' => '',
			'pix_title' => esc_html__('Categories', 'pixsettings'),
            'pix_all_title' => esc_html__('All', 'pixsettings'),
		);
		$pix_taxonomy_arr = array('' => esc_html__('Select Taxonomy Category', 'pixsettings'));
		if( $pix_settings->settings->get_setting('pix-team') == 'on' ){
            $pix_taxonomy_arr['pix-team-cat'] = esc_html__('Team Category', 'pixsettings');
        }
        if( $pix_settings->settings->get_setting('pix-portfolio') == 'on' ){
            $pix_taxonomy_arr['pix-portfolio-cat'] = esc_html__('Portfolio Category', 'pixsettings');
        }
        if( $pix_settings->settings->get_setting('pix-service') == 'on' ){
            $pix_taxonomy_arr['pix-service-cat'] = esc_html__('Services Category', 'pixsettings');
        }
		$instance = wp_parse_args((array)$instance, $defaults); ?>
        <p>
			<select id="<?php echo esc_attr($this->get_field_id('pix_taxonomy')); ?>" name="<?php echo esc_attr($this->get_field_name('pix_taxonomy')); ?>" class="widefat" >
            <?php
            foreach($pix_taxonomy_arr as $key => $val){
                if($instance['pix_taxonomy'] == $key){
                    echo '<option value="'.esc_attr($key).'" selected>'.wp_kses_post($val).'</option>';
                }else{
                    echo '<option value="'.esc_attr($key).'">'.wp_kses_post($val).'</option>';
                }
            }
            ?>
            </select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('pix_title')); ?>"><?php esc_html_e('Title', 'pixsettings'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('pix_title')); ?>" type="text" name="<?php echo esc_attr($this->get_field_name('pix_title')); ?>" value="<?php echo esc_attr($instance['pix_title']); ?>" class="widefat" />
		</p>
        <p>
			<label for="<?php echo esc_attr($this->get_field_id('pix_all_title')); ?>"><?php esc_html_e('All Items Title', 'pixsettings'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('pix_all_title')); ?>" type="text" name="<?php echo esc_attr($this->get_field_name('pix_all_title')); ?>" value="<?php echo esc_attr($instance['pix_all_title']); ?>" class="widefat" />
		</p>

	<?php
	}
}

class PixThemeSettings_Latest_News extends WP_Widget {

	// Widget setup.
	function __construct() {
		// Create the widget.
		parent::__construct('pixtheme_latest_news', esc_html__('Latest News', 'pixsettings') , array( 'description' => esc_html__('Display Latest News', 'pixsettings'), ));
	}

	// Display the widget on the screen.
	function widget($args, $instance) {
		global $post;
		extract($args);
		$title = apply_filters('widget_title', $instance['news_title']);
		$count = isset( $instance['news_count'] ) ? $instance['news_count'] : '2';
		$all_title = isset( $instance['news_all_title'] ) ? $instance['news_all_title'] : '';
		$all_page = isset( $instance['news_page'] ) ? $instance['news_page'] : '';

		$args_posts = array(
            'ignore_sticky_posts' => true,
            'showposts' => $count,
        );

        $wp_query = new WP_Query( $args_posts );
        if ($wp_query->have_posts()):

            echo wp_kses_post($before_widget);
		    if ($title) echo wp_kses_post($before_title . $title . $after_title);

            $date = '';
            while ($wp_query->have_posts()) :
                $wp_query->the_post();
                if( pixtheme_get_option('blog_show_date', '1') ){
                    $date = '<span class="time"><a href="'.esc_url(get_the_permalink()).'"><time>'.wp_kses_post(get_the_date()).'</time></a></span>';
                }
                $thumbnail = get_the_post_thumbnail( get_the_ID() ) != '' ? get_the_post_thumbnail( get_the_ID(), 'pixtheme-thumb' ) : '';
                //'<a href="'.esc_url(get_the_permalink()).'">'.wp_kses_post($thumbnail).'</a>';
                echo '
                <div class="side-menu__item-news">
                    <div class="news-image">
                        '.wp_kses_post($date).'
                    </div>
                    <div class="news-text">
                        <a href="'.esc_url(get_the_permalink()).'">'.wp_kses_post(get_the_title()).'</a>
                    </div>
                </div>
                ';

            endwhile;

            if($all_title){
                echo '<a class="side-menu__item-all_news" href="'.esc_url($all_page).'">'.wp_kses_post($all_title).'</a>';
            }

            echo wp_kses_post($after_widget);

        endif;

        wp_reset_query();

	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['news_title'] = strip_tags($new_instance['news_title']);
		$instance['news_count'] = strip_tags($new_instance['news_count']);
		$instance['news_all_title'] = strip_tags($new_instance['news_all_title']);
		$instance['news_page'] = strip_tags($new_instance['news_page']);
		return $instance;
	}

	function form($instance) {
	    $guid = '';
	    $blog_page  = get_page_by_title( 'Blog' );
	    if($blog_page)
	        $guid = $blog_page->guid;
		$defaults = array(
			'news_title' => esc_html__('Latest News', 'pixsettings'),
            'news_count' => '2',
            'news_all_title' => esc_html__('all', 'pixsettings'),
            'news_page' => esc_url($guid),
		);
		$instance = wp_parse_args((array)$instance, $defaults); ?>
		<p>
            <label for="<?php echo esc_attr($this->get_field_id('news_title')); ?>"><?php esc_html_e('Title', 'pixsettings'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('news_title')); ?>" type="text" name="<?php echo esc_attr($this->get_field_name('news_title')); ?>" value="<?php echo esc_attr($instance['news_title']); ?>" class="widefat" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('news_count')); ?>"><?php esc_html_e('Count', 'pixsettings'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('news_count')); ?>" type="text" name="<?php echo esc_attr($this->get_field_name('news_count')); ?>" value="<?php echo esc_attr($instance['news_count']); ?>" class="widefat" />
        </p>
        <p>
			<label for="<?php echo esc_attr($this->get_field_id('news_all_title')); ?>"><?php esc_html_e('All Button Title', 'pixsettings'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('news_all_title')); ?>" type="text" name="<?php echo esc_attr($this->get_field_name('news_all_title')); ?>" value="<?php echo esc_attr($instance['news_all_title']); ?>" class="widefat" />
		</p>
        <p>
			<label for="<?php echo esc_attr($this->get_field_id('news_page')); ?>"><?php esc_html_e('All Button Url', 'pixsettings'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('news_page')); ?>" type="text" name="<?php echo esc_attr($this->get_field_name('news_page')); ?>" value="<?php echo esc_url($instance['news_page']); ?>" class="widefat" />
		</p>

	<?php
	}
}