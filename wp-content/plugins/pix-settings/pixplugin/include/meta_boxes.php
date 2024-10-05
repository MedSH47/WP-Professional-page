<?php
// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


function pix_meta_boxes() {
 
	add_meta_box( 'pix_calcfields_details', esc_html__( 'Field Details', 'pixsettings' ), 'pix_calcfields_details', 'pix-calculator-field', 'normal', 'high' );
	
	function pix_field_default_hidden_meta_boxes( $hidden, $screen ) {
        $post_type = $screen->post_type;
        if( $post_type == 'pix-calculator-field' ){
            $hidden = array(
                'slugdiv',
                'mymetabox_revslider_0'
            );
            return $hidden;
        }
        return $hidden;
    }
    add_action( 'default_hidden_meta_boxes', 'pix_field_default_hidden_meta_boxes', 10, 2 );
}


function pix_get_value( $key ) {
	return sanitize_text_field( get_post_meta( get_the_ID(), $key, true ) );
}


function pix_calcfields_details() {
    
    $field_values = get_post_meta( get_the_ID(), 'pix-field-values', true );
    $i = 0;
    
	?>
	
    <input name="pix-fields-meta" type="hidden" value="save">
    
    <div class="pix-fields-form">
        <div class="pix-form-group">
            <label class="pix-header pix-control-label">
                <?php esc_html_e('Field Type', 'pixsettings') ?>
            </label>
            <div class="pix-content">
                <select name="pix-field-type" class="pix-form-control">
                    <option value="select" <?php selected( pix_get_value('pix-field-type'), 'select' ); ?> ><?php esc_html_e('Select', 'pixsettings') ?></option>
                    <option value="multiselect" <?php selected( pix_get_value('pix-field-type'), 'multiselect' ); ?> ><?php esc_html_e('Multi Select', 'pixsettings') ?></option>
                    <option value="check" <?php selected( pix_get_value('pix-field-type'), 'check' ); ?> ><?php esc_html_e('Checkbox', 'pixsettings') ?></option>
                    <option value="radio" <?php selected( pix_get_value('pix-field-type'), 'radio' ); ?> ><?php esc_html_e('Radiobutton', 'pixsettings') ?></option>
                </select>
            </div>
        </div>
        <div class="pix-form-group">
            <label class="pix-header pix-control-label">
                <?php esc_html_e('Empty Value', 'pixsettings') ?>
            </label>
            <div class="pix-content">
                <input name="pix-field-empty" type="text" value="<?php echo pix_get_value('pix-field-empty'); ?>" class="pix-form-control">
            </div>
        </div>
        <div class="pix-form-group">
            <label class="pix-header pix-control-label">
                <?php esc_html_e('Operation', 'pixsettings') ?>
            </label>
            <div class="pix-content">
                <select name="pix-operation-type" class="pix-form-control">
                    <option value="add" <?php selected( pix_get_value('pix-operation-type'), 'add' ); ?> ><?php esc_html_e('Addition', 'pixsettings') ?></option>
                    <option value="multi" <?php selected( pix_get_value('pix-operation-type'), 'multi' ); ?> ><?php esc_html_e('Multiplication', 'pixsettings') ?></option>
                </select>
            </div>
        </div>
        <div class="pix-form-group fields">
            <label class="pix-header pix-control-label">
                <?php esc_html_e('Values', 'pixsettings') ?>
            </label>
            <div class="pix-values">
                <div class="pix-content header">
                    <span><?php esc_html_e('Title', 'pixsettings') ?></span>
                    <span><?php esc_html_e('Price', 'pixsettings') ?></span>
                </div>
                
                <div class="pix-content-dynamic">
                <?php
                    if(isset($field_values['title']) ) {
                    
                        foreach ($field_values['title'] as $key => $val) {
                            $i++;
                            $del_btn = $i>1 ? '<a href="#" class="pix-delete-value"><i class="far fa-trash-alt"></i></a>' : '';
                            $price = isset($field_values['price'][$key]) ? $field_values['price'][$key] : '';
                            if(trim($val) != '' || $price != '') {
                                ?>
                                <div class="pix-content value">
                                    <input name="pix-calc-field[title][]" type="text"
                                           value="<?php echo wp_kses_post($val); ?>" class="pix-form-control">
                                    <div class="pix-input-wrapper">
                                        <input name="pix-calc-field[price][]" type="number" class="pix-form-control" step="any"
                                               value="<?php echo esc_attr($price); ?>"/>
                                    </div>
                                    <?php echo wp_kses_post($del_btn); ?>
                                </div>
                                <?php
                            }
                        }
                        
                    } else {
                ?>
                    <div class="pix-content value">
                        <input name="pix-calc-field[title][]" type="text" value="" class="pix-form-control">
                        <div class="pix-input-wrapper">
                            <input name="pix-calc-field[price][]" type="number" class="pix-form-control" step="any" value="" />
                        </div>
                    </div>
                <?php
                    }
                ?>
                </div>
                
                <a class="pix-add-field-button" href="#">
                    <i class="far fa-plus-square"></i>
                </a>
            </div>
        </div>
    </div>
    
    <?php
}


function save_pix_meta_boxes( $post_id ) {
    global $pix_settings;
	
	if( isset( $_POST['pix-fields-meta'] ) && $_POST['pix-fields-meta'] == 'save' ) {

	    update_post_meta( $post_id, 'pix-field-values', $_POST['pix-calc-field'] );

	}

    if (isset($_POST['pix-field-type'])) {
        update_post_meta($post_id, 'pix-field-type', $_POST['pix-field-type']);
    }
    
    if (isset($_POST['pix-field-empty'])) {
        update_post_meta($post_id, 'pix-field-empty', $_POST['pix-field-empty']);
    }

    if (isset($_POST['pix-operation-type'])) {
        update_post_meta($post_id, 'pix-operation-type', $_POST['pix-operation-type']);
    }

}
add_action( 'save_post', 'save_pix_meta_boxes' );


?>