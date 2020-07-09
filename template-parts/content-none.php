<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package francedatacenter
 */

?>

<section class="no-results not-found">
	<header class="entry-header">
		<h1 class="page-title">Aucun resultat</h1>
	</header><!-- .page-header -->

	<div class="entry-content container">
		<?php
		if ( is_search() ) :
			?>

			<p>Désolé, aucun résultat n'a été trouvé. Voulez-vous essayer avec des mots-clés différents&nbsp;?</p>
			<?php
			get_search_form();

		else :
			?>

			<p>Voulez-vous essayer une recherche&nbsp;?</p>
			<?php
			get_search_form();

		endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
