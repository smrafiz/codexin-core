<?php
/**
 * The file Contains all properties & attributes of the Custom Posts Type
 * And Taxonomies used in plugin
 *
 * @package     Codexin Core
 * @category    Core
 * @since       1.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Class to register Custom Post Type.
 *
 * @since 1.0
 */
class Codexin_Register_CPT {

	/**
	 * Custom Post Type name.
	 *
	 * @access public
	 * @since  1.0
	 * @var    string
	 */
	public $post_type_name;

	/**
	 * Custom Post Type arguments.
	 *
	 * @access public
	 * @since  1.0
	 * @var    array
	 */
	public $post_type_args;

	/**
	 * Custom Post Type labels.
	 *
	 * @access public
	 * @since  1.0
	 * @var    array
	 */
	public $post_type_labels;

	/**
	 * Taxonomy labels.
	 *
	 * @access public
	 * @since  1.0
	 * @var    array
	 */
	public $taxonomy_labels;

	/**
	 * Taxonomy args.
	 *
	 * @access public
	 * @since  1.0
	 * @var    array
	 */
	public $taxonomy_args;

	/**
	 * Class constructor.
	 *
	 * @param  string $name Name of Custom Post Type.
	 * @param  array  $args Arguments for the Custom Post Type.
	 * @param  array  $labels labels for the Custom Post Type.
	 * @access public
	 * @since  1.0
	 */
	public function __construct( $name, $args = array(), $labels = array() ) {

		// Set some important variables.
		$this->post_type_name  	 = self::cx_uglify( $name );
		$this->post_type_args    = $args;
		$this->post_type_labels  = $labels;

		// Register the post type, if the post type does not already exist.
		if ( ! post_type_exists( $this->post_type_name ) ) {

			// Registering the Custom Post Type.
			add_action( 'init', array( $this, 'cx_core_register_post_type' ) );

			// Flush Rewrite Rules.
			add_action( 'init', array( $this, 'cx_core_flush_rewrite_rules' ) );

			// Custom messages.
			add_filter( 'post_updated_messages', array( $this, 'codexin_core_updated_messages' ) );

			// Custom Title placeholders.
			add_filter( 'enter_title_here', array( $this, 'codexin_core_title_placeholder' ), 0, 2 );
		}
	}

	/**
	 * Method to register the post type.
	 *
	 * @access public
	 * @since  1.0
	 */
	public function cx_core_register_post_type() {

		// Capitilize the words and make it plural.
		$name       = self::cx_beautify( $this->post_type_name );
		$plural     = self::cx_pluralize( $name );

		// Setting the default labels.
		$labels = array_merge(

			// Defaults.
			array(
				/* translators: %s: post type plural name */
				'name'                  => sprintf( esc_html_x( '%s', 'post type general name', 'codexin-core' ), $plural ),
				/* translators: %s: post type singular name */
				'singular_name'         => sprintf( esc_html_x( '%s', 'post type singular name', 'codexin-core' ), $name ),
				/* translators: %s: post type name */
				'add_new'               => sprintf( esc_html_x( 'Add New', '%s', 'codexin-core' ), strtolower( $name ) ),
				/* translators: %s: post type name */
				'add_new_item'          => sprintf( esc_html__( 'Add New %s', 'codexin-core' ), $name ),
				/* translators: %s: post type name */
				'edit_item'             => sprintf( esc_html__( 'Edit %s', 'codexin-core' ), $name ),
				/* translators: %s: post type name */
				'new_item'              => sprintf( esc_html__( 'New %s', 'codexin-core' ), $name ),
				/* translators: %s: post type plural name */
				'all_items'             => sprintf( esc_html__( 'All %s', 'codexin-core' ), $plural ),
				/* translators: %s: post type name */
				'view_item'             => sprintf( esc_html__( 'View %s', 'codexin-core' ), $name ),
				/* translators: %s: post type plural name */
				'search_items'          => sprintf( esc_html__( 'Search %s', 'codexin-core' ), $plural ),
				/* translators: %s: post type plural name */
				'not_found'             => sprintf( esc_html__( 'No %s found', 'codexin-core' ), strtolower( $plural ) ),
				/* translators: %s: post type plural name */
				'not_found_in_trash'    => sprintf( esc_html__( 'No %s found in Trash', 'codexin-core' ), strtolower( $plural ) ),
				/* translators: %s: post type plural name */
				'parent_item_colon'     => sprintf( esc_html__( 'Parent %s: ', 'codexin-core' ), $plural ),
				'menu_name'             => $plural,
			),
			// Given labels.
			$this->post_type_labels
		);

		// Setting the default arguments.
		$args = array_merge(

			// Defaults.
			array(
				'label'                 => $plural,
				'labels'                => $labels,
				'menu_icon'				=> 'dashicons-admin-customizer',
				'public'                => true,
				'show_ui'               => true,
				'has_archive'			=> true,
				'publicly_queryable'	=> true,
				'query_var'				=> true,
				'rewrite'				=> true,
				'capability-type'		=> 'post',
				'hierarchical'			=> true,
				'supports'				=> array(
					'title',
					'editor',
					'excerpt',
					'thumbnail',
				),
				'show_in_nav_menus'     => true,
				'menu_position'			=> 30,
			),
			// Given args.
			$this->post_type_args
		);

		// Register the post type.
		register_post_type( $this->post_type_name, $args );
	}

	/**
	 * Method to attach the taxonomy to the post type.
	 *
	 * @param  string $name Name of the Custom Post Type.
	 * @param  array  $args Arguments for the Taxonomy.
	 * @param  array  $labels labels for the Taxonomy.
	 * @access public
	 * @since  1.0
	 */
	public function cx_core_register_taxonomy( $name, $args = array(), $labels = array() ) {
		if ( ! empty( $name ) ) {

			// Name of the post type.
			$post_type_name = $this->post_type_name;

			// Taxonomy properties.
			$taxonomy_name      	  = self::cx_get_slug( $name );
			$this->taxonomy_labels    = $labels;
			$this->taxonomy_args      = $args;

			if ( ! taxonomy_exists( $taxonomy_name ) ) {

				// Creating the taxonomy and attaching it to the object type (post type).
				$name       = self::cx_beautify( $name );
				$plural     = self::cx_pluralize( $name );
				$cx_name 	= strpos( $taxonomy_name, 'tag' ) !== false ? self::cx_pluralize( 'Tag' ) : self::cx_pluralize( 'Category' );

				// Setting the default labels.
				$labels = array_merge(

					// Defaults.
					array(
						/* translators: %s: taxonomy plural name */
						'name'                  => sprintf( esc_html_x( '%s', 'taxonomy general name', 'codexin-core' ), $plural ),
						/* translators: %s: taxonomy singular name */
						'singular_name'         => sprintf( esc_html_x( '%s', 'taxonomy singular name', 'codexin-core' ), $name ),
						/* translators: %s: taxonomy plural name */
						'search_items'          => sprintf( esc_html__( 'Search %s', 'codexin-core' ), $plural ),
						/* translators: %s: taxonomy plural name */
						'all_items'             => sprintf( esc_html__( 'All %s', 'codexin-core' ), $plural ),
						/* translators: %s: taxonomy name */
						'parent_item'           => sprintf( esc_html__( 'Parent %s', 'codexin-core' ), $name ),
						/* translators: %s: taxonomy name */
						'parent_item_colon'     => sprintf( esc_html__( 'Parent %s:', 'codexin-core' ), $name ),
						/* translators: %s: taxonomy name */
						'edit_item'             => sprintf( esc_html__( 'Edit %s', 'codexin-core' ), $name ),
						/* translators: %s: taxonomy name */
						'update_item'           => sprintf( esc_html__( 'Update %s', 'codexin-core' ), $name ),
						/* translators: %s: taxonomy name */
						'add_new_item'          => sprintf( esc_html__( 'Add New %s', 'codexin-core' ), $name ),
						/* translators: %s: taxonomy name */
						'new_item_name'         => sprintf( esc_html__( 'New %s Name', 'codexin-core' ), $name ),
						/* translators: %s: taxonomy modified name */
						'menu_name'             => sprintf( esc_html__( '%s', 'codexin-core' ), $cx_name ),
					),
					// Given labels.
					$this->taxonomy_labels
				);

				// Setting the default arguments.
				$args = array_merge(

					// Defaults.
					array(
						'label'                 => $plural,
						'labels'                => $labels,
						'hierarchical' 			=> strpos( $taxonomy_name, 'tag' ) !== false ? false : true,
						'public'                => true,
						'has_archive'			=> true,
						'show_admin_column' 	=> true,
						'query_var' 			=> true,
						'show_ui'               => true,
						'show_in_nav_menus'     => true,
						'rewrite' 			=> array(
							'slug' => $taxonomy_name,
						),
					),
					// Given args.
					$this->taxonomy_args
				);

				// Adding the taxonomy to the post type.
				add_action( 'init',
					function() use ( $taxonomy_name, $post_type_name, $args ) {
						register_taxonomy( $taxonomy_name, $post_type_name, $args );
					}
				);
			} else {
				// If the taxonomy already exists, attaching it to the object type (post type).
				add_action( 'init',
					function() use ( $taxonomy_name, $post_type_name ) {
						register_taxonomy_for_object_type( $taxonomy_name, $post_type_name );
					}
				);
			} // End if().
		} // End if().
	}

	/**
	 * Custom Post Type update messages.
	 *
	 * @param  array $messages Existing post update messages.
	 * @return array Amended post update messages with new CPT update messages.
	 * @access public
	 * @since  1.0
	 */
	public function codexin_core_updated_messages( $messages ) {
		$post             = get_post();
		$post_type        = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );
		$post_type_name   = self::cx_beautify( $this->post_type_name );

		$messages[$this->post_type_name] = array(
			0  => '',
			1  => esc_html__( $post_type_name . ' updated.', 'codexin-core' ),
			2  => esc_html__( 'Custom field updated.', 'codexin-core' ),
			3  => esc_html__( 'Custom field deleted.', 'codexin-core' ),
			4  => esc_html__( $post_type_name . ' updated.', 'codexin-core' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( esc_html__( $post_type_name . ' restored to revision from %s', 'codexin-core' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => esc_html__( $post_type_name . ' published.', 'codexin-core' ),
			7  => esc_html__( $post_type_name . ' saved.', 'codexin-core' ),
			8  => esc_html__( $post_type_name . ' submitted.', 'codexin-core' ),
			9  => sprintf(
				/* translators: Publish box date format. */
				esc_html__( ucwords( $this->post_type_name ) . ' scheduled for: <strong>%1$s</strong>.', 'codexin-core' ),
				date_i18n( esc_html__( 'M j, Y @ G:i', 'codexin-core' ), strtotime( $post->post_date ) )
			),
			10 => esc_html__( ucwords( $this->post_type_name ) . ' draft updated.', 'codexin-core' ),
		);

		if ( $post_type_object->publicly_queryable && $this->post_type_name === $post_type ) {
			$permalink = get_permalink( $post->ID );

			/* translators: %s: URL of View Post & Name of the Custom Post Type */
			$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), esc_html__( 'View ' . ucwords( $this->post_type_name ), 'codexin-core' ) );
			$messages[ $post_type ][1] .= $view_link;
			$messages[ $post_type ][6] .= $view_link;
			$messages[ $post_type ][9] .= $view_link;

			/* translators: %s: URL of Preview Post & Name of the Custom Post Type */
			$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
			$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), esc_html__( 'Preview ' . ucwords( $this->post_type_name ), 'codexin-core' ) );
			$messages[ $post_type ][8]  .= $preview_link;
			$messages[ $post_type ][10] .= $preview_link;
		}

		return $messages;
	}

	/**
	 * Custom Post Type title placeholder text.
	 *
	 * @param  string $title Placeholder Title text.
	 * @param  Object $post Post Object.
	 * @access public
	 * @since  1.0
	 */
	public function codexin_core_title_placeholder( $title, $post ) {
		$post_type_name = $this->post_type_name;
		$name           = self::cx_beautify( $post_type_name );

		if ( $post_type_name === $post->post_type ) {
			/* translators: post type name */
			$cx_title = sprintf( esc_html__( 'Enter %s Title', 'codexin-core' ), $name );
			return $cx_title;
		}

		return $title;
	}

	/**
	 * Method to beautify string.
	 *
	 * @static
	 * @param  string $string String to beautify.
	 * @access private
	 * @since  1.0
	 */
	private static function cx_beautify( $string ) {
		return ucwords( str_replace( '_', ' ', $string ) );
	}

	/**
	 * Method to uglify string.
	 *
	 * @static
	 * @param  string $string String to uglify.
	 * @access private
	 * @since  1.0
	 */
	private static function cx_uglify( $string ) {
		return strtolower( str_replace( ' ', '_', $string ) );
	}

	/**
	 * Method to Pluralize string.
	 *
	 * @static
	 * @param  string $string String to Pluralize.
	 * @access private
	 * @since  1.0
	 */
	private static function cx_pluralize( $string ) {
		$last = $string[strlen( $string ) - 1];

		if ( 'y' === $last ) {
			$cut = substr( $string, 0, -1 );
			// convert y to ies.
			$plural = $cut . 'ies';
		} else {
			// just attach an s.
			$plural = $string . 's';
		}

		return $plural;
	}

	/**
	 * Method to get slug.
	 *
	 * @static
	 * @param  string $name String to get slug.
	 * @access private
	 * @since  1.0
	 */
	private static function cx_get_slug( $name = null ) {
		// If no name set use the post type name.
		if ( ! isset( $name ) ) {
			$name = $this->post_type_name;
		}
		// Name to lower case.
		$name = strtolower( $name );
		// Replace spaces with hyphen.
		$name = str_replace( ' ', '-', $name );
		// Replace underscore with hyphen.
		$name = str_replace( '_', '-', $name );

		return $name;
	}

	/**
	 * Method to check if we need to flush rewrite rules.
	 *
	 * @access public
	 * @since  1.0
	 */
	public function cx_core_flush_rewrite_rules() {
		$has_been_flushed = get_option( $this->post_type_name . '_flush_rewrite_rules' );
		// if we haven't flushed re-write rules, flush them (should be triggered only once).
		if ( true !== $has_been_flushed ) {
			flush_rewrite_rules( true );
			update_option( $this->post_type_name . '_flush_rewrite_rules', true );
		}
	}
}
