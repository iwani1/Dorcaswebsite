<?php
/**
 * Dress the site in the client's logo colours.
 *
 * The palette is two sampled values — Adinkra Teal #0B4B4C from the D
 * monogram and Crown Gold #C8AC77 from the name and the crown — expanded into
 * full ramps by tools/brand_palette.py and emitted as tokens by
 * tools/build-brand-assets.py. Nothing here is hand-written CSS: both
 * stylesheets are generated, so the shop and the client's preview page cannot
 * drift apart.
 *
 * Load order matters. The parent theme prints its own option colours inline in
 * the head, so these load last and win.
 *
 * @package luxrio-child
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'QUEENDOR_TEAL' ) ) {
	define( 'QUEENDOR_TEAL', '#0b4b4c' );
}
if ( ! defined( 'QUEENDOR_GOLD' ) ) {
	define( 'QUEENDOR_GOLD', '#c8ac77' );
}

/**
 * Tokens first, then the components that read them.
 */
function queendor_brand_colours() {
	$dir = get_stylesheet_directory_uri() . '/assets/css';

	wp_enqueue_style(
		'queendor-brand-tokens',
		$dir . '/brand-tokens.css',
		array( 'luxrio-child-style' ),
		queendor_version()
	);

	wp_enqueue_style(
		'queendor-brand-components',
		$dir . '/brand-components.css',
		array( 'queendor-brand-tokens' ),
		queendor_version()
	);

	wp_enqueue_style(
		'queendor-brand-light',
		$dir . '/brand-light.css',
		array( 'queendor-brand-components' ),
		queendor_version()
	);
}
add_action( 'wp_enqueue_scripts', 'queendor_brand_colours', 30 );

/**
 * Light storefront, on by default.
 *
 * The demo's black shell is Elementor content rather than a theme setting, so
 * there is nothing in the customiser to switch — it is overridden in CSS and
 * gated behind a body class, which means one filter turns it back off without
 * editing a stylesheet.
 *
 * @return bool
 */
function queendor_light_storefront() {
	return (bool) apply_filters( 'queendor_light_storefront', true );
}

/**
 * Add the body class the light stylesheet hangs off.
 *
 * @param array $classes Body classes.
 * @return array
 */
function queendor_light_body_class( $classes ) {
	if ( queendor_light_storefront() ) {
		$classes[] = 'qd-light';
	}
	return $classes;
}
add_filter( 'body_class', 'queendor_light_body_class' );

/**
 * Colour the mobile browser chrome to match the header.
 */
function queendor_theme_colour_meta() {
	printf( '<meta name="theme-color" content="%s">' . "\n", esc_attr( QUEENDOR_TEAL ) );
}
add_action( 'wp_head', 'queendor_theme_colour_meta', 1 );
