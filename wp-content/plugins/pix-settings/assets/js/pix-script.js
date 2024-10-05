jQuery(document).ready(function($) {

    // init vanillaSelectBox
    function pixVanillaSelectBox() {
        var pixMultiSelectBox = $('select.pix-multi-select'),
            pixMultiSelect = [];

        pixMultiSelectBox.each(function () {
            var id = $(this).attr('id'),
                placeholder = $(this).data('placeholder');

            pixMultiSelect[id] = new vanillaSelectBox('#' + id, {
                placeHolder: placeholder,
                search: false
            });
        });
    }
    pixVanillaSelectBox();

    function getSelectValues(id) {
        var result = [],
            collection = document.querySelectorAll("#" + id + " option");
        
        collection.forEach(function (x) {
            if (x.selected) {
                result.push(x.value);
            }
        });
        return result;
    }

    function getSelectTotal(id) {
        var total = 0,
            select = document.getElementById(id),
            collection = document.querySelectorAll("#" + id + " option");
        
        collection.forEach(function (x) {
            if (x.selected) {
                if(total === 0){
                    total = parseFloat(x.dataset.price);
                } else {
                    total = select.dataset.operation === 'multi' ? total * parseFloat(x.dataset.price) : total + parseFloat(x.dataset.price);
                }
            }
        });
        return total;
    }

    function pix_calc_get_total($parent){
        var $total = 0,
            $out = '',
            $decimals = $('.pix-calc-total-price', $parent).attr('data-decimals');
        $('.pix-calc-value', $parent).each(function() {
            var operation = $(this).data('operation');
            if($(this).is('.pix-multi-select')){
                var str = (getSelectValues($(this).attr('id'))).join(','),
                    sum = getSelectTotal($(this).attr('id'));
                if($total === 0){
                    $total = parseFloat(sum);
                } else {
                    $total = operation === 'multi' ? $total * parseFloat(sum) : $total + parseFloat(sum);
                }
                $out = $out + $(this).attr('data-title') + ': ' + str + ' - ' + sum + "\n";
            } else if($(this).is('select') && $(this).find(':selected').attr('value') !== ''){
                if($total === 0){
                    $total = parseFloat($(this).find(':selected').attr('data-price'));
                } else {
                    $total = operation === 'multi' ? $total * parseFloat($(this).find(':selected').attr('data-price')) : $total + parseFloat($(this).find(':selected').attr('data-price'));
                }
                $out = $out + $(this).attr('data-title') + ': ' + $(this).val() + ' - ' + $(this).find(':selected').attr('data-price') + "\n";
            } else {
                if($(this).prop('checked')){
                    if($total === 0){
                        $total = parseFloat($(this).attr('data-price'));
                    } else {
                        $total = operation === 'multi' ? $total * parseFloat($(this).attr('data-price')) : $total + parseFloat($(this).attr('data-price'));
                    }
                    $out = $out + $(this).attr('data-title') + ': ' + $(this).val() + ' - ' + $(this).attr('data-price') + "\n";
                }
            }
        });
        
        if($decimals > 0){
            $total = $total.toFixed($decimals);
        }
        $('.pix-calc-total-price span', $parent).html($total);

        if($('.pix-form-container', $parent).length){
            $out = $out + $total;
            $('.pix-form-container .pix-calculator-data', $parent).html($out);
        }
    }

    $('.pix-calc-value').on('change', function () {
        pix_calc_get_total($(this).closest('.pix-calculator'));
    });

    $('.pix-calc-total-btn button').on('click', function () {
        var $calculator = $(this).closest('.pix-calculator')
        if ( $( '.pix-form-container', $calculator ).first().is( ":hidden" ) ) {
            pix_calc_get_total($calculator);
            $( '.pix-form-container', $calculator ).slideDown( 700 );
        } else {
            $( '.pix-form-container', $calculator ).slideUp( 700 );
        }
    });

    $('.pix-reset a').on('click', function () {
        var $parent = $(this).closest('.pix-calculator-fields'),
            $fields = $(this).closest('.pix-calculator-field');

        $('.pix-calc-value', $fields).each(function() {
            if($(this).is('select')){
                $(this).prop('selectedIndex', 0);
            } else {
                $(this).prop('checked', false);
            }
        });

        pix_calc_get_total($parent);
    });

});