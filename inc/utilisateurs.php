<?php
if ( ! defined( 'ABSPATH' ) ) exit;

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
	var identifiant=$('#user_login');

	//A la création du profil, copier l'identifiant dans le champ email
	var email=$('#email');
	if(identifiant.length && email.length) {
		identifiant.on('blur, keyup', function(){
			email.val(identifiant.val());
		});
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
		var fields_to_hide = ['nickname', 'display_name','description'];
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
	if( is_admin() && !defined('DOING_AJAX')  )
	{
		if(!current_user_can('edit_posts') ) {
			wp_safe_redirect(home_url());
			exit;
		}

	}
}
add_action('init','fdc_block_access_to_dashboard');


