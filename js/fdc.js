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
			$(montrerAdherents[0]).find('a').focus();
			if(next==last) {
				$(this).hide();
			} else {
				next++;
				$(this).attr('data-prochain-groupe',next);
			}
		});

		/****************** Filtre agenda et ressources *************************/	
		if($("#filtre-liste").length>0) {
			var boutonPlus=("#afficher-plus");
			var increment=parseInt($(boutonPlus).attr('data-increment'));
			var resultats=('.list');
			var listeFiltrable = new List('liste-filtrable', {
				valueNames: ['type'],
				page: increment,
				pagination: true
			});
			$('#filtre-liste').change(function(){
				//quand on clique sur une checkbox
				$(resultats).animate(
					{opacity:0},
					400,
					'linear',
					function(){
						//callback de l'animation
						var selectedValues=[];
						//on crée un tableau avec tous les types cochés
						$("#filtre-liste input:checked").each(function(i) {
							selectedValues.push($(this).val());
						});
						//on filtre la liste pour ne garder que les éléments dont le type est présent dans la liste
						listeFiltrable.filter(function(item) {
							return (selectedValues.indexOf(item.values().type)>=0);
						});
						actualiseBouton();
						//la nouvelle liste est prête, nouvelle animation pour réafficher
						$(resultats).animate(
							{opacity:1}, 1000, 'linear'	
						);
					}
				);
				
			});
			$(boutonPlus).click(function(){
				//calcul du nouveau nombre d'évènements à afficher
				var next=parseInt($(this).attr('data-affiche')) + increment;

				$(resultats).animate(
					{opacity:0},
					400,
					'linear',
					function(){
						//callback de la première animation
						//on applique à la liste
						listeFiltrable.show(0,next);
						actualiseBouton();
						
						//la nouvelle liste est prête, nouvelle animation pour réafficher
						$(resultats).animate(
							{opacity:1}, 1000, 'linear'	
						);
					}
				);
				
				
			});
			function actualiseBouton() {
				//nbre d'éléments actuellement affichés (tient compte du filtre)
				var affiche=$('.list li').length; 
				$(boutonPlus).attr('data-affiche',affiche); //on stocke cette valeur dans le bouton

				//nombre de pages automatiquement mis à jour par list.js (tient compte du filtre)
				var pages=$('.pagination li').length;
				//s'il y a plus d'une page, c'est qu'il y a encore des éléments à afficher = on montre le bouton - sinon on le cache
				if(pages > 1) {
					$(boutonPlus).show();
				} else {
					$(boutonPlus).hide();
				}
			}
		}

	}); //fin document ready
})( jQuery );

