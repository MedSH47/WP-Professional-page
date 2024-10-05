!function ($) {

    $('.pix-vc-switch-button').each(function () {

        var $container = $(this),
        $input = $container.find('input.wpb_vc_param_value'),
        $checkbox = $container.find('.pix-switch-button-field');

        $checkbox.on('click', function() {
            if($(this).prop('checked')) {
                $input.val('on');
            } else {
                $input.val('off');
            }
            $input.trigger( "change" );
        });

    });


}(window.jQuery);