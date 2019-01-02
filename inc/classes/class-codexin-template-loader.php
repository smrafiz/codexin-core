<?php
/**
 * Custom Template Loader for plugin
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
 * Class to locate template.
 *
 * @since 1.0
 */
class Codexin_Template_Loader {

	/**
	 * Custom Post Type Slug.
	 *
	 * @access private
	 * @since  1.0
	 * @var    array
	 */
	private $cpt_types = array();

	/**
	 * Class constructor.
	 *
	 * @param  array $args CPT slug name.
	 * @access public
	 * @since  1.0
	 */
	function __construct( array $args ) {

		// Getting the CPT Name.
		$this->cpt_types = $args;

		// Including the template.
		add_filter( 'template_include', array( $this, 'codexin_core_include_templates' ) );
	}

	/**
	 * Method to return template.
	 *
	 * @param  string $template The template.
	 * @access public
	 * @since  1.0
	 */
	public function codexin_core_include_templates( $template ) {

		foreach ( $this->cpt_types as $cpt ) {
			if ( get_post_type() === $cpt ) {
				return $this->codexin_core_get_custom_template( $cpt );
			}
		}

		return $template;
	}

	/**
	 * Method to get the templates.
	 *
	 * @param  string $cpt CPT slug name.
	 * @access private
	 * @since  1.0
	 */
	private function codexin_core_get_custom_template( $cpt ) {

		// Archive view template.
		if ( is_post_type_archive( $cpt ) ) {
			return $this->codexin_core_locate_template( $cpt, 'archive' );
		}

		// Single view template.
		if ( is_singular( $cpt ) ) {
			return $this->codexin_core_locate_template( $cpt, 'single' );
		}
	}

	/**
	 * Method to locate templates.
	 *
	 * @param  string $cpt CPT slug name.
	 * @param  string $type Type of the template.
	 * @access private
	 * @since  1.0
	 */
	private function codexin_core_locate_template( $cpt, $type ) {

		$theme_files = array( $type . '-' . $cpt . '.php', 'templates/' . $type . '-' . $cpt . '.php' );
		$exists_in_theme = locate_template( $theme_files, false );

		if ( '' !== $exists_in_theme ) {
			// Checking the template in theme first. If located, return the template.
			return $exists_in_theme;
		} else {
			// If template is not located in theme, return the default template from plugin.
			return CODEXIN_CORE_ROOT_DIR . 'templates/' . $type . '-' . $cpt . '.php';
		}
	}
}
