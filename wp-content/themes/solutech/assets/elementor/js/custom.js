(function($) {

    'use strict';

    var $window = $( window ),
        $body = $( 'body' );

    $window.ready(function() {
        goBackButton();
        initSlickSwiper();
        projectsLoadMore();
    });

    function goBackButton() {
        if ( ! $body.hasClass( 'error404' ) ) {
            return;
        }

        goBackButton = $( '#pix-btn-go-back' );

        if ( window.history.length > 1 ) {
            goBackButton.on( 'click', function(e) {
                e.preventDefault();
                window.history.go( -1 );
            });
        } else {
            goBackButton.text( 'go to Home' ).on( 'click', function(e) {
                e.preventDefault();
                location.pathname = '/';
            });
        }
    }

    function initSlickSwiper() {
        $( '.pix-swiper-theme' ).each( function() {
            $( this ).PixthemeSwiper();
        } );
    }

    function projectsLoadMore() {
        $( '.pix-portfolio-loadmore .btn' ).on( 'click', function( e )  {
            e.preventDefault();

            var currentPage = $( this ).attr( 'data-current' );
            var maxPages = $( this ).attr( 'data-max-pages' );
            var currentTermId = $( this ).attr( 'data-termid' );
            var currentTaxonomy = $( this ).attr( 'data-taxonomy' );
            $( this ).hide();
            currentPage++;

            ajaxProjects( currentPage, maxPages, currentTermId, currentTaxonomy );

            if ( maxPages > currentPage ) {
                $( this ).show();
                $( this ).attr( 'data-current', currentPage );
            } else {
                $( this ).parent().remove();
            }
        });
    }

    function ajaxProjects( currentPage, maxPages, currentTermId, currentTaxonomy ) {

        var data = {
            action: 'add_projects',
            current: currentPage,
            max: maxPages,
            termid: currentTermId,
            taxonomy: currentTaxonomy
        };

        $.post( synevoAjax.url, data, function(response) {
            var projectsContainer = $( '.projects__container' );

            projectsContainer.append( response );
            projectsContainer.imagesLoaded( function() {
                projectsContainer.isotope( 'reloadItems' ).isotope( { sortBy: 'original-order' } );
            });
        });

    }

}(jQuery));