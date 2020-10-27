<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_agenda_acf_init' );
function fdc_acf_block_agenda_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-agenda',
			'title'           => 'Bloc agenda',
			'description'     => 'Bloc qui affiche la liste des évènements futurs.',
			'render_callback' => 'fdc_agenda_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'calendar-alt',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'agenda', 'fdc','evenement'],
		] );
	}
}

function fdc_agenda_callback( $block ) {
	if( !function_exists("get_field") || !function_exists("fdc_affiche_evenement") || !function_exists("fdc_affiche_filtre_agenda") ) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$page=esc_attr(get_field('page'));
	if(!$page) $page=3;

	$titre=wp_kses_post(get_field('titre'));
	$ordre=esc_attr(get_field('ordre'));
	if(empty($ordre)) $ordre='ASC';

	printf('<section class="acf-block-agenda %s">', $className);
		$args=array(
			'post_type' => 'evenement',
			'posts_per_page' => -1,
			'meta_key' => 'date_debut', //on trie les évènements selon leur date
			'orderby' => 'meta_value',
			'order' => $ordre, 
		);
		$agenda=new WP_Query($args);
		if($agenda->have_posts()) :
			if($titre) printf('<h2 class="has-text-align-center">%s</h2>',$titre);
			echo '<div class="agenda" id="liste-filtrable">';
				fdc_affiche_filtre_agenda();
				echo '<ul class="list evenements">';
				while ($agenda->have_posts()):
					$agenda->the_post();
					fdc_affiche_evenement(get_the_ID());
				endwhile;
				echo '</ul>';
				if($agenda->found_posts > $page) {
					printf('<div class="fleche bas"><button id="afficher-plus" data-affiche="%s" data-increment="%s" data-max="%s" aria-label="Afficher plus d\'évènements">Afficher plus %s</button></div>',
						$page,
						$page,
						$agenda->found_posts,
						fdc_get_picto_inline('angle-bas')
					);
				}
				//reçoit la pagination list.js - cet élément est masqué, mais sert à repérer si tous les éléments sont affichés (en tenant compte des filtres), pour savoir si on masque ou pas le bouton Afficher plus
				echo '<ul class="pagination" style="display:none"></ul>'; 
			echo '</div>';
		else : 
			echo '<p>Aucun évènement</p>';
		endif;	
		wp_reset_postdata();
	echo "</section>";

}