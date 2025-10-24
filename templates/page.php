<?php
get_header();
?>

	<main id="primary" class="site-main">
	<p>CECI EST UN TEST DU FONCTIONNEMENT DE MON LIEN PHP</p>
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template_parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_sidebar();

get_footer();