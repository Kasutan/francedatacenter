<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_comite_acf_init' );
function fdc_acf_block_comite_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-comite',
			'title'           => 'Bloc comité éditorial',
			'description'     => 'Bloc comité éditorial. Pour chaque groupe de travail : nom, descriptif et ressources (optionnelles).',
			'render_callback' => 'fdc_comite_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'editor-ol',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'liste', 'fdc', 'comité'],
		] );
	}
}

function fdc_comite_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	if( have_rows('groupes') ):
		printf('<section class="acf-block-comite alignfull %s">', $className);
			//TODO ajouter décor
			echo '<ol class="groupes">';
			$count=1;
			while(have_rows('groupes')): the_row();
				$nom=wp_kses_post(get_sub_field('nom'));
				$texte=wp_kses_post(get_sub_field('texte'));

				printf('<li class="groupe"><div class="numero">%s</div>',$count);
				if($nom) printf('<p class="nom">%s</p>',$nom);
				if($texte) printf('<p class="texte">%s</p>',$texte);

				//Liste des liens vers les ressources
				if(have_rows('ressources')) : 
					echo '<ul cass="liens">';
					while(have_rows('ressources')): the_row();
						$ressource=esc_attr(get_sub_field('ressource'));
						$label=wp_kses_post(get_sub_field('label'));
						if($ressource && $label) {
							//TODO vérifier si la ressource est publique et sinon, si l'adhérent est connecté
							printf('<li><a href="%s">%s</a></li>',get_the_permalink( $ressource),$label);
						}
					endwhile;
					echo '</ul>';
				endif;
				echo '</li>';
				$count++;
			endwhile;
			echo '</ol>';
		echo "</section>";
	endif;

}