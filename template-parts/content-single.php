<?php
/**
 * @package Magzimum
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>

		<div class="entry-meta">
			<?php magzimum_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
    <?php
    /**
     * magzimum_single_image hook
     *
     * @hooked magzimum_add_image_in_single_display -  10
     *
     */
    do_action( 'magzimum_single_image' );
    ?>
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'magzimum' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php magzimum_entry_footer(); ?>
	</footer><!-- .entry-footer -->

  <?php
  /**
   * magzimum_author_bio hook
   *
   * @hooked magzimum_add_author_bio_in_single -  10
   *
   */
  do_action( 'magzimum_author_bio' );
  ?>

</article><!-- #post-## -->
