<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package francedatacenter
 */

get_header();
			//TODO afficher une image bannière -> image par défaut

?>

	<main id="main" class="site-main">

			<header class="entry-header">
				<h1 class="page-title">Page introuvable</h1>
			</header><!-- .page-header -->

			<div class="entry-content container avec-ancre"><div class="ancre" id="entry-content"></div>
				<p>Cette page n'existe pas. Voulez-vous essayer une recherche&nbsp;?</p>

				<?php
				get_search_form();

				?>
			</div><!-- .page-content -->

	</main><!-- #main -->

<?php
get_footer();
