<?php
/**
 * The plugin core action class
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
 * Action class for the Plugin
 *
 * @since v1.0
 */
class Codexin_Core {
	/**
	 * Initialize the actions.
	 *
	 * @access public
	 * @since  1.0
	 */
	public function init() {

		// Plugin Textdomain.
		add_action( 'plugins_loaded', array( $this, 'codexin_core_load_textdomain' ) );

		// Enquequeing styles and scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'codexin_core_styles' ), 99 );
		add_action( 'wp_enqueue_scripts', array( $this, 'codexin_core_script' ), 99 );

		// Enquequeing admin styles and scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'codexin_core_admin_styles' ), 99 );

		// Adding custom image sizes.
		add_action( 'init', array( $this, 'codexin_core_add_image_sizes' ) );

		// Initialization of photoswipe.
		add_action( 'wp_footer', array( $this, 'codexin_core_photoswipe_init' ) );
	}

	/**
	 * Load plugin text domain.
	 *
	 * @access public
	 * @since  1.0
	 */
	public function codexin_core_load_textdomain() {
		load_plugin_textdomain( 'codexin-core', false, CODEXIN_CORE_ROOT_DIR . '/languages' );
	}

	/**
	 * Enqueques styles
	 *
	 * @access public
	 * @since  1.0
	 */
	public function codexin_core_styles() {
		wp_enqueue_style( 'swiper', CODEXIN_CORE_CSS_URL . 'swiper.min.css', false, '4.4.2','all' );
		wp_enqueue_style( 'photoswipe', CODEXIN_CORE_CSS_URL . 'photoswipe.min.css', false, '4.1.2','all' );
	}

	/**
	 * Enqueques scripts
	 *
	 * @access public
	 * @since  1.0
	 */
	public function codexin_core_script() {
		wp_enqueue_script( 'swiper', CODEXIN_CORE_JS_URL . 'swiper.min.js', array( 'jquery' ), '4.4.2', true );
		wp_enqueue_script( 'photoswipe', CODEXIN_CORE_JS_URL . 'photoswipe.js', array( 'jquery' ), '4.1.2', true );
	}

	/**
	 * Enqueque admin styles
	 *
	 * @access public
	 * @since  1.0
	 */
	public function codexin_core_admin_styles() {
		wp_enqueue_style( 'codexin-admin-stylesheet', CODEXIN_CORE_CSS_URL . 'admin/admin-metabox-styles.css', false, '1.0','all' );
	}

	/**
	 * Adding custom image sizes.
	 *
	 * @access public
	 * @since  1.0
	 */
	public function codexin_core_add_image_sizes() {
		add_image_size( 'codexin-core-rect-one', 600, 400, true );
		add_image_size( 'codexin-core-rect-two', 570, 464, true );
		add_image_size( 'codexin-core-square-one', 220, 220, true );
		add_image_size( 'codexin-core-square-two', 500, 500, true );
	}

	/**
	 * Adding required Photoswipe initialization markups.
	 *
	 * @access public
	 * @since  1.0
	 */
	public function codexin_core_photoswipe_init() {
		$result = '';

		ob_start();
		?>
		<!-- Initializing Photoswipe -->
		<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="pswp__bg"></div>
			<div class="pswp__scroll-wrap">
				<div class="pswp__container">
					<div class="pswp__item"></div>
					<div class="pswp__item"></div>
					<div class="pswp__item"></div>
				</div>
				<div class="pswp__ui pswp__ui--hidden">
					<div class="pswp__top-bar">
						<div class="pswp__counter"></div>
						<button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
						<button class="pswp__button pswp__button--share" title="Share"></button>
						<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
						<button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
						<div class="pswp__preloader">
							<div class="pswp__preloader__icn">
								<div class="pswp__preloader__cut">
									<div class="pswp__preloader__donut"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
						<div class="pswp__share-tooltip"></div>
					</div>
					<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
					</button>
					<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
					</button>
					<div class="pswp__caption">
						<div class="pswp__caption__center"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- end of Photoswipe -->
		<?php
		$result .= ob_get_clean();
		printf( '%s', $result );
	}
}
