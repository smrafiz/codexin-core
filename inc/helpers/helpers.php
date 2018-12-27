<?php
/**
 * Various helper functions definition related to Codexin Core
 *
 * @package     Codexin Core
 * @category    Helpers
 * @since       1.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( ! function_exists( 'codexin_get_post_views' ) ) {
	/**
	 * Function to get the post views.
	 *
	 * @param   int $post_id ID of the post.
	 * @return  string
	 * @since   v1.0
	 */
	function codexin_get_post_views( $post_id ) {
		$count_key = 'cx_post_views';
		$count = get_post_meta( $post_id, $count_key, true );
		if ( '' == $count ) {
			delete_post_meta( $post_id, $count_key );
			add_post_meta( $post_id, $count_key, '0' );
			return ' 0';
		}
		return ' ' . $count;
	}
}

if ( ! function_exists( 'codexin_set_post_views' ) ) {
	/**
	 * Function to set the post views
	 *
	 * @param   int $post_id ID of the post.
	 * @since   v1.0
	 */
	function codexin_set_post_views( $post_id ) {
		$count_key = 'cx_post_views';
		$count = get_post_meta( $post_id, $count_key, true );
		if ( '' == $count ) {
			$count = 0;
			delete_post_meta( $post_id, $count_key );
			add_post_meta( $post_id, $count_key, '0' );
		} else {
			$count++;
			update_post_meta( $post_id, $count_key, $count );
		}
	}
}
// To keep the count accurate, lets get rid of prefetching.
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

if ( ! function_exists( 'codexin_retrieve_img_src' ) ) {
	/**
	 * Helper Function for retrieving Image URL
	 *
	 * @param  int   $image The ID of the image.
	 * @param  mixed $image_size The registered image size.
	 * @return string
	 * @since  v1.0
	 */
	function codexin_retrieve_img_src( $image, $image_size ) {

		$img_src     = wp_get_attachment_image_src( $image, $image_size );
		$img_source  = $img_src[0];
		return $img_source;
	}
}

if ( ! function_exists( 'codexin_retrieve_alt_tag' ) ) {
	/**
	 * Helper Function for retrieving image alt tag
	 *
	 * @return  string
	 * @since   v1.0
	 */
	function codexin_retrieve_alt_tag() {

		global $post;
		$attachment_id  = get_post_thumbnail_id( $post->ID );
		$image          = wp_prepare_attachment_for_js( $attachment_id );
		$alt            = $image['alt'];
		return $alt;
	}
}
