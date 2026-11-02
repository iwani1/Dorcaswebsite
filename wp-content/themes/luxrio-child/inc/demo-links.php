<?php
/**
 * Repair the demo's links and vendor references on the front end.
 *
 * The demo shipped with its own URLs baked into menus, buttons and widgets:
 * links to the theme author's demo store, duplicate `-2` pages left behind by
 * the import, and an Instagram strip pointing at instagram.com rather than the
 * client's profile.
 *
 * Rather than asking for a hundred small edits across Elementor and the menu
 * editor, the URLs are rewritten on their way out. Each rule retires itself:
 * once the real link is stored, the string it looks for no longer exists and
 * the replacement does nothing.
 *
 * @package luxrio-child
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'QUEENDOR_INSTAGRAM' ) ) {
	define( 'QUEENDOR_INSTAGRAM', 'https://www.instagram.com/queendor_fashionhouse/' );
}

/**
 * Absolute URLs that should never appear on the site.
 *
 * @return array<string, string>
 */
function queendor_link_map() {
	return array(
		// The theme author's demo store — clicking these left the site entirely.
		'https://wordpress.vecurosoft.com/luxrio/shop/'    => home_url( '/shop/' ),
		'https://wordpress.vecurosoft.com/luxrio/shop'     => home_url( '/shop/' ),
		'https://wordpress.vecurosoft.com/luxrio/contact/' => home_url( '/contact/' ),
		'https://wordpress.vecurosoft.com/luxrio/contact'  => home_url( '/contact/' ),
		'https://wordpress.vecurosoft.com/luxrio/404page'  => home_url( '/' ),
	);
}

/**
 * Replace the demo's duplicate page slugs with the real WooCommerce pages.
 *
 * These are relative paths, matching both bare and absolute forms.
 *
 * @param string $subject Any string.
 * @return string
 */
function queendor_repair_duplicate_slugs( $subject ) {
	return str_replace(
		array( '/shop-2/', '/cart-2/', '/checkout-2/', '/my-account-2/' ),
		array( '/shop/', '/cart/', '/checkout/', '/my-account/' ),
		$subject
	);
}

/**
 * Rewrite known-bad URLs in a block of markup.
 *
 * @param string $content Markup.
 * @return string
 */
function queendor_repair_links( $content ) {
	if ( ! is_string( $content ) || '' === $content ) {
		return $content;
	}

	foreach ( queendor_link_map() as $from => $to ) {
		$content = str_replace( $from, $to, $content );
	}

	$content = queendor_repair_duplicate_slugs( $content );

	// The demo's Instagram strip links to the bare domain. The trailing quote
	// keeps this from touching a real post permalink if one is added later.
	$content = str_replace(
		'https://www.instagram.com/"',
		esc_url( QUEENDOR_INSTAGRAM ) . '"',
		$content
	);

	/**
	 * Filter whether "GHC" is normalised to the cedi sign.
	 *
	 * @param bool $normalise Default true.
	 */
	if ( apply_filters( 'queendor_normalise_currency', true ) ) {
		$content = preg_replace( '/\bGHC\s?/u', '₵', $content );
	}

	return $content;
}

/**
 * Elementor widgets and post content.
 */
add_filter( 'elementor/widget/render_content', 'queendor_repair_links', 5 );
add_filter( 'the_content', 'queendor_repair_links', 5 );

/**
 * Menu items.
 *
 * Skipped in the admin so the menu editor keeps showing what is actually
 * stored, not the rewritten version.
 *
 * @param object $item Menu item.
 * @return object
 */
function queendor_repair_menu_item( $item ) {
	if ( is_admin() || ! is_object( $item ) || empty( $item->url ) ) {
		return $item;
	}

	$item->url = queendor_repair_links( $item->url );

	return $item;
}
add_filter( 'wp_setup_nav_menu_item', 'queendor_repair_menu_item' );

/**
 * The megamenu shortcode builds its own markup outside the widget filter.
 *
 * @param string $output Menu HTML.
 * @return string
 */
function queendor_repair_menu_output( $output ) {
	if ( is_admin() ) {
		return $output;
	}

	return queendor_repair_links( $output );
}
add_filter( 'wp_nav_menu', 'queendor_repair_menu_output' );
