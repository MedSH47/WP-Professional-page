jQuery(function ($) {

    'use strict';

    var $rtl = false;
	if( $('body').hasClass('rtl') ){
		$rtl = true;
	}

    $(document).ready(function() {
		var $preloader = $('#page-preloader');
		$preloader.delay(350).fadeOut(800);
	});

	$('a[href="#"]').on('click', function(e){
        e.preventDefault();
    });


	// isotope grid
	var $grid3 = $('.service__filter').isotope();

	// Filtering
	$('.service__select a').on('click', function() {
		var filterValue = $(this).attr('data-filter');
		$('.service__select a').removeClass('active');
		$(this).addClass('active');
		$grid3.isotope({ filter: filterValue });
	});


	var $services_grid = $('.grid-services').isotope({
		itemSelector: '.grid-services-item',
		filter: $('.filter-button-menu a.active').data('filter'),
		percentPosition: true,
		masonry: {
			gutter: '.grid-services-gutter',
			columnWidth: '.grid-services-sizer',
		},
		hiddenStyle: {
			opacity: 0
		},
		visibleStyle: {
			opacity: 1
		},
		stagger: 30,
		transitionDuration: '0.5s'
	});

	// Portfolio isotope filtering
	$('.filter-button-menu a').on('click', function() {
		var filterValue = $(this).attr('data-filter');
		$('.filter-button-menu a').removeClass('active');
		$(".grid-services-item").removeClass("animated");
		$(".grid-services-item").removeClass("fadeInUp");
		$(this).addClass('active');
		$services_grid.isotope({ filter: filterValue });
	});



	$('.blog-masonry').masonry({
		itemSelector: '.blog-masonry-item', // use a separate class for itemSelector, other than .col-
		columnWidth: '.blog-masonry-item',
		percentPosition: true
	});








	// Menu
	$( "ul.js-menu li:has(ul.submenu)" ).each(function( index ){
		$(this).addClass('arrow');
	});

	// Add menu
	$('.js-addmenu').on('click',  function() {
		$('.addmenu').fadeToggle(100);
	});



	$('#js-search-container>a').on('click', function(){
		$('.search-container > .input-container').html(pix_js_vars.search_form);
        $('.search-container').addClass('show');
        $('.menu-logo').addClass('hide');
        $('.pix-header nav').addClass('hide');
    });

	$('.pix-search-close').on('click', function(){
		$('.search-container').removeClass('show');
		$('.menu-logo').removeClass('hide');
		$('.pix-header nav').removeClass('hide');
	});
	
	if($(window).width() > 1000){

        if( $('.pix-header.sticky').hasClass('pix-levels') ){
            if ( $(window).scrollTop() > 0 ){
                $('.pix-header.sticky').addClass('fixed');
            }
            $(window).scroll(function() {
                if ($(window).scrollTop() > 0){
                    $('.pix-header.sticky').addClass('fixed');
                } else {
                    $('.pix-header.sticky').removeClass('fixed');
                }
            });
            var classes = $('.pix-header .pix-header-menu').attr('class');
            var style = getComputedStyle(document.body);
            var height = style.getPropertyValue('--pix-header-height').replace ( /[^\d.]/g, '' );
            if ( $(window).scrollTop() > height ){
                $('.pix-header.sticky').addClass('fixed');
                $('.pix-header .pix-header-menu').removeClass().addClass('pix-header-menu');
            }
            $(window).scroll(function() {
                if ($(window).scrollTop() > height){
                    $('.pix-header.sticky').addClass('fixed');
                    $('.pix-header .pix-header-menu').removeClass().addClass('pix-header-menu');
                } else {
                    $('.pix-header.sticky').removeClass('fixed');
                    $('.pix-header .pix-header-menu').removeClass().addClass(classes);
                }
            });
        } else {
            if ( $(window).scrollTop() > 0 ){
                $('.pix-header.sticky').addClass('fixed');
            }
            $(window).scroll(function() {
                if ($(window).scrollTop() > 0){
                    $('.pix-header.sticky').addClass('fixed');
                } else {
                    $('.pix-header.sticky').removeClass('fixed');
                }
            });
        }
    
        // Sticky on Up Scroll
        if( $('.pix-header').hasClass('sticky-up') ) {
    
            var previousScroll = 0,
                headerOrgOffset = $('.pix-header.sticky-up').offset().top;
    
            $(window).scroll(function () {
                var currentScroll = $(this).scrollTop();
                //console.log(currentScroll + " and " + previousScroll + " and " + headerOrgOffset);
                if (currentScroll > headerOrgOffset) {
                    if (currentScroll > previousScroll) {
                        $('.pix-header.sticky-up').fadeOut();
                    } else {
                        $('.pix-header.sticky-up').fadeIn();
                        $('.pix-header.sticky-up').addClass('fixed');
                    }
                } else {
                    $('.pix-header.sticky-up').removeClass('fixed');
                }
                previousScroll = currentScroll;
            });
        }
    
	}

    $('.js-search-toggle').on('click', function(){
        $('.menu-mobile__header .navbar-brand').toggleClass('hide');
        $('.menu-mobile__header .js-mobile-toggle').toggleClass('hide');
        $('.menu-mobile__header .cart-container').toggleClass('hide');
        $('.js-search-toggle').next().toggleClass('show');
        if( $('.js-search-toggle').next().hasClass('show') ){
            $('.js-search-toggle + .search-container > .input-container').html(pix_js_vars.search_form);
            $('.js-search-toggle').removeClass('fa-search').addClass('fa-times-circle');
        } else {
            $('.js-search-toggle').removeClass('fa-times-circle').addClass('fa-search');
        }
    });



    // Mobile menu
    if($(window).width() <= 1000) {

        if ($('.menu-mobile').hasClass('sticky')) {
            if ($(window).scrollTop() > 0) {
                $('.menu-mobile.sticky').addClass('fixed');
            }
            $(window).scroll(function () {
                if ($(window).scrollTop() > 0) {
                    $('.menu-mobile.sticky').addClass('fixed');
                } else {
                    $('.menu-mobile.sticky').removeClass('fixed');
                }
            });
        }

        // Sticky on Up Scroll
        if ($('.menu-mobile').hasClass('sticky-up')) {

            var previousScroll = 0,
                headerOrgOffset = $('.menu-mobile.sticky-up').offset().top;

            $(window).scroll(function () {
                var currentScroll = $(this).scrollTop();
                //console.log(currentScroll + " and " + previousScroll + " and " + headerOrgOffset);
                if (currentScroll > headerOrgOffset) {
                    if (currentScroll > previousScroll) {
                        $('.menu-mobile.sticky-up').fadeOut();
                    } else {
                        $('.menu-mobile.sticky-up').fadeIn();
                        $('.menu-mobile.sticky-up').addClass('fixed');
                    }
                } else {
                    $('.menu-mobile.sticky-up').removeClass('fixed');
                }
                previousScroll = currentScroll;
            });
        }


        $('.js-mobile-toggle').on('click', function () {
            $(".menu-mobile__list").toggle();
            $('body').toggleClass('pix-body-fixed');

            function fadeMenu() {
                $(".menu-mobile__list").toggleClass('show');
            }

            setTimeout(fadeMenu, 1);
        });
        $(".pix-mobile-menu-container ul li a[href*='#']").on('click', function (event) {
            $('.js-mobile-toggle').click();
        });
        $('.pix-mobile-menu-container ul li:not(.js-mobile-menu)').on('click', function (event) {
            event.stopPropagation();
        });
        $('.js-mobile-menu').on('click', function (event) {
            event.stopPropagation();
            $('.mobile-submenu:first', this).slideToggle();
            $(this).toggleClass('purple');
        });
        $(".js-mobile-menu").each(function (index) {
            $(this).append($('<i class="fa fa-angle-down" aria-hidden="true">'));
        });

    }



	$('.news-card-feedback__navigate button.next').on('click', function(){
		$('.news-card-feedback__navigate button.prev').removeClass('disabled');
		var activeBlock = $('.news-card-feedback__user.active');
		if (activeBlock.is(':last-child')) {
			return;
		}
		activeBlock.removeClass('active');
		activeBlock.next().addClass('active');
	});

	$('.news-card-feedback__navigate button.prev').on('click', function(){
		$('.news-card-feedback__navigate button.prev').removeClass('disabled');
		var activeBlock = $('.news-card-feedback__user.active');
		if (activeBlock.is(':first-child')) {
			return;
		}
		activeBlock.removeClass('active');
		activeBlock.prev().addClass('active');
	});






    //init pix-news-slider
    $('.pix-news-slider').owlCarousel({
        rtl:$rtl,
        items: 3,
        margin: 50,
        dots: true,
        loop: true,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            1370: {
                items: 3
            }

        }
    });
    //-------------------------------------------


    //init pix-special-offer-slider
    $('.pix-special-offer-slider').owlCarousel({
        rtl:$rtl,
        items: 2,
        margin: 50,
        dots: true,
        loop: true,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            }

        }
    });
    //-------------------------------------------

    //init isotope
    var $grid = $('.pix-isotope-items').isotope({
        // options
        itemSelector: '.pix-isotope-item',
        stagger: 30,
        transitionDuration: '0.5s',
        stamp: '.pix-sidebar-filter',
        hiddenStyle: {
            opacity: 0,
            transform: 'scale(0.001)'
        },
        visibleStyle: {
            opacity: 1,
            transform: 'scale(1)'
        },
        masonry: {
            columnWidth: '.pix-isotope-item',
		    gutter: '.pix-gutter-sizer'
        },
        percentPosition: true
    });
    $grid.imagesLoaded().progress( function() {
        $grid.isotope('layout');
    });
    //isotope filter
    $('.pix-filter-head ul li a').on( 'click', function(event) {
        event.preventDefault();
        var $isotop_parent = $(this).closest('.pix-isotope');
        $isotop_parent.find('.pix-filter-head ul li').removeClass('active');
        $(this).parent('li').addClass('active');

        var filterValue = $(this).attr('data-filter');
        $isotop_parent.find('.pix-isotope-items').isotope({ filter: filterValue });
    });
    //-------------------------------------------





    //spinner
    var spinnerInput = $('.pix-spinner-input');
    $('.pix-spinner-plus').on('click', function () {
        var val = spinnerInput.val();
        val++;
        spinnerInput.val(val);
    });
    $('.pix-spinner-minus').on('click', function () {
        var val = spinnerInput.val();
        if(val <= 1){
            val = 1;
            spinnerInput.val(val);
        }else{
            val--;
            spinnerInput.val(val);
        }
    });
    spinnerInput.on('change', function () {
        var val = $(this).val();
        if(val <= 1){
            val = 1;
            console.log(val);
            $(this).val(val);
        }
    });
    //------------------------------------------------


    //sidebar categories accordion
    $('.pix-li-btn').on('click', function () {
        if($(this).hasClass('pix-active')){
            $(this).removeClass('pix-active');
            $(this).next('ul').slideUp(250);
            $(this).text('+');
        }else{
            $(this).addClass('pix-active');
            $(this).next('ul').slideDown(250);
            $(this).text('-');
        }
    });
    //------------------------------------------------


    // init pix-gallery-slider
    $('.pix-gallery').each(function(index, el) {
        var $gallery_slider = $('.pix-gallery-slider', this),
            $gallery_filter = $gallery_slider.hasClass('pix-filter'),
            $margin = $gallery_slider.data('gap'),
            $count = $gallery_slider.data('col'),
            $dots = false;
        if ($gallery_slider.data('nav') == 'dots') {
            $dots = true;
        }

        $gallery_slider.owlCarousel({
            rtl:$rtl,
            // items: $count,
            // dots: $dots,
            nav: false,
            loop: true,
            responsive: {
                0: {
                    items: 1,
                    margin: 0
                },
                768: {
                    items: 2,
                    margin: $margin
                },
                1024: {
                    items: $count,
                    margin: $margin
                }
            }
        });

        if($gallery_filter) {
            $('.owl-filter-bar', this).on('click', '.item', function () {

                var $item = $(this);
                var filter = $item.data('owl-filter')

                $item.addClass('pix-active').siblings().removeClass('pix-active');

                $gallery_slider.owlcarousel2_filter(filter);

            });
        }

        $('.pix-gallery-slider-controls .pix-slider-next', this).on('click', function () {
            //console.log('next');
            $gallery_slider.trigger('next.owl.carousel');
        });
        $('.pix-gallery-slider-controls .pix-slider-prev', this).on('click', function () {
            //console.log('prev');
            $gallery_slider.trigger('prev.owl.carousel');
        });
    });
    //------------------------------------------------


    var $carousel = $('[data-owl-options]');
    if ($carousel.length) {
        $carousel.each(function(index, el) {
        	var options = $(this).data('owl-options');
        	options['rtl'] = $rtl;
        	if(options.onTranslate != null)
            	options.onTranslate = eval(options.onTranslate);
            $(this).owlCarousel(options);
        });
    }

    //-------------------------------------------


    var lastWindowWidth = $(window).width();
	function fullWidthSection() {

        var windowWidth = $(window).width();
        var widthContainer = $('.home-template > .container, .portfolio-section  > .container , .page-content  > .container').width() + 30 ;

        var fullWidthMargin = windowWidth - widthContainer;
        var fullWidthMarginHalf = fullWidthMargin / 2;

        $('.wpb_column.pix-col-content-right, .pix-section-title.pix-col-content-right').css('padding-left', fullWidthMarginHalf+15);
        $('.wpb_column.pix-col-content-right, .pix-section-title.pix-col-content-right').css('padding-right', '15px');

        $('.wpb_column.pix-col-content-left, .pix-section-title.pix-col-content-left').css('padding-right', fullWidthMarginHalf+15);
        $('.wpb_column.pix-col-content-left, .pix-section-title.pix-col-content-left').css('padding-left', '15px');

        $('.wpb_column.pix-col-content-center, .pix-section-title.pix-col-content-center').css('padding-right', fullWidthMarginHalf/2);
        $('.wpb_column.pix-col-content-center, .pix-section-title.pix-col-content-center').css('padding-left', fullWidthMarginHalf/2);

		var $this_owl = $('div[data-vc-stretch-content=true] .vc_col-sm-12 .owl-carousel'),
            $container = $this_owl.closest( ".container.pix-width-1300.pix-container-boxed" ),
            $container_parent = $container.parent();

        if(windowWidth <= 575){
            if( $('.blog > .container').hasClass('pix-container-boxed') ){
                $this_owl.css("width", windowWidth-70);
            } else {
                $this_owl.css("width", windowWidth-40);
            }
        } else if( typeof($container) !== 'undefined' && $container_parent.attr('class') !== 'home-template' ) {
            $this_owl.css("width", 1460);
            $this_owl.css("margin-left", 'auto');
            $this_owl.css("margin-right", 'auto');
        } else {
            $this_owl.css("width", windowWidth);
        }
        $this_owl.owlCarousel().trigger('refresh.owl.carousel');


        if ( windowWidth < 576 ) {
            var $mob_owl = $('.owl-carousel.pix-mobile-carousel-off');
            $mob_owl.trigger('destroy.owl.carousel');
            $mob_owl.find('.owl-stage-outer').children(':eq(0)').unwrap();

            $( '.container > .vc_row[class*="pix_shadow_"]' ).each(function( index ){
                console.log($(this).prev().prev().index());
                if($(this).prev().prev().index() !== 0){
                    $(this).prev().prev().addClass('pix-shadow-offset-padding');
                }
            });
        } else if(lastWindowWidth < 576 && windowWidth >= 576 ) {
            var $mob_owl = $('.owl-carousel.pix-mobile-carousel-off');
            $mob_owl.owlCarousel();
        }

        lastWindowWidth = windowWidth;

    }

    fullWidthSection();
    $(window).resize(function() {
       fullWidthSection();
    });


    $(document).ready(function() {
		$('.pix-video-popup').magnificPopup({
			disableOn: 700,
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,

			fixedContentPos: false
		});


	});
    
    
    $(document).ready(function() {
		$('.pix-popup-gallery').magnificPopup({
            delegate: 'a',
			type: 'image',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			gallery:{
                enabled:true
            }
		});
	});



    var pix_video = document.querySelectorAll( ".pix-video.embed" );

    for (var i = 0; i < pix_video.length; i++) {

        if(pix_video[i].dataset.vendor == 'youtube') {

            var source = "https://img.youtube.com/vi/" + pix_video[i].dataset.embed;

            pix_video[i].addEventListener("click", function () {

                var iframe = document.createElement("iframe");

                iframe.setAttribute("frameborder", "0");
                iframe.setAttribute("allowfullscreen", "");
                iframe.setAttribute("src", "https://www.youtube.com/embed/" + this.dataset.embed + "?rel=0&showinfo=0&autoplay=1");

                this.innerHTML = "";
                this.appendChild(iframe);
            });
        } else if(pix_video[i].dataset.vendor == 'vimeo') {

            pix_video[i].addEventListener("click", function () {

                var iframe = document.createElement("iframe");

                iframe.setAttribute("frameborder", "0");
                iframe.setAttribute("allowfullscreen", "");
                iframe.setAttribute("src", "https://player.vimeo.com/video" + this.dataset.embed + "?autoplay=1&autopause=1&title=1&byline=1&portrait=1");

                this.innerHTML = "";
                this.appendChild(iframe);
            });
        }
    };






    /////////////////////////////////////
	//  Chars Start
	/////////////////////////////////////

	function CharsStart() {
		$('.chart').easyPieChart({
            barColor: false,
            trackColor: false,
            scaleColor: false,
            scaleLength: false,
            lineCap: false,
            lineWidth: false,
            size: false,
            animate: 7000,

            onStep: function(from, to, percent) {
                    $(this.el).find('.percent').text(Math.round(percent));
            }
		});
	}

	$('.chart').each(function() {
        CharsStart();
    });
	
	
	$('.plus-ico').click( function() {
		var x = $('.container-timeline').children('.hidden:first');
		$(x).removeClass('hidden');
		if ( !x.next('.hidden').length ) {
			$(this).text('').addClass('inactive');
		}
	});


	$(document).ready(function() {
		// Test for placeholder support
		$.support.placeholder = (function(){
			var i = document.createElement('input');
			return 'placeholder' in i;
		})();

		// Hide labels by default if placeholders are supported
		if($.support.placeholder) {
			$('.form-label').each(function(){
				$(this).addClass('js-hide-label');
			});

			// Code for adding/removing classes here
			$('.form-group').find('input, textarea').on('keyup blur focus', function(e){

				// Cache our selectors
				var $this = $(this),
					$parent = $this.parent().find("label");

					switch(e.type) {
						case 'keyup': {
							 $parent.toggleClass('js-hide-label', $this.val() == '');
						} break;
						case 'blur': {
							if( $this.val() == '' ) {
						        $parent.addClass('js-hide-label');
							} else {
								$parent.removeClass('js-hide-label').addClass('js-unhighlight-label');
							}
						} break;
						case 'focus': {
							if( $this.val() !== '' ) {
								$parent.removeClass('js-unhighlight-label');
							}
						} break;
							default: break;
						}

			});
		}
	});



    function mobile_table_change($table, $table_index){
        $('tr', $table).each(function() {
            var $parent = $(this).parent().prop('tagName');
            $('th, td', $(this)).each(function( index, value ) {
                if( index == $table_index ){
                    $(this).removeClass('pix-hide-mobile');
                    if($parent == 'THEAD' || $parent == 'TFOOT'){
                        $(this).attr('colspan', '2');
                        console.log($(this).attr('colspan'));
                    }
                } else if( index > 0 ) {
                    $(this).addClass('pix-hide-mobile');
                }
            });
        });
    }

	$('.pix-mobile-table-select').on('change', function () {
	    var $table_index = $(this).val(),
            $table = $(this).parent().find('table');

        mobile_table_change($table, $table_index);
    });

    if(screen.width <= 575){
        var $table = $('.pix-compare-table .pix-price-compare-table'),
            $table_index = $('.pix-compare-table .pix-mobile-table-select').val();
        mobile_table_change($table, $table_index);
    }



	// WooCommerce



	// Responsive
	if(screen.width <= 575){
		$('div[class*="vc_custom_"]:has(div.pix-video)').css('padding', '0 !important');
	}


    //fixed footer
    function fixedFooter() {
        var footerHeight = $('.pix-footer').outerHeight();
        $('.pix-wrapper').css('margin-bottom', footerHeight);
    }
    $(window).on('load', function () {
        fixedFooter();

        $(window).on('resize', function () {
            fixedFooter();
        });

    });
    //------------------------------------------------


    //init wow
    new WOW().init();
    //------------------------------------------------

});