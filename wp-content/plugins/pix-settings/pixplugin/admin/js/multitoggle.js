/**
 * Javascript functions for MultiToggle component
 */

jQuery(document).ready(function ($) {

	'use strict';

	function pix_change_data( field ){
		var data = {},
            select = [],
            input = $('input.pix-hidden-text[name="'+field+'"]'),
            dataJSON = '';

        $('.pix-multitoggle-boxes[data-field="'+field+'"] .pix-switch-button-field').each(function () {
            if($(this).prop('checked')) {
                data[$(this).data('id')] = 'on';
            } else {
                data[$(this).data('id')] = 'off';
            }
        });

        if( $('.pix-multitoggle-boxes[data-field="'+field+'"] .pix-select-option:not(.pix-add-new)').length ){
            $('.pix-multitoggle-boxes[data-field="'+field+'"] .pix-select-option:not(.pix-add-new)').each(function (i) {
                select.push({
                    id : $(this).attr('data-id'),
                    name : $(this).find('span').text(),
                    visible : $(this).find('button.pix-visible').hasClass('visible'),
                    delete : $(this).attr('data-delete')
                });
            });
            //console.log(select);
            data['select'] = select;
            //console.log(data);
        }
        dataJSON = JSON.stringify(data);
		input.val(dataJSON);
		console.log(input.val());
        input.trigger( "change" );

	}

    $('.pix-multitoggle-boxes').each(function () {

        var field = $(this).data('field'),
            input = $(this).find('input.pix-hidden-text'),
            checkbox = $(this).find('.pix-switch-button-field');

        checkbox.on('click', function() {
            pix_change_data(field);
        });

    });

    var pix_update_sel_options_order = function(e, ui) {
        pix_change_data(ui.item.data('field'));
    };
    $('.pix-select-sortable').sortable({
        items: "> div:not(.pix-add-new)",
        placeholder: "ui-state-highlight",
        forcePlaceholderSize: true,
        stop: pix_update_sel_options_order
    }).disableSelection();

    $('.pix-multitoggle-boxes .pix-toggle-btn').on('click', function() {
        var select = $(this).parent().find('.pix-select-sortable-wrapper');
        if( select.hasClass("pix-slide-up") ){
            select.removeClass("pix-slide-up").addClass("pix-slide-down");
        } else {
            select.removeClass("pix-slide-down").addClass("pix-slide-up");
        }
        $(this).toggleClass('open');
    });

    $('.pix-visible').live('click', function() {
        if( $(this).hasClass("visible") ){
            $(this).removeClass("visible");
        } else {
            $(this).addClass("visible");
        }
        pix_change_data($(this).parent().data('field'));
    });

    $('.pix-edit').live('click', function() {
        var name = $(this).parent().find('span').text(),
            id = $(this).parent().data('id');
        $('.pix-add-new').removeClass('hide-fields');
        $('.pix-add-new input').removeClass('pix-error').val(name);
        if( !$('.pix-add-new .pix-save').hasClass('edit') ){
            $('.pix-add-new .pix-save').addClass('edit');
        }
        $('.pix-add-new').data('id', id);
    });

    $('.pix-delete').live('click', function() {
        var field = $(this).parent().data('field');
        $(this).parent().remove();
        pix_change_data(field);
    });

    $('.pix-add').on('click', function() {
        $(this).parent().removeClass('hide-fields');
        $(this).parent().find('input').removeClass('pix-error');
        if( $(this).parent().find('pix-save').hasClass('edit') ){
            $(this).parent().find('pix-save').removeClass('edit');
        }
    });

    $('.pix-cancel').on('click', function() {
        $(this).parent().parent().addClass('hide-fields');
        $(this).parent().find('input').removeClass('pix-error');
        if( $(this).parent().find('pix-save').hasClass('edit') ){
            $(this).parent().find('pix-save').removeClass('edit');
        }
    });

    $('.pix-save:not(.edit)').live('click', function() {
        var name = $(this).parent().find('input');
        if( name.val() != '' ){
            var field = $(this).parent().parent().data('field'),
                name_slug = name.val(),
                name_text = name.val();

            var new_option = '<div class="pix-select-option has-delete" data-field="' + field + '" data-id="' + name_slug + '" data-delete="true" > \
                                    <span>' + name_text + '</span> \
                                    <button class="pix-visible visible" type="button"><i class="far fa-lightbulb"></i></button> \
                                    <button class="pix-edit" type="button"><i class="fas fa-pencil-alt"></i></button> \
                                    <button class="pix-delete" type="button"><i class="far fa-trash-alt"></i></button> \
                                </div>';
            $(this).parent().parent().before(new_option);
            name.val('');
            $(this).parent().parent().addClass('hide-fields');
            pix_change_data(field);
        } else {
            name.addClass('pix-error');
        }

    });

    $('.pix-save.edit').live('click', function() {
        var name = $(this).parent().find('input');
        if( name.val() != '' ){
            var field = $(this).parent().parent().data('field'),
                id = $(this).parent().parent().data('id'),
                name_text = name.val();
            $('div[data-field="'+field+'"][data-id="'+id+'"]').find('span').text(name_text);
            name.val('');
            $(this).parent().parent().addClass('hide-fields');
            pix_change_data(field);
        } else {
            name.addClass('pix-error');
        }

    });

});
