!function ($) {

    $('.pix-vc-radio-images').each(function () {

        var $container = $(this),
        $input = $container.find('input.wpb_vc_param_value'),
        $radioboxes = $container.find('.pix-radio-images-field'),
        $value = $input.val();

        //reset all selected value
        $container.find('.pix-radio-images-field').prop('checked', false);
        $container.find('.pix-radio-images-field[value="'+ $value +'"]').prop('checked', true);

        $radioboxes.on('click', function() {
            if($(this).prop('checked')) {
                $container.find('.pix-radio-images-field').prop('checked', false);
                $(this).prop('checked', true);
                $value = $(this).val();
            }
            $input.val($value);
            $input.trigger( "change" );
        });

    });


}(window.jQuery);