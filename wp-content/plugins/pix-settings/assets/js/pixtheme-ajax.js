jQuery(document).ready(function($) 
{

    $('#ajax-department').on( 'change', function (e) {
        e.preventDefault();

        $('.common-appointment-calendar').addClass('ajax-loading');

        var dep = $(this).val();
		var data = {
            action: 'pixcustom',
            nonce: pixcustomAjax.nonce,
			department: dep,
        };

        $.post( pixcustomAjax.url, data, function( response ){
            //console.log('AJAX response : ', response.data);
			$('.common-appointment-calendar').removeClass('ajax-loading');
            var prev_val = $('.booked_calendar_chooser').val();
            $('.booked_calendar_chooser').html(response.data);
            if(prev_val >= 0) {
				$('.booked_calendar_chooser').trigger('change');
			}

        });
    });

});