(function($){
    'use strict';

    var time = 200;

    var w = $(window).width();

    var xs = 360,
        sm = 576,
        md = 768,
        lg = 992,
        xl = 1200,
        xx = 1300,
        xy = 1660,
        xz = 1800;

    /* ============== Links [href="#"] =============== */
    $('a[href="#"]').on('click', function(e){
        e.preventDefault();
    });
    /* =============================================== */
    
    $('.btn').each(function(){
        var has_ripple = false,
            button = $(this),
            text = $(this).text(),
            html = $(this).html();
            
        if( $('span', $(this)).hasClass('pix-button-ripple-title') ){
            has_ripple = true;
        }
        if(!has_ripple){
            $(this).html('<span class="pix-button-ripple-title"><span data-text="'+text+'">'+html+'</span></span>');
        }
    });
    
    /* ================== Preloader ================== */
    window.onload = setTimeout(function(){
        $('body').removeClass('loading');
        $('body').removeClass('custom-background');
    }, 400);
    /* =============================================== */
    
    /* ================== Parallax ================== */
    $(window).bind('scroll',function(e){
		parallaxScroll();
	});

	function parallaxScroll(){
		if(w >= xl){
			var scrolled = $(window).scrollTop();
			$('.level1').css('top',(scrolled*.05)+'px');
			$('.level2').css('top',(scrolled*.15)+'px');
			$('.level3').css('top',(scrolled*.30)+'px');
		}
	}
    
    /* ================= Data-hover ================== */
    $('[data-hover]').on('mouseover',function(){
        var color = $(this).attr('data-hover');
        $(this).css('color', color);
    }).on('mouseleave', function(){
        $(this).removeAttr('style');
    });
    /* =============================================== */

	/* =============== Sticky Header ================= */
	if ( $(window).scrollTop() > 0 ){
		$('.header.sticky').addClass('fixed');
	}
	$(window).scroll(function() {
		if ($(window).scrollTop() > 0){
			$('.header.sticky').addClass('fixed');
		} else {
			$('.header.sticky').removeClass('fixed');
		}
	});
	if( $('.header').hasClass('sticky-up') ) {

        var previousScroll = 0,
            headerOrgOffset = $('.header.sticky-up').offset().top;

        $(window).scroll(function () {
            var currentScroll = $(this).scrollTop();
            
            if (currentScroll > headerOrgOffset) {
                if (currentScroll > previousScroll) {
                    $('.header.sticky-up').fadeOut();
                } else {
                    $('.header.sticky-up').fadeIn();
                    $('.header.sticky-up').addClass('fixed');
                }
            } else {
                $('.header.sticky-up').removeClass('fixed');
            }
            previousScroll = currentScroll;
        });
    }
    /* =============================================== */
    
    /* ================= Main menu =================== */
    $('.menu__burger').on('click', function(e){
        e.preventDefault();
        $(this).children('i').toggleClass('pix-icon-menu pix-icon-close')
        $(this).prev('ul').toggleClass('open').on('mouseleave', function(){
            $(this).removeClass('open').find('.open').removeClass('open');
            $(this).next().children('i.pix-icon-close').toggleClass('pix-icon-menu pix-icon-close');
        });

        if($(this).prev('ul').is('.open') == true) {
            $(this).prev('ul').find('.open').removeClass('open');
            $(this).prev('ul').find('.pix-icon-chevron2-left').toggleClass('pix-icon-chevron2-right pix-icon-chevron2-left');
            $(this).prev('ul').find('.pix-icon-chevron2-top').toggleClass('pix-icon-chevron2-bottom pix-icon-chevron2-top');
        }

        if($('.menu__catalog > li > ul').is('.open') == true) {
            $('.menu__catalog > li > a').removeClass('active');
            $('.menu__catalog > li > ul').removeClass('open').children('.active').removeClass('active');
        }
    });

    $(document).on('keyup', function(e) {
        if (e.keyCode == 27) {
            $('.menu__icons > li > a').removeClass('active');
            $('.menu__icons > li > .open').removeClass('open');
            $('.menu .menu__btn > a').removeClass('active').next('ul').removeClass('open').children('.active').removeClass('active');
            $('.menu__burger').children('i.pix-icon-close').toggleClass('pix-icon-menu pix-icon-close')
            $('.menu__burger').prev('ul').removeClass('open');
        }
    });

    $(window).resize(function(){
        $('.menu__burger').children('i.pix-icon-close').toggleClass('pix-icon-menu pix-icon-close');
        $('.menu__burger').blur().parent().find('.open').removeClass('open');
        $('.menu__catalogItemN2Menu').find('.pix-icon-chevron2-top').toggleClass('pix-icon-chevron2-bottom pix-icon-chevron2-top');
        $('.menu__catalogItemN2Menu').find('.open').removeClass('open');
        $('.menu__icons > li > .open').removeClass('open');
        $('.menu__icons > li > a').removeClass('active');

        if ($(window).width() >= xl) {
            $('.menu .pix-icon-chevron2-left').toggleClass('pix-icon-chevron2-right pix-icon-chevron2-left');
            $('.menu .pix-icon-chevron2-top').toggleClass('pix-icon-chevron2-bottom pix-icon-chevron2-top');
        }
    });

    $('.menu li.menu-item-has-children').on('mouseover', function(){
        if ($(window).width() >= xl) {
            $(this).children('ul').addClass('open');
        }
    }).on('mouseleave', function(){
        if ($(window).width() >= xl) {
            $(this).removeClass('open').find('.open').removeClass('open');
        }
    });

    $('.menu li').on('mouseleave', function(){
        $(this).find('.active').removeClass('active')
        $(this).find('.open').removeClass('open');
    });

    $('.menu li.menu-item-has-children > a > span').on('click touchstart touch', function(e){
        var icon = $(this).children('i');
        e.preventDefault();
        if($(window).width() < xl) {
            $(this).parent().next('ul').toggleClass('open');
            if(icon.is('.pix-icon-chevron2-right') || icon.is('.pix-icon-chevron2-left')) {
                $(this).children('i').toggleClass('pix-icon-chevron2-right pix-icon-chevron2-left');
            } else if (icon.is('.pix-icon-chevron2-bottom') || icon.is('.pix-icon-chevron2-top')) {
                $(this).children('i').toggleClass('pix-icon-chevron2-bottom pix-icon-chevron2-top');
            }
        }
    })

    $('.menu .menu__btn > a').on('click', function(e){
        e.preventDefault();
    });

    $('.menu .menu__btn').on('mouseenter', function(){
        $(this).children('a').addClass('active').next('ul').addClass('open');

        if ($(window).width() >= sm) {
            $(this).children('a').next('ul').children('li:first').addClass('active');
        }

        if ($('.menu__burger > i').is('.pix-icon-close') == true) {
            $('.menu__burger > i').toggleClass('pix-icon-menu pix-icon-close').parent().prev('ul').removeClass('open').find('.open').removeClass('open');
        }
    }).on('mouseleave', function() {
        setTimeout(function(){
            $(this).children('a.active').removeClass('active').next('ul.open').removeClass('open').children('.active').removeClass('active');
        }, 400);
    });

    $('.menu .pix-mega-menu').on('mouseenter', function(){
        $(this).children('a').addClass('active').next('ul').addClass('open');

        if ($(window).width() >= sm) {
            $(this).children('a').next('ul').children('li:first').addClass('active');
        }
    }).on('mouseleave', function() {
        setTimeout(function(){
            $(this).children('a.active').removeClass('active').next('ul.open').removeClass('open').children('.active').removeClass('active');
        }, 400);
    });

    $('.menu__catalogItemN1').on('mouseenter', function(){
        if ($(window).width() >= md) {
            $(this).addClass('active').siblings('.active').removeClass('active');
        }
    }).parent().on('mouseleave', function(){
        $(this).removeClass('open').prev().removeClass('active');
        $(this).find('.active').removeClass('active');
        $(this).find('.pix-icon-chevron2-top').toggleClass('pix-icon-chevron2-bottom pix-icon-chevron2-top');
        $(this).find('.open').removeClass('open');
    })

    $('.pix-icon-chevron2-right').on('click', function(e){
        e.preventDefault();
        $(this).parents('.menu__catalogItemN1').toggleClass('active').siblings('.active').removeClass('active');
    });

    $('.menu__catalogSubmenuTitle .pix-icon-chevron2-bottom').on('click', function(e){
        e.preventDefault();
        $(this).toggleClass('pix-icon-chevron2-bottom pix-icon-chevron2-top').parent().next('ul').toggleClass('open');
    });

    $('.menu__icons > li:not(.menu__iconsLink)').hover(function(){
        $(this).children('a').addClass('active');
        $(this).children('a').next().addClass('open');
        $(this).siblings('li').children('.active').removeClass('active');
        $(this).siblings('li').children('.open').removeClass('open');
    }, function(){
        $(this).children('a').removeClass('active');
        $(this).children('a').next().removeClass('open');
    });
    /* =============================================== */
    
    /* ================ Swiper Slider ================ */
    $('.fullprod__upsellsSlider').each(function(index, element){
        $(this).addClass('upsellsSlider'+index);
        $(this).prev().find('.arrows__btn-prev').addClass('upsellsSlider-l'+index);
        $(this).prev().find('.arrows__btn-next').addClass('upsellsSlider-r'+index);
        var slider = new Swiper('.upsellsSlider'+index, {
            slidesPerView: 1,
            spaceBetween: 30,
            navigation: {
                prevEl: '.upsellsSlider-l'+index,
                nextEl: '.upsellsSlider-r'+index,
            },
            breakpoints: {
                [md]: {
                    slidesPerView: 1,
                },
                [lg]: {
                    slidesPerView: 2,
                },
                [xl]: {
                    slidesPerView: 3,
                },
                [xy]: {
                    slidesPerView: 1,
                }

            }
        });
    });

    $('.relproducts').each(function(index, element){
        $(this).addClass('relproducts'+index);
        $(this).prev().find('.arrows__btn-prev').addClass('relproducts-l'+index);
        $(this).prev().find('.arrows__btn-next').addClass('relproducts-r'+index);
        var slider = new Swiper('.relproducts'+index, {
            slidesPerView: 1,
            spaceBetween: 30,
            navigation: {
                prevEl: '.relproducts-l'+index,
                nextEl: '.relproducts-r'+index,
            },
            breakpoints: {
                [md]: {
                    slidesPerView: 1,
                },
                [lg]: {
                    slidesPerView: 2,
                },
                [xl]: {
                    slidesPerView: 3,
                },
                [xx]: {
                    slidesPerView: 4,
                }
            }
        });
    });
    /* =============================================== */
    
    /* ================ Video Pop-up ================= */
    $('[data-fancybox]').fancybox({
        youtube : {
            controls : 1,
            showinfo : 0
        },
        vimeo : {
            color : '39f'
        }
    });
    /* =============================================== */
    
    /* =============== Widget Toggler ================ */
    $('.widget__toggler').on('click', function(){
        $(this).children('i').toggleClass('pix-icon-chevron2-top pix-icon-chevron2-bottom');
        $(this).parent().next('.widget__wrap').fadeToggle(time);
    });
    /* =============================================== */
    
    /* =============== Shop Categories =============== */
    $('.shopCat__itemOpen').on('click', function(){
        $(this).toggleClass('minus');
        $(this).next().find('.shopCat__itemOpen').removeClass('minus')
    });
    /* =============================================== */
    
    /* =============== Bestseller Img ================ */
    $('.bestseller__imagesPreview > img').on('touch touchstart mouseover', function(){
        var target = $(this).attr('data-target');
        $(this).addClass('active').siblings('.active').removeClass('active');
        $(target).addClass('active').siblings('.active').removeClass('active');
    });
    /* =============================================== */

    
    /* ================= Portfolio =================== */
    var $projects = $('.projects'),
        $grid = $projects.find('.projects__container'),
        $filter = $projects.find('.projects__filter-isotope');

    $filter.on( 'click', 'a', function(e) {
        e.preventDefault();
        var filterValue = $(this).attr('data-filter');
        $(this).parent().addClass('active').siblings('.active').removeClass('active');
        $grid.isotope({ filter: filterValue });
    });

    if ( $projects.length ) {
        $grid.imagesLoaded().progress( function() {
            $grid.each(function(){
                $(this).isotope();
            });
        });
    }

    /* =============================================== */
    
    /* ================= Google map ================== */
    if($('#map').length) {
        google.maps.event.addDomListener(window, 'load', init);

        function init() {
            var mapOptions = {
                zoom: 12,
                center: new google.maps.LatLng(51.5, 0),
                styles: [{featureType:"landscape",stylers:[{saturation:-100},{lightness:65},{visibility:"on"}]},{featureType:"poi",stylers:[{saturation:-100},{lightness:50},{visibility:"simplified"}]},{featureType:"road.highway",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"road.arterial",stylers:[{saturation:-100},{lightness:30},{visibility:"on"}]},{featureType:"road.local",stylers:[{saturation:-100},{lightness:40},{visibility:"on"}]},{featureType:"transit",stylers:[{saturation:-100},{visibility:"simplified"}]},{featureType:"administrative.province",stylers:[{visibility:"off"}]/**/},{featureType:"administrative.locality",stylers:[{visibility:"off"}]},{featureType:"administrative.neighborhood",stylers:[{visibility:"on"}]/**/},{featureType:"water",elementType:"labels",stylers:[{visibility:"on"},{lightness:-25},{saturation:-100}]},{featureType:"water",elementType:"geometry",stylers:[{hue:"#29cccc"},{lightness:-25},{saturation:-95}]}]
            }

            var mapElement = document.getElementById('map');
            var map = new google.maps.Map(mapElement, mapOptions);
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(51.5, 0),
                map: map,
                title:"My Busines Point"
            });
        }
    }
    /* =============================================== */

})( jQuery );