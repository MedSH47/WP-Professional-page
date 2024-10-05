
jQuery(function($){
	"use strict";

	window.VcPixContainerView = window.VcTabView.extend({
		events: {
			"click > .vc_controls .vc_control-btn-delete": "deleteShortcode",
			"click > .vc_controls .vc_control-btn-prepend": "addElement",
			"click > .vc_controls .vc_control-btn-edit": "editElement",
			"click > .vc_controls .vc_control-btn-clone": "clone",
			"click > .wpb_element_wrapper > .vc_empty-container": "addToEmpty"
		}, deleteShortcode: function (e) {
			var parent, parent_id = this.model.get("parent_id");
			_.isObject(e) && e.preventDefault();
			var answer = confirm(window.i18nLocale.press_ok_to_delete_section);
			return !0 !== answer ? !1 : (this.model.destroy(), void(parent_id && !vc.shortcodes.where({parent_id: parent_id}).length ? (parent = vc.shortcodes.get(parent_id), _.contains(["vc_column", "vc_column_inner"], parent.get("shortcode")) || parent.destroy()) : parent_id && (parent = vc.shortcodes.get(parent_id), parent && parent.view && parent.view.setActiveLayoutButton && parent.view.setActiveLayoutButton())))
		}
	})

});



