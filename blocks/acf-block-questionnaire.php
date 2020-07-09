<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_banniere_acf_init' );
function fdc_acf_block_banniere_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-banniere',
			'title'           => 'Bloc questionnaire avec grande image',
			'description'     => 'Bloc questionnaire avec grande image pour découvrir l\'élément du visiteur. Ce bloc ne peut être inséré qu\'une fois par page.',
			'render_callback' => 'fdc_questionnaire_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'editor-help',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'image', 'fdc', 'questionnaire'],
		] );
	}
}

function fdc_questionnaire_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$image_id=esc_attr( get_field('image') );
	$titre=wp_kses_post( get_field('titre') );
	$ouvrir_questionnaire=wp_kses_post( get_field('ouvrir_questionnaire') );
	$intro=wp_kses_post( get_field('intro') );
	$formulaire_id=esc_attr( get_field('formulaire') );
	$conclusion=wp_kses_post( get_field('conclusion') );
	$label_cta=wp_kses_post( get_field('label_cta') );
	$cible_cta=esc_url( get_field('cible_cta') );

	printf('<section class="acf-block-questionnaire %s">', $className);
		printf('<div class="image">%s</div>',	wp_get_attachment_image( $image_id,'large' ));
		echo '<div class="texte">';
			printf('<h2 class="titre">%s</h2>', $titre);
			printf('<div class="ouvrir hide-for-md"><a href="#questionnaire" id="ouvrir-questionnaire" class="fleche-simple">%s</a></div>',$ouvrir_questionnaire);
			echo '<div class="questionnaire" id="questionnaire">';
				printf('<div class="intro">%s</div>',$intro);
				echo '<div class="intro-resultat"><div id="lottie" class="animation"></div><div class="titre-resultat">Vous avez une tendance</div><div class="element" id="element"></div></div>';
				echo Caldera_Forms::render_form($formulaire_id);
				printf('<div class="conclusion-resultat">%s</div><a class="cta-resultat" href="%s"><span>%s</span>',$conclusion, $cible_cta, $label_cta);
				echo fdc_get_picto_inline('fleche-cta').'</a>';
				echo '<button id="fermer-questionnaire" class="fermer"><span class="screen-reader-text">Fermer le questionnaire</span>
					<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path fill="#EC6557" d="m16.789 24.959-15.17-15.17 2.388-2.408 12.782 12.782 12.783-12.782 2.387 2.408z" fill-rule="evenodd" transform="matrix(0 -1 1 0 .62 32.96)"/></svg>
				</button>';
			echo '</div>'; //fin questionnaire
		echo '</div>'; //fin texte		
	
	echo "</section>";

}