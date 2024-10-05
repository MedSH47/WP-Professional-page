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
    
    /* ================= Data-hover ================== */
    $('[data-hover]').on('mouseover',function(){
        var color = $(this).attr('data-hover');
        $(this).css('color', color);
    }).on('mouseleave', function(){
        $(this).removeAttr('style');
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

    /* ============== Ion Range Slider =============== */
    $('.pixRangeSlider').ionRangeSlider({
        skin: 'pix'
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