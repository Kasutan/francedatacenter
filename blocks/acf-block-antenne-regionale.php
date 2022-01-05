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

	if(!empty($antenne)):
		printf('<div class="acf-block-antenne %s">', $className);
			printf('<h2 class="nom">%s</h2>',$antenne->name);

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

					if($photo) printf('<div class="photo">%s</div>',wp_get_attachment_image( $photo, 'thumbnail'));

					echo '<div class="texte">';
						if($nom) printf('<p class="nom"><strong>%s</strong></p>',$nom);
						if($fonction) printf('<p>%s</p>',$fonction);
						if($societe) printf('<p>%s</p>',$societe);
					echo '</div>';
				endwhile;
				echo '</ul>';
			}

			//TODO liste des événements liés à cette région


			//TODO liste des ressources liées à cette région
		
		echo '</div>';
	endif;

}