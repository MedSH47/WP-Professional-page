( function( $ ) {

        'use strict';

        var PixthemeProjectsFilterHandler = function( $scope, $ ) {
            var $element = $scope.find( '.pix-extended-projects-container' ),
                height = $element.height();

            $element.each( function() {
                var container = $(this),
                    projectsContainer = container.find( '.topproducts' ),
                    projectsContainerInner = container.find( '.swiper-wrapper' ),
                    projectCategoriesLinks = container.find( '.pix-project-categories-container' ),
                    projectFilterLinks = container.find( '.pix-project-filter-container' );

                container.on( 'click', '.pix-project-categories-container a', function( e )  {
                    e.preventDefault();

                    var currentQuery = projectsContainer.attr( 'data-query' );
                    var currentTermId = $( this ).attr( 'data-term-id' );
                    var currentTaxonomy = projectsContainer.attr( 'data-taxonomy' );

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
                        projectsContainer.addClass( 'loading' );
                        projectsContainerInner.html( response );
                        container.imagesLoaded( function() {
                            container.PixthemeSwiper();
                        });
                        setTimeout( function() {
                            projectsContainer.removeClass( 'loading' );
                            container.removeAttr( 'style' );
                        }, 1000 );
                    });
                });

            });

        };

        $( window ).on( 'elementor/frontend/init', function() {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/pixtheme-projects-extended-carousel.default', PixthemeProjectsFilterHandler );
        } );
    }

)( jQuery );
