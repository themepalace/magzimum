<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Magzimum
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function magzimum_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	//For Custom Background
	$enable_background = magzimum_get_option( 'enable_background' );

	if ( 'disable' != $enable_background ) {
		$classes[] = 'custom-background';
	}
	
	return $classes;
}
add_filter( 'body_class', 'magzimum_body_classes' );


if ( ! function_exists( 'magzimum_custom_background' ) ) :
/**
 * wp_head_callback function for Custom Background
 * Changes the background image according the option selected
 *
 * @since 1.4
 */
function magzimum_custom_background() {
	if ( $bgcolor = get_theme_mod( 'background_color' ) ) {
		?>
			<style type="text/css">
			body.custom-background { background-color: #<?php echo esc_attr( $bgcolor ); ?> }
			</style>
		<?php
	}
	$enable_background = magzimum_get_option( 'enable_background' );

	if( 'disable' == $enable_background ) {
		return;
	}

	$background = get_background_image();

	global $post, $wp_query;

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	$page_for_posts = get_option('page_for_posts');

	if ( is_home() && $page_for_posts == $page_id ) {
		$id = $page_id;
	}
	else {
		if ( isset( $post->ID ) ) {
			$id = $post->ID;
		}
		else {
			$id = $page_id;
		}
	}

	if( 'entire-site-page-post' == $enable_background ) {
		global $post;
		if( has_post_thumbnail($id) ) {
			$feat_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'full' );
			$background =  esc_url( $feat_image[0] ); 	
		}
	}
	
	if ( ! $background ) {
		return;
	}

	if ( $background ) {
		$image = " background-image: url('$background');";

		$repeat = get_theme_mod( 'background_repeat', 'repeat' );
		
		if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) ) {
			$repeat = 'repeat';
		}	

		$repeat = " background-repeat: $repeat;";

		$position = get_theme_mod( 'background_position_x', 'center' );
			
		if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) ) {
			$position = 'left';
		}

		$position = " background-position: top $position;";

		$attachment = get_theme_mod( 'background_attachment', 'fixed' );
		
		if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) ) {
			$attachment = 'scroll';
		}
		
		$attachment = " background-attachment: $attachment;";
		
		$style = $image . $repeat . $position . $attachment;
	}
	?>
	<style type="text/css">
	body.custom-background { <?php echo trim( $style ); ?> }
	</style>
	<?php
}
endif; //magzimum_custom_background