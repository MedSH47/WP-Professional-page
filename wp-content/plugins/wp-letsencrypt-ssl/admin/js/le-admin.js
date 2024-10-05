(function ($) {
  'use strict';

  $('.le-section-title').click(function () {
    var scn = $(this).attr('data-section');
    $('.le-section-title').removeClass('active');
    $(this).addClass('active');

    localStorage.setItem('le-state', scn);

    $('.le-section.active')
      .fadeOut('fast')
      .removeClass('active')
      .promise()
      .done(function () {
        $('.' + scn)
          .fadeIn('fast')
          .addClass('active');
      });
  });

  //restore last tab
  if (localStorage.getItem('le-state') !== null) {
    var section = localStorage.getItem('le-state');

    $('.le-section-title[data-section=' + section + ']').click();
  }

  // Since 2.5.0
  $('.wple-tooltip').each(function () {
    var $this = $(this);

    tippy('.wple-tooltip:not(.bottom)', {
      //content: $this.attr('data-content'),
      placement: 'top',
      onShow(instance) {
        instance.popper.hidden = instance.reference.dataset.tippy
          ? false
          : true;
        instance.setContent(instance.reference.dataset.tippy);
      },
      //arrow: false
    });

    tippy('.wple-tooltip.bottom', {
      //content: $this.attr('data-content'),
      placement: 'bottom',
      onShow(instance) {
        instance.popper.hidden = instance.reference.dataset.tippy
          ? false
          : true;
        instance.setContent(instance.reference.dataset.tippy);
      },
      //arrow: false
    });
  });

  $('.toggle-debugger').click(function () {
    $(this).find('span').toggleClass('rotate');

    $('.le-debugger').slideToggle('fast');
  });

  //since 4.6.0
  $('#admin-verify-dns').submit(function (e) {
    e.preventDefault();

    var $this = $(this);

    jQuery.ajax({
      method: 'POST',
      url: ajaxurl,
      dataType: 'text',
      data: {
        action: 'wple_admin_dnsverify',
        nc: $('#checkdns').val(),
      },
      beforeSend: function () {
        $('.dns-notvalid').removeClass('active');
        $this.addClass('buttonrotate');
        $this.find('button').attr('disabled', true);
      },
      error: function () {
        $('.dns-notvalid').removeClass('active');
        $this.removeClass('buttonrotate');
        $this.find('button').removeAttr('disabled');
        alert('Something went wrong! Please try again');
      },
      success: function (response) {
        $this.removeClass('buttonrotate');
        $this.find('button').removeAttr('disabled');

        if (response === '1') {
          $this.find('button').text('Verified');
          setTimeout(function () {
            window.location.href = window.location.href + '&wpleauto=dns';
            exit();
          }, 1000);

          // } else if (response !== 'fail') {
          //   alert("Partially verified. Could not verify " + String(response));
        } else {
          $('.dns-notvalid').addClass('active');
        }
      },
    });

    return false;
  });

  //since 4.7.0
  $('#verify-subdns').click(function (e) {
    e.preventDefault();

    var $this = $(this);

    jQuery.ajax({
      method: 'POST',
      url: ajaxurl,
      dataType: 'text',
      data: {
        action: 'wple_admin_dnsverify',
        nc: $this.prev().val(),
      },
      beforeSend: function () {
        $('.dns-notvalid').removeClass('active');
        $this.addClass('buttonrotate');
        $this.attr('disabled', true);
        $('#wple-letsdebug').html('');
      },
      error: function () {
        $('.dns-notvalid').removeClass('active');
        $this.removeClass('buttonrotate');
        $this.removeAttr('disabled');
        alert('Something went wrong! Please try again');
      },
      success: function (response) {
        $this.removeClass('buttonrotate');
        $this.removeAttr('disabled');

        if (response === '1') {
          $this.text('Verified');
          $('#wple-error-popper .wple-error').hide();
          $('#wple-error-popper').fadeIn('fast');
          $('#wple-error-popper .wple-flex img').show();

          setTimeout(function () {
            window.location.href =
              window.location.href + '&subdir=1&wpleauto=dns';
            exit();
          }, 1000);

          // } else if (response !== 'fail') {
          //   alert("Partially verified. Could not verify " + String(response));
        } else {
          if (response.indexOf('ul') >= 0) {
            $('#wple-letsdebug').html(response);
          }

          $('.dns-notvalid').addClass('active');
        }
      },
    });

    return false;
  });

  $('#verify-subhttp').click(function (e) {
    e.preventDefault();

    var $this = $(this);

    jQuery.ajax({
      method: 'POST',
      url: ajaxurl,
      dataType: 'text',
      data: {
        action: 'wple_admin_httpverify',
        nc: $this.prev().val(),
      },
      beforeSend: function () {
        $('.http-notvalid').removeClass('active');
        $this.addClass('buttonrotate');
        $this.attr('disabled', true);
        $('#wple-letsdebug').html('');
      },
      error: function () {
        $('.http-notvalid').removeClass('active');
        $this.removeClass('buttonrotate');
        $this.removeAttr('disabled');
        alert('Something went wrong! Please try again');
      },
      success: function (response) {
        $this.removeClass('buttonrotate');
        $this.removeAttr('disabled');

        if (response == 'empty') {
          alert('HTTP challenges empty. Please use RESET once and try again.');
        } else if (response == 'not_possible') {
          $('.http-notvalid-blocked').addClass('active');
        } else if (response === '1') {
          $this.text('Verified');
          $('#wple-error-popper .wple-error').hide();
          $('#wple-error-popper').fadeIn('fast');
          $('#wple-error-popper .wple-flex img').show();

          setTimeout(function () {
            window.location.href =
              window.location.href + '&subdir=1&wpleauto=http';
            return false;
          }, 1000);
        } else {
          //fail

          if (response.indexOf('ul') >= 0) {
            $('#wple-letsdebug').html(response);
          }

          $('.http-notvalid').addClass('active');
        }
      },
    });

    return false;
  });

  //since 4.7.1
  $('#singledvssl').click(function (e) {
    //e.preventDefault();

    var flag = 0;
    if ($('input.wple_email').val() == '') {
      flag = 1;
      $('#wple-error-popper .wple-error').text('Email address is required');
      $('#wple-error-popper').fadeIn('slow');
    } else if (
      !$('input.wple_agree_le').is(':checked') ||
      !$('input.wple_agree_gws').is(':checked')
    ) {
      flag = 1;
      $('#wple-error-popper .wple-error').text('Agree to TOS required');
      $('#wple-error-popper').fadeIn('slow');
    }

    if (flag == 0) {
      $('#wple-error-popper .wple-error').hide();
      $('#wple-error-popper').fadeIn('fast');
      $('#wple-error-popper .wple-flex img').show();
      //$(this).closest(".le-genform").submit();
    } else {
      setTimeout(function () {
        $('#wple-error-popper').fadeOut(500);
      }, 2000);
      return false;
    }
  });

  

  $('.wple_include_www').change(function () {
    if ($(this).is(':checked')) {
      var $this = $(this);

      $.ajax({
        type: 'GET',
        url: ajaxurl,
        async: true,
        dataType: 'text',
        data: {
          action: 'wple_include_www',
          nc: $('#letsencrypt').attr('value'),
        },
        beforeSend: function () {},
        error: function () {
          alert('Something went wrong. Please re-try..');
        },
        success: function (response) {
          if (response !== '1') {
            $this.removeAttr('checked');

            if (response == 'www') {
              alert(
                'Your www domain is not reachable, so this option cannot be enabled.'
              );
            } else if (response == 'nonwww') {
              alert(
                'Your non-www domain is not reachable, so this option cannot be enabled.'
              );
            } else {
              alert('Authentication failure! Please try again');
            }
          } else {
            $('.wple-www').addClass('active');
          }
        },
      });
    } else {
      $('.wple-www').removeClass('active');
    }
  });

  $('.single-wildcard-switch').change(function () {
    if ($(this).is(':checked')) {
      $('.single-genform').fadeOut('fast');
      $('.wildcard-genform').fadeIn('fast');
      $('.wple-wc').addClass('active');
    } else {
      $('.wildcard-genform').fadeOut('fast');
      $('.single-genform').fadeIn('fast');
      $('.wple-wc').removeClass('active');
    }
  });

  $('.initplan-switch').change(function () {
    if ($(this).is(':checked')) {
      $('.wplepricingcol.proplan').removeClass('hiddenplan');
      $('.wplepricingcol.firewallplan').addClass('hiddenplan');
    } else {
      $('.wplepricingcol.proplan').addClass('hiddenplan');
      $('.wplepricingcol.firewallplan').removeClass('hiddenplan');
    }
  });

  jQuery('.wple-scan').click(function () {
    var $button = $(this);
    $('.wple-frameholder').html('');
    $(this).text('SCANNING').attr('disabled', 'disabled');

    jQuery.ajax({
      method: 'POST',
      url: SCAN.adminajax,
      dataType: 'html',
      data: {
        action: 'wple_start_scanner',
        nc: $button.attr('data-nc'),
      },
      beforeSend: function () {
        $('.mxnossl').remove();
        $('#wple-scanner-iframe').css('height', '510px');

        var frm = document.createElement('iframe');

        frm.src = SCAN.base;
        frm.width = 500;
        frm.height = 500;
        frm.scrolling = 'no';
        document.getElementsByClassName('wple-frameholder')[0].appendChild(frm);
      },
      error: function () {
        alert('Request failed! Please try again.');
        $button.text('SCAN').removeAttr('disabled');
        $('.wple-frameholder').slideUp('fast');
      },
      success: function (response) {
        if (response == 'nossl') {
          $button.text('START THE SCAN').removeAttr('disabled');
          $('#wple-scanner-iframe').fadeOut('fast');
          $('#wple-scanner').after(
            '<div class="mxnossl">Valid SSL Certificate could not be detected on your site! Please install SSL Certificate & force HTTPS before checking for mixed content issues.</div>'
          );
          return false;
        } else {
          $('.wple-scanbar')
            .css('animation', 'none')
            .text('Populating Mixed Content Stats! Please wait...')
            .addClass('complete');

          if (response == 'success') {
            $('.wple-scan').text('COMPLETED');
            $('.wple-scanbar')
              .text('All good! Mixed content issues not found.')
              .addClass('success');
            $('.wple-frameholder').slideUp('fast');
            return false;
          }

          $('#wple-scanner-iframe').fadeOut('fast');
          $('#wple-scanresults').html(response);
          $('.wple-scan').text('COMPLETED');

          $('.wple-tooltip').each(function () {
            var $this = $(this);

            tippy('.wple-tooltip:not(.bottom)', {
              //content: $this.attr('data-content'),
              placement: 'top',
              onShow(instance) {
                instance.popper.hidden = instance.reference.dataset.tippy
                  ? false
                  : true;
                instance.setContent(instance.reference.dataset.tippy);
              },
              //arrow: false
            });
          });
        }
      },
    });
  });

  /**
   * v5.2.6
   */
  // var handler = FS.Checkout.configure({
  //   plugin_id: '5090',
  //   plan_id: '10643',
  //   public_key: 'pk_f6a07c106bf4ef064d9ac4b989e02',
  //   image: 'https://s3-us-west-2.amazonaws.com/freemius/plugins/5090/icons/766cb1e9dfd1b9436c3fb2c489a667ea.png'
  // });

  // $('#upgradetocdn').on('click', function (e) {
  //   handler.open({
  //     name: 'WP Encryption',
  //     licenses: 1,
  //     // You can consume the response for after purchase logic.
  //     purchaseCompleted: function (response) {
  //       // The logic here will be executed immediately after the purchase confirmation.                                // alert(response.user.email);
  //     },
  //     success: function (response) {
  //       // The logic here will be executed after the customer closes the checkout, after a successful purchase.                                // alert(response.user.email);
  //     }
  //   });
  //   e.preventDefault();
  // });

  $('.have-root-ssh').click(function () {
    $(this).siblings().removeClass('active');
    $(this).addClass('active');

    $('.rootssh-check').fadeOut('fast');
    $('.havessh').fadeIn('fast');
  });

  $('.no-root-ssh').click(function () {
    $(this).siblings().removeClass('active');
    $(this).addClass('active');

    $('.rootssh-check').fadeOut('fast');
    $('.nossh').fadeIn('fast');
  });

  $('.check-root-ssh li').click(function () {
    $('.nocp-ssl-validation').show();
  });

  $('#validate-nocp-ssl').click(function () {
    var $this = $(this);

    jQuery.ajax({
      method: 'GET',
      url: ajaxurl,
      dataType: 'text',
      data: {
        action: 'wple_validate_ssl',
      },
      beforeSend: function () {
        $this.find('span').show();
        $('.wple-validate-nossl').hide();
      },
      error: function () {
        $this.find('span').hide();
        alert('Could not validate SSL! Please try later.');
      },
      success: function (response) {
        $this.find('span').hide();

        if (response == 1) {
          var currenthref = window.location.href;
          window.location.href = currenthref + '&success=1';
          return false;
        } else {
          $('.wple-validate-nossl').fadeIn('fast');
        }
      },
    });
  });

  $('.email-certs-switch,.disable-spmode-switch,.force-spmode-switch').change(
    function () {
      var $this = $(this);

      jQuery.ajax({
        method: 'POST',
        url: ajaxurl,
        dataType: 'text',
        data: {
          action: 'wple_email_certs',
          emailcert: $('.email-certs-switch').is(':checked'),
          spmode: $('.disable-spmode-switch').is(':checked'),
          forcespmode: $('.force-spmode-switch').is(':checked'),
          nc: $('.download-certs').attr('data-update'),
        },
        beforeSend: function () {},
        error: function () {
          alert('Failed to save opt! Please try again');
        },
        success: function (response) {
          if (response == 'failed') {
            alert("Couldn't save your settings! Please re-try.");
          } else {
            alert('Settings Saved!');
          }
        },
      });
    }
  );

  $('.wple-did-review,.wple-later-review').click(function (e) {
    var $this = $(this);
    e.preventDefault();

    jQuery.ajax({
      method: 'POST',
      url: ajaxurl,
      dataType: 'text',
      data: {
        action: 'wple_review_notice',
        nc: $this.attr('data-nc'),
        choice: $this.attr('data-action'),
      },
      beforeSend: function () {},
      error: function () {
        alert('Failed to save! Please try again');
      },
      success: function (response) {
        $('.wple-admin-review').fadeOut('slow');
      },
    });
  });

  $('.wple-mx-ignore').click(function (e) {
    var $this = $(this);
    e.preventDefault();

    jQuery.ajax({
      method: 'POST',
      url: ajaxurl,
      dataType: 'text',
      data: {
        action: 'wple_mxerror_ignore',
        remind: $this.hasClass('wple-hire-later'),
      },
      beforeSend: function () {},
      error: function () {
        //alert("Failed to save! Please try again");
      },
      success: function (response) {
        $('.wple-mx-prom').fadeOut('slow');
      },
    });
  });

  function copycert(elem) {
    var element = document.querySelector(elem);
    if (typeof element !== 'undefined') {
      element.select();
      element.setSelectionRange(0, 9999999);
      return document.execCommand('copy');
    } else {
      return false;
    }
  }

  $('.copycert').click(function () {
    var $this = $(this);
    var ftype = $this.attr('data-type');
    var txtarea = $('.crt-content textarea');

    jQuery.ajax({
      method: 'GET',
      url: ajaxurl,
      dataType: 'text',
      data: {
        action: 'wple_getcert_for_copy',
        nc: txtarea.attr('data-nc'),
        gettype: ftype,
      },
      beforeSend: function () {
        txtarea.slideUp('fast');
      },
      error: function () {
        alert('Something went wrong! Please try again');
      },
      success: function (response) {
        txtarea.text(response).slideDown('fast');
        $('.copied-success')
          .fadeIn('fast')
          .delay(2000)
          .promise()
          .done(function () {
            $('.copied-success').fadeOut('fast');
          });
        copycert('.crt-content textarea');
      },
    });
  });

  /** 5.5.0 */
  function colorSwitch($new_score) {
    var $scorebar = $('.wple-scorebar span');

    if ($new_score >= 30 && $new_score <= 70) {
      $scorebar.css('background', '#e2d754');
    } else if ($new_score > 70) {
      $scorebar.css('background', '#67d467');
    } else {
      $scorebar.css('background', '#ff5252');
    }
  }

  $('.wple-setting').click(function () {
    var $this = $(this);
    var $opt = $this.attr('data-opt');
    var $val = 0;

    if ($this.is(':checked')) {
      $val = 1;
    }

    jQuery.ajax({
      method: 'POST',
      url: ajaxurl,
      dataType: 'text',
      data: {
        action: 'wple_update_settings',
        opt: $opt,
        nc: $('.wple-ssl-settings').attr('data-update'),
        val: $val,
      },
      beforeSend: function () {
        $('li.wple-setting-error').fadeOut('fast');
      },
      error: function () {
        alert('Could not update setting! Please try again.');
      },
      success: function (response) {
        var $scorebar = $('.wple-scorebar span');
        var $existing_score = $scorebar.attr('data-width');
        var $new_score;

        if (response == '1') {
          $this.removeAttr('checked');
          $('.wple-setting-error').fadeIn('fast');
          return false;
        } else if (response > 0) {
          $new_score = parseInt($existing_score) + 10;

          $scorebar.animate({
            width: $new_score + '%',
          });

          $scorebar.attr('data-width', $new_score);

          $('li.' + $opt + ' span')
            .removeClass('wple-no')
            .addClass('wple-yes')
            .text('Yes');
          colorSwitch($new_score);

          if ($new_score == 80 && !$('.score-prom').length) {
            $('.wple-scorebar').after(
              "<h3 class='score-prom'>You still have major task pending!</h3>"
            );
          }
        } else if (response < 0) {
          $new_score = parseInt($existing_score) - 10;

          $scorebar.animate({
            width: $new_score + '%',
          });

          $scorebar.attr('data-width', $new_score);

          $('li.' + $opt + ' span')
            .removeClass('wple-yes')
            .addClass('wple-no')
            .text('No');
          colorSwitch($new_score);
        } else if (response == 'htaccessnotwritable') {
          alert(
            '.htaccess file not writable! Please change .htaccess file permission to 644 in order to implement security headers.'
          );
          $this.removeAttr('checked');
          return false;
        } else if (response == 'wpconfignotwritable') {
          alert(
            'wp-config.php file not writable! Please change wp-config file permission to 644 in order to implement HttpOnly cookies.'
          );
          $this.removeAttr('checked');
          return false;
        }

        if ($opt == 'vulnerability_scan') {
          if ($val == 1) {
            $('#wple-vulnerability-scanner').show();
          } else {
            $('#wple-vulnerability-scanner').hide();
          }
        }

        $('.wple-score').text($new_score);
      },
    });
  });

  /** 5.7.14 **/
  $('.wple-backup-skip').click(function (e) {
    var $this = $(this);
    e.preventDefault();

    jQuery.ajax({
      method: 'POST',
      url: ajaxurl,
      dataType: 'text',
      data: {
        action: 'wple_backup_ignore',
      },
      beforeSend: function () {},
      error: function () {
        //alert("Failed to save! Please try again");
      },
      success: function (response) {
        $('.le-powered').fadeOut('slow');
      },
    });
  });

  $("#wple-security-settings input").change(function(){
    var opts = $("#wple-security-settings").serializeArray();
    var nc = $("#wple-security-settings").attr("data-update");

    jQuery.ajax({
      method: 'POST',
      url: ajaxurl,
      dataType: 'text',
      data: {
        action: 'wple_update_security',
        opt: opts,
        nc: nc
      },
      beforeSend: function () {        
      },
      error: function () {
        alert('Could not update setting! Please try again.');
      },
      success: function (response) {
        if(response==0){
          alert('Could not update setting! Please try again.');
        } else {
          console.log(response);
        }
      }
    });

  });
})(jQuery);
