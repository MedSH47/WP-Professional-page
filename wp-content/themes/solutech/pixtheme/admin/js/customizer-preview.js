/* customizer preview */

jQuery(function($){

    "use strict";
    var api = wp.customize;
    function hexToRgb(hex) {
        // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
        var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
        hex = hex.replace(shorthandRegex, function(m, r, g, b) {
            return r + r + g + g + b + b;
        });

        var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? parseInt(result[1], 16)+', '+parseInt(result[2], 16)+', '+parseInt(result[3], 16) : null;
    }

    var pix_directions_arr = {
        'to right' : {'-webkit' : 'left', '-o-linear' : 'right', '-moz-linear' : 'right', 'linear' : 'to right'},
        'to left' : {'-webkit' : 'right', '-o-linear' : 'left', '-moz-linear' : 'left', 'linear' : 'to left'},
        'to bottom' : {'-webkit' : 'top', '-o-linear' : 'bottom', '-moz-linear' : 'bottom', 'linear' : 'to bottom'},
        'to top' : {'-webkit' : 'bottom', '-o-linear' : 'top', '-moz-linear' : 'top', 'linear' : 'to top'},
        'to bottom right' : {'-webkit' : 'left top', '-o-linear' : 'bottom right', '-moz-linear' : 'bottom right', 'linear' : 'to bottom right'},
        'to bottom left' : {'-webkit' : 'right top', '-o-linear' : 'bottom left', '-moz-linear' : 'bottom left', 'linear' : 'to bottom left'},
        'to top right' : {'-webkit' : 'left bottom', '-o-linear' : 'top right', '-moz-linear' : 'top right', 'linear' : 'to top right'},
        'to top left' : {'-webkit' : 'right bottom', '-o-linear' : 'top left', '-moz-linear' : 'top left', 'linear' : 'to top left'},
        //'angle' : array('-webkit' : $gradient_angle.'deg', '-o-linear' => $gradient_angle.'deg', '-moz-linear' => $gradient_angle.'deg', 'linear' => $gradient_angle.'deg',),
    };



    /////////////////////////////////////////////////////////////////
    //                  GENERAL SETTINGS                           //
    /////////////////////////////////////////////////////////////////

    api( 'pixtheme_general_settings_logo', function( value ) {
        value.bind( function( to ) {
            var logo = document.getElementsByClassName('pix-header-logo');
            if ( to != '' ) {
                logo[0].setAttribute('src', to);
            } else {
                logo[0].setAttribute('src', pix_customizer_ajax.template+'/images/logo.svg');
            }
        } );
    } );

    api( 'pixtheme_general_settings_logo_height', function( value ) {
        value.bind( function( to ) {
            if ( to > 75 ) {
                $('html').attr('style', '--pix-header-height: '+to+'px');
            }
        } );
    } );

    api( 'pixtheme_general_settings_logo_width', function( value ) {
        value.bind( function( to ) {
            if ( to ) {
                $( 'a.navbar-brand').css('width', to+'px');
            }
        } );
    } );




    /////////////////////////////////////////////////////////////////
    //                    GENERAL COLORS                           //
    /////////////////////////////////////////////////////////////////

    api( 'pixtheme_style_settings_main_color', function( value ) {
        value.bind( function( to ) {
            if ( to != '' ) {
                document.documentElement.style.setProperty('--pix-main-color', to);
            } else {
                document.documentElement.style.setProperty('--pix-main-color', pix_customizer_ajax.main_color);
            }
        } );
    } );

    api( 'pixtheme_style_settings_gradient_color', function( value ) {
        value.bind( function( to ) {
            if ( to != '' ) {
                document.documentElement.style.setProperty('--pix-gradient-color', to);
            } else {
                document.documentElement.style.setProperty('--pix-gradient-color', pix_customizer_ajax.gradient_color);
            }
        } );
    } );

    api( 'pixtheme_gradient_direction', function( value ) {
        value.bind( function( to ) {
            if ( to != '' ) {
                document.documentElement.style.setProperty('--pix-gradient-direction-webkit', pix_directions_arr[to]['-webkit']);
                document.documentElement.style.setProperty('--pix-gradient-direction-o', pix_directions_arr[to]['-o-linear']);
                document.documentElement.style.setProperty('--pix-gradient-direction-moz', pix_directions_arr[to]['-moz-linear']);
                document.documentElement.style.setProperty('--pix-gradient-direction', pix_directions_arr[to]['linear']);
            }
        } );
    } );

    api( 'pixtheme_style_settings_additional_color', function( value ) {
        value.bind( function( to ) {
            if ( to != '' ) {
                document.documentElement.style.setProperty('--pix-additional-color', to);
            } else {
                document.documentElement.style.setProperty('--pix-additional-color', pix_customizer_ajax.add_color);
            }
        } );
    } );

    api( 'pixtheme_style_settings_black_color', function( value ) {
        value.bind( function( to ) {
            if ( to != '' ) {
                document.documentElement.style.setProperty('--pix-black-color', to);
            } else {
                document.documentElement.style.setProperty('--pix-black-color', pix_customizer_ajax.black_color);
            }
        } );
    } );

    api( 'pixtheme_style_theme_tone', function( value ) {
        value.bind( function( to ) {
            if ( to == '' ) {
                $( 'body').removeClass('pix-theme-tone-dark');
            } else {
                $( 'body').addClass('pix-theme-tone-dark');
            }
        } );
    } );




    /////////////////////////////////////////////////////////////////
    //                          DECOR                              //
    /////////////////////////////////////////////////////////////////

    api( 'pixtheme_decor_show', function( value ) {
        value.bind( function( to ) {
            if ( to == '1' ) {
                $('html .sep-element').css('display', 'block');
            } else {
                $('html .sep-element').css('display', 'none');
            }
        } );
    } );

    api( 'pixtheme_decor_img', function( value ) {
        value.bind( function( to ) {
            if ( to != '' ) {
                document.documentElement.style.setProperty('--pix-decor-img', "url('"+to+"')");
            } else {
                document.documentElement.style.setProperty('--pix-decor-img', "url('"+pix_customizer_ajax.template+"/images/decor.svg')");
            }
        } );
    } );

    api( 'pixtheme_decor_width', function( value ) {
        value.bind( function( to ) {
            if ( to != '' ) {
                $('html .sep-element').css('width', to+'px');
            }
        } );
    } );

    api( 'pixtheme_decor_height', function( value ) {
        value.bind( function( to ) {
            if ( to != '' ) {
                $('html .sep-element').css('height', to+'px');
            }
        } );
    } );




    /////////////////////////////////////////////////////////////////
    //                  HEADER GENERAL SETTINGS                    //
    /////////////////////////////////////////////////////////////////

    api( 'pixtheme_header_type', function( value ) {
        value.bind( function( to ) {
            var data = {
                action: 'pix_get_customizer_header',
                nonce: pix_customizer_ajax.nonce,
                header: to
            };
            $.post(pix_customizer_ajax.url, data, function (response) {
                //console.log('AJAX response : ',response.data);
                $('.pix-header').replaceWith(response.data);
            });
        } );
    } );

    api( 'pixtheme_header_layout', function( value ) {
        value.bind( function( to ) {
            if ( to == 'container-fluid' ) {
                $( 'header.pix-header div[class*="container"]').addClass('container-fluid').removeClass('container');
            } else {
                $( 'header.pix-header div[class*="container"]').addClass('container').removeClass('container-fluid');
            }
        } );
    } );

    api( 'pixtheme_header_sticky', function( value ) {
        value.bind( function( to ) {
            if ( to == '' ) {
                $( 'header.pix-header').removeClass('sticky').removeClass('sticky-up');
            } else if ( to == 'sticky' ) {
                $( 'header.pix-header').addClass('sticky').removeClass('sticky-up');
            } else if ( to == 'sticky-up' ) {
                $( 'header.pix-header').addClass('sticky-up').removeClass('sticky');
            }
        } );
    } );

    api( 'pixtheme_header_sticky_width', function( value ) {
        value.bind( function( to ) {
            if ( to == '' ) {
                $( 'header.pix-header').removeClass('boxed');
            } else {
                $( 'header.pix-header').addClass('boxed');
            }
        } );
    } );

    api( 'pixtheme_header_menu_pos', function( value ) {
        value.bind( function( to ) {
            if ( to == '' ) {
                $( 'header.pix-header .pix-main-menu').removeClass('pix-text-center');
                $( 'header.pix-header .pix-header-menu').removeClass('pix-text-center');
            } else {
                $( 'header.pix-header .pix-main-menu').addClass('pix-text-center');
                $( 'header.pix-header .pix-header-menu').addClass('pix-text-center');
            }
        } );
    } );






    /////////////////////////////////////////////////////////////////
    //                       HEADER COLORS                         //
    /////////////////////////////////////////////////////////////////

    api( 'pixtheme_top_bar_background', function( value ) {
        value.bind( function( to ) {
            if ( to == 'white' ) {
                $( 'header.pix-header .pix-top-bar').addClass('white').removeClass('black');
            } else {
                $( 'header.pix-header .pix-top-bar').addClass('black').removeClass('white');
            }
        } );
    } );

    api( 'pixtheme_top_bar_transparent', function( value ) {
        value.bind( function( to ) {
            if ( to < 100 ) {
                $( 'header.pix-header .pix-top-bar').addClass('transparent');
                document.documentElement.style.setProperty('--pix-top-bar-transparent', to/100);
            } else {
                $( 'header.pix-header .pix-top-bar').removeClass('transparent');
            }
        } );
    } );


    api( 'pixtheme_header_background', function( value ) {
        if( value.get() == 'white' ){
            $( 'header.pix-header').addClass('white').removeClass('black');
        } else {
            $( 'header.pix-header').addClass('black').removeClass('white');
        }
        value.bind( function( to ) {
            if ( to == 'white' ) {
                $( 'header.pix-header').addClass('white').removeClass('black');
            } else {
                $( 'header.pix-header').addClass('black').removeClass('white');
            }
        } );
    } );

    api( 'pixtheme_header_transparent', function( value ) {
        value.bind( function( to ) {
            if ( to < 100 ) {
                $( 'header.pix-header').addClass('transparent');
                document.documentElement.style.setProperty('--pix-header-transparent', to/100);
            } else {
                $( 'header.pix-header').removeClass('transparent');
            }
        } );
    } );

    api( 'pixtheme_header_border', function( value ) {
        value.bind( function( to ) {
            if ( to == '0' ) {
                $('header.pix-header, header.pix-header.header-topbar-view .pix-top-bar').css('border-width', '0');
            } else if ( to == 'top' ) {
                $('.pix-header').css('border-bottom-width', '0');
                $('.pix-header:not(.header-topbar-view)').css('border-top-width', '1px');
                $('.pix-header.header-topbar-view .pix-top-bar').css('border-bottom-width', '1px');
            } else if ( to == 'bottom' ) {
                $('header.pix-header, header.pix-header.header-topbar-view .pix-top-bar').css('border-width', '0');
                $('.pix-header').css('border-bottom-width', '1px');
            } else if ( to == 'both' ) {
                $('.pix-header:not(.header-topbar-view)').css('border-width', '1px 0');
                $('.pix-header, .pix-header.header-topbar-view .pix-top-bar').css('border-bottom-width', '1px');
            }
        } );
    } );


    api( 'pixtheme_header_menu_background', function( value ) {
        value.bind( function( to ) {
            console.log(to)
            if ( to == 'white' ) {
                $( 'header.pix-header .pix-header-menu').addClass('white').removeClass('black').removeClass('main-color').removeClass('add-color').removeClass('gradient');
            } else if ( to == 'main-color' ) {
                $( 'header.pix-header .pix-header-menu').addClass('main-color').removeClass('black').removeClass('white').removeClass('add-color').removeClass('gradient');
            } else if ( to == 'add-color' ) {
                $( 'header.pix-header .pix-header-menu').addClass('add-color').removeClass('black').removeClass('white').removeClass('main-color').removeClass('gradient');
            } else if ( to == 'gradient' ) {
                $( 'header.pix-header .pix-header-menu').addClass('gradient').removeClass('black').removeClass('white').removeClass('add-color').removeClass('main-color');
            } else {
                $( 'header.pix-header .pix-header-menu').addClass('black').removeClass('white').removeClass('main-color').removeClass('add-color').removeClass('gradient');
            }
        } );
    } );

    api( 'pixtheme_header_menu_transparent', function( value ) {
        value.bind( function( to ) {
            if ( to < 100 ) {
                $( 'header.pix-header .pix-header-menu').addClass('transparent');
                document.documentElement.style.setProperty('--pix-header-menu-transparent', to/100);
            } else {
                $( 'header.pix-header .pix-header-menu').removeClass('transparent');
            }
        } );
    } );




    /////////////////////////////////////////////////////////////////
    //                    HEADER ELEMENTS                          //
    /////////////////////////////////////////////////////////////////

    api( 'pixtheme_header_bar', function( value ) {
        value.bind( function( to ) {
            if ( to == '1' ) {
                var data = {
                    action: 'pix_get_customizer_topbar',
                    nonce: pix_customizer_ajax.nonce,
                    topbar: to
                };
                $.post(pix_customizer_ajax.url, data, function (response) {
                    //console.log('AJAX response : ',response.data);
                    $('.pix-header').prepend(response.data).addClass('header-topbar-view');
                });
            } else {
                $( 'header.pix-header .pix-top-bar').remove();
                $( 'header.pix-header' ).removeClass('header-topbar-view');
            }
        } );
    } );

    api( 'pixtheme_header_search', function( value ) {
        value.bind( function( to ) {
            if ( to == '1' ) {
                var search = '<a><i class="fas fa-search"></i></a>';
                $('.pix-header .main-menu-elements li.search').html(search);
            } else {
                $( '.pix-header .main-menu-elements li.search').html('');
            }
        } );
    } );

    api( 'pixtheme_header_minicart', function( value ) {
        value.bind( function( to ) {
            if ( to == '1' ) {
                var minicart = '<a href="#">\n' +
                    '               <div class="pix-cart-items">\n' +
                    '                   <i class="fas fa-shopping-basket"></i>\n' +
                    '                   <span class="pix-cart-count">0</span>\n' +
                    '               </div>\n' +
                    '           </a>';
                $('.pix-header .main-menu-elements li.cart').html(minicart);
            } else {
                $( '.pix-header .main-menu-elements li.cart').html('');
            }
        } );
    } );

    api( 'pixtheme_header_socials', function( value ) {
        value.bind( function( to ) {
            if ( to == '1' ) {
                var socials = '<ul class="header-socials">' +
                    '   <li class="header-social-link"><a href="#" target="_blank"><i class="fab fa-facebook-square"></i></a></li>' +
                    '   <li class="header-social-link"><a href="#" target="_blank"><i class="fab fa-twitter-square"></i></a></li>' +
                    '   <li class="header-social-link"><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>' +
                    '</ul>';
                $('.pix-header .header-topbarbox-2').append(socials);
            } else {
                $( '.pix-header .header-topbarbox-2 ul.header-socials').remove();
            }
        } );
    } );



    /////////////////////////////////////////////////////////////////
    //                  HEADER BACKGROUND                          //
    /////////////////////////////////////////////////////////////////

    api( 'pixtheme_tab_bg_image', function( value ) {
        value.bind( function( to ) {
            var header = document.getElementsByClassName('custom-header');
            if ( to != '' ) {
                header[0].style.backgroundImage = "url('"+to+"')";
            } else {
                header[0].style.backgroundImage = "none";
            }
        } );
    } );

    api( 'pixtheme_tab_bg_image_size', function( value ) {
        value.bind( function( to ) {
            var header = document.getElementsByClassName('custom-header');
            if ( to != '' ) {
                header[0].style.backgroundSize = to;
            }
        } );
    } );

    api( 'pixtheme_tab_bg_image_repeat', function( value ) {
        value.bind( function( to ) {
            var header = document.getElementsByClassName('custom-header');
            if ( to != '' ) {
                header[0].style.backgroundRepeat = to;
            }
        } );
    } );

    api( 'pixtheme_tab_bg_image_horizontal_pos', function( value ) {
        value.bind( function( to ) {
            var header = document.getElementsByClassName('custom-header');
            if ( to != '' ) {
                header[0].style.backgroundPositionX = to+'%';
            }
        } );
    } );

    api( 'pixtheme_tab_bg_image_vertical_pos', function( value ) {
        value.bind( function( to ) {
            var header = document.getElementsByClassName('custom-header');
            if ( to != '' ) {
                header[0].style.backgroundPositionY = to+'%';
            }
        } );
    } );

    api( 'pixtheme_tab_bg_image_fixed', function( value ) {
        value.bind( function( to ) {
            var header = document.getElementsByClassName('custom-header');
            if ( to != '' ) {
                header[0].style.backgroundAttachment = 'fixed';
            } else {
                header[0].style.backgroundAttachment = 'unset';
            }
        } );
    } );

    api( 'pixtheme_tab_bg_color', function( value ) {
        value.bind( function( to ) {
            if ( to != '' ) {
                document.documentElement.style.setProperty('--pix-tab-overlay-color', to);
            }
        } );
    } );

    api( 'pixtheme_tab_bg_color_gradient', function( value ) {
        value.bind( function( to ) {
            if ( to != '' ) {
                document.documentElement.style.setProperty('--pix-tab-overlay-gradient', to);
            }
        } );
    } );

    api( 'pixtheme_tab_gradient_direction', function( value ) {
        value.bind( function( to ) {
            if ( to != '' ) {
                document.documentElement.style.setProperty('--pix-tab-gradient-direction-webkit', pix_directions_arr[to]['-webkit']);
                document.documentElement.style.setProperty('--pix-tab-gradient-direction-o', pix_directions_arr[to]['-o-linear']);
                document.documentElement.style.setProperty('--pix-tab-gradient-direction-moz', pix_directions_arr[to]['-moz-linear']);
                document.documentElement.style.setProperty('--pix-tab-gradient-direction', pix_directions_arr[to]['linear']);
            }
        } );
    } );

    api( 'pixtheme_tab_bg_opacity', function( value ) {
        value.bind( function( to ) {
            if ( to != '' ) {
                document.documentElement.style.setProperty('--pix-tab-overlay-opacity', to/100);
            }
        } );
    } );



    /////////////////////////////////////////////////////////////////
    //                  TITLE & BREADCRUMBS                        //
    /////////////////////////////////////////////////////////////////

    api( 'pixtheme_tab_tone', function( value ) {
        if( value.get() != '' ){
            $( '.pix-header-tab-box').addClass('pix-tab-tone-dark').removeClass('text-white-color');
        } else {
            $( '.pix-header-tab-box').addClass('text-white-color').removeClass('pix-tab-tone-dark');
        }
        value.bind( function( to ) {
            if ( to != '' ) {
                $( '.pix-header-tab-box').addClass('pix-tab-tone-dark').removeClass('text-white-color');
            } else {
                $( '.pix-header-tab-box').addClass('text-white-color').removeClass('pix-tab-tone-dark');
            }
        } );
    } );

    api( 'pixtheme_tab_position', function( value ) {
        if( value.get() != 'left_right' && value.get() != 'right_left' ){
            $('.pix-header-breadcrumbs').attr('class', 'pix-header-breadcrumbs').addClass('text-' + value.get());
            $('.pix-header-title').attr('class', 'pix-header-title').addClass('text-' + value.get());
        } else if( value.get() == 'left_right' ) {
            $('.pix-header-breadcrumbs').attr('class', 'pix-header-breadcrumbs').addClass('pull-left');
            $('.pix-header-title').attr('class', 'pix-header-title').addClass('pull-right');
        } else if( value.get() == 'right_left' ) {
            $('.pix-header-breadcrumbs').attr('class', 'pix-header-breadcrumbs').addClass('pull-right');
            $('.pix-header-title').attr('class', 'pix-header-title').addClass('pull-left');
        } else {
            $('.pix-header-breadcrumbs').attr('class', 'pix-header-breadcrumbs');
            $('.pix-header-title').attr('class', 'pix-header-title');
        }
        value.bind( function( to ) {
            if( to != 'left_right' && to != 'right_left' ){
                $('.pix-header-breadcrumbs').attr('class', 'pix-header-breadcrumbs').addClass('text-' + to );
                $('.pix-header-title').attr('class', 'pix-header-title').addClass('text-' + to );
            } else if( to == 'left_right' ) {
                $('.pix-header-title').attr('class', 'pix-header-title').addClass('pull-left');
                $('.pix-header-breadcrumbs').attr('class', 'pix-header-breadcrumbs').addClass('pull-right');
            } else if( to == 'right_left' ) {
                $('.pix-header-title').attr('class', 'pix-header-title').addClass('pull-right');
                $('.pix-header-breadcrumbs').attr('class', 'pix-header-breadcrumbs').addClass('pull-left');
            } else {
                $('.pix-header-breadcrumbs').attr('class', 'pix-header-breadcrumbs');
                $('.pix-header-title').attr('class', 'pix-header-title');
            }
        } );
    } );

    api( 'pixtheme_tab_hide', function( value ) {
        if( value.get() != '' ){
            $('.custom-header .col-md-12').attr('class', 'col-md-12').addClass( value.get() );
        } else {
            $('.custom-header .col-md-12').attr('class', 'col-md-12');
        }
        value.bind( function( to ) {
            if( to != '' ){
                $('.custom-header .col-md-12').attr('class', 'col-md-12').addClass( to );
            } else {
                $('.custom-header .col-md-12').attr('class', 'col-md-12');
            }
        } );
    } );

    api( 'pixtheme_tab_breadcrumbs_v_position', function( value ) {
        var breadcrumbs = $('.pix-header-tab-box .pix-header-breadcrumbs'),
            title = $('.pix-header-tab-box .pix-header-title');
        if( value.get() != '' ){
            $('.pix-header-tab-box .pix-header-breadcrumbs').remove();
            title.before(breadcrumbs);
        } else {
            $('.pix-header-tab-box .pix-header-breadcrumbs').remove();
            title.after(breadcrumbs);
        }
        value.bind( function( to ) {
            if( to != '' ){
                $('.pix-header-tab-box .pix-header-breadcrumbs').remove();
                title.before(breadcrumbs);
            } else {
                $('.pix-header-tab-box .pix-header-breadcrumbs').remove();
                title.after(breadcrumbs);
            }
        } );
    } );

    api( 'pixtheme_tab_breadcrumbs_current', function( value ) {
        var breadcrumbs = $('.pix-breadcrumbs-path').html(),
            title = $('.pix-header-title h1').text();
        if( value.get() == '1' ){
            $('.pix-breadcrumbs-path').append('&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;' + title);
        } else {
            $('.pix-breadcrumbs-path').html(breadcrumbs);
        }
        value.bind( function( to ) {
            if( to == '1' ){
                $('.pix-breadcrumbs-path').append('&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;' + title);
            } else {
                $('.pix-breadcrumbs-path').html(breadcrumbs);
            }
        } );
    } );

    api( 'pixtheme_tab_padding_top', function( value ) {
        value.bind( function( to ) {
            $('html div.custom-header').css('padding-top', to+'px');
        } );
    } );

    api( 'pixtheme_tab_padding_bottom', function( value ) {
        value.bind( function( to ) {
            $('html div.custom-header').css('padding-bottom', to+'px');
        } );
    } );

    api( 'pixtheme_tab_margin_bottom', function( value ) {
        value.bind( function( to ) {
            $('html div.custom-header').css('margin-bottom', to+'px');
        } );
    } );

});
