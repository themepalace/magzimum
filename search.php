<?php
/**
 * The template for displaying search results pages.
 *
 * @package Magzimum
 */

get_header(); ?>

	<section id="primary" <?php magzimum_content_class( 'content-area' ); ?> >
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'magzimum' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );
				?>

			<?php endwhile; ?>

			<?php
      /**
       * magzimum_action_posts_navigation hook
       *
       * @hooked: magzimum_custom_posts_navigation - 10
       *
       */
      do_action( 'magzimum_action_posts_navigation' );?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->


<?php
/**
 * magzimum_action_sidebar hook
 *
 * @hooked: magzimum_add_sidebar - 10
 *
 */
do_action( 'magzimum_action_sidebar' );?>


<?php get_footer(); ?>
