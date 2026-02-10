<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function fdc_affiche_membre($post_id) {
	if(get_post_type($post_id)!=='fdc_membre' || !function_exists('get_field')) {
		return;
	}
	$nom=get_the_title($post_id);
	$prenom=wp_kses_post(get_field( 'prenom', $post_id ));  
	$fonction=wp_kses_post(get_field( 'fonction', $post_id ));
	$entreprise=wp_kses_post(get_field( 'entreprise', $post_id ));
	$photo=esc_attr(get_field( 'photo', $post_id ));

	printf('<li class="membre">');
		printf('<a href="#membre-%s" class="ouvrir-modaal">',$post_id);
			echo wp_get_attachment_image($photo, 'thumb', false, array('alt'=>$nom.' '.$prenom));

			printf('<p class="nom"><strong>%s<br>%s</strong></p>',$prenom,$nom);

			printf('<p class="fonction">%s</p>',$fonction);

			printf('<p class="entreprise"><strong>%s</strong></p>',$entreprise);

			fdc_prepare_popup_membre($post_id,$photo,$nom,$prenom,$fonction,$entreprise);
			
	echo '</a></li>';
}


function fdc_prepare_popup_membre($post_id,$photo,$nom,$prenom,$fonction,$entreprise) {
	
	$bio=wp_kses_post(get_field( 'bio', $post_id ));

	ob_start(); 
	printf('<div id="membre-%s" class="popup">',$post_id);
		echo '<div class="infos-membre">';

			echo wp_get_attachment_image($photo, 'thumb', false, array('alt'=>$nom.' '.$prenom));

			printf('<p class="nom"><strong>%s %s</strong></p>',$prenom,$nom);

			printf('<p class="fonction">%s</p>',$fonction);

			printf('<p class="entreprise"><strong>%s</strong></p>',$entreprise);

			printf('<div class="bio">%s</div>',$bio);

		echo '</div>'; //fin .infos

		printf('<button class="fermer-modaal retour"><img src="%s" width="52" height="52" alt="Fermer"/><span>Revenir à la liste</span></button>',fdc_get_picto_url('croix'));

	echo '</div>'; //fin .popup
	return ob_get_clean();
}

//Pour le trombi de la page Gang
function fdc_affiche_trombi() {
	//TODO ordre alphabétique

	$args=array(
		'posts_per_page' => -1,
		'post_type' => 'fdc_membre',
	);
	$membres=new WP_Query($args);
	if($membres->have_posts()) :
		echo '<ul>';
		while ($membres->have_posts()):
			$membres->the_post();
			fdc_affiche_membre($get_the_ID());
		endwhile;
		echo '</ul>';
	else : 
		echo '<p>Aucune membre</p>';
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

