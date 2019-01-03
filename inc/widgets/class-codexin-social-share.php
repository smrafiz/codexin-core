<?php
/**
 * Social Share Widget
 *
 * @package     Codexin Core
 * @category    Widget
 * @since       1.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Social Share Widget Class
 *
 * @since v1.0
 */
class Codexin_Social_Share extends WP_Widget {

	/**
	 * Class constructor.
	 *
	 * @access public
	 * @since  1.0
	 */
	public function __construct() {

		// Initializing the basic parameters.
		$widget_ops = array(
			'classname'     => esc_attr( 'codexin-social-share-widget' ),
			'description'   => esc_html__( 'Social Media Share for Posts or Pages', 'codexin-core' ),
		);
		parent::__construct( 'codexin-social-share-widget', esc_html__( 'Codexin: Social Media Share', 'codexin-core' ), $widget_ops );
	}

	/**
	 * Back-end display of widget
	 *
	 * @param  array $instance Various instances.
	 * @access public
	 * @since  1.0
	 */
	public function form( $instance ) {

		$title  = ( ! empty( $instance['title'] ) ? $instance['title'] : '' );
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'codexin-core' ) ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" placeholder="<?php echo esc_html__( 'Ex: Share', 'codexin-core' ) ?>">
		</p>
		
	<?php
	}

	/**
	 * Updating of widget
	 *
	 * @param  array $new_instance New instances.
	 * @param  array $old_instance Old instances.
	 * @access public
	 * @since  1.0
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title']    = ( ! empty( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '' );

		return $instance;
	}

	/**
	 * Front-end display of widget
	 *
	 * @param  array $args Form parameters.
	 * @param  array $instance Variable instance.
	 * @access public
	 * @since  1.0
	 */
	public function widget( $args, $instance ) {

		printf( '%s', $args['before_widget'] );
		$share_url = get_the_permalink();
		if ( is_home() && ! is_front_page() ) {
			$share_url = get_permalink( get_option( 'page_for_posts' ) );
		}
		if ( is_home() && is_front_page() ) {
			$share_url = home_url( '/' );
		}

		if ( ! empty( $instance['title'] ) ) {
			printf( '%s' . apply_filters( 'widget_title', $instance['title'] ) . '%s', $args['before_title'], $args['after_title'] );
		}
		?>

			<div class="socials social-icons-round">
				<ul class="list-inline">
					<li class="list-inline-item">
						<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( $share_url );?>" class="bg-facebook" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a>
					</li>
					<li class="list-inline-item">
						<a href="https://twitter.com/home?status=<?php echo esc_url( $share_url ); ?>" class="bg-twitter" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a>
					</li>
					<li class="list-inline-item">
						<a href="https://plus.google.com/share?url=<?php echo esc_url( $share_url ); ?>" class="bg-google-plus" title="Google Plus" target="_blank"><i class="fa fa-google-plus"></i></a>
					</li>
					<li class="list-inline-item">
						<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url( $share_url ); ?>" class="bg-linkedin" title="Linked In" target="_blank"><i class="fa fa-linkedin"></i></a>
					</li>
				</ul>
			</div>

		<?php

		printf( '%s', $args['after_widget'] );
	}
}
