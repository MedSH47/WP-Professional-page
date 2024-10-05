!function ($) {

    $('.pix-vc-range-slider').each(function () {

        var $container = $(this),
        $input = $container.find('input.wpb_vc_param_value'),
        $range = $container.find('.pix-range-slider-field');
        var Format = wNumb({
            suffix: $range.data('unit')
        });
        var $value = $range.val();
        var $min = $range.data('min');
        var $max = $range.data('max');
        var $step = $range.data('step') == '' ? 1 : $range.data('step');
        var $value_div = $range.next( '.range-values');
        //console.log($value);
        var $value_input = $value_div.find( '.range-value');
        $value_input.val( Format.to(parseInt($value)) );

        $range.ionRangeSlider({
            type: "single",
            min: $min,
            max: $max,
            step: $step,
            from: $value,
            hide_min_max: false,
            hide_from_to: false,
            postfix: $range.data('unit'),
            grid: false
        });

        $range.on("change", function () {
            var $this = $(this),
                from = $this.data("from"),
                $value_div = $(this).next( '.range-values');

            $value_div.find( '.range-value').val( Format.to(from) );
            $input.val(Format.to(from));
            $input.trigger( "change" );
        });

        var slider = $range.data("ionRangeSlider");

        $value_input.on("change", function () {
            var $from = $(this).val();

            slider.update({
                from: Format.from($from)
            });
            $input.val(Format.from($from));
            $input.trigger( "change" );
        });

    });

}(window.jQuery);