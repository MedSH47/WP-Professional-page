/* customizer range-slider */

jQuery(function($){

    "use strict";

    /////////////////////////////////////////////////////////////////
    //   RANGE SLIDER
    /////////////////////////////////////////////////////////////////

    $( '.range-slider-single' ).each(function() {
        var $range = $( this );
        var Format = wNumb({
            suffix: $range.data('unit')
        });
        var $value = $range.val();
        var $step = $range.data('step') == '' ? 1 : $range.data('step');
        var $min = $range.data('min');
        var $max = $range.data('max');
        var $value_div = $range.next( '.range-values');
        var $value_input = $value_div.find( '.range-value');
        var $value_plus = $value_div.find( '.pix-slider-plus');
        var $value_minus = $value_div.find( '.pix-slider-minus');
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
        });

        var slider = $range.data("ionRangeSlider");

        $value_input.on("change", function () {
            var $from = $(this).val();

            slider.update({
                from: Format.from($from)
            });
        });

        $value_plus.on("click", function () {
            var $from = Format.from($value_input.val())+$step;
            if($from <= $max) {
                $value_input.val(Format.to($from));
                slider.update({
                    from: $from
                });
            }
        });

        $value_minus.on("click", function () {
            var $from = Format.from($value_input.val())-$step;
            if($from >= $min) {
                $value_input.val(Format.to($from));
                slider.update({
                    from: $from
                });
            }
        });

    });


    $( '.range-slider-double' ).each(function() {
        var $range = $( this );
        var Format = wNumb({
            suffix: '%'
        });
        var $values = $range.val().split(";");
        var $min = $range.data('min');
        var $max = $range.data('max');
        var $control = $range.data('control');
        var $value_div = $range.next( '.range-values');
        $value_div.find( '.range-value-1').val( Format.to(parseInt($values[0])) );
        $value_div.find( '.range-value-2' ).val( Format.to($values[1]-$values[0]) );
        $value_div.find( '.range-value-3' ).val( Format.to($max-$values[1]) );

        $range.ionRangeSlider({
            type: "double",
            min: $min,
            max: $max,
            from: $values[0],
            to: $values[1],
            hide_min_max: true,
            hide_from_to: true,
            postfix: "%",
            grid: false
        });

        $range.on("change", function () {
            var $this = $(this),
                from = $this.data("from"),
                to = $this.data("to"),
                $value_div = $(this).next( '.range-values');

            $value_div.find( '.range-value-1').val( Format.to(from) );
            $value_div.find( '.range-value-2' ).val( Format.to(to-from) );
            $value_div.find( '.range-value-3' ).val( Format.to($max-to) );

        });
    });

});
