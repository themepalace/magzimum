<?php
/**
 * The template for displaying all single posts.
 *
 * @package Magzimum
 */
get_header(); ?>

	<div id="primary" <?php magzimum_content_class( 'content-area' ); ?> >
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'single' ); ?>

			<?php the_post_navigation(); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->


<?php
/**
 * magzimum_action_sidebar hook
 *
 * @hooked: magzimum_add_sidebar - 10
 *
 */
do_action( 'magzimum_action_sidebar' );?>

<?php get_footer(); ?>
