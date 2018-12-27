<?php
/**
 * Plugin Name:   Codexin Core
 * Plugin URI:    http://themeitems.com
 * Description:   A plugin to carry out all the core functionalities for PowerPro theme
 * Author:        Themeitems
 * Author URI:    http://themeitems.com
 * Version:       1.0
 * Text Domain:   codexin-core
 *
 * @package     Codexin Core
 * @category    Core
 * @since       1.0
 */

if ( defined( 'ABSPATH' ) && ! defined( 'CODEXIN_CORE_VERSION' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'inc/class-codexin-base.php';
	require_once plugin_dir_path( __FILE__ ) . 'class-codexin-loader.php';

	// Initializing the plugin.
	$codexin_loader = new Codexin_Loader();
	$codexin_loader->init();
}
