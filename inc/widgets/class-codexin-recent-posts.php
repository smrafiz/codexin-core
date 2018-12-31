<?php
/**
 * Recent Posts Widget
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
 * Popular Posts Widget Class
 *
 * @since v1.0
 */
class Codexin_Recent_Posts extends WP_Widget {

	/**
	 * Class constructor.
	 *
	 * @access public
	 * @since  1.0
	 */
	public function __construct() {

		// Initializing the basic parameters.
		$widget_ops = array(
			'classname' 	=> esc_attr( 'codexin-recent-posts-widget' ),
			'description' 	=> esc_html__( 'Displays Most Recent Posts', 'codexin-core' ),
		);
		parent::__construct( 'codexin-recent-posts', esc_html__( 'Codexin: Recent Posts', 'codexin-core' ), $widget_ops );
	}

	/**
	 * Back-end display of widget
	 *
	 * @param  array $instance Various instances.
	 * @access public
	 * @since  1.0
	 */
	public function form( $instance ) {

		// Assigning or updating the values.
		$title 			= ( ! empty( $instance['title'] ) ? $instance['title'] : '' );
		$num_posts 		= ( ! empty( $instance['num_posts'] ) ? absint( $instance['num_posts'] ) : esc_html__( '3', 'codexin-core' ) );
		$title_len 		= ( ! empty( $instance['title_len'] ) ? absint( $instance['title_len'] ) : esc_html__( '30', 'codexin-core' ) );
		$show_thumb 	= ( ! empty( $instance['show_thumb'] ) ? $instance['show_thumb'] : '' );
		$display_meta 	= ( ! empty( $instance['display_meta'] ) ? $instance['display_meta'] : '' );
		$display_order 	= ( ! empty( $instance['display_order'] ) ? $instance['display_order'] : '' );

		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'codexin-core' ) ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" placeholder="<?php echo esc_html__( 'Ex: Recent Posts', 'codexin-core' ) ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'num_posts' ) ); ?>"><?php echo esc_html__( 'Number of Posts to Show:', 'codexin-core' ) ?></label>
			<input type="number" class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'num_posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'num_posts' ) ); ?>" value="<?php echo esc_attr( $num_posts ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title_len' ) ); ?>"><?php echo esc_html__( 'Title Length (In Characters): ', 'codexin-core' ) ?></label>
			<input type="number" class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'title_len' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_len' ) ); ?>" value="<?php echo esc_attr( $title_len ); ?>">
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php esc_attr( checked( $show_thumb, 'on' ) ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_thumb' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_thumb' ) ); ?>" /> 
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_thumb' ) ); ?>"><?php echo esc_html__( 'Display Post Featured Image?', 'codexin-core' ); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'display_order' ) ); ?>"><?php echo esc_html__( 'Choose The Order to Display Posts:', 'codexin-core' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'display_order' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'display_order' ) ); ?>" class="widefat">
				<?php
				$disp_opt = array(
						__( 'Descending', 'codexin-core' ) 	=> 'DESC',
						__( 'Ascending', 'codexin-core' ) 	=> 'ASC',
						);
				foreach ( $disp_opt as $opt => $value ) {
					echo '<option value="' . esc_attr( $value ) . '" id="' . esc_attr( $value ) . '"', $display_order === $value ? ' selected="selected"' : '', '>', esc_html( $opt ), '</option>';
				}
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'display_meta' ) ); ?>"><?php echo esc_html__( 'Select Post Meta to Display:', 'codexin-core' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'display_meta' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'display_meta' ) ); ?>" class="widefat">
				<?php
				$options = array(
						__( 'Display Post Date', 'codexin-core' ),
						__( 'Display Comments Count', 'codexin-core' ),
						);
				foreach ( $options as $option ) {
					$opt = strtolower( str_replace( ' ', '-', $option ) );
					echo '<option value="' . esc_attr( $opt ) . '" id="' . esc_attr( $opt ) . '"', $display_meta === $opt ? ' selected="selected"' : '', '>', esc_html( $option ), '</option>';
				}
				?>
			</select>
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

		$instance = array();

		// Updating to the latest values.
		$instance['title'] 			= ( ! empty( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '' );
		$instance['num_posts'] 		= ( ! empty( $new_instance['num_posts'] ) ? absint( strip_tags( $new_instance['num_posts'] ) ) : 0 );
		$instance['title_len'] 		= ( ! empty( $new_instance['title_len'] ) ? absint( strip_tags( $new_instance['title_len'] ) ) : 0 );
		$instance['show_thumb'] 	= strip_tags( $new_instance['show_thumb'] );
		$instance['display_meta'] 	= strip_tags( $new_instance['display_meta'] );
		$instance['display_order'] 	= strip_tags( $new_instance['display_order'] );

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

		$num_posts 		= absint( $instance['num_posts'] );
		$title_len 		= absint( $instance['title_len'] );
		$show_thumb 	= $instance['show_thumb'];
		$display_meta 	= $instance['display_meta'];
		$display_order 	= $instance['display_order'];
		$display_meta_a = 'display-post-date';
		$display_meta_b = 'display-comments-count';

		$posts_args = array(
			'post_type'			=> 'post',
			'posts_per_page'	=> $num_posts,
			'order'				=> $display_order,
			'ignore_sticky_posts' 	=> 1,
		);

		$posts_query = new WP_Query( $posts_args );

		printf( '%s', $args['before_widget'] );

		if ( ! empty( $instance['title'] ) ) {
			printf( '%s' . apply_filters( 'widget_title', $instance['title'] ) . '%s', $args['before_title'], $args['after_title'] );
		}

		if ( $posts_query->have_posts() ) {

			while ( $posts_query->have_posts() ) {
				$posts_query->the_post();

				// Alt tag.
				$image_alt = ( ! empty( codexin_retrieve_alt_tag() ) ) ? codexin_retrieve_alt_tag() : get_the_title();

				// Post thumbnail.
				$thumbnail_size = 'codexin-core-square-one';
				$post_thumbnail = ( has_post_thumbnail() ) ? get_the_post_thumbnail_url( get_the_ID(), $thumbnail_size ) : '';

				echo '<div class="posts-single media">';
					if ( 'on' === $instance['show_thumb'] ) {
						if ( ! empty( $post_thumbnail ) ) {
							echo '<div class="post-thumbnail">';
								echo '<a href="' . esc_url( get_the_permalink() ) . '"><img src="' . esc_url( $post_thumbnail ) . '" alt="' . esc_attr( $image_alt ) . '"/><div class="overlay"></div></a>';
							echo '</div> <!-- end of posts-thumbnail -->';
						}
					}
					echo '<div class="post-content media-body">';
						echo '<h4><a href="' . esc_url( get_the_permalink() ) . '">';
							if ( function_exists( 'codexin_char_limit' ) ) {
								echo apply_filters( 'the_title', codexin_char_limit( $title_len, 'title' ) );
							} else {
								echo esc_html( wp_trim_words( get_the_title(), $title_len ) );
							}
						echo '</a></h4>';
						if ( $display_meta === $display_meta_a ) {
							echo '<p class="post-date">' . esc_html( date( get_option( 'date_format' ) ) ) . '</p>';
						}

						if ( $display_meta === $display_meta_b ) {
							echo '<p class="post-comments"><i class="fa fa-comments"></i> ' . absint( get_comments_number() ) . '</p>';
						}

					echo '</div><!-- end of post-content -->';
				echo '</div><!-- end of posts-single -->';
			} // End while().
		} // End if().

		wp_reset_postdata();

		printf( '%s', $args['after_widget'] );
	}
}
