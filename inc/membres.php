<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function fdc_affiche_membre($post_id) {
	if(get_post_type($post_id)!=='ressource' || !function_exists('get_field') || !function_exists('fdc_get_picto_inline') || !function_exists('fdc_is_current_user_adherent')) {
		return;
	}
	$titre=get_the_title($post_id);
	$desc=apply_filters('the_content',get_the_content($post_id));
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
		//pour le filtre uniquement
		printf('<span class="type screen-reader-text">%s</span>',
			$type_ressource
		);
	echo '</li>';

}

//Pour le trombi de la page Gang
function fdc_affiche_trombi() {
	$args=array(
		'posts_per_page' => 3,
		'post_type' => 'ressource',
		'tax_query' => array(
			array(
				'taxonomy' => 'type_ressource',
				'terms' => 11, //exclure les vidéos
				'operator' => 'NOT IN'
			)
		),
		'meta_query' => array( 
			'relation' => 'OR',
			array( 
				'key' => 'masquer_national',
				'value' => 'masquer',
				'compare' => '!=',
			),
			array( 
				'key' => 'masquer_national',
				'compare' => 'NOT EXISTS',
			)
		)
	);
	$ressources=new WP_Query($args);
	if($ressources->have_posts()) :
		echo '<ul>';
		while ($ressources->have_posts()):
			$ressources->the_post();
			$acces=esc_attr(get_field('acces',get_the_ID()));

			printf('<li><a href="%s"><strong>%s</strong>',get_the_permalink(),get_the_title());
				if($acces=='privee') {
					printf('<span class="picto-verrou">%s</span>',fdc_get_picto_inline('petit-verrou'));
				}
				printf('<p>Publié le %s</p>',get_the_date('d/m/y'));
			echo '</a></li>';
		endwhile;
		echo '</ul>';
	else : 
		echo '<p>Aucune ressource</p>';
	endif;	
	wp_reset_postdata();
}
/******************Colonnes dans l'admin *****************/
add_filter( 'manage_fdc_membre_posts_columns', 'fdc_set_custom_edit_membre_columns' );

function fdc_set_custom_edit_membre_columns( $columns ) {
	$new_columns;
	foreach($columns as $key=>$value) {
		if('title' === $key) {
			$new_columns['title'] = __( 'Nom', 'francedatacenter' );
			$new_columns['prenom'] = __( 'Prénom', 'francedatacenter' );
			$new_columns['fonction'] = __( 'Fonction', 'francedatacenter' );
			$new_columns['entreprise'] = __( 'Entreprise', 'francedatacenter' );
			$new_columns['photo'] = __( 'Photo', 'francedatacenter' );
		} else {
			$new_columns[$key] = $value;
		}
	}

	return $new_columns;
}

add_action( 'manage_fdc_membre_posts_custom_column' , 'fdc_custom_membre_column', 10, 2 );

function fdc_custom_membre_column( $column, $post_id ) {
	if(!function_exists('get_field')) {
		$prenom='';
		$fonction='';
		$entreprise='';
		$photo=false;
	} else {
		$prenom=wp_kses_post(get_field( 'prenom', $post_id ));  
		$fonction=wp_kses_post(get_field( 'fonction', $post_id ));
		$entreprise=wp_kses_post(get_field( 'entreprise', $post_id ));
		$photo=esc_attr(get_field( 'photo', $post_id ));
	}
	
	switch ( $column ) {

		case 'prenom' :
			echo $prenom;
		break;

		case 'fonction' :
			echo $fonction;
		break;

		case 'entreprise' :
			echo $entreprise;
		break;

		case 'photo' :
			if($photo) {
				echo wp_get_attachment_image($photo, [50,50]);
			} else {
				echo '<span style="color:orange">Photo manquante</span>';
			}
		break;

	}
}

