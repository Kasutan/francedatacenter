<?php
/**
 * The template for displaying all pages and posts
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package francedatacenter
 */

get_header();

?>

<main id="main" class="site-main">
<?php
	while ( have_posts() ) :
		the_post(); 

		if(function_exists('get_field')) {
			$baseline=wp_kses_post( get_field('baseline'));
			$decoupe_banniere=esc_html( get_field('decoupe_banniere'));
			$decor_banniere=esc_html( get_field('decor_banniere'));
		} else {
			$baseline=$decoupe_banniere=$decor_banniere='';
		}
		

		printf('<header class="entry-header %s %s">',$decoupe_banniere,$decor_banniere);
				
			if(function_exists('fdc_post_thumbnail')) echo '<div class="image">'.fdc_post_thumbnail('banniere').'</div>';
			echo '<div class="texte-banniere">';
				printf('<h1 class="page-title">%s</h1>',get_the_title());
				if($baseline) printf('<p class="baseline">%s</p>',$baseline);
			echo '</div>';
			if(function_exists('fdc_get_picto_url')) printf('<a href="#entry-content"><img src="%s" alt="fleche vers le bas" width="40" height="23"/></a>',fdc_get_picto_url('angle-bas'));
			?>
		</header><!-- .entry-header -->


		<div class="entry-content container" id="entry-content">
			<div class="overlay"></div>
			<div>Fil d'ariane ici</div>
			<?php if ( 'post' === get_post_type() ) :
					?>
					<div class="entry-meta">
						<?php
						the_date('', 'Publié le ');
						?>
					</div><!-- .entry-meta -->
				<?php endif; ?>	
			<?php
			the_content();
			?>

		</div><!-- .entry-content -->

		<?php	

endwhile; // End of the loop. ?>

</main><!-- #main -->

<?php
get_footer();
