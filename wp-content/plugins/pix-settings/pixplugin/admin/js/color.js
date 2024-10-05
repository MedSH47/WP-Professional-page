/**
 * Javascript functions for Color component
 *
 * @package PixAdmin
 */

jQuery(document).ready(function ($) {

	"use strict";
    // Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $('.pix-color-field').wpColorPicker();
    });

});
