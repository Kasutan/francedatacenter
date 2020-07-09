<?php
/**
 * Register Custom color palette for Gutenberg editor
 *
 * Should be the colors from css/colors.css.
 *
 * @package francedatacenter
 */

add_theme_support( 'editor-color-palette', array(
	
	array(
		'name'  =>'Bleu',
		'slug'  => 'bleu',
		'color'	=> '#49495D',
	),
	array(
		'name'  =>'Rouge',
		'slug'  => 'rouge',
		'color'	=> '#EC6557',
	),
	array(
		'name'  =>'Jaune',
		'slug'  => 'jaune',
		'color'	=> '#E6CB6D',
	),

	
	array(
		'name'  =>'Gris texte',
		'slug'  => 'gris-texte',
		'color'	=> '#707070',
	),
	array(
		'name'  =>'Gris fond',
		'slug'  => 'gris-fond',
		'color'	=> '#AAA89E',
	),
	array(
		'name'  =>'Gris fond clair',
		'slug'  => 'gris-fond-clair',
		'color'	=> '#F2F1ED',
	),
	array(
		'name'  =>'Blanc',
		'slug'  => 'blanc',
		'color'	=> '#ffffff',
	),
	array(
		'name'  =>'Noir',
		'slug'  => 'noir',
		'color'	=> '#000000',
	),
));