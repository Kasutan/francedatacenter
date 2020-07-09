<?php
if ( ! defined( 'ABSPATH' ) ) exit;

//filtre sur champ ACF url_fichier pour stocker les fichiers dans un répertoire séparé
// avec un hash pour empêcher de deviner l'url ?
// règle robots.txt pour empêcher l'indexation de ce répertoire


function fdc_affiche_ressource($post_id) {
	if(get_post_type($post_id)!=='ressource' || !function_exists('get_field') || !function_exists('fdc_get_picto_inline') || !function_exists('fdc_is_current_user_adherent')) {
		return;
	}
	$titre=get_the_title($post_id);
	$desc=get_the_content($post_id);
	$date=get_the_date('', $post_id);
	$type_ressource=fdc_get_type_ressource($post_id); // pour la couleur et le filtre
	$access=esc_attr(get_field('access',$post_id));
	$type_ficher=esc_attr(get_field('type_fichier',$post_id)); // pour le picto et l'url
	$label_lien=esc_html(get_field('type_fichier',$post_id)); 
	
	if($type_fichier=='video') {
		$url=esc_url(get_field('url_video',$post_id));
		$forcer_telechargement='';
	} else {
		$url=esc_url(get_field('url_fichier',$post_id));
		$forcer_telechargement=' download';
	}

	$adherent=fdc_is_current_user_adherent();

	printf('<li class="ressource %s">',$type_ressource);
		echo '<div class="pictos">';
			printf('<div class="picto-type">%s</div>',fdc_get_picto_inline($type_fichier));

			if($access=='privee' && !$adherent) {
				printf('<div class="picto-verrou">%s</div>',fdc_get_picto_inline('verrou-ferme'));
			} else if($access=='privee' && $adherent) {
				printf('<div class="picto-verrou">%s</div>',fdc_get_picto_inline('verrou-ouvert'));
			}
		echo '</div>';//fin .pictos
		printf('<div class="texte"><h2 class="titre">%s</h2><div class="desc"></div>',$titre, $desc);
			echo '<div class="meta">';
				printf('<div class="date">%s %s</div>',fdc_get_picto_inline('calendrier'),$date);
				
				if($access=='privee' && !$adherent) {
					printf('<div class="message verrouillage">%s %s</div>',
						fdc_get_picto_inline($type_fichier),
						'Accès réservé aux adhérents'
					);
				} else {
					printf('<a href="%s"%s>%s %s</a>',
						$url,
						$forcer_telechargement,
						fdc_get_picto_inline($type_fichier),
						$label_lien
					);
				}
			echo '</div>'; //fin .meta

		echo '</div>';//fin .texte
	echo '</li>';

}

function fdc_is_current_user_adherent() {
	$current_user=wp_get_current_user()->ID;
	if($current_user==0) { //le visiteur n'est pas connecté
		return false; 
	}
	$date_expiration=get_field('date_expiration','user_'.$current_user);
	$date_actuelle=date('Ymd');

	if($date_actuelle<=$date_expiration) {
		return true;
	} else {
		return false;
	}
}