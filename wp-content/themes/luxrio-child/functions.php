<?php
/**
 * Luxrio Child — Queen Dor's.
 *
 * The parent theme's enqueue is kept as-is; everything added for the client
 * lives in inc/, one file per concern, so each piece can be removed on its
 * own without touching the rest.
 *
 * @package luxrio-child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Child theme version, used to bust the asset cache.
 *
 * @return string
 */
function queendor_version() {
	return wp_get_theme()->get( 'Version' );
}

/**
 * Enqueue the parent style, the child style, then the components.
 *
 * @return void
 */
function luxrio_child_enqueue_styles() {

	wp_enqueue_style( 'luxrio-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'luxrio-child-style', get_stylesheet_directory_uri() . '/style.css', array( 'luxrio-style' ), queendor_version() );

	wp_enqueue_style(
		'queendor-components',
		get_stylesheet_directory_uri() . '/assets/css/queendor.css',
		array( 'luxrio-child-style' ),
		queendor_version()
	);
}
add_action( 'wp_enqueue_scripts', 'luxrio_child_enqueue_styles', 100000 );

require_once get_stylesheet_directory() . '/inc/rebrand.php';
require_once get_stylesheet_directory() . '/inc/symbol-guide.php';
require_once get_stylesheet_directory() . '/inc/ring-size.php';

/*
 * The product blocks talk to WooCommerce classes directly, so they are only
 * loaded once WooCommerce is confirmed present — a deactivated WooCommerce
 * must not white-screen the whole site.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require_once get_stylesheet_directory() . '/inc/product-blocks.php';
}
