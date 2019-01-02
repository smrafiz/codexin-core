<?php
/**
 * Load all plugin's required files.
 * Also initialize the core functionalities.
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
 * Plugin loader class.
 *
 * @since 1.0
 */
class Codexin_Loader extends Codexin_Base {

	/**
	 * Required files.
	 *
	 * @var array $files 	File list to load
	 * @access private
	 * @since  1.0
	 */
	private $files = array(
		'shortcodes/shortcodes',
		'helpers/helpers',
	);

	/**
	 * Widgets list
	 *
	 * @var array $widget_list	Widget list
	 * @access private
	 * @since  1.0
	 */
	private $widget_list = array(
		'Codexin_Instagram_Widget',
		'Codexin_Popular_Posts',
		'Codexin_Recent_Posts',
		'Codexin_Social_Share',
	);

	/**
	 * Class constructor.
	 *
	 * @access public
	 * @since  1.0
	 */
	public function __construct() {
		parent::__construct(
			array(
				plugin_dir_path( __FILE__ ) . 'inc/classes/',
				plugin_dir_path( __FILE__ ) . 'inc/widgets/',
			)
		);
	}

	/**
	 * Defining plugin constants.
	 *
	 * @access private
	 * @since  1.0
	 */
	private function init_constants() {

		// Plugin version.
		define( 'CODEXIN_CORE_VERSION', '1.0' );

		// System constants.
		define( 'CODEXIN_CORE_ROOT_DIR', wp_normalize_path( trailingslashit( plugin_dir_path( __FILE__ ) ) ) );
		define( 'CODEXIN_CORE_INC_DIR', trailingslashit( CODEXIN_CORE_ROOT_DIR . 'inc' ) );
		define( 'CODEXIN_CORE_WDGT_DIR', trailingslashit( CODEXIN_CORE_INC_DIR . 'widgets' ) );
		define( 'CODEXIN_CORE_ROOT_URL', wp_normalize_path( plugin_dir_url( __FILE__ ) ) );
		define( 'CODEXIN_CORE_ASSET_URL', wp_normalize_path( trailingslashit( CODEXIN_CORE_ROOT_URL . 'assets' ) ) );
		define( 'CODEXIN_CORE_JS_URL', trailingslashit( CODEXIN_CORE_ASSET_URL . 'js' ) );
		define( 'CODEXIN_CORE_CSS_URL', trailingslashit( CODEXIN_CORE_ASSET_URL . 'css' ) );
	}

	/**
	 * Initialize the plugin.
	 *
	 * @access public
	 * @since  1.0
	 */
	public function init() {

		// Defined Constants.
		$this->init_constants();

		// Initiating plugin core.
		$codexin_core = new Codexin_Core();
		$codexin_core->init();

		// Registering Custom Post Types.
		$this->init_custom_post_types();

		// Registering Metaboxes.
		$init_codexin_metaboxes = new Codexin_Metaboxes();

		// Loading required templates.
		$init_template_loader = new Codexin_Template_Loader(
			array(
				'testimonial',
				'client',
			)
		);

		// Registering Custom Widgets.
		add_action( 'widgets_init', array( $this, 'register_custom_widgets' ) );

		// Requiring helpers and shortcodes.
		$this->init_files();
	}

	/**
	 * Registering Custom Widgets
	 *
	 * @access public
	 * @since  1.0
	 */
	public function register_custom_widgets() {
		foreach ( $this->widget_list as $widget ) {
			register_widget( $widget );
		}
	}

	/**
	 * Registering required Custom Post Types.
	 *
	 * @access private
	 * @since  1.0
	 */
	private function init_custom_post_types() {

		// Registering Custom Post Type 'Client'.
		$clients = new Codexin_Register_CPT( 'Client' );

		// Registering Custom Post Type 'Testimonial'.
		$testimonial = new Codexin_Register_CPT( 'Testimonial' );
		$testimonial->post_type_args = array(
			'menu_icon'				=> 'dashicons-universal-access-alt',
			'has_archive'			=> true,
			'hierarchical'			=> false,
			'supports'				=> array(
				'title',
				'editor',
			),
			'menu_position'			=> 60,
		);

		// Registering Custom taxonomies for 'Testimonial'.
		$testimonial->cx_core_register_taxonomy( 'Testimonial Category' );
		$testimonial->cx_core_register_taxonomy( 'Testimonial Tag' );
	}

	/**
	 * Loading of helpers and shortcodes
	 *
	 * @access private
	 * @since  1.0
	 */
	private function init_files() {
		foreach ( $this->files as $file ) {
			parent::require_file( CODEXIN_CORE_INC_DIR . "$file.php" );
		}
	}
}
