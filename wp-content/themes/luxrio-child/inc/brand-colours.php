<?php
/**
 * Repaint the site in the client's logo colours.
 *
 * The logo is two colours: a deep teal and a warm gold. The parent theme
 * exposes almost all of its colour through CSS custom properties, so the
 * palette is set once and inherited everywhere.
 *
 * The same values can be typed into Theme Options → General → Primary Colour,
 * Secondary Colour and Heading Colour. Both work; this file also covers the
 * handful of places the theme hardcodes rather than uses a variable, and it
 * cannot be undone by an options reset.
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
 * Load the palette after the theme's own stylesheets and inline CSS.
 */
function queendor_brand_colours() {
	wp_enqueue_style(
		'queendor-brand-colours',
		get_stylesheet_directory_uri() . '/assets/css/brand-colours.css',
		array( 'luxrio-child-style' ),
		queendor_version()
	);
}
add_action( 'wp_enqueue_scripts', 'queendor_brand_colours', 30 );

/**
 * Give the browser the teal as its address-bar colour on mobile.
 */
function queendor_theme_colour_meta() {
	printf( '<meta name="theme-color" content="%s">' . "\n", esc_attr( QUEENDOR_TEAL ) );
}
add_action( 'wp_head', 'queendor_theme_colour_meta', 1 );
