(function($) {

	$( document ).ready(function() {
		//var width=$(window).width();
		/****************** Modaal*************************/
		$('.ouvrir-modaal').modaal();
		$('.fermer-modaal').click(function(){
			$('.ouvrir-modaal').modaal('close');
		});
		$('.video-modaal').modaal({
			type: 'video',
			height:500,
			width:900
		});
		
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



		/****************** Carrousel de logos adhérents *************************/


		$(".acf-block-adherents-slider .owl-carousel").owlCarousel({
			loop:true,
			nav : false,
			dots : false,
			margin : 44,
			autoplay:true,
			autoplayTimeout:2000,
			autoplaySpeed:2000,
			autoplayHoverPause:true,
			responsive : {
				// breakpoint from 0 up
				0 : {
					items:2,
				},
				500 : {
					items : 3,
				},
				740 : {
					items : 4,
				},
				926 : {
					items : 5,
				},
				1120 : {
					items : 6,
				},
				1320 : {
					items : 7,
				},
				1510 : {
					items : 8,
				},
				1702 : {
					items : 9,
				},
				1900 : {
					items : 10,
				}
			},
		});

		/****************** Afficher plus d'adhérents *************************/	
		$('.acf-block-adherents #afficher-plus').click(function(){
			var next=$(this).attr('data-prochain-groupe');
			var last=$(this).attr('data-dernier-groupe');
			var montrerAdherents=$('.adherent[data-groupe="'+next+'"]');
			$(montrerAdherents).each(function( index ) {
				var img=$(this).find('img');
				$(img).attr('src',$(this).attr('data-src'));
				$(this).css('display','flex');
				$(this).animate({opacity:1},1000);
			});
			console.log($(montrerAdherents[0]).find('a'));
			$(montrerAdherents[0]).find('a').focus();
			if(next==last) {
				$(this).hide();
			} else {
				next++;
				$(this).attr('data-prochain-groupe',next);
			}
		});

	}); //fin document ready
})( jQuery );

