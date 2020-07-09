<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package francedatacenter
 */

?>

	<footer id="colophon" class="site-footer">
		<?php

		printf('<div class="logo-footer"><img src="%s" width="97" height="70" alt="My Big Bang Logo"/></div>',fdc_get_picto_url('logo-Footer') );

		wp_nav_menu( array(
			'theme_location' => 'liens-footer',
			'container' => false,
			'fallback_cb' => false,
			'menu_id' => 'liens-footer',
			'menu_class' => 'liens'
		) );

		wp_nav_menu( array(
			'theme_location' => 'boutons-footer',
			'container' => false,
			'fallback_cb' => false,
			'menu_id' => 'boutons-footer',
			'menu_class' => 'boutons'
		) );

		echo '<div class="social"><p class="titre">Suivez-nous</p>';
			wp_nav_menu( array(
				'theme_location' => 'social-footer',
				'container' => false,
				'fallback_cb' => false,
				'menu_id' => 'social-footer',
				'menu_class' => 'social-footer'
			) );
		echo '</div>';

		wp_nav_menu( array(
			'theme_location' => 'liens-techniques-footer',
			'container' => false,
			'fallback_cb' => false,
			'menu_id' => 'liens-techniques-footer',
			'menu_class' => 'liens-techniques'
		) );

		printf('<div class="copyright">Copyright 2016-%s My Big Bang</div>',current_time('Y'));
		
		?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
