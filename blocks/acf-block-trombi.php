<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_trombi_acf_init' );
function fdc_acf_block_trombi_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-trombi',
			'title'           => 'Bloc Trombinoscope',
			'description'     => 'Bloc qui affiche une grille des portraits des membres du Gang des femmes. Le contenu de ce bloc est automatique.',
			'render_callback' => 'fdc_trombi_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'nametag',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'gang', 'fdc', 'trombi','membre'],
		] );
	}
}

function fdc_trombi_callback( $block ) {
	if( !function_exists("get_field") || !function_exists("fdc_affiche_trombi")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$titre=esc_html(get_field('titre'));
	$lien=get_field('lien');

	printf('<section class="acf-block-trombi alignfull %s" id="trombi">', $className);
		
		printf('<h2 class="titre-section">%s</h2>',$titre);
		fdc_affiche_trombi();

		if(!empty($lien)) {
			$target_atts='';
			if(!empty($lien['target']) && esc_attr($lien['target'])==='_blank') {
				$target_atts='target="_blank" rel="noopener noreferrer"';
			}
			printf('<div class="fleche angle"><a href="%s" %s>%s %s</a></div>',
				esc_url($lien['url']),
				$target_atts,
				wp_kses_post( $lien['title'] ),
				fdc_get_picto_inline('angle')
			);
		}
	echo "</section>";

}