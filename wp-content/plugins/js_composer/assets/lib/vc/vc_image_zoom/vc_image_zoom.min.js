/*!
* WPBakery Page Builder v7.6.0 (https://wpbakery.com)
* Copyright 2011-2024 Michael M, WPBakery
* License: Commercial. More details: http://go.wpbakery.com/licensing
*/
	// jscs:disable
	// jshint ignore: start 
!function(a){a.fn.vcImageZoom=function(){return this.each(function(){var o=a(this),t=o.data("vcZoom");o.removeAttr("data-vc-zoom").wrap('<div class="vc-zoom-wrapper"></div>').parent().zoom({duration:500,url:t,onZoomIn:function(){o.width()>a(this).width()&&o.trigger("zoom.destroy").attr("data-vc-zoom","").unwrap().vcImageZoom()}})}),this},"function"!=typeof window.vc_image_zoom&&(window.vc_image_zoom=function(o){var t="[data-vc-zoom]";a(t=void 0!==o?'[data-model-id="'+o+'"] '+t:t).vcImageZoom()}),a(document).ready(function(){window.vc_iframe||vc_image_zoom()})}(jQuery);