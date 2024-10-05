( function($) {

        'use strict';

        var w = $( window ).width();

        var PixthemeSwiperHandler = function( $scope, $ ) {
            var $element = $scope.find( '.pix-swiper-widget' );

            $element.PixthemeSwiper();
        };

        var PixthemeSwiperHcardsHandler = function( $scope, $ ) {
            var $element = $scope.find( '.pix-swiper-widget' );

            $element.PixthemeSwiper();
            $element.find( '.lastchanceProducts' ).on( 'breakpoint', function( event, swiper, breakpoint ) {
                $( this ).find( '.productCard2__slider' ).each( function () {
                    var imgBox = $( this ).children( '.productCard2__images' ),
                        hoverBox = imgBox.children( '.productCard2__hover' ),
                        hoverDots = imgBox.next( '.productCard2__dots' ),
                        countImg = imgBox.children( 'span' ).length;

                    hoverBox.children().on( 'touch touchstart mouseover', function () {
                        var index = $( this ).index();
                        imgBox.children().eq( index ).addClass( 'active' ).siblings().removeClass( 'active' );
                        hoverDots.children().eq( index ).addClass( 'active' ).siblings().removeClass( 'active' );
                    });

                    hoverDots.children().on( 'touch touchstart mouseover', function () {
                        var index = $( this ).index();
                        imgBox.children().eq( index).addClass( 'active' ).siblings().removeClass( 'active' );
                        hoverDots.children().eq( index ).addClass( 'active' ).siblings().removeClass( 'active' );
                    });

                    if ( w <= 768 ) {
                        imgBox.on( 'click touch touchstart', function( e ) {
                            e.preventDefault();
                        });
                    }
                });
            });
        };

        $( window ).on( 'elementor/frontend/init', function() {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/pixtheme-logos-carousel.default', PixthemeSwiperHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/pixtheme-items-carousel.default', PixthemeSwiperHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/pixtheme-product-categories-carousel.default', PixthemeSwiperHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/pixtheme-posts-carousel.default', PixthemeSwiperHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/pixtheme-products-extended-carousel.default', PixthemeSwiperHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/pixtheme-products-vcard-carousel.default', PixthemeSwiperHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/pixtheme-products-hcard-carousel.default', PixthemeSwiperHcardsHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/pixtheme-products-double-block-carousel.default', PixthemeSwiperHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/pixtheme-projects-extended-carousel.default', PixthemeSwiperHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/pixtheme-services-extended-carousel.default', PixthemeSwiperHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/pixtheme-items-extended-carousel.default', PixthemeSwiperHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/pixtheme-team-double-block-carousel.default', PixthemeSwiperHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/pixtheme-testimonials-carousel.default', PixthemeSwiperHandler );
            elementorFrontend.hooks.addAction( 'frontend/element_ready/pixtheme-team-carousel.default', PixthemeSwiperHandler );
        } );

} )( jQuery );
