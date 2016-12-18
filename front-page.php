<?php
/**
 * Front Page.
 *
 * @package Magzimum
 *
 */

get_header(); ?>

  <div id="primary" <?php magzimum_content_class( 'content-area' ); ?> >
    <main id="main" class="site-main" role="main">

      <?php
      /**
       * magzimum_action_front_page hook
       */
      do_action( 'magzimum_action_front_page' );
      ?>
        <?php if ( have_posts() ) : ?>

      <?php /* Start the Loop */ ?>
      <?php while ( have_posts() ) : the_post(); ?>

        <?php
          /* Include the Post-Format-specific template for the content.
           * If you want to override this in a child theme, then include a file
           * called content-___.php (where ___ is the Post Format name) and that will be used instead.
           */
          get_template_part( 'template-parts/content', get_post_format() );
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

      <?php get_template_part( 'template-parts/content', 'none' ); ?>

    <?php endif; ?>
      <?php
        $show_blog_listing_in_front = magzimum_get_option( 'show_blog_listing_in_front' );
       ?>
       <?php if ( true == $show_blog_listing_in_front ): ?>
        <?php $args = array('post_type' => 'post'); ?>
        <?php $query = new WP_Query($args); ?>
         <?php if ( $query->have_posts() ) : ?>

           <?php /* Start the Loop */ ?>
           <?php while ( $query->have_posts() ) : $query->the_post(); ?>

             <?php
               /* Include the Post-Format-specific template for the content.
                * If you want to override this in a child theme, then include a file
                * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                */
               get_template_part( 'template-parts/content', get_post_format() );
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

           <?php get_template_part( 'template-parts/content', 'none' ); ?>

         <?php endif; ?>

       <?php endif // end if true ?>




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
