( function( $ ) {

        'use strict';

        var PixthemeIsotopeFilterHandler = function( $scope, $ ) {
            var $element = $scope.find( '.widget-projects-isotope' );

            $element.each( function() {
                var $container = $( this ).find( '.projects__container' ),
                    $filter = $( this ).find( '.projects__filter-isotope' );

                $filter.on( 'click', 'a', function( e )  {
                    e.preventDefault();

                    var filterValue = $( this ).attr( 'data-filter' );
                    $( this ).parent().addClass( 'active' ).siblings( '.active' ).removeClass( 'active' );
                    $container.isotope( { filter: filterValue } );
                });

                $container.imagesLoaded().progress( function() {
                    $container.isotope();
                });

            });

        };

        $( window ).on( 'elementor/frontend/init', function() {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/pixtheme-projects.default', PixthemeIsotopeFilterHandler );
        } );
    }

)( jQuery );
