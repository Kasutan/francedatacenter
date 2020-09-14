<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_agenda_ressources_acf_init' );
function fdc_acf_block_agenda_ressources_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-agenda-ressources',
			'title'           => 'Bloc agenda, ressources et vidéos pour la page d\'accueil',
			'description'     => 'Bloc avec titres, intros, 4 évènements à venir, 4 ressources récemment publiées (hors vidéos), et 3 vidéos à choisir parmi les ressources de type vidéo.',
			'render_callback' => 'fdc_agenda_ressources_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'admin-home',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'agenda', 'ressource','video', 'accueil', 'fdc'],
		] );
	}
}

function fdc_agenda_ressources_callback( $block ) {
	if( !function_exists("get_field") || !function_exists("fdc_get_picto_inline") || !function_exists('fdc_affiche_liste_evenements') || !function_exists('fdc_affiche_liste_ressources_pour_accueil')) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$intro_agenda=wp_kses_post( get_field('intro_agenda') );
	$intro_agenda_2=wp_kses_post( get_field('intro_agenda_2') );
	$image_agenda=esc_attr(get_field('image_agenda'));
	$image_ressources=esc_attr(get_field('image_ressources'));
	$intro_ressources=wp_kses_post( get_field('intro_ressources') );
	$intro_ressources_2=wp_kses_post( get_field('intro_ressources_2') );



	printf('<section class="acf-block-agenda-ressources  alignfull %s">', $className);
		echo '<div class="fond"></div>';
		echo '<div class="agenda">';
				printf('<div class="image">%s<div class="decor"></div><h2 class="titre has-blanc-color">Agenda</h2></div>',	wp_get_attachment_image( $image_agenda , 'medium'));

				echo '<div class="texte">';
					printf('<p class="h2">%s <span>%s</span></p>',$intro_agenda,$intro_agenda_2);
					fdc_affiche_liste_evenements();
					$agenda=fdc_get_page_ID('page_agenda'); 
					if($agenda) :
						printf('<div class="fleche"><a href="%s">Tout l\'agenda %s</a></div>',
							get_the_permalink( $agenda),
							fdc_get_picto_inline('angle')
						);
					endif;
				echo '</div>'; //fin .texte 
		echo '</div>'; //fin .agenda 
		
		echo '<div class="ressources">';
				printf('<div class="image">%s<div class="decor"></div><h2 class="titre has-blanc-color">Ressources</h2></div>',	wp_get_attachment_image( $image_ressources , 'medium'));

				echo '<div class="texte">';
					printf('<p class="h2">%s <span>%s</span></p>',$intro_ressources,$intro_ressources_2);
					fdc_affiche_liste_ressources_pour_accueil();
					$ressources=fdc_get_page_ID('page_ressources'); 
					if($ressources) :
						printf('<div class="fleche"><a href="%s">Toutes les ressources %s</a></div>',
							get_the_permalink( $ressources),
							fdc_get_picto_inline('angle')
						);
					endif;
				echo '</div>'; //fin .texte 
		echo '</div>'; //fin .ressources 

		if( have_rows('videos') ):
			echo '<div class="videos">';
				echo '<h2 class="titre">Vidéos</h2>';
					echo '<ul class="liste-videos">';
					while(have_rows('videos')): the_row();	
						$post_id=esc_attr(get_sub_field('ressource'));
						$url=esc_url(get_field('url_video',$post_id));
						$video_id='';
						if(strpos($url,'youtube.com')>0) {  //on a l'url de visionnage
							$video_id = explode("?v=", $url);
							$video_id = $video_id[1]; //on garde ce qu'il y a après ?v=
							$video_id = explode("&", $video_id)[0]; // on enlève les autres paramètres
						} elseif(strpos($url,'youtu.be')>0) { //on a l'url de partage
							$video_id=explode('youtu.be/',$url)[1]; // on ne garde que ce qu'il y a après le domaine
						}
						
						$image_id=esc_attr(get_sub_field('image'));
						if($image_id) {
							$image_url=wp_get_attachment_url( $image_id );
						} else {
							$image_url="https://img.youtube.com/vi/".$video_id."/maxresdefault.jpg";
						}
						
						printf('<li><a href="https://www.youtube.com/embed/%s" class="video-modaal"><img src="%s" alt="%s" width="385" height="182"/></a>',
							$video_id,
							$image_url,
							get_the_title($post_id),
						);
					endwhile;
					echo '</ul>';
				printf('<div class="fleche bleu"><a href="%s?filtre_ressources=videos">Toutes les vidéos %s</a></div>',
					get_the_permalink( $ressources),
					fdc_get_picto_inline('angle')
				);
			echo '</div>'; //fin .videos 
		endif;
	echo "</section>";
}