<?php
/**
 * The Codexin Core autoloader.
 * Handles locating and loading other class-files.
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
 * Autoload plugin classes.
 *
 * @since 1.0
 */
class Codexin_Base {

	/**
	 * Directory Paths.
	 *
	 * @var array $absolute_dirs	Absoute directory list
	 * @access private
	 * @since  1.0
	 */
	private $absolute_dirs = array();

	/**
	 * Class constructor.
	 *
	 * @param  array $absolute_dirs Absolute directory for class files.
	 * @access public
	 * @since  1.0
	 */
	public function __construct( array $absolute_dirs ) {

		// Directory assingment.
		$this->absolute_dirs = $absolute_dirs;

		// Register autoloader for plugin classes.
		spl_autoload_register( array( $this, 'autoload_class' ) );

		// Fallback for autoload.
		if ( ! class_exists( 'Codexin_Core' ) ) {
			$this->fallback();
		}
	}

	/**
	 * The class autoloader.
	 * Finds the path to a class that we're requiring and includes the file.
	 *
	 * @param  string $class The name of the class we're trying to load.
	 * @access private
	 * @since  1.0
	 */
	private function autoload_class( $class ) {

		if ( 0 !== strpos( $class, 'Codexin_' ) ) {
			return;
		}

		foreach ( $this->absolute_dirs as $key => $absolute_dir ) {
			$file = $absolute_dir . strtolower( str_replace( '_', '-', "class-$class.php" ) );
			if ( file_exists( $file ) ) {
				include_once wp_normalize_path( $file );
				return true;
			}
		}
	}

	/**
	 * Fallback for autoload
	 *
	 * @access private
	 * @since  1.0
	 */
	private function fallback() {
		$files = array(
			'inc/classes/class-codexin-core',
			'inc/classes/class-codexin-register-cpt',
			'inc/classes/class-codexin-metaboxes',
			'inc/classes/class-codexin-template-loader',
			'inc/widgets/class-codexin-instagram-widget',
		);

		foreach ( $files as $file ) {
			self::require_file( plugin_dir_path( dirname( __FILE__ ) ) . "$file.php" );
		}
	}

	/**
	 * If a file exists, require it from the file system.
	 *
	 * @static
	 * @param  string $file The file to require.
	 * @return bool True if the file exists, false if not.
	 * @access protected
	 * @since  1.0
	 */
	protected static function require_file( $file ) {
		if ( file_exists( $file ) ) {
			require_once sanitize_text_field( $file );
			return true;
		}

		return false;
	}
}
