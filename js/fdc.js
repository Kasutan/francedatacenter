(function($) {

	$( document ).ready(function() {
		var width=$(window).width();
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

		/*********Afficher/masquer le volet de connexion **********/
		/*********+ modifier formulaire de connexion **********/
		var voletConnexion=$('#volet-connexion');
		var menu=$('.main-navigation');

		if($(voletConnexion).length>0) {
			var boutonConnexion=$("#ouvrir-connexion");
			$(boutonConnexion).click(function(){
				if($(boutonConnexion).attr('aria-expanded')=="false") {
					$(voletConnexion).slideDown('slow');
					$(voletConnexion).css('display','flex');
					$(voletConnexion).attr('aria-expanded','true');
					$(boutonConnexion).attr('aria-expanded','true');
					$('#user_login').focus();

					$('body,html').animate(
						{scrollTop : 0},
						400,
						function() {
							fermeMenuMobile();
						}
					);
				} else {
					$(voletConnexion).slideUp('slow');
					$(voletConnexion).attr('aria-expanded','false');
					$(boutonConnexion).attr('aria-expanded','false');
				}

			});
			$('#fermer-connexion').click(function(){
				$(voletConnexion).slideUp('slow');
				$(voletConnexion).attr('aria-expanded','false');
				$(boutonConnexion).attr('aria-expanded','false');
			});
			$('#volet-connexion #user_login').attr('placeholder','login');
			$('#volet-connexion #user_pass').attr('placeholder','mot de passe');
			$('#volet-connexion #wp-submit').attr('value','OK');
		}

		function fermeMenuMobile(){
			if($(menu).hasClass('toggled')) {
				$(menu).removeClass('toggled');
				$(menu).attr('aria-expanded',false);
				$('.menu-toggle').attr('aria-expanded',false);
			}
		}
		
		/*********Afficher/masquer le volet de recherche **********/
		var voletRecherche=$('#volet-recherche');
		if($(voletRecherche).length>0) {
			var boutonRecherche=$("#ouvrir-recherche");
			$(boutonRecherche).click(function(){
				if($(boutonRecherche).attr('aria-expanded')=="false") {
					$(voletRecherche).fadeIn('slow');
					$(voletRecherche).css('display','flex');
					$(voletRecherche).attr('aria-expanded','true');
					$(boutonRecherche).attr('aria-expanded','true');
					$('#volet-recherche .search-field').focus();

					$('body,html').animate(
						{scrollTop : 0},
						400,
						function() {
							fermeMenuMobile();
						}
					);
					
				} else {
					$(voletRecherche).fadeOut('slow');
					$(voletRecherche).attr('aria-expanded','false');
					$(boutonRecherche).attr('aria-expanded','false');
				}

			});
			$('#fermer-recherche').click(function(){
				$(voletRecherche).fadeOut('slow');
				$(voletRecherche).attr('aria-expanded','false');
				$(boutonRecherche).attr('aria-expanded','false');
			});
		}
		
		/********* Ouvrir-fermer les sous-menus mobile **********/
		var ouvrirSousMenu=$('.ouvrir-sous-menu, .menu-item-has-children > a');
		if(width<960 && ouvrirSousMenu.length>0) {
			ouvrirSousMenu.click(function(e) {
				e.preventDefault();
				$(this).siblings('.sub-menu').animate(
					{right:0},
					400
				);
			});
			$('.fermer-sous-menu').click(function(){
				$(this).parents('.sub-menu').animate(
					{right:-1*width},
					400
				);
			});
		}
		/********* Desktop : neutraliser clic pour lien de menu parent **********/
		var liensParents=$('.volet-navigation .menu-item-has-children > a');
		if(width>=960 && liensParents.length>0) {
			liensParents.click(function(e) {
				e.preventDefault();
				$(this).blur();
			})
		}


		/****************** Sticky header *************************/	
		var siteHeader=$('.site-header');
		var pageHeaderImg=$('.entry-header .image');
		var siteContent=$('.site-main');
		var mainNavigation=$('.main-navigation');
		var headerTop=0;
		var headerBottom=0;
		updateHeaderPosition();


		$(window).scroll(function () { // scroll event
			var windowTop = $(window).scrollTop(); // returns number
			var windowBottom=window.innerHeight+windowTop;
			if (windowTop > headerTop && ($(voletConnexion).length==0 || $(voletConnexion).attr('aria-expanded')!="true")) {
				siteContent.css('margin-top',siteHeader.outerHeight());
				siteHeader.addClass('sticky');
				mainNavigation.addClass('sticky');
				var parallax=windowTop*0.2;
				if(parallax <= 40) {
					$(pageHeaderImg).css({'transform':'translateY(-'+parallax+'px)'});
				}
			} else {
				siteContent.css('margin-top',0);
				siteHeader.removeClass('sticky');
				mainNavigation.removeClass('sticky');
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
			var montrerAdherents=$('.js-afficher-plus');
			if(montrerAdherents.length>0) {
				montrerAdherents.each(function( index ) {
					var img=$(this).find('img');
					$(img).attr('src',$(this).attr('data-src'));
					$(this).css('display','flex');
					$(this).animate({opacity:1},1000);
				});
				$(montrerAdherents[0]).find('a').focus();
				$(this).hide();
			}
		});

		/****************** Filtre agenda et ressources et adhérents*************************/	
		if($("#filtre-liste").length>0) {
			var boutonPlus=("#afficher-plus");
			var increment=1000; // au cas où il n'y aurait pas de bouton plus avec data-increment stocké
			if($(boutonPlus).length >0) {
				increment=parseInt($(boutonPlus).attr('data-increment'));
			}
			var resultats=('.list');

			/*Actions supplémentaires si liste d'adhérents*/
			var listeAdherents=$(resultats).hasClass('adherents');
			if(listeAdherents) {
				//au chargement de la page, tous les adhérents sont affichés (le filtre n'a pas encore été activé) -> montrer l'input "Tous" comme étant coché
				$('#tous').prop( "checked", true );
			}

			var listeFiltrable = new List('liste-filtrable', {
				valueNames: ['type'],
				page: increment,
				pagination: true
			});
			$('#filtre-liste').change(function(){
				//quand on clique sur une option
				$(resultats).animate(
					{opacity:0},
					400,
					'linear',
					function(){
						//callback de l'animation
						//on récupère le type sélectionné
						var selectedValue=$("#filtre-liste input:checked").val();
						//console.log(selectedValue);

						if(selectedValue=='tous') {
							//on réinitialise le filtre
							listeFiltrable.filter();
							//on affiche les adhérents récents
							if(listeAdherents) {
								$('.recents').fadeIn();
							}
						} else {
							//on filtre la liste pour ne garder que les éléments dont le type est sélectionné
							listeFiltrable.filter(function(item) {
								return (item.values().type.indexOf(selectedValue)>=0);
							});

							//on masque les adhérents récents
							if(listeAdherents) {
								$('.recents').slideUp();
							}
						}
						

						if($(boutonPlus).length >0) {
							actualiseBouton();
						}
						
						//la nouvelle liste est prête, nouvelle animation pour réafficher
						$(resultats).animate(
							{opacity:1}, 1000, 'linear'	
						);
					}
				);
				
			});
			$(boutonPlus).click(function(){
				//calcul du nouveau nombre d'évènements à afficher
				var affiche=parseInt($(this).attr('data-affiche'));
				var next=affiche + increment;
				var mettreFocus=affiche+1;

				$(resultats).animate(
					{opacity:0},
					400,
					'linear',
					function(){
						//callback de la première animation
						//on applique à la liste
						listeFiltrable.show(0,next);
						actualiseBouton();

						//on met le focus sur le lien à l'intérieur du premier élément nouvellement affiché
						$('.list li:nth-of-type('+mettreFocus+') a').focus();
						
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

		/*********Afficher/masquer les filtres ressources et adhérents **********/
		var toggleFiltre=$('#toggle-filtre');
		if($(toggleFiltre).length>0) {
			if(width>=768) {
				toggleFiltre.hide();
				$('.ressources #filtre-liste, .adherents .filtre-wrap, .filtre-wrap .titre-filtre').show();
				$('#filtre-liste').removeAttr('aria-expanded');
			} else {
				$('.ressources #filtre-liste, .adherents .filtre-wrap, .filtre-wrap .titre-filtre').hide();
				toggleFiltre.click(function(){
					if(toggleFiltre.hasClass('ouvert')) {
						$('.ressources #filtre-liste, .adherents .filtre-wrap').slideUp('slow');
						$('#filtre-liste').attr('aria-expanded','false');
						$(toggleFiltre).attr('aria-expanded','false');
					} else {
						$('.ressources #filtre-liste, .adherents .filtre-wrap').slideDown('slow');
						$('#filtre-liste').attr('aria-expanded','true');
						$(toggleFiltre).attr('aria-expanded','true');
					}
					toggleFiltre.toggleClass('ouvert');
				});
			}
		}

		/*********Filtrer les ressources si paramètre videos ds l'url **********/
		var url_string = window.location.href;
		var url = new URL(url_string);
		filtreRessources = url.searchParams.get("filtre_ressources");
		if(filtreRessources=="videos" && $('#filtre-liste.filtre-ressources').length>0) {
			$('#filtre-liste input').prop( "checked", false );
			$('#videos').prop( "checked", true );
			$('#filtre-liste').trigger("change");
		}


		/*********Info sur accès ressources dans le bloc Comité éditorial **********/
		var liensPrives=$('.acf-block-comite li.prive a');
		if(liensPrives.length >0) {
			$('.acf-block-comite li.prive .info-access').hide();
			$(liensPrives).click(function (e) { 
				e.preventDefault();
				var target=$(this).attr('href');
				$(target).slideDown();
			});
		}

		/****************** Style titre événements dans bloc Antenne régionale*************************/
		var eveFutur=$('.acf-block-antenne li.futur');
		if(eveFutur.length > 0) {
			$(eveFutur).each(function( index ) {
				$(this).parents('.evenements-wrap').addClass('contient-futur');
			});
		}

		/****************** Ajout décor au premier bloc antenne régionale*************************/
		$('.acf-block-antenne').first().addClass('avec-decor');

		/***********Backtotop en position fixed quand on scrolle vers le haut *******/
		window.onscroll = function(e) {
			if(this.oldScroll > this.scrollY) {
				$('.backtotop').addClass(('js-fixed'));
			} else {
				$('.backtotop').removeClass(('js-fixed'));
			}
			this.oldScroll = this.scrollY;
		}

	}); //fin document ready
})( jQuery );

