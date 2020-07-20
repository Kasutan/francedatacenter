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


	printf('<section class="acf-block-agenda %s">', $className);
		$args=array(
			'post_type' => 'evenement',
			'posts_per_page' => -1,
			'meta_key' => 'date_debut', //on trie les évènements selon leur date
			'orderby' => 'meta_value',
			'order' => 'ASC', 
			'meta_query' => array(
					array(
					'key' => 'date_debut',
					'value' => date('Y-m-d'),
					'compare' => '>=', // on n'affiche que les évènements futurs
					'type' => 'CHAR'
				)
			)
		);
		$agenda=new WP_Query($args);
		if($agenda->have_posts()) :
			echo '<div class="agenda" id="agenda">';
				fdc_affiche_filtre_agenda();
				echo '<ul class="liste-agenda">';
				while ($agenda->have_posts()):
					$agenda->the_post();
					fdc_affiche_evenement(get_the_ID());
				endwhile;
				echo '</ul>';
				//TODO bouton pour afficher plus d'évènements
			echo '</div>';
		else : 
			echo '<p>Aucun évènement</p>';
		endif;	
		wp_reset_postdata();
	echo "</section>";

}