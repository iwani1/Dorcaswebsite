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

/**
 * Replace the demo palette inside Elementor's own kit.
 *
 * Elementor stores its global colours as custom properties declared on the
 * body's `elementor-kit-N` class, and the kit came from the demo — so its
 * "primary" is still the demo's orange #ff3e01. The home page survives only
 * because its one emphasised word is overridden by ID in brand-light.css;
 * every page built from here would have painted orange.
 *
 * Redeclaring the properties on `body[class*="elementor-kit-"]` outranks the
 * kit's own rule, so the palette is fixed wherever a global colour is used —
 * no DB edit, no Elementor clicking, and the kit screen can be set properly
 * later without undoing anything.
 *
 * Secondary kit names are included defensively: an unknown name costs nothing,
 * a missed one leaks orange. Turn this off with:
 *   add_filter( 'queendor_brand_kit_palette', '__return_false' );
 */
function queendor_brand_kit_palette() {
	if ( ! apply_filters( 'queendor_brand_kit_palette', true ) ) {
		return;
	}

	$palette = array(
		// Elementor's standard four.
		'--e-global-color-primary'               => QUEENDOR_TEAL,
		'--e-global-color-secondary'             => QUEENDOR_GOLD,
		'--e-global-color-text'                  => '#211F1C',
		'--e-global-color-accent'                => '#8F6B28',
		// The Luxrio kit's own names — the one that produced the orange span.
		'--e-global-color-luxrio_opt_primary'    => QUEENDOR_TEAL,
		'--e-global-color-luxrio_opt_secondary'  => QUEENDOR_GOLD,
		'--e-global-color-luxrio_opt_accent'     => '#8F6B28',
		'--e-global-color-luxrio_opt_title'      => QUEENDOR_TEAL,
		'--e-global-color-luxrio_opt_heading'    => QUEENDOR_TEAL,
		'--e-global-color-luxrio_opt_body'       => '#3F4A49',
		'--e-global-color-luxrio_opt_text'       => '#3F4A49',
	);

	$css = '';
	foreach ( $palette as $property => $value ) {
		$css .= $property . ':' . $value . ';';
	}

	printf(
		'<style id="queendor-kit-palette">:root,body[class*="elementor-kit-"]{%s}</style>' . "\n",
		$css // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- literals above.
	);
}
add_action( 'wp_head', 'queendor_brand_kit_palette', 99 );
