( function( $ ) {

        'use strict';

        var PixthemeServicesFilterHandler = function( $scope, $ ) {
            var $element = $scope.find( '.pix-extended-projects-container' ),
                height = $element.height();

            $element.each( function() {
                var container = $(this),
                    servicesContainer = container.find( '.topproducts' ),
                    servicesContainerInner = container.find( '.swiper-wrapper' ),
                    projectCategoriesLinks = container.find( '.pix-project-categories-container' ),
                    projectFilterLinks = container.find( '.pix-project-filter-container' );

                container.on( 'click', '.pix-project-categories-container a', function( e )  {
                    e.preventDefault();

                    var currentQuery = servicesContainer.attr( 'data-query' );
                    var currentTermId = $( this ).attr( 'data-term-id' );
                    var currentTaxonomy = servicesContainer.attr( 'data-taxonomy' );

                    $( this ).parent( 'li' ).siblings().children( 'a' ).removeClass('active');
                    $( this ).siblings().removeClass('active');
                    $( this ).addClass( 'active' );

                    var data = {
                        action: 'add_projects',
                        current: false,
                        max: false,
                        termid: currentTermId,
                        taxonomy: currentTaxonomy,
                        is_swiper: true,
                    };
                    
                    $.post( solutechAjax.url, data, function( response ) {
                        container.css( 'height', height );
                        servicesContainer.addClass( 'loading' );
                        servicesContainerInner.html( response );
                        container.imagesLoaded( function() {
                            container.PixthemeSwiper();
                        });
                        setTimeout( function() {
                            servicesContainer.removeClass( 'loading' );
                            container.removeAttr( 'style' );
                        }, 1000 );
                    });
                });

            });

        };

        $( window ).on( 'elementor/frontend/init', function() {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/pixtheme-services-extended-carousel.default', PixthemeServicesFilterHandler );
        } );
    }

)( jQuery );
