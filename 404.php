<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Magzimum
 */

get_header(); ?>

	<div id="primary" class="content-area col-sm-12">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h2 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'magzimum' ); ?></h2>
				</header><!-- .page-header -->

        <div class="text-404"><?php _e( '404', 'magzimum' ); ?></div><!-- .404-text -->

        <?php
          wp_nav_menu( array(
            'theme_location' => 'notfound' ,
            'depth'          => 1 ,
            'fallback_cb'    => false,
            'container'      => 'div',
            'container_id'   => 'quick-links-404',
            )
          );
        ?>

				<div class="page-content">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try searching?', 'magzimum' ); ?></p>

					<?php get_search_form(); ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
