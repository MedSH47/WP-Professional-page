jQuery(document).ready(function($)
{

    $(document).on('click', 'a[href="#"]', function(e){
        e.preventDefault();
    });

    $('.pix-add-field-button').on('click', function() {
        var $container = $(this).parent().find('.pix-content-dynamic');

        $container.append('<div class="pix-content value"><input name="pix-calc-field[title][]" type="text" value="" class="pix-form-control"><div class="pix-input-wrapper"><input name="pix-calc-field[price][]" type="number" step="any" class="pix-form-control" value=""/></div><a href="#" class="pix-delete-value"><i class="far fa-trash-alt"></i></a></div>');
    });

    $(document).on('click', '.pix-delete-value', function() {
        console.log('delete');
        $(this).parent().remove();
    });



});