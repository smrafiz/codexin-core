<?php
/**
 * Load all metaboxes in plugin
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
 * Metabox class.
 *
 * @since 1.0
 */
class Codexin_Metaboxes {

	/**
	 * Metabox prefix.
	 *
	 * @access private
	 * @since  1.0
	 * @var    string
	 */
	private $prefix = 'codexin_';

	/**
	 * Metaboxes.
	 *
	 * @access private
	 * @since  1.0
	 * @var    array
	 */
	private $meta_boxes = array();

	/**
	 * Class constructor.
	 *
	 * @access public
	 * @since  1.0
	 */
	public function __construct() {
		add_filter( 'rwmb_meta_boxes', array( $this, 'codexin_core_register_metaboxes' ) );
	}

	/**
	 * Registering of metaboxes
	 *
	 * @access public
	 * @since  1.0
	 */
	public function codexin_core_register_metaboxes() {

		// 'Post' Metaboxes.
		$this->post_metaboxes();

		// 'Page' Metaboxes.
		$this->page_metaboxes();

		return $this->meta_boxes;
	}

	/**
	 * Building up metaboxes for 'Post'.
	 *
	 * @access private
	 * @since  1.0
	 */
	private function post_metaboxes() {

		// Gallery Metabox.
		$this->meta_boxes[] = array(
			'id'            => 'codexin-gallery-meta',
			'title'         => esc_html__( 'Gallery', 'codexin-core' ),
			'post_types'    => array( 'post' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'fields'        => array(
				array(
					'name'  => esc_html__( 'Create Gallery', 'codexin-core' ),
					'desc'  => esc_html__( 'Add images to create a slideshow', 'codexin-core' ),
					'id'    => $this->prefix . 'gallery',
					'type'  => 'image_advanced',
				),
			),
		);

		// Video Metabox.
		$this->meta_boxes[] = array(
			'id'            => 'codexin-video-meta',
			'title'         => esc_html__( 'Video', 'codexin-core' ),
			'post_types'    => array( 'post' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'fields'        => array(
				array(
					'name'  => esc_html__( 'Embed Video', 'codexin-core' ),
					'desc'  =>
					sprintf(
						'%1$s<a href="%2$s" target="_blank">%3$s</a>',
						esc_html__( 'Insert Video Links from Youtube, Vimeo and ', 'codexin-core' ),
						esc_url( '//codex.wordpress.org/Embeds' ),
						esc_html__( 'all Video supported sites by WordPress.', 'codexin-core' )
					),
					'id'    => $this->prefix . 'video',
					'type'  => 'oembed',
					'size'  => 95,
				),
			),
		);

		// Audio Metabox.
		$this->meta_boxes[] = array(
			'id'            => 'codexin-audio-meta',
			'title'         => esc_html__( 'Audio', 'codexin-core' ),
			'post_types'    => array( 'post' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'fields'        => array(
				array(
					'name'  => esc_html__( 'Embed Audio', 'codexin-core' ),
					'desc'  =>
					sprintf(
						'%1$s<a href="%2$s" target="_blank">%3$s</a>',
						esc_html__( 'Insert Audio Links from Soundcloud, Spotify and ', 'codexin-core' ),
						esc_url( '//codex.wordpress.org/Embeds' ),
						esc_html__( 'all Music supported sites by WordPress.', 'codexin-core' )
					),
					'id'    => $this->prefix . 'audio',
					'type'  => 'oembed',
					'size'  => 95,
				),
			),
		);

		// Quote Metabox.
		$this->meta_boxes[] = array(
			'id'            => 'codexin-quote-meta',
			'title'         => esc_html__( 'Quote', 'codexin-core' ),
			'post_types'    => array( 'post' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'fields'        => array(
				array(
					'name'  => esc_html__( 'Quote Text', 'codexin-core' ),
					'desc'  => esc_html__( 'Insert The Quote Text', 'codexin-core' ),
					'id'    => $this->prefix . 'quote_text',
					'type'  => 'textarea',
					'rows'  => '5',
				),

				array(
					'name'  => esc_html__( 'Name', 'codexin-core' ),
					'desc'  => esc_html__( 'Author Name', 'codexin-core' ),
					'id'    => $this->prefix . 'quote_name',
					'type'  => 'text',
					'size'  => 80,
				),

				array(
					'name'  => esc_html__( 'Source', 'codexin-core' ),
					'desc'  => esc_html__( 'Source URL', 'codexin-core' ),
					'id'    => $this->prefix . 'quote_source',
					'type'  => 'url',
					'size'  => 80,
				),
			),
		);

		// Link Metabox.
		$this->meta_boxes[] = array(
			'id'            => 'codexin-link-meta',
			'title'         => esc_html__( 'Link', 'codexin-core' ),
			'post_types'    => array( 'post' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'fields'        => array(
				array(
					'name'  => esc_html__( 'Link URL', 'codexin-core' ),
					'desc'  => esc_html__( 'Insert Link URL', 'codexin-core' ),
					'id'    => $this->prefix . 'link_url',
					'type'  => 'text',
					'size'  => 95,
				),

				array(
					'name'  => esc_html__( 'Link Text', 'codexin-core' ),
					'desc'  => esc_html__( 'Insert Link Text', 'codexin-core' ),
					'id'    => $this->prefix . 'link_text',
					'type'  => 'text',
					'size'  => 95,
				),

				array(
					'name'    => esc_html__( 'Open link in a new window?', 'codexin-core' ),
					'desc'    => esc_html__( 'Select "yes" to open link in a new window', 'codexin-core' ),
					'id'      => $this->prefix . 'link_target',
					'type'    => 'select',
					'options' => array(
						'_blank' => esc_html__( 'Yes', 'codexin-core' ),
						'_self'  => esc_html__( 'No', 'codexin-core' ),
					),

					'std'     => '_blank',
					'size'    => 95,
				),

				array(
					'name'  => esc_html__( 'Link Relation (Optional)', 'codexin-core' ),
					'desc'  => esc_html__( 'Set the link "rel" attribute(ex: nofollow, dofollow, etc.)', 'codexin-core' ),
					'id'    => $this->prefix . 'link_rel',
					'type'  => 'text',
					'size'  => 95,
				),
			),
		);
	}

	/**
	 * Building up metaboxes for 'Page'.
	 *
	 * @access private
	 * @since  1.0
	 */
	private function page_metaboxes() {

		// Page Background, Title and breadcrumb Metabox.
		$this->meta_boxes[] = array(
			'id'            => 'codexin_page_background_meta_common',
			'title'         => esc_html__( 'Page Title Settings', 'codexin-core' ),
			'post_types'    => array( 'page' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'fields'        => array(
				array(
					'name'      => esc_html__( 'Disable Page Title Area?', 'codexin-core' ),
					'desc'      => esc_html__( 'Checking this will disable the Page Title Section', 'codexin-core' ),
					'id'        => $this->prefix . 'disable_page_title',
					'type'      => 'checkbox',
					'std'       => 0,
				),

				array(
					'name'      => esc_html__( 'Page Title Background Image', 'codexin-core' ),
					'desc'      => esc_html__( 'Upload Page Header Background Image. The Image will be functional for all page templates except \'Page - Home Page\'. This image will override the page title background image set from theme customizer ', 'codexin-core' ),
					'id'        => $this->prefix . 'page_background',
					'type'      => 'background',
				),

				array(
					'name'      => esc_html__( 'Page Title Alignment', 'codexin-core' ),
					'desc'      => esc_html__( 'Please Select the Page title alignment to override. If you want default settings, choose \'Global Settings\'', 'codexin-core' ),
					'id'        => $this->prefix . 'page_title_alignment',
					'type'      => 'select',
					'options'   => array(
							'global' => esc_html__( 'Global Settings', 'codexin-core' ),
							'left'   => esc_html__( 'Left', 'codexin-core' ),
							'center' => esc_html__( 'Center', 'codexin-core' ),
							'right'  => esc_html__( 'Right', 'codexin-core' ),
						),

					'std'       => '0',
					'size'  => 95,
				),

				array(
					'name'      => esc_html__( 'Breadcrumbs Alignment', 'codexin-core' ),
					'desc'      => esc_html__( 'Please Select the Breadcrumbs alignment to override. If you want default settings, choose \'Global Settings\'', 'codexin-core' ),
					'id'        => $this->prefix . 'page_breadcrumb_alignment',
					'type'      => 'select',
					'options'   => array(
							'global'        => esc_html__( 'Global Settings', 'codexin-core' ),
							'flex-start'    => esc_html__( 'Left', 'codexin-core' ),
							'center'        => esc_html__( 'Center', 'codexin-core' ),
							'flex-end'      => esc_html__( 'Right', 'codexin-core' ),
						),

					'std'       => '0',
					'size'  => 95,
				),
			),
		);

		// Page Slider Metabox.
		$this->meta_boxes[] = array(
			'id'            => 'codexin_page_slider_meta',
			'title'         => esc_html__( 'Page Slider Settings', 'codexin-core' ),
			'post_types'    => array( 'page' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'fields'        => array(
				array(
					'name'          => esc_html__( 'Select a Page Slider', 'codexin-core' ),
					'desc'          => empty( array_filter( self::get_smart_slider() ) ) ? esc_html__( 'Smart Slider is not Activated. Please Activate Smart Slider and try again.', 'codexin-core' ) : esc_html__( 'Select Slider Name to show on Page header, Please note that, Slider will be functional for \'Page - Home Page\' template only  ', 'codexin-core' ),
					'id'            => $this->prefix . 'page_slider',
					'type'          => 'select',
					'options'       => self::get_smart_slider(),
					'placeholder'   => esc_html__( 'Select a Slider', 'codexin-core' ),
					'clone'         => false,
				),
			),
		);
	}

	/**
	 * Get Smart Slider Name & ID.
	 *
	 * @static
	 * @access private
	 * @since  1.0
	 */
	private static function get_smart_slider() {

		// Retrieving the created slider names and ids from Smart Slider.
		if ( class_exists( 'SmartSlider3' ) ) {
			global $wpdb;

			$slider_id 		= array();
			$slider_name 	= array();

			$sql = 'SELECT id, title FROM ' . $wpdb->prefix . 'nextend2_smartslider3_sliders';

			$smartsliders = wp_cache_get( md5( $sql ), 'codexin_smartslider3' );

			if ( false === $smartsliders ) {
				$smartsliders = $wpdb->get_results( $wpdb->prepare( 'SELECT id, title FROM %1$snextend2_smartslider3_sliders',  $wpdb->prefix ), OBJECT );
				wp_cache_add( md5( $sql ), $smartsliders, 'codexin_smartslider3' );
			}

			foreach ( $smartsliders as $slide ) {
				$slider_id[] 	= $slide->id;
				$slider_name[] 	= $slide->title;
			}

			$sliders = array_combine( $slider_id, $slider_name );
		} else {
			$sliders = array();
		}

		return $sliders;
	}
}
