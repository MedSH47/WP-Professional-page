var synevoWoo;

(function($) {

    'use strict';

    var $window = $( window ),
        $body = $( 'body' );

    synevoWoo = {
        init: function() {
            this.initQuickViewButton();
            this.closeQuickViewPopup();
            this.variationsThumbs();
            this.wishlistChangeCount();
            this.compareChangeCount();
        },

        initQuickViewButton: function() {
            var popupProductContainer = $('.popup__product-container');
            $( '.productCard__expand, productCard2__expand, bestseller__expand, productlistItem__expand' ).on( 'click touch touchstart', function( e ) {
                e.preventDefault();
                e.stopPropagation();

                var $button = $( this );

                $button.addClass( 'loading' );
                var productID = $button.data( 'productId' );

                var $popupContent = $body.children( '#' + 'popup__product-quick-view-content-' + productID );

                if ( $popupContent.length < 1 ) {
                    popupProductContainer.html('<div class="productLoading"><div></div></div>');
                    synevoWoo.ajaxQuickViewPopup( productID );
                }

                $( '.pix-quick-view-popup' ).addClass( 'show' );

                $button.removeClass( 'loading' );

            } );
        },

        ajaxQuickViewPopup: function( productID ) {
            var popupProductContainer = $('.popup__product-container');
            var data = {
                action: 'product_quick_view',
                prodid: productID
            };

            $.ajax( {
                url: synevoAjax.url,
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function( response ) {

                    popupProductContainer.html( response );
                    $('.woocommerce-product-gallery').css( 'opacity', 1 );

                    var form_variation = popupProductContainer.find( '.variations_form' );
                    form_variation.each( function() {
                        $( this ).wc_variation_form();
                    });

                    form_variation.trigger( 'check_variations' );
                    form_variation.trigger( 'reset_image' );

                    if ( typeof $.fn.wc_product_gallery !== 'undefined' ) {
                        popupProductContainer.find( '.woocommerce-product-gallery__wrapper' ).each( function () {
                            $( this ).wc_product_gallery();
                        });
                    }

                    var popupGallery = $('.popup__productImg > .swiper-container');

                    if ( popupGallery.length ) {

                        var slider = new Swiper( popupGallery, {
                            slidesPerView: 1,
                            spaceBetween: 0,
                            effeсt: 'fade',
                            fadeEffect : {
                                crossFade: true
                            },
                            navigation: {
                                prevEl: '.arrows__btn-prev',
                                nextEl: '.arrows__btn-next',
                            },
                        });

                        var full_image = popupGallery.find( 'img' ).first();

                        if ( ! full_image ) return;

                        var origFullSrc = full_image.attr('src'),
                            origFullSrcset = full_image.attr('srcset');

                        $( document.body )
                        .on( 'found_variation', 'form.variations_form', function ( event, variation ) {
                            full_image.attr( 'src', variation.image.full_src );

                            if ( variation.image.srcset ) {
                                full_image.attr( 'srcset', variation.image.full_src );
                            }

                            if ( typeof slider != 'undefined' ) {
                                slider.slideTo(0);
                            }
                        })
                        .on( 'reset_image', 'form.variations_form', function ( event ) {
                            full_image.attr( 'src', origFullSrc ).attr( 'srcset', origFullSrcset );

                            if ( typeof slider != 'undefined' ) {
                                slider.slideTo(0);
                            }
                        });

                    }

                    $( document ).trigger( 'synevo_qv_loader_stop' );
                },
            } );
        },

        closeQuickViewPopup: function() {
            $( '.pix-quick-view-popup .popup__closer, .pix-quick-view-popup .popup__close' ).on( 'click touch touchstart', function( e ) {
                e.preventDefault();
                $( this ).parents( '.pix-quick-view-popup' ).removeClass( 'show' );
            });
        },

        variationsThumbs: function() {

            if ( $('.fullprod__image-wrapper .fullprod__gallery').length ) {

                var sliderWrap = $( '.fullprod__image-wrapper .fullprod__gallery' );

                var thumbs = sliderWrap.find('.fullprod__galleryTumbs').children('.swiper-container');
                var images = sliderWrap.find('.fullprod__galleryImages');

                var full_image = sliderWrap.find( '.fullprod__galleryImages img' ).first(),
                    thumb_image = sliderWrap.find( '.fullprod__galleryTumbs img' ).first();

                if ( ! full_image || ! thumb_image ) return;

                var origFullSrc = full_image.attr('src'),
                    origFullSrcset = full_image.attr('srcset'),
                    origThumbSrc = thumb_image.attr('src'),
                    origThumbSrcset = thumb_image.attr('srcset');

                var galleryThumbs = new Swiper( thumbs, {
                    direction: 'vertical',
                    spaceBetween: 10,
                    freeMode: true,
                    grabCursor: true,
                    slidesPerView: 'auto',
                    navigation: {
                        prevEl: '.fullprod__galleryPrev',
                        nextEl: '.fullprod__galleryNext',
                    },
                });

                var galleryImages = new Swiper( images, {
                    spaceBetween: 0,
                    effect: 'fade',
                    fadeEffect : {
                        crossFade: true
                    },
                    paginationClickable: true,
                    thumbs: {
                        swiper: galleryThumbs,
                    },
                });

                var goToFirst = function () {
                    if ( typeof galleryThumbs != 'undefined' && typeof galleryImages != 'undefined' ) {
                        galleryThumbs.slideTo(0);
                        galleryImages.slideTo(0);
                    }
                };

                $( document.body )
                    .on( 'found_variation', 'form.variations_form', function ( event, variation ) {
                            full_image.attr( 'src', variation.image.full_src );
                            thumb_image.attr( 'src', variation.image.thumb_src );

                            if ( variation.image.srcset ) {
                                full_image.attr( 'srcset', variation.image.full_src );
                                thumb_image.attr('srcset', variation.image.thumb_src);
                            }

                            goToFirst();
                    })
                    .on( 'reset_image', 'form.variations_form', function ( event ) {
                        full_image.attr( 'src', origFullSrc ).attr( 'srcset', origFullSrcset );
                        thumb_image.attr( 'src', origThumbSrc ).attr('srcset', origThumbSrcset);

                        goToFirst();
                    });

            }

        },

        wishlistChangeCount: function() {
            $( document.body ).on( 'woosw_change_count', function( event, count ) {
                if ( count == 0 ) {
                    $( '.pix-wishlist-menu-item .badge' ).html( count );
                    $( '.pix-wishlist-menu-item .badge' ).addClass( 'invisible' );
                } else {
                    $( '.pix-wishlist-menu-item .badge' ).html( count );
                    $( '.pix-wishlist-menu-item .badge' ).removeClass( 'invisible' );
                }
            });
        },

        compareChangeCount: function() {
            $( document.body ).on( 'wooscp_change_count', function( event, count ) {
                if ( count == 0 ) {
                    $( '.pix-compare-menu-item .badge' ).html( count );
                    $( '.pix-compare-menu-item .badge' ).addClass( 'invisible' );
                } else {
                    $( '.pix-compare-menu-item .badge' ).html( count );
                    $( '.pix-compare-menu-item .badge' ).removeClass( 'invisible' );
                }
            });
        }

    }

    $(document).ready(function () {
        synevoWoo.init();
    });

}(jQuery));