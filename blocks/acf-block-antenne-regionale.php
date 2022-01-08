<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_antenne_acf_init' );
function fdc_acf_block_antenne_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-antenne',
			'title'           => 'Bloc antenne régionale',
			'description'     => 'Bloc antenne régionale avec nom de la région, descriptif "en bref", référent(s). Affichage dynamique des événements et ressources associés à la région.',
			'render_callback' => 'fdc_antenne_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'location',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'antenne', 'region', 'regionale'],
		] );
	}
}

function fdc_antenne_callback( $block ) {
	if( !function_exists("get_field") || !function_exists("fdc_get_picto_inline")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$antenne=get_field('antenne'); //renvoie object term

	$description=wp_kses_post(get_field('description')); //renvoie texte avec <br>

	$adherent=fdc_is_current_user_adherent(); // Pour l'affichage des documents réservés aux adhérents

	if(!empty($antenne)):
		$term_id=$antenne->term_id;
		printf('<div class="acf-block-antenne %s" id="antenne-%s">', $className,$antenne->slug);
			echo '<div class="fond"></div>';
			printf('<div class="nom-wrap"><h2 class="nom-antenne">%s</h2></div>',$antenne->name);

			echo '<div class="col-1">';


			if($description) {
				echo '<h3 class="titre">En bref</h3><ul class="description">';
				$description=explode('<br />',$description);
				foreach($description as $ligne) {
					printf('<li>%s</li>',$ligne);
				}
				echo '</ul>';
			}

			if(have_rows('referents')) {
				$count=count(get_field('referents'));
				$titre=$count>1 ? 'Référents' : 'Référent';
				printf('<h3 class="titre">%s</h3><ul class="referents">',$titre);
				while(have_rows('referents')): the_row();
					$nom=esc_html(get_sub_field('nom'));
					$fonction=esc_html(get_sub_field('fonction'));
					$societe=esc_html(get_sub_field('societe'));
					$photo=esc_attr(get_sub_field('photo'));
					echo '<li class="referent">';
					if($photo) printf('<div class="photo">%s</div>',wp_get_attachment_image( $photo, 'thumbnail'));

					echo '<div class="texte">';
						if($nom) printf('<p class="nom"><strong>%s</strong></p>',$nom);
						if($fonction) printf('<p>%s</p>',$fonction);
						if($societe) printf('<p>%s</p>',$societe);
					echo '</div></li>';
				endwhile;
				echo '</ul>';
			}

			echo '</div><div class="col-2">';

			//Liste des événements liés à cette région

			$evenements= get_posts(array(
				'post_type' => "evenement",
				'numberposts' => -1,
				'meta_key' => 'date_debut', //on trie les évènements selon leur date
				'orderby' => 'meta_value',
				'order' => 'DESC', //du plus récent (ou futur) au plus loin dans le passé 
				'tax_query' => array(
					array(
						'taxonomy' => 'antenne_regionnale',
						'terms'    => $term_id,
					),
				),
			));

			$nb_passes=0;

			if(!empty($evenements)) {
				echo '<div class="evenements-wrap"><h3 class="titre">Evenements</h3><ul class="evenements">';
				foreach($evenements as $post) {
					$post_id=$post->ID;
					if($nb_passes >= 2) break; //on va du futur vers le passé. Si on a déjà listé 2 événements passés, on sort de la boucle

					$titre_item=get_the_title($post_id);
					$ville=esc_html(get_field('ville',$post_id));

					$date_debut=esc_attr(get_field('date_debut',$post_id));
					$date_fin=esc_attr(get_field('date_fin',$post_id));
					//s'agit-il d'un évènement futur ?
					$classe_futur='';
					if($date_debut > date('Y-m-d')) {
						$classe_futur='futur';
					} else {
						$nb_passes++;
					}

					//préparer format dates
					$array_date_debut=explode('-',$date_debut);
					$date_a_afficher=sprintf('%s/%s/%s',$array_date_debut[2],$array_date_debut[1],$array_date_debut[0]);

					if($date_fin) {
						$array_date_fin=explode('-',$date_fin);
						$date_a_afficher.=sprintf(' > %s/%s/%s',$array_date_fin[2],$array_date_fin[1],$array_date_fin[0]);
					}
					
					printf('<li class="%s"><a href="#evenement-%s" class="ouvrir-modaal">%s - <strong>%s</strong></br><strong>%s</strong></a></li>', $classe_futur,$post_id,$date_a_afficher, $ville, $titre_item);

					/*Données pour la popup*/
					$desc=$post->post_content;
					$pays=wp_kses_post(get_field('pays',$post_id));
					$plage_horaire=wp_kses_post(get_field('plage_horaire',$post_id));
					$label_lien_resa=wp_kses_post(get_field('label_lien_resa',$post_id));
					$lien_resa=esc_url(get_field('lien_resa',$post_id));
					$type_evenement=fdc_get_type_evenement($post_id); 
					fdc_prepare_popup_evenement($post_id,$classe_futur='',$date_debut,$date_fin,$titre_item,$plage_horaire,$type_evenement,$ville,$pays,$desc,$lien_resa,$label_lien_resa,'accueil');
				}

				echo '</ul></div>';
			}

			//Liste des ressources liées à cette région - avec type de fichier et vérification accès
			$ressources= get_posts(array(
				'post_type' => "ressource",
				'numberposts' => -1,
				'tax_query' => array(
					array(
						'taxonomy' => 'antenne_regionnale',
						'terms'    => $term_id,
					),
				),
			));
			if(!empty($ressources)) {
				echo '<div class="ressources-wrap"><h3 class="titre">Ressources</h3><ul class="ressources">';
				foreach($ressources as $post_id) {
					$titre_item=get_the_title($post_id);
					$type_fichier=esc_attr(get_field('type_fichier',$post_id));
					//Vérifier si l'accès à la ressource est autorisé 
					$acces=esc_attr(get_field('acces',$post_id));
					if($acces=='privee' && !$adherent) {
						printf('<li class="prive">
								<div class="picto">%s</div>%s (%s) - Accès adhérent</p>
							</li>',
							fdc_get_picto_inline('verrou-ferme'),
							$titre_item,
							$type_fichier
						);
					} else {
						printf('<li><a href="%s">%s (%s)</a></li>', get_the_permalink( $post_id),$titre_item,$type_fichier);
					}
				}

				echo '</ul></div>';
			}

			echo '</div>'; //fin .col-2

		echo '</div>'; //fin bloc
	endif;

}