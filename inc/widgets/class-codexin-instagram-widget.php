<?php
/**
 * Instagram Widget
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
 * Instagram Widget Class
 *
 * @since v1.0
 */
class Codexin_Instagram_Widget extends WP_Widget {

	/**
	 * Class constructor.
	 *
	 * @access public
	 * @since  1.0
	 */
	public function __construct() {

		// Initializing the basic parameters.
		$widget_ops = array(
			'classname'     => esc_attr( 'codexin-instagram-widget' ),
			'description'   => esc_html__( 'Displays Your Latest Instagrams', 'codexin-core' ),
		);
		parent::__construct( 'codexin_instagram_widget', esc_html__( 'Codexin: Instagram Widget', 'codexin-core' ), $widget_ops );

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
		$title       = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$username    = ( ! empty( $instance['username'] ) ) ? $instance['username'] : '';
		$user_id     = ( ! empty( $instance['user_id'] ) ) ? $instance['user_id'] : '';
		$client_id   = ( ! empty( $instance['client_id'] ) ) ? $instance['client_id'] : '';
		$accss_token = ( ! empty( $instance['accss_token'] ) ) ? $instance['accss_token'] : '';
		$count       = ( ! empty( $instance['count'] ) ) ? $instance['count'] : '';
		$placeholder = ( ! empty( $instance['placeholder'] ) ) ? $instance['placeholder'] : '';

		$this->form_input(
			array(
				'label'       => esc_html__( 'Widget Title:', 'codexin-core' ),
				'name'        => $this->get_field_name( 'title' ),
				'id'          => $this->get_field_id( 'title' ),
				'type'        => 'text',
				'value'       => $title,
				'placeholder' => esc_html__( 'Ex: Instagram Feed', 'codexin-core' ),
			)
		);
		$this->form_input(
			array(
				'label'       => esc_html__( 'Username:', 'codexin-core' ),
				'name'        => $this->get_field_name( 'username' ),
				'id'          => $this->get_field_id( 'username' ),
				'type'        => 'text',
				'value'       => $username,
				'placeholder' => esc_html__( 'Insert User Name', 'codexin-core' ),
			)
		);
		$this->form_input(
			array(
				'label'       => esc_html__( 'User ID:', 'codexin-core' ),
				'name'        => $this->get_field_name( 'user_id' ),
				'id'          => $this->get_field_id( 'user_id' ),
				'type'        => 'text',
				'value'       => $user_id,
				'placeholder' => esc_html__( 'Insert User ID', 'codexin-core' ),
				'desc'        =>
					sprintf(
						'%1$s<a href="%2$s" target="_blank">%3$s</a>',
						esc_html__( 'Lookup your User ID from ', 'codexin-core' ),
						esc_url( '//ershad7.com/InstagramUserID/' ),
						esc_html__( 'here', 'codexin-core' )
					),
			)
		);
		$this->form_input(
			array(
				'label'       => esc_html__( 'Access Token:', 'codexin-core' ),
				'name'        => $this->get_field_name( 'accss_token' ),
				'id'          => $this->get_field_id( 'accss_token' ),
				'type'        => 'text',
				'value'       => $accss_token,
				'placeholder' => esc_html__( 'Insert Access Token', 'codexin-core' ),
				'desc'        =>
					sprintf(
						'%1$s<a href="%2$s" target="_blank">%3$s</a>',
						esc_html__( 'Generate Your Access Token from ', 'codexin-core' ),
						esc_url( '//instagram.pixelunion.net/' ),
						esc_html__( 'here', 'codexin-core' )
					),
			)
		);
		$this->form_input(
			array(
				'label'       => esc_html__( 'Client ID:', 'codexin-core' ),
				'name'        => $this->get_field_name( 'client_id' ),
				'id'          => $this->get_field_id( 'client_id' ),
				'type'        => 'text',
				'value'       => $client_id,
				'placeholder' => esc_html__( 'Insert Client ID', 'codexin-core' ),
				'desc'        =>
					sprintf(
						'%1$s<a href="%2$s" target="_blank">%3$s</a>',
						esc_html__( 'Register a new client from ', 'codexin-core' ),
						esc_url( '//instagram.com/developer/clients/manage/' ),
						esc_html__( 'here', 'codexin-core' )
					),
			)
		);
		$this->form_input(
			array(
				'label'       => esc_html__( 'Number of Photos to be Shown:', 'codexin-core' ),
				'name'        => $this->get_field_name( 'count' ),
				'id'          => $this->get_field_id( 'count' ),
				'type'        => 'number',
				'value'       => $count,
				'placeholder' => absint( '9' ),
			)
		);
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
		foreach ( array( 'title', 'username', 'user_id', 'accss_token', 'client_id', 'count' ) as $key => $value ) {
			$instance[$value] = sanitize_text_field( $new_instance[$value] );
		}

		return $instance;
	}

	/**
	 * Form inputs of widget
	 *
	 * @param  array $args Form parameters.
	 * @access public
	 * @since  1.0
	 */
	public function form_input( $args = array() ) {
		$args = wp_parse_args( $args,
			array(
				'label'       => '',
				'name'        => '',
				'id'          => '',
				'type'        => 'text',
				'value'       => '',
				'placeholder' => '',
				'desc'        => '',
			)
		);
		$label       = esc_html( $args['label'] );
		$name        = esc_html( $args['name'] );
		$id          = esc_html( $args['id'] );
		$type        = esc_html( $args['type'] );
		$value       = esc_html( $args['value'] );
		$placeholder = esc_html( $args['placeholder'] );
		$desc        = ! empty( $args['desc'] ) ? sprintf( '<span class="description">%1$s</span>', esc_html( $args['desc'] ) ) : '';

		printf(
			'<p><label for="%1$s">%2$s</label><input type="%3$s" class="widefat" name="%4$s" id="%1$s" value="%5$s" placeholder="%6$s" />%7$s</p>',
			$id,
			$label,
			$type,
			$name,
			$value,
			$placeholder,
			$desc
		);
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

		// Assigning or updating the values.
		$title    = ( ! empty( $instance['title'] ) ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$username = ( ! empty( $instance['username'] ) ) ? esc_attr( $instance['username'] ) : '';

		// Get instagrams.
		$cx_instagram = $this->get_instagrams_data(
			array(
				'user_id'     => $instance['user_id'],
				'client_id'   => $instance['client_id'],
				'accss_token' => $instance['accss_token'],
				'count'       => $instance['count'],
				'flush_cache' => false,
			)
		);

		// Check the parameters.
		if ( false !== $cx_instagram ) {

			printf( '%s', $args['before_widget'] );

			if ( ! empty( $title ) ) {
				printf(
					'%s' . apply_filters( 'widget_title', $title ) . '%s',
					$args['before_title'],
					$args['after_title']
				);
			}

			$ig_image_lo_res = apply_filters( 'codexin_lo_image_res', 'thumbnail' );
			$ig_image_hi_res = apply_filters( 'codexin_hi_image_res', 'standard_resolution' );
			?>

			<div class="instagram-images image-popup">

				<?php
				// Looping through the parameters.
				foreach ( $cx_instagram['data'] as $key => $ig_image ) {
					echo apply_filters(
						'codexin_ig_image_html',
						sprintf(
							'<figure>
								<a href="%1$s" data-size="640x640">
									<img src="%2$s" alt="Instagram Image" />
								</a>
								<figcaption class="visually-hidden">%3$s</figcaption>
							</figure>',
							esc_url( $ig_image['images'][ $ig_image_hi_res ]['url'] ),
							esc_url( $ig_image['images'][ $ig_image_lo_res ]['url'] ),
							esc_html( $ig_image['caption']['text'] )
						),
					$ig_image );
				}
				?>

			</div>
			<a href="<?php echo esc_url( '//instagram.com/' . esc_html( $username ) ); ?>" class='more' target='_blank'>
				<i>
					<?php
					/* translators: instagram username */
					printf( esc_html__( 'Follow %1$s @Instagram', 'codexin-core' ), esc_html( $username ) );
					?>
				</i>
			</a>

			<?php printf( '%s', $args['after_widget'] ); ?>

		<?php
		} elseif ( ( defined( 'WP_DEBUG' ) && true === WP_DEBUG )
			&& ( defined( 'WP_DEBUG_DISPLAY' )
			&& false !== WP_DEBUG_DISPLAY ) ) {
		?>
			<div class="cx-error"><p><?php esc_html_e( 'Error: We were unable to fetch your instagram feed.', 'codexin-core' ); ?></p></div>

		<?php
		} // End if().
	}

	/**
	 * Getting data from Instagram API.
	 *
	 * @param  array $args Instagram arguments.
	 * @access public
	 * @since  1.0
	 */
	public function get_instagrams_data( $args = array() ) {

		// Get args.
		$user_id        = ( ! empty( $args['user_id'] ) ) ? $args['user_id'] : '';
		$accss_token    = ( ! empty( $args['accss_token'] ) ) ? $args['accss_token'] : '';
		$client_id      = ( ! empty( $args['client_id'] ) ) ? $args['client_id'] : '';
		$count          = ( ! empty( $args['count'] ) ) ? $args['count'] : '';
		$flush          = ( ! empty( $args['flush_cache'] ) ) ? $args['flush_cache'] : '';

		// Check if all the fields are filled up.
		if ( empty( $client_id ) || empty( $user_id ) || empty( $accss_token ) ) {
			echo '<div class="cx-error"><p>' . esc_html__( 'Error: Please Provide Valid Instagram User ID, Client ID and Access Token.', 'codexin-core' ) . '</p></div>';
			return false;
		}

		// Get instagram URL by username and access token.
		$api_url = 'https://api.instagram.com/v1/users/' . esc_html( $user_id ) . '/media/recent/?access_token=' . esc_html( $accss_token );

		// Set transient key.
		$transient_key = $this->id;
		delete_transient( $this->id );

		// Set cache time.
		$cache_time = 10;

		// Attempt to fetch from transient.
		$data = get_transient( $transient_key );

		// If we're flushing or there's no transient.
		if ( $flush || false === ( $data ) ) {

			// Ping Instragram's API.
			$ig_ping = wp_remote_get(
				add_query_arg(
					array(
						'client_id' => esc_html( $client_id ),
						'count'     => absint( $count ),
					),
					esc_url( $api_url )
				)
			);

			// Check if the API is up.
			if ( ! 200 == wp_remote_retrieve_response_code( $ig_ping ) ) {
				return false;
			}

			// Parse the API data and store in a variable.
			$data = json_decode( wp_remote_retrieve_body( $ig_ping ), true );

			// Check the result whether its an array.
			if ( $data && ! is_array( $data ) ) {
				return false;
			}

			// Unserialize the results.
			$data = maybe_unserialize( $data );

			// Store Instagrams in a transient.
			set_transient( $transient_key, $data, 60 * $cache_time );
		}

		return $data;
	}
}
