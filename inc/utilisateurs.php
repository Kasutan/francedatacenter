<?php
if ( ! defined( 'ABSPATH' ) ) exit;

//Ajouter colonnes avec infos personnalisées dans la table des utilisateurs
//https://www.tipsandtricks-hq.com/adding-a-custom-column-to-the-users-table-in-wordpress-7378
add_action('manage_users_columns','fdc_modify_user_columns');
function fdc_modify_user_columns($column_headers) {
	unset($column_headers['posts']);
	$column_headers['entreprise'] = 'Entreprise';
	$column_headers['categorie'] = 'Catégorie';
	$column_headers['date_expiration'] = 'Fin d\'adhésion';
	return $column_headers;
}

add_action('manage_users_custom_column', 'fdc_user_custom_column_content', 10, 3);
function fdc_user_custom_column_content($value, $column_name, $user_id) {
	if(!function_exists('get_field')) {
		return $value;
	}
	if ( 'entreprise' == $column_name ) {
		return esc_html(get_field('entreprise','user_'.$user_id));
	} else if('date_expiration' == $column_name) {
		$date_expiration=get_field('date_expiration','user_'.$user_id);
		if($date_expiration) {
			$date_actuelle=date('Ymd');
			$date_expiration_formatee = date("d-m-Y", strtotime($date_expiration));
			if($date_actuelle<=$date_expiration) {
				return '<span style="color:green">'.$date_expiration_formatee.'</span>';
			} else {
				return '<span style="color:orange">'.$date_expiration_formatee.'</span>';
			}
		}
	} else if ( 'categorie' == $column_name ) {
		$cat_string='';
		$cat_array=get_field('categorie','user_'.$user_id);
		if($cat_array) {
			foreach($cat_array as $cat)
			$cat_string.=esc_html($cat['label']).' ';
		}
		return $cat_string;
	}
	return $value;
}

function fdc_affiche_adherent($user,$contexte='grille',$groupe=0) {
	if( !function_exists('get_field') || !function_exists('fdc_get_picto_url') ) {
		return;
	}
	$user_id=$user->ID;
	$logo=esc_attr(get_field('logo','user_'.$user_id));
	$entreprise=esc_html(get_field('entreprise','user_'.$user_id));
	$url=$user->get('user_url');

	$cat_array=false;
	$cat_string='';
	$cat_array=get_field_object('categorie','user_'.$user_id);

	if(!empty($cat_array)) {
		$cats=$cat_array['value'];
		if(is_array($cats)) {
			foreach($cats as $cat)
			$cat_string.=$cat['value'].' ';
		}
	}
	


	if($contexte==='slider') { //on affiche le logo cliquable ou simplement l'image
		if(!empty($url)) {
			printf('<li class="adherent">%s</li>',
				wp_get_attachment_image($logo, 'logo', false, array('alt'=>$entreprise))
			);
		} else {
			printf('<li class="adherent">%s</li>',
				wp_get_attachment_image($logo, 'logo', false, array('alt'=>$entreprise))
			);
		}
	} else { //contexte grille, on affiche le logo cliquable qui ouvre une popup au clic

		if ($groupe > 0) {
			//ce logo n'est pas visible au chargement de la page : on lui passe différentes infos pour le JS et on ne charge pas l'image
			printf('<li class="adherent js-afficher-plus" data-groupe="%s" data-src="%s">',$groupe,
			wp_get_attachment_image_url($logo, 'medium'));
			if($cat) {
				printf('<span class="cat" style="display:none" aria-hidden="true">%s</span>',print_r($cat));
			}
			printf('<a href="#adherent-%s" class="ouvrir-modaal"><img src="data:," alt="%s" class="no-lazy-load" /></a>%s</li>',
				$user_id,
				$entreprise,
				fdc_prepare_popup_adherent($user_id,$logo,$entreprise,$url)
			);
		} else {
			echo '<li class="adherent">';
			if($cat_string) {
				printf('<span class="type" style="display:none" aria-hidden="true">%s</span>',$cat_string); //pour le filtre
			}
			printf('<a href="#adherent-%s" class="ouvrir-modaal">%s</a>%s</li>',

				$user_id,
				wp_get_attachment_image($logo, 'medium', false, array('alt'=>$entreprise)),
				fdc_prepare_popup_adherent($user_id,$logo,$entreprise,$url)
			);
		}
		
	}
}

function fdc_prepare_popup_adherent($user_id,$logo,$entreprise,$url) {
	$descriptif=wp_kses_post(get_field('descriptif','user_'.$user_id));
	ob_start(); 
	printf('<div id="adherent-%s" class="popup">',$user_id);
		echo '<div class="infos-adherent">';
			if($logo) echo wp_get_attachment_image($logo, 'medium', false, array('alt'=>$entreprise));
			if($descriptif) printf('<div class="descriptif">%s</div>',$descriptif); else echo $entreprise;
			if($url) printf('<a href="%s" class="url" target="_blank">%s</a>',$url, $url);
		echo '</div>'; //fin .infos
		printf('<button class="fermer-modaal retour"><img src="%s" width="52" height="52" alt="Fermer"/><span>Revenir à la liste</span></button>',fdc_get_picto_url('croix'));
	echo '</div>'; //fin .popup
	return ob_get_clean();
}


/**
* Déterminer si l'utilisateur actuel est un adhérent actif (=la date d'expiration de son adhésion n'est pas dépassée)
*/
function fdc_is_current_user_adherent() {
	$current_user=wp_get_current_user()->ID;
	if($current_user==0) { //le visiteur n'est pas connecté
		return false; 
	}
	if(current_user_can('edit_posts')) {
		return true; // toujours montrer tout le contenu aux éditeurs
	}

	$date_expiration=get_field('date_expiration','user_'.$current_user);
	$date_actuelle=date('Ymd');

	if($date_actuelle<=$date_expiration) {
		return true;
	} else {
		return false;
	}
}

/**
* Afficher le lien de connexion ou de déconnexion dans l'en-tête
*/
function fdc_affiche_lien_connexion() {
	if(!function_exists('fdc_get_picto_inline') || !function_exists('get_field')) {
		return;
	}
	$current_user=wp_get_current_user()->ID;
	if($current_user==0) { //le visiteur n'est pas connecté
		printf('<button id="ouvrir-connexion" aria-expanded="false" class="connexion bouton" aria-controls="volet-connexion">%s<span>Connexion adhérent</span></button>',
			fdc_get_picto_inline('connexion')
		);
	} else {
		$entreprise=get_field('entreprise','user_'.$current_user);
		$user_data=get_userdata( $current_user );
		printf('<a class="connexion lien" href="%s" title="Se déconnecter">%s<span>%s',
			wp_logout_url('/'),
			fdc_get_picto_inline('deconnexion'),
			$user_data->display_name
		);
		if($entreprise) printf(' - %s',$entreprise);
		printf('</span></a>');
	}
}

/**
* Afficher le volet de connexion dans l'en-tête
*/
function fdc_affiche_volet_connexion() {
	if(!function_exists('fdc_get_picto_url') || !function_exists('get_field')) {
		return;
	}
	$current_user=wp_get_current_user()->ID;
	if($current_user!=0) { //le visiteur est connecté, pas besoin d'afficher le volet
		return '';
	}
	$message=wp_kses_post(get_field('message_login','options'));
	echo '<div class="volet-header" id="volet-connexion" aria-expanded="false" role="form"><div class="decor"></div>';
		printf('<img class="picto" src="%s" width="49" height="39" alt="picto connexion"/>',
			fdc_get_picto_url('verrou-ferme-blanc')
		);
		echo '<p class="h2">Connexion adhérent</p>';
		wp_login_form(array('remember'=>false));
		if($message) printf('<div class="message">%s</div>',$message);
		printf('<button id="fermer-connexion" class="fermer"><span>Fermer</span><img src="%s" width="52" height="52" alt="Fermer"/></button>',fdc_get_picto_url('croix-blanc'));
	echo '</div>';
}

/**
* Masquer certains champs des écrans d'édition et de création d'utilisateurs
* https://www.role-editor.com/hide-disable-wordpress-user-profile-fields/
*/
add_action('admin_init', 'fdc_simplifier_admin_utilisateur');

function fdc_simplifier_admin_utilisateur() {

	global $pagenow;

	if( $pagenow==='user-new.php' ) {
		add_action( 'admin_footer', 'fdc_simplifier_admin_creation_utilisateur_js' );
	}

	if( $pagenow==='user-edit.php' ) {
		add_action( 'admin_footer', 'fdc_simplifier_admin_edition_utilisateur_js' );
	}

}

/**
* Utilise jQuery pour désactiver, masquer et/ou pré-remplir certains champs
*/
function fdc_simplifier_admin_creation_utilisateur_js() {
?>
<script>
jQuery(document).ready( function($) {

	//Décocher et cacher la case d'envoi d'une notification à l'utilisateur 
	var notification = $('#send_user_notification');
	if(notification.length) {
		$(notification).prop('checked',false);
		$(notification).parents('tr').hide();
	}

	//Ajouter une indication au niveau du champ identifiant
	var identifiant=$('#user_login');
	if(identifiant.length) {
		$('label[for="user_login"]').append('<p><em>Saisir ici le nom de l\'entreprise (sans espaces ni caractères spéciaux). Cet identifiant sera utilisé pour présenter les entreprises par ordre alphabétique sur la page Adhérents</em></p>');
	}

});
</script>
<?php
}

function fdc_simplifier_admin_edition_utilisateur_js() {
	?>
	<script>
	jQuery(document).ready( function($) {
	
		//Champs à cacher dans l'écran d'édition
		var fields_to_hide = ['nickname', 'description'];
		for(i=0; i<fields_to_hide.length; i++) {
			if ( $('#'+ fields_to_hide[i]).length ) {
				$('#'+ fields_to_hide[i]).parents('tr').hide();
			}
		}
	
		//Cacher la ligne qui contient la photo Gravatar (pour éviter la confusion avec le champ logo)
		if($('tr.user-profile-picture').length) {
			$('tr.user-profile-picture').hide();
		}
	
		//Cacher le titre About the user
		$('.user-url-wrap').parents('table').next('h2').hide();

		//Cacher le titre et tous les champs d'affichage personnalisé (ce sont les premiers du formulaire)
		$('#your-profile h2:first-of-type, #your-profile table:first-of-type').hide();
	
	});
	</script>
	<?php
	}
	

/**
* Disable new user notification emails and password changed notification emails
* https://www.itsupportguides.com/knowledge-base/wordpress/wordpress-how-to-disable-new-user-notification-emails/
*/
if ( ! function_exists( 'wp_new_user_notification' ) ) :
		function wp_new_user_notification( $user_id, $deprecated = null, $notify = '' ) {
				return;
		}
endif;
if ( ! function_exists( 'wp_password_change_notification' ) ) :
		function wp_password_change_notification( $user ) {
				return;
		}
endif;


//Masquer la barre d'admin pour les non éditeurs
add_action('set_current_user', 'fdc_hide_admin_bar');
function fdc_hide_admin_bar()
{
	if (!current_user_can( 'edit_posts' ))
		{
		show_admin_bar(false);
		}
}

//Redirect users if they are not editors to the front-end (no direct access to back-end)
function fdc_block_access_to_dashboard(){
	if( is_admin() && !defined('DOING_AJAX')	)
	{
		if(!current_user_can('edit_posts') ) {
			wp_safe_redirect(home_url());
			exit;
		}

	}
}
add_action('init','fdc_block_access_to_dashboard');


function fdc_affiche_filtre_adherents($titre_filtre){
	//On récupère les labels dans les options du site - pour les avoir dans l'ordre
	$labels_filtres=get_field('labels_filtre','options');
	if(empty($labels_filtres)) {
		return;
	}

	printf('<button id="toggle-filtre" aria-controls="filtre-liste" aria-expanded="false" class="toggle-filtre">%s <span class="afficher">Filtrer par secteur d\'activité</span><span class="masquer">Masquer le filtre</span></button>',
		fdc_get_picto_inline('filtre')
	);
	
	echo '<div class="filtre-wrap">';
	if($titre_filtre) printf('<p class="titre-filtre">%s</p>',$titre_filtre);

		echo '<form id="filtre-liste" class="filtre filtre-adherents">';
			echo '<input type="radio" name="filtre-adherents" id="tous" value="tous" class="type" checked>';
			echo '<label for="tous" class="tous">Tous</label>';
			foreach($labels_filtres as $slug => $label) : 
				printf('<input type="radio" id="%s" name="filtre-adherents" value="%s" class="type">',
					$slug,
					$slug
				);
				printf('<label for="%s" class="%s">%s</label>',
					$slug,
					$slug,
					$label
				);
			endforeach;
		echo '</form>';
	echo '</div>';
}

//Ne plus envoyer d'email à l'utilisateur quand on modifie son mot de passe depuis le BO
add_filter( 'send_password_change_email', '__return_false' );