(function( $ ) {
    'use strict';
    
    $.fn.PixthemeSwiper = function( options ) {
        var defaults = {};
        var settings = $.extend( {}, defaults, options );

        var $swiper;

        this.each( function() {
            var $slider = $( this );
            var sliderSettings = $slider.data();
            
            var $sliderContainer = $slider.find( '.swiper-container' ),
                lgSlidesPerView = sliderSettings.lgSlidesPerView ? sliderSettings.lgSlidesPerView : 1,
                mdSlidesPerView = sliderSettings.mdSlidesPerView ? sliderSettings.mdSlidesPerView : lgSlidesPerView,
                smSlidesPerView = sliderSettings.smSlidesPerView ? sliderSettings.smSlidesPerView : mdSlidesPerView,
                lgSlidesPerGroup = sliderSettings.lgSlidesPerGroup ? sliderSettings.lgSlidesPerGroup : 1,
                mdSlidesPerGroup = sliderSettings.mdSlidesPerGroup ? sliderSettings.mdSlidesPerGroup : lgSlidesPerGroup,
                smSlidesPerGroup = sliderSettings.smSlidesPerGroup ? sliderSettings.smSlidesPerGroup : mdSlidesPerGroup,
                lgSlidesPerColumn = sliderSettings.lgSlidesPerColumn ? sliderSettings.lgSlidesPerColumn : 1,
                mdSlidesPerColumn = sliderSettings.mdSlidesPerColumn ? sliderSettings.mdSlidesPerColumn : lgSlidesPerColumn,
                smSlidesPerColumn = sliderSettings.smSlidesPerColumn ? sliderSettings.smSlidesPerColumn : mdSlidesPerColumn,
                lgSpace = sliderSettings.lgSpace ? sliderSettings.lgSpace : 0,
                mdSpace = sliderSettings.mdSpace ? sliderSettings.mdSpace : lgSpace,
                smSpace  = sliderSettings.smSpace ? sliderSettings.smSpace : mdSpace,
                speed  = sliderSettings.speed ? sliderSettings.speed : 1000,
                arrows = sliderSettings.arrows ? true : false,
                dots = sliderSettings.dots ? true : false,
                mdBreakPoint = pixtheme_swiper_options.md ? pixtheme_swiper_options.md : 768,
                lgBreakPoint = pixtheme_swiper_options.lg ? pixtheme_swiper_options.lg : 1025;

            var swiperOptions = $.extend( {}, {
                init: false,
                slidesPerView: smSlidesPerView,
                slidesPerGroup: smSlidesPerGroup,
                slidesPerColumnFill: 'row',
                slidesPerColumn: smSlidesPerColumn,
                spaceBetween: smSpace,
                speed: speed
            }, settings );

            swiperOptions.breakpoints = {};

            swiperOptions.breakpoints[mdBreakPoint] = {
                slidesPerView: mdSlidesPerView,
                slidesPerGroup: mdSlidesPerGroup,
                slidesPerColumn: mdSlidesPerColumn,
                spaceBetween: mdSpace
            };

             swiperOptions.breakpoints[lgBreakPoint] = {
                slidesPerView: lgSlidesPerView,
                slidesPerGroup: lgSlidesPerGroup,
                slidesPerColumn: lgSlidesPerColumn,
                spaceBetween: lgSpace
            };

            if ( sliderSettings.loop ) {
                swiperOptions.loop = true;
            }

            if ( sliderSettings.autoplay ) {
                swiperOptions.autoplay = {
                    delay: sliderSettings.autoplay,
                    disableOnInteraction: false
                };
            }

            if ( sliderSettings.dots ) {
                var $swiperPaginationWrap = $slider.find( '.swiper-pagination-wrap' );
                var $swiperPagination = $( '<div class="swiper-pagination"></div>' );

                $swiperPaginationWrap.html( '' );
                $swiperPaginationWrap.append( $swiperPagination );

                swiperOptions.pagination = {
                    el: $swiperPagination,
                    clickable: true
                };
            }

            if ( sliderSettings.arrows ) {
                var appendArrowsTop = $slider.children('.section__title').find('.arrows');
                var appendArrowsBottom = $slider.find('.slideControl');
                if ( appendArrowsTop.length ) {
                    var $swiperPrev = $( '<div class="arrows__btn-prev"></div>' );
                    var $swiperNext = $( '<div class="arrows__btn-next"></div>' );

                    appendArrowsTop.html( '' );
                    appendArrowsTop.append( $swiperPrev ).append( $swiperNext );
                }
                if ( appendArrowsBottom.length ) {

                    var $swiperPrev = $( '<div class="slideControl__left"><i class="pix-icon-left-arrow"></i></div>' );
                    var $swiperNext = $( '<div class="slideControl__right"><i class="pix-icon-right-arrow"></i></div>' );

                    appendArrowsBottom.html( '' );
                    appendArrowsBottom.append( $swiperPrev ).append( $swiperNext );
                }

                    swiperOptions.navigation = {
                        nextEl: $swiperNext,
                        prevEl: $swiperPrev
                    };
            }

            $swiper = new Swiper( $sliderContainer, swiperOptions );

            $swiper.init();

            //Disabled auto play when focus.
            if ( sliderSettings.pauseOnHover && sliderSettings.autoplay ) {
                $sliderContainer.hover( function() {
                    $swiper.autoplay.stop();
                }, function() {
                    $swiper.autoplay.start();
                } );
            }

            $( document ).trigger( 'PixthemeSwiperInit', [ $swiper, $slider, swiperOptions ] );
        } );

        return $swiper;
    };
}( jQuery ));
