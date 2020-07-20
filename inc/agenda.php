<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function fdc_affiche_evenement($post_id) {
	if(get_post_type($post_id)!=='evenement' || !function_exists('get_field') || !function_exists('fdc_get_picto_inline') || !function_exists('fdc_get_picto_url') || !function_exists('fdc_get_type_evenement')) {
		return;
	}

	/*Récupérer toutes les infos*/
	$titre=get_the_title($post_id);
	$desc=get_the_content($post_id);
	$date_debut=esc_attr(get_field('date_debut',$post_id));
	$date_fin=esc_attr(get_field('date_fin',$post_id));
	$plage_horaire=wp_kses_post(get_field('plage_horaire',$post_id));
	$ville=wp_kses_post(get_field('ville',$post_id));
	$pays=wp_kses_post(get_field('pays',$post_id));
	$label_lien_resa=wp_kses_post(get_field('label_lien_resa',$post_id));
	$lien_resa=esc_url(get_field('lien_resa',$post_id));
	$type_evenement=fdc_get_type_evenement($post_id); //objet Term - utiliser slug (pour le filtre) et name (pour l'affichage)

	/*Préparer les dates*/
	$array_date_debut=explode('-',$date_debut);
	$date_debut=sprintf('<span class="date">%s/%s</span><span class="sep">/</span><span class="annee">%s</span>',$array_date_debut[2],$array_date_debut[1],$array_date_debut[0]);

	$array_date_fin=explode('-',$date_fin);
	$date_fin=sprintf('<span class="date">%s/%s</span><span class="sep">/</span><span class="annee">%s</span>',$array_date_fin[2],$array_date_fin[1],$array_date_fin[0]);

	$annee_courante=date('Y');
	if($array_date_debut[0]>=$annee_courante) {
		$classe_futur='futur';
	} else {
		$classe_futur='';
	}

	/*on commence l'affichage*/
	printf('<li class="evenement %s"><a href="#evenement-%s" class="ouvrir-modaal">',
		$classe_futur,
		$post_id
	);
		if(has_post_thumbnail( $post_id )) {
			printf('<div class="image">%s</div>',get_the_post_thumbnail( $post_id));
		} else {
			printf('<div class="image defaut"><img src="%s" alt="picto calendrier" width="88" height="91"/></div>',fdc_get_picto_url('calendrier-2'));
		}
		fdc_affiche_resume_evenement($date_debut,$date_fin,$titre,$plage_horaire,$type_evenement,$ville,$pays);
		if($type_evenement) { 
			// affiché en desktop en position absolute
			printf('<span class="type-desktop">%s</span>',
				$type_evenement->name
			);
			//pour le filtre uniquement
			printf('<span class="type screen-reader-text">%s</span>',
				$type_evenement->slug
			);
		}
	echo '</a>'; //fin du bloc cliquable
	
	//on prépare la popup
	printf('<div id="evenement-%s" class="popup %s">',$post_id,$classe_futur);
		fdc_affiche_resume_evenement($date_debut,$date_fin,$titre,$plage_horaire,$type_evenement,$ville,$pays);
		if(has_post_thumbnail( $post_id )) {
			printf('<div class="image">%s</div>',get_the_post_thumbnail( $post_id,'medium'));
		} 
		echo '<div class="desc">';
			echo $desc;
			if($lien_resa) {
				echo '<p class="lien">';
				if($label_lien_resa) printf('<strong>%s&nbsp;:</strong>',$label_lien_resa);
				printf('<a href="%s">%s</a>',$lien_resa);
				echo '</p>';
			}
		echo '</div>';
		printf('<button class="fermer-modaal retour" id="retour-liste"><img src="%s" width="52" height="52" alt="Fermer"/><span>Revenir à la liste</span></button>',fdc_get_picto_url('croix'));
	echo '</div>'; //fin .popup

	echo '</li>'; // fin de l'évènement
}

function fdc_affiche_resume_evenement($date_debut,$date_fin,$titre,$plage_horaire,$type_evenement,$ville,$pays) {
	echo '<div class="resume">';
		printf('<div class="dates"><div class="debut">%s</div>',$date_debut);
		if($date_fin) {
			printf('<div class="fleche">%s</div><div class="fin">%s</div>',
				fdc_get_picto_inline('angle-bas'),
				$date_fin
			);
		}
		echo '</div>'; //fin .dates
		echo '<div class="texte">';
			printf('<p class="nom">%s</p>',$titre);
			if($plage_horaire) {
				printf('<span class="horaires">%s %s</span>',
					fdc_get_picto_inline('horloge'),
					$plage_horaire
				);
			}
			if($ville) {
				printf('<span class="lieu">%s %s',
					fdc_get_picto_inline('map-marker'),
					$ville
				);
				if($pays) printf(', %s',$pays);
				echo '</span>';
			}
			if($type_evenement) {
				// affiché en mobile et dans la popup
				printf('<span class="type-mobile">%s %s</span>',
					fdc_get_picto_inline('award'),
					$type_evenement->name
				);
			}
		echo '</div>'; //fin .texte
	echo '</div>'; //fin resume
}