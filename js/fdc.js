(function($) {

	$( document ).ready(function() {
		//var width=$(window).width();

		/****************** Sticky header *************************/	
		var siteHeader=$('.site-header');
		var siteContent=$('.site-main');
		var mainNavigation=$('.main-navigation');
		var headerTop=0;
		var headerBottom=0;
		updateHeaderPosition();


		$(window).scroll(function () { // scroll event
			var windowTop = $(window).scrollTop(); // returns number
			var windowBottom=window.innerHeight+windowTop;
			if (windowTop > headerTop) {
				siteHeader.addClass('sticky');
				mainNavigation.addClass('sticky');
				siteContent.css('margin-top',siteHeader.outerHeight());
			} else {
				siteHeader.removeClass('sticky');
				mainNavigation.removeClass('sticky');
				siteContent.css('margin-top',0);
			}

		});
		

		//Si on permet au visiteur de masquer la topbar
		//var topbar = $('.topbar');
		//updateHeaderPosition()

		function updateHeaderPosition() {
			headerTop=siteHeader.offset().top;
			headerBottom=headerTop + siteHeader.outerHeight(); // inclut la topbar si elle est présente
			document.documentElement.style.setProperty('--header-bottom', headerBottom); //utile pour positionner le menu mobile
		}



		/****************** Carrousel de logos presse *************************/


		$(".acf-block-presse .owl-carousel").owlCarousel({
			center: true,
			loop:true,
			nav : true,
			dots : false,
			margin : 40,
			autoplay:true,
			autoplayTimeout:2000,
			autoplayHoverPause:true,
			responsive : {
				// breakpoint from 0 up
				0 : {
					items:1,
				},
				// breakpoint from 768px (md) up
				768 : {
					items : 3,
				},
				// breakpoint from 960px  (lg) up
				960 : {
					items : 5,
				},
			},
		});
	});
})( jQuery );

