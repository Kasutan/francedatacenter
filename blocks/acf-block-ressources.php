<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_ressources_acf_init' );
function fdc_acf_block_ressources_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-ressources',
			'title'           => 'Bloc ressources',
			'description'     => 'Bloc qui affiche la liste des ressources.',
			'render_callback' => 'fdc_ressources_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'index-card',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'ressource', 'fdc'],
		] );
	}
}

function fdc_ressources_callback( $block ) {
	if( !function_exists("get_field") || !function_exists("fdc_affiche_ressource") || !function_exists("fdc_affiche_filtre_ressources") ) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	printf('<section class="acf-block-ressources %s">', $className);
		$args=array(
			'post_type' => 'ressource',
			'posts_per_page' => -1
		);
		$ressources=new WP_Query($args);
		if($ressources->have_posts()) :
			echo '<div class="ressources" id="ressources">';
				fdc_affiche_filtre_ressources();
				echo '<ul class="liste-ressources">';
				while ($ressources->have_posts()):
					$ressources->the_post();
					fdc_affiche_ressource(get_the_ID());
				endwhile;
				echo '</ul>';
				//TODO bouton pour afficher plus de ressources
			echo '</div>';
		else : 
			echo '<p>Aucune ressource</p>';
		endif;	
		wp_reset_postdata();
	echo "</section>";

}