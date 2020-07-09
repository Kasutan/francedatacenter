<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package francedatacenter
 */

get_header();
?>

		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="entry-header">
				<h1 class="page-title">
					<?php
					echo "Recherche&nbsp;:".' <span>'. get_search_query() . '</span>' ;
					?>
				</h1>
			</header><!-- .page-header -->
			<div class="entry-content container loop">
			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'loop' );

			endwhile;

			if (function_exists('wp_pagenavi')) :
				wp_pagenavi();
			else :
				the_posts_navigation();
			endif;

			
			echo '</div>'; //fin entry-content

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- #main -->

<?php
get_footer();
