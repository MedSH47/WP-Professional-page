<?php

add_action('edit_form_after_title', function() {
    global $post, $wp_meta_boxes;
    do_meta_boxes(get_current_screen(), 'advanced', $post);
    unset($wp_meta_boxes[get_post_type($post)]['advanced']);
});



function pixtheme_team_info( $post ) {

    $field_1 = get_post_meta($post->ID, 'pix_field_1', 1);
    $field_2 = get_post_meta($post->ID, 'pix_field_2', 1);
    $field_3 = get_post_meta($post->ID, 'pix_field_3', 1);
    $field_4 = get_post_meta($post->ID, 'pix_field_4', 1);

    ?>
    <div class="pix-metabox-normal-fields">

            <label for="pix_field_1"><?php esc_html_e('Object', 'solutech'); ?></label>
            <input name="pix_field_1" id="pix_field_1" type="text" value="<?php echo esc_attr($field_1); ?>"/>

            <label for="pix_field_2"><?php esc_html_e('Year', 'solutech'); ?></label>
            <input name="pix_field_2" id="pix_field_2" type="text" value="<?php echo esc_attr($field_2); ?>"/>

            <label for="pix_field_3"><?php esc_html_e('Security Level', 'solutech'); ?></label>
            <input name="pix_field_3" id="pix_field_3" type="text" value="<?php echo esc_attr($field_3); ?>"/>

            <label for="pix_field_4"><?php esc_html_e('Project Place', 'solutech'); ?></label>
            <input name="pix_field_4" id="pix_field_4" type="text" value="<?php echo esc_attr($field_4); ?>"/>
    
    </div>
    <?php

}

add_action( 'save_post', 'pixtheme_team_info_save' );
function pixtheme_team_info_save( $post_id ) {
    if ( !empty($_POST['extra_fields_nonce']) && !wp_verify_nonce($_POST['extra_fields_nonce'], __FILE__) ) return false;
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false;
    if ( !current_user_can('edit_post', $post_id) ) return false;

    if( !isset($_POST['pix_field_1'])
        && !isset($_POST['pix_field_2'])
        && !isset($_POST['pix_field_3'])
        && !isset($_POST['pix_field_4'])
    ) return false;

    $_POST['pix_field_1'] = trim($_POST['pix_field_1']);
    $_POST['pix_field_2'] = trim($_POST['pix_field_2']);
    $_POST['pix_field_3'] = trim($_POST['pix_field_3']);
    $_POST['pix_field_4'] = trim($_POST['pix_field_4']);

    if( !isset($_POST['pix_field_1']) ){
        delete_post_meta($post_id, 'pix_field_1');
    }else{
        update_post_meta($post_id, 'pix_field_1', $_POST['pix_field_1']);
    }

    if( !isset($_POST['pix_field_2']) ){
        delete_post_meta($post_id, 'pix_field_2');
    }else{
        update_post_meta($post_id, 'pix_field_2', $_POST['pix_field_2']);
    }

    if( !isset($_POST['pix_field_3']) ){
        delete_post_meta($post_id, 'pix_field_3');
    }else{
        update_post_meta($post_id, 'pix_field_3', $_POST['pix_field_3']);
    }

    if( !isset($_POST['pix_field_4']) ){
        delete_post_meta($post_id, 'pix_field_4');
    }else{
        update_post_meta($post_id, 'pix_field_4', $_POST['pix_field_4']);
    }

    return $post_id;
}

add_action('wp_ajax_pix_get_post_gallery', 'pix_get_post_gallery');
add_action('wp_ajax_nopriv_pix_get_post_gallery', 'pix_get_post_gallery');

function pix_get_post_gallery() {
    $data = array_map( 'esc_attr', $_GET );

    check_ajax_referer( 'pix_post_ajax_nonce', 'nonce' );
    $keys = array_keys($data);

    if( true && in_array('ids', $keys) ) {
        wp_send_json_success( do_shortcode('[gallery ids="' . ($data['ids']) . '"]') );
    } else {
        wp_send_json_error(array('error' => 'Something wrong!'));
    }
}

function pixtheme_post_formats( $post ) {
    
    // Gallery Format
    $pix_ids = get_post_meta($post->ID, 'pix_post_gallery_ids', 1);
    // We display the gallery
    $html  = '<div class="pix-gallery-content">';
    $html  .= $pix_ids != '' ? do_shortcode('[gallery ids="'.esc_attr($pix_ids).'"]') : '';
    $html  .= '</div>';
    // Here we store the image ids which are used when saving the auto
    $html .= '<input id="pix_post_gallery_ids" type="hidden" name="pix_post_gallery_ids" value="'.esc_attr($pix_ids). '" />';
    // A button which we will bind to later on in JavaScript
    $html .= '<input id="manage_gallery" title="'.esc_html__( 'Manage gallery', 'solutech').'" type="button" value="'.esc_html__( 'Manage', 'solutech').'" />';
    $html .= '<input id="clear_gallery" title="'.esc_html__( 'Clear gallery', 'solutech').'" type="button" value="'.esc_html__( 'Clear', 'solutech').'" />';


    $pix_post_video_url = get_post_meta($post->ID, 'pix_post_video_url', 1);
    $pix_post_quote_content = get_post_meta($post->ID, 'pix_post_quote_content', 1);
    $pix_post_quote_source = get_post_meta($post->ID, 'pix_post_quote_source', 1);
    
    ?>
    <div class="pix-post-format-settings">

        <div class="pix-format-gallery">
            <h4><?php esc_html_e('Gallery', 'solutech'); ?></h4>
            <?php
            if(function_exists('pix_out')){
                pix_out($html);
            } else {
                echo wp_kses_post($html);
            }
            ?>
        </div>

        <div class="pix-format-video">
            <h4><?php esc_html_e('Video', 'solutech'); ?></h4>
            <div class="pix-metabox-normal-fields">
                <label for="pix_post_video_url"><?php esc_html_e('Link', 'solutech'); ?></label>
                <input name="pix_post_video_url" id="pix_post_video_url" type="text" value="<?php echo esc_url($pix_post_video_url); ?>"/>
            </div>
        </div>

        <div class="pix-format-quote">
            <h4><?php esc_html_e('Quote', 'solutech'); ?></h4>
            <div class="pix-metabox-normal-fields">
                <label for="pix_post_quote_content"><?php esc_html_e('Content', 'solutech'); ?></label>
                <textarea name="pix_post_quote_content" id="pix_post_quote_content" rows="4"><?php echo wp_kses_post($pix_post_quote_content); ?></textarea>
                <label for="pix_post_quote_source"><?php esc_html_e('Source', 'solutech'); ?></label>
                <input name="pix_post_quote_source" id="pix_post_quote_source" type="text" value="<?php echo wp_kses_post($pix_post_quote_source); ?>"/>
            </div>
        </div>

    </div>
    <?php

    wp_nonce_field('pix_post_format_nonce', 'post_format_nonce'); // Security

}

add_action( 'save_post', 'pixtheme_post_formats_save' );
function pixtheme_post_formats_save( $post_id ) {
    if ( !empty($_POST['post_format_nonce']) && !wp_verify_nonce($_POST['post_format_nonce'], 'pix_post_format_nonce') ) return false;
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false;
    if ( !current_user_can('edit_post', $post_id) ) return false;

    if( !isset($_POST['pix_post_gallery_ids'])
        && !isset($_POST['pix_post_video_url'])
        && !isset($_POST['pix_post_quote_content'])
    ) return false;

    $_POST['pix_post_video_url'] = trim($_POST['pix_post_video_url']);

    if( !isset($_POST['pix_post_video_url']) ){
		delete_post_meta($post_id, 'pix_post_video_url');
	}else{
		update_post_meta($post_id, 'pix_post_video_url', $_POST['pix_post_video_url']);
	}

	if( !isset($_POST['pix_post_quote_content']) ){
		delete_post_meta($post_id, 'pix_post_quote_content');
	}else{
		update_post_meta($post_id, 'pix_post_quote_content', $_POST['pix_post_quote_content']);
	}

	if( !isset($_POST['pix_post_quote_source']) ){
		delete_post_meta($post_id, 'pix_post_quote_source');
	}else{
		update_post_meta($post_id, 'pix_post_quote_source', $_POST['pix_post_quote_source']);
	}

	if( !isset($_POST['pix_post_gallery_ids']) ){
		delete_post_meta($post_id, 'pix_post_gallery_ids');
	}else{
		update_post_meta($post_id, 'pix_post_gallery_ids', $_POST['pix_post_gallery_ids']);
	}

    return $post_id;
}



// Layout Settings //

function pixtheme_layout_side_content( $post ) {

	echo '<p class="pix-margin-bottom-xs"><strong>'.esc_html__('Main Color', 'solutech').'</strong></p>';
	$sel_v = get_post_meta($post->ID, 'page_main_color', 1);
	echo '<input type="text" name="page_main_color" value="'.esc_attr($sel_v).'" class="admin-color-field" data-default-color="" />';
	
	echo '<p class="pix-margin-bottom-xs"><strong>'.esc_html__('Additional Color', 'solutech').'</strong></p>';
	$sel_add = get_post_meta($post->ID, 'page_additional_color', 1);
	echo '<input type="text" name="page_additional_color" value="'.esc_attr($sel_add).'" class="admin-color-field" data-default-color="" />';
	
	echo '<p class="pix-margin-bottom-xs"><strong>'.esc_html__('Header Logo', 'solutech').'</strong></p>';
	$sel_logo = get_post_meta($post->ID, 'header_logo', true);
    echo '<p class="pix-margin-top-xs">
	        <input type="text" name="header_logo" id="header_logo" value="'.esc_url($sel_logo).'" />
            <button data-input="header_logo" class="btn pix-image-upload pix-btn-icon"><i class="fa fa-picture-o"></i></button>
            <button type="button" class="btn pix-reset pix-btn-icon"><i class="fa fa-trash-o"></i></button>
          </p>';
    if($sel_logo){
        echo '<p class="pix-bg-png"> <img src="'.esc_url($sel_logo).'" alt="'.esc_attr__('Logo Light', 'solutech').'"> </p>';
    }
    
    echo '<p class="pix-margin-bottom-xs"><strong>'.esc_html__('Header Image', 'solutech').'</strong></p>';
	$sel_bg = get_post_meta($post->ID, 'header_bg_image', true);
    echo '<p class="pix-margin-top-xs">
	        <input type="text" name="header_bg_image" id="header_bg_image" value="'.esc_url($sel_bg).'" />
            <button data-input="header_bg_image" class="btn pix-image-upload pix-btn-icon"><i class="fa fa-picture-o"></i></button>
            <button type="button" class="btn pix-reset pix-btn-icon"><i class="fa fa-trash-o"></i></button>
          </p>';
    if($sel_bg){
        echo '<p class="pix-bg-png"> <img src="'.esc_url($sel_bg).'" alt="'.esc_attr__('Header Image', 'solutech').'"> </p>';
    }

}


add_action( 'save_post', 'pixtheme_layout_side_save' );
function pixtheme_layout_side_save( $post_id ) {
	if ( !empty($_POST['extra_fields_nonce']) && !wp_verify_nonce($_POST['extra_fields_nonce'], __FILE__) ) return false;
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false;
	if ( !current_user_can('edit_post', $post_id) ) return false;

	if( !isset($_POST['page_main_color'])
        && !isset($_POST['page_additional_color'])
		&& !isset($_POST['header_logo'])
		&& !isset($_POST['header_bg_image'])
	) return false;
	
	$_POST['header_logo'] = trim($_POST['header_logo']);
	$_POST['header_bg_image'] = trim($_POST['header_bg_image']);
	$_POST['page_main_color'] = trim($_POST['page_main_color']);
	$_POST['page_additional_color'] = trim($_POST['page_additional_color']);
	

	if( !isset($_POST['page_main_color']) ){
		delete_post_meta($post_id, 'page_main_color');
	}else{
		update_post_meta($post_id, 'page_main_color', $_POST['page_main_color']);
	}
	
	if( !isset($_POST['page_additional_color']) ){
		delete_post_meta($post_id, 'page_additional_color');
	}else{
		update_post_meta($post_id, 'page_additional_color', $_POST['page_additional_color']);
	}

	if( !isset($_POST['header_logo']) ){
		delete_post_meta($post_id, 'header_logo');
	}else{
		update_post_meta($post_id, 'header_logo', $_POST['header_logo']);
	}

	if( !isset($_POST['header_bg_image']) ){
		delete_post_meta($post_id, 'header_bg_image');
	}else{
		update_post_meta($post_id, 'header_bg_image', $_POST['header_bg_image']);
	}

	return $post_id;
}

//*** Layout Settings ***//



function pixtheme_header_style_content( $post ) {


	echo '<p><strong>'.esc_html__('Header On/Off', 'solutech').'</strong></p>';
	$sel_switch = get_post_meta($post->ID, 'pix_header_switch', true);

    $checked = $sel_switch == 'off' ? '' : 'checked';
    echo '<div class="pix-switch-container">
            <label class="switch switch-green">
              <input type="checkbox" class="switch-input pix-switch-button" '.esc_attr($checked).'>
              <span class="switch-label" data-on="On" data-off="Off"></span>
              <span class="switch-handle"></span>
            </label>
            <input type="text" name="pix_header_switch" class="pix-switch-value hidden-field-value" value="'.esc_attr($sel_switch).'"/>
          </div>
            ';

	echo '<input type="hidden" name="extra_fields_nonce" value="'.esc_attr(wp_create_nonce(__FILE__)).'" />';
}

add_action( 'save_post', 'pixtheme_header_style_save' );
function pixtheme_header_style_save( $post_id ) {
	if ( !empty($_POST['extra_fields_nonce']) && !wp_verify_nonce($_POST['extra_fields_nonce'], __FILE__) ) return false; // проверка
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; // выходим если это автосохранение
	if ( !current_user_can('edit_post', $post_id) ) return false; // выходим если юзер не имеет право редактировать запись

	if( !isset($_POST['pix_header_switch'])
	) return false;


	if( !isset($_POST['pix_header_switch']) ){
		delete_post_meta($post_id, 'pix_header_switch'); // удаляем поле если значение пустое
	}else{
		update_post_meta($post_id, 'pix_header_switch', $_POST['pix_header_switch']); // add_post_meta() работает автоматически
	}

	return $post_id;
}




/** START SIDEBAR OPTIONS */

function pixtheme_sidebar_options(){
	global $wp_registered_sidebars;
 
	// SIDEBAR
	$selected_sidebar_layout = get_post_meta(get_the_ID(), 'pix_page_layout', true);
    
    
    // SIDEBAR CONTENT
    $selected_sidebar = get_post_meta(get_the_ID(), 'pix_selected_sidebar', true);
    
    $pix_sidebars = array( '' => esc_html__( 'Global Settings', 'solutech' ));
    foreach($wp_registered_sidebars as $key => $val){
        $pix_sidebars[$val['id']] = $val['name'];
    }
    
    
    // FOOTER
    $selected_footer = (get_post_meta(get_the_ID(), 'pix_page_footer', true) == "") ? 'global' : get_post_meta(get_the_ID(), 'pix_page_footer', true);
	
	$args = array(
		'post_type'        => 'pix-section',
		'post_status'      => 'publish',
	);
	$pix_sections = array();
	$pix_sections['global'] = esc_html__('Global Settings','solutech');
	$pix_sections_data = get_posts( $args );
	foreach($pix_sections_data as $pix_section){
		$pix_sections[$pix_section->ID] =  $pix_section->post_title;
	}
	$pix_sections['nofooter'] = esc_html__('No Footer','solutech');
	
	?>

	<p><strong><?php echo esc_html__('Sidebar', 'solutech')?></strong></p>
	
	<select class="pix-sidebar-select" name="pix_page_layout" id="pix_page_layout" size="0">
		<option value="" <?php if ($selected_sidebar_layout == ''):?>selected="selected"<?php endif?>><?php echo esc_html__('Global Settings', 'solutech')?></option>
		<option value="1" <?php if ($selected_sidebar_layout == 1):?>selected="selected"<?php endif?>><?php echo esc_html__('Without Sidebar', 'solutech')?></option>
		<option value="2" <?php if ($selected_sidebar_layout == 2):?>selected="selected"<?php endif?>><?php echo esc_html__('Right Sidebar', 'solutech')?></option>
		<option value="3" <?php if ($selected_sidebar_layout == 3):?>selected="selected"<?php endif?>><?php echo esc_html__('Left Sidebar', 'solutech')?></option>
	</select>
 
	
	<p><strong><?php echo esc_html__('Sidebar Content', 'solutech')?></strong></p>
	
    <select class="pix-sidebar-select" name="sidebar_content">
    <?php
    if(is_array($pix_sidebars) && !empty($pix_sidebars)){
        foreach($pix_sidebars as $key => $val){
            if($selected_sidebar == $key){
                echo '<option value="'.esc_attr($key).'" selected>'.wp_kses_post($val).'</option>';
            }else{
                echo '<option value="'.esc_attr($key).'">'.wp_kses_post($val).'</option>';
            }
        }
    }
    ?>
    </select>


	<p><strong><?php echo esc_html__('Footer', 'solutech')?></strong></p>
	
    <select class="pix-sidebar-select" name="pix_page_footer">
    <?php
        foreach($pix_sections as $id => $section){
            if($id == $selected_footer){
                echo "<option value='".esc_attr($id)."' selected>".esc_attr($section)."</option>\n";
            }else{
                echo "<option value='".esc_attr($id)."'>".esc_attr($section)."</option>\n";
            }
        }
    ?>
    </select>

<?php }

/** END SIDEBAR OPTIONS */


/** START WOO LAYOUT OPTIONS */

function pixtheme_woo_layout(){

	$selected_woo_layout = (get_post_meta(get_the_ID(), 'pix_woo_layout', true) == "") ? '' : get_post_meta(get_the_ID(), 'pix_woo_layout', true);

	?>

	<p><strong><?php echo esc_html__('Woocommerce Layout', 'solutech')?></strong></p>

	<select class="pix-sidebar-select" name="pix_woo_layout" id="pix_woo_layout" size="0">
		<option value="" <?php if ($selected_woo_layout == ''):?>selected="selected"<?php endif?>><?php echo esc_html__('Global', 'solutech')?></option>
		<option value="default" <?php if ($selected_woo_layout == 'default'):?>selected="selected"<?php endif?>><?php echo esc_html__('Default', 'solutech')?></option>
		<option value="hover" <?php if ($selected_woo_layout == 'hover'):?>selected="selected"<?php endif?>><?php echo esc_html__('Hover Info', 'solutech')?></option>
	</select>

<?php }

/** END WOO LAYOUT OPTIONS */


/** START PORTFOLIO LAYOUT OPTIONS */

function pixtheme_portfolio_layout_options(){
	global $post;
	$post_id = $post;
	if (is_object($post_id)) {
		$post_id = $post_id->ID;
	}

	if(class_exists('booked_plugin')) {

		$selected_calendar = get_post_meta($post_id, 'pix_portfolio_calendar', true) == '' ? -1 : get_post_meta($post_id, 'pix_portfolio_calendar', true);

		$args = array( 'hide_empty' => false );
		$categories = get_terms( $args );
		$calendars = array();
		$calendars[-1] = esc_html__('Booking Disable', 'solutech');
		$calendars[0] = esc_html__('Default Calendar', 'solutech');
		foreach($categories as $category){
			if( is_object($category) ){
				if( $category->taxonomy == 'booked_custom_calendars' ){
					$calendars[$category->term_id] = $category->name;
				}
			}
		}
		?>
		<ul>

			<li>
				<select name="pix_portfolio_calendar">
					<?php foreach($calendars as $id => $_calendars){
						if($id == $selected_calendar){
							echo "<option value='".esc_attr($id)."' selected>".esc_attr($_calendars)."</option>\n";
						}else{
							echo "<option value='".esc_attr($id)."'>".esc_attr($_calendars)."</option>\n";
						}
					}
					?>
				</select>
			</li>
		</ul>
		<?php
	}
}

add_action('save_post', 'pixtheme_save_postdata');
function pixtheme_save_postdata( $post_id ){


    if (isset($_POST['pix_page_layout'])){
        if(get_post_meta($post_id, 'pix_page_layout') == "")
            add_post_meta($post_id, 'pix_page_layout', $_POST['pix_page_layout'], true);
        else
            update_post_meta($post_id, 'pix_page_layout', $_POST['pix_page_layout']);
    }

    if (isset($_POST['sidebar_content'])){
        if(get_post_meta($post_id, 'pix_page_layout') == "")
            add_post_meta($post_id, 'pix_selected_sidebar', $_POST['sidebar_content'], true);
        else
            update_post_meta($post_id, 'pix_selected_sidebar', $_POST['sidebar_content']);
    }
    if (isset($_POST['pix_page_footer'])){
        if(get_post_meta($post_id, 'pix_page_footer') == "")
            add_post_meta($post_id, 'pix_page_footer', $_POST['pix_page_footer'], true);
        else
            update_post_meta($post_id, 'pix_page_footer', $_POST['pix_page_footer']);
    }

    if (isset($_POST['pix_woo_layout'])){
        if(get_post_meta($post_id, 'pix_woo_layout') == "")
            add_post_meta($post_id, 'pix_woo_layout', $_POST['pix_woo_layout'], true);
        else
            update_post_meta($post_id, 'pix_woo_layout', $_POST['pix_woo_layout']);
    }

    if (isset($_POST['pix_portfolio_calendar'])){
        update_post_meta($post_id, 'pix_portfolio_calendar', $_POST['pix_portfolio_calendar']);
    } else {
        delete_post_meta($post_id, 'pix_portfolio_calendar');
    }
}


/** END PORTFOLIO LAYOUT OPTIONS */

