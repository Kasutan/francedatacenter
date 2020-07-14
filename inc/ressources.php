<?php
if ( ! defined( 'ABSPATH' ) ) exit;

//Filtre sur champ ACF url_fichier pour stocker les fichiers dans un répertoire séparé
//https://support.advancedcustomfields.com/forums/topic/change-file-upload-path-for-one-specific-field/
add_filter('acf/upload_prefilter/name=url_fichier', 'fdc_field_name_upload_prefilter');
function fdc_field_name_upload_prefilter($errors) {
  // in this filter we add a WP filter that alters the upload path
  add_filter('upload_dir', 'fdc_field_name_upload_dir');
  return $errors;
}
// second filter
function fdc_field_name_upload_dir($uploads) {
  // here is where we alter the path
  //random string appended for each upload
	$random = substr(str_shuffle('1234567890abcefghijklmnopqrstuvwxyz'), 0, 10);

  $uploads['path'] = $uploads['basedir'].'/ressources'.'/'.$random;
  $uploads['url'] = $uploads['baseurl'].'/ressources'.'/'.$random;
  $uploads['subdir'] = '';
  return $uploads;
}


//TODO afficher métas pertinentes dans les colonnes du BO


function fdc_affiche_ressource($post_id) {
	if(get_post_type($post_id)!=='ressource' || !function_exists('get_field') || !function_exists('fdc_get_picto_inline') || !function_exists('fdc_is_current_user_adherent')) {
		return;
	}
	$titre=get_the_title($post_id);
	$desc=get_the_content($post_id);
	$date=get_the_date('', $post_id);
	$type_ressource=fdc_get_type_ressource($post_id); // pour la couleur et le filtre
	$acces=esc_attr(get_field('acces',$post_id));
	$type_fichier=esc_attr(get_field('type_fichier',$post_id)); // pour le picto et l'url
	$label_lien=esc_html(get_field('label_lien',$post_id)); 
	
	if($type_fichier=='video') {
		$url=esc_url(get_field('url_video',$post_id));
		$attribut_lien=' target="_blank"';
	} else {
		$url=esc_url(get_field('url_fichier',$post_id));
		$attribut_lien=' download';
	}

	$adherent=fdc_is_current_user_adherent();

	printf('<li class="ressource %s">',$type_ressource);
		echo '<div class="pictos">';
			printf('<div class="picto-type">%s</div>',fdc_get_picto_inline($type_fichier));

			if($acces=='privee' && !$adherent) {
				printf('<div class="picto-verrou">%s</div>',fdc_get_picto_inline('verrou-ferme'));
			} else if($acces=='privee' && $adherent) {
				printf('<div class="picto-verrou ouvert">%s</div>',fdc_get_picto_inline('verrou-ouvert'));
			}
		echo '</div>';//fin .pictos
		printf('<div class="texte"><h2 class="titre">%s</h2><div class="desc">%s</div>',$titre, $desc);
			echo '<div class="meta">';
				printf('<div class="date"><span class="picto">%s</span> %s</div>',fdc_get_picto_inline('calendrier'),$date);
				
				if($acces=='privee' && !$adherent) {
					printf('<div class="message-verrouillage"><span class="picto">%s</span> %s</div>',
						fdc_get_picto_inline($type_fichier),
						'Accès réservé aux adhérents'
					);
				} else {
					printf('<a href="%s"%s><span class="picto">%s</span> %s</a>',
						$url,
						$attribut_lien,
						fdc_get_picto_inline($type_fichier),
						$label_lien
					);
				}
			echo '</div>'; //fin .meta

		echo '</div>';//fin .texte
	echo '</li>';

}

function fdc_affiche_filtre_ressources(){
	echo '<nav style="background-color:var(--gris);margin-bottom:50px;padding:30px">filtre ressources ici</nav>';
}