<?php
/**
 * The file Contains all Shortcodes definitions
 *
 * @package     Codexin Core
 * @category    Shortcode
 * @since       1.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

add_action( 'init', 'codexin_core_shortcodes' );
if ( ! function_exists( 'codexin_core_shortcodes' ) ) {

	/**
	 * Registering shortcodes.
	 *
	 * @since  1.0
	 */
	function codexin_core_shortcodes() {

		// Shortcode names.
		$shortcodes = array(
			'cx_contacts',
			'cx_socials',
			'cx_social_share',
		);

		// Adding the shortcodes.
		foreach ( $shortcodes as $shortcode ) {
			add_shortcode( $shortcode, $shortcode . '_shortcode' );
		}
	}
}

/**
 * Shortcode Syntax:
 * [cx_contacts address="" phone="" phone_url="" fax="" email="" website=""]
 *
 * @param array $atts Arguments for the cx_contacts shortcode.
 */
function cx_contacts_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'address'		=> '',
			'phone'			=> '',
			'phone_url'		=> '',
			'fax'			=> '',
			'email'			=> '',
			'website'		=> '',
		),
		$atts
	);

	// Variables.
	$address 	= $atts['address'];
	$phone 		= $atts['phone'];
	$phone_url 	= $atts['phone_url'];
	$fax 		= $atts['fax'];
	$email 		= $atts['email'];
	$website 	= $atts['website'];

	$result = '';
	ob_start();
	?>
	
	<div class="cx-contacts">
		<?php if ( ! empty( $address ) ) { ?>
			<div class="contact-item contact-address">
				<span><span><?php echo esc_html__( 'Address:', 'codexin-core' ); ?></span><?php echo esc_html( $address ); ?></span>
			</div>
		<?php } ?>

		<?php if ( ( ! empty( $phone ) ) && ( ! empty( $phone_url ) ) ) { ?>
			<div class="contact-item contact-phone">
				<span><span><?php echo esc_html__( 'Telephone:', 'codexin-core' ); ?></span><a href="tel:<?php echo esc_attr( $phone_url ); ?>"><?php echo esc_html( $phone ); ?></a></span>
			</div>
		<?php } ?>

		<?php if ( ! empty( $fax ) ) { ?>
			<div class="contact-item contact-fax">
				<span><span><?php echo esc_html__( 'Fax:', 'codexin-core' ); ?></span><?php echo esc_html( $fax ); ?></span>
			</div>
		<?php } ?>

		<?php if ( ! empty( $email ) ) { ?>
			<div class="contact-item contact-email">
				<span><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></span>
			</div>
		<?php } ?>

		<?php if ( ! empty( $website ) ) { ?>
			<div class="contact-item contact-website">
				<span><a href="<?php echo esc_url( $website ); ?>"><?php echo esc_html( $website ); ?></a></span>
			</div>
		<?php } ?>
	</div> <!-- end of cx-contacts -->

	<?php
	$result .= ob_get_clean();
	return $result;
}

/**
 * Shortcode Syntax:
 * [cx_socials facebook="" twitter="" google_plus="" pinterest="" instagram="" linkedin="" dribbble="" flickr="" medium="" tumblr="" vimeo="" youtube="" reddit="" skype=""]
 *
 * @param array $atts Arguments for the cx_socials shortcode.
 */
function cx_socials_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'facebook'		=> '',
			'twitter'		=> '',
			'google_plus'	=> '',
			'pinterest'		=> '',
			'instagram'		=> '',
			'linkedin'		=> '',
			'dribbble'		=> '',
			'flickr'		=> '',
			'medium'		=> '',
			'tumblr'		=> '',
			'vimeo'			=> '',
			'youtube'		=> '',
			'reddit'		=> '',
			'skype'			=> '',
		),
		$atts
	);

	$result = '';
	ob_start();

	$social_array = array(
		'facebook'		=> $atts['facebook'],
		'twitter'		=> $atts['twitter'],
		'google_plus'	=> $atts['google_plus'],
		'pinterest'		=> $atts['pinterest'],
		'instagram'		=> $atts['instagram'],
		'linkedin'		=> $atts['linkedin'],
		'dribbble'		=> $atts['dribbble'],
		'flickr'		=> $atts['flickr'],
		'medium'		=> $atts['medium'],
		'tumblr'		=> $atts['tumblr'],
		'vimeo'			=> $atts['vimeo'],
		'youtube'		=> $atts['youtube'],
		'reddit'		=> $atts['reddit'],
		'skype'			=> $atts['skype'],
	);

	?>

		<!-- <div id="cx_socials" class="socials social-icons-round d-flex align-items-center justify-content-center justify-content-md-start"> -->
		<div id="cx_socials" class="socials social-icons-round">
			<ul class="list-inline">

				<?php
				foreach ( $social_array as $social_key => $social_value ) {
					if ( ! empty( $social_value ) ) {

						$key = ( 'google_plus' === $social_key ) ? str_replace( '_', '-', $social_key ) : $social_key;
					?>

						<li class="list-inline-item">
							<a href="<?php echo esc_url( $social_value ); ?>" class="bg-<?php echo esc_attr( $key ); ?>" title="<?php echo esc_attr( ucfirst( $key ) ); ?>" target="_blank">
								<i class="fa fa-<?php echo esc_attr( $key ); ?>"></i>
							</a>
						</li>

					<?php
					}
				}
				?>
			</ul>
		</div>
	<?php

	$result .= ob_get_clean();
	return $result;
}

/**
 * Shortcode Syntax:
 * [cx_social_share]
 *
 * @param array $atts Arguments for the cx_social_share shortcode.
 */
function cx_social_share_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(),
		$atts
	);
	$result = '';
	ob_start();
	global $post;
	$url = get_permalink( $post->ID );
	?>
		<div class="share socials share-links">
			<ul class="list-inline">
				<li class="list-inline-item caption"><?php esc_html_e( 'Share this post: ', 'codexin-core' ); ?></li>
				<li class="list-inline-item"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( $url ); ?>" class="bg-facebook" data-toggle="tooltip" data-position="top" data-original-title="Facebook" target="_blank"><i class="fa fa-facebook"></i><span>Share</span></a></li>
				<li class="list-inline-item"><a href="https://twitter.com/home?status=<?php echo esc_url( $url ); ?>" class="bg-twitter" data-toggle="tooltip" data-position="top" data-original-title="Twitter" target="_blank"><i class="fa fa-twitter"></i><span>Tweet</span></a></li>
				<li class="list-inline-item"><a href="https://plus.google.com/share?url=<?php echo esc_url( $url ); ?>" class="bg-google-plus" data-toggle="tooltip" data-position="top" data-original-title="Google Plus" target="_blank"><i class="fa fa-google-plus"></i><span>Google+</span></a></li>
				<li class="list-inline-item"><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url( $url ); ?>" class="bg-linkedin" data-toggle="tooltip" data-position="top" data-original-title="LinkedIn" target="_blank"><i class="fa fa-linkedin"></i><span>LinkedIn</span></a></li>
			</ul>
		</div>
	<?php

	$result .= ob_get_clean();
	return $result;
}
