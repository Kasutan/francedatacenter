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
		<div class="footer-widgets">
			<div class="row">
				<?php dynamic_sidebar('footer_1');
				dynamic_sidebar('footer_2');
				dynamic_sidebar('footer_3');
				dynamic_sidebar('footer_4');
			echo '</div>';
			echo '<div class="footer-5">';
				dynamic_sidebar('footer_5');
			echo '</div>';
		

		echo '</div>'; //fin .footer-widgets
		echo '<div class="copyright alignfull">';
			printf('<span>&copy;%s francedatacenter.com</span>',current_time('Y'));
			wp_nav_menu( array(
				'theme_location' => 'footer',
				'container' => false,
				'fallback_cb' => false,
				'menu_id' => 'footer',
				'menu_class' => 'liens-copyright'
			) );
		echo '</div>'; //.fin copyright
		
		?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
