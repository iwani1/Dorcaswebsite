<?php
/**
 * Trim Cart and Checkout out of the header menu.
 *
 * The menu carries eight items — Jewelry House, Wholesale, FAQ's, Contact,
 * Shop, Cart, Checkout, My account — and at 1440px it wraps onto a second line,
 * so the header runs to 176px instead of 96px. Cart and Checkout are the two
 * that are already reachable from the header itself: the cart icon with its
 * count sits top right, and the cart page leads to checkout in one click.
 *
 * Removing them here rather than in Appearance → Menus means the change travels
 * with the theme and cannot be lost to a menu re-import, and it does not touch
 * the stored menu at all — switch the filter off and the items are back.
 *
 * @package luxrio-child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Drop the items whose title or URL says cart or checkout.
 *
 * Matching on both the label and the URL, because a cart item is often labelled
 * with its live count ("Cart (2)") and would not match the word alone.
 *
 * @param array $items Menu item objects.
 * @param array $args  Arguments passed to wp_nav_menu().
 * @return array
 */
function queendor_trim_header_menu( $items, $args ) {
	if ( is_admin() ) {
		return $items;
	}

	if ( ! apply_filters( 'queendor_trim_header_menu', true, $args ) ) {
		return $items;
	}

	$needles = apply_filters( 'queendor_trim_menu_needles', array( 'cart', 'checkout' ) );

	$kept = array();

	foreach ( $items as $item ) {
		$title = strtolower( wp_strip_all_tags( isset( $item->title ) ? $item->title : '' ) );
		$url   = strtolower( isset( $item->url ) ? $item->url : '' );

		$drop = false;

		foreach ( (array) $needles as $needle ) {
			if ( '' === $needle ) {
				continue;
			}
			if ( false !== strpos( $title, $needle ) || false !== strpos( $url, '/' . $needle ) ) {
				$drop = true;
				break;
			}
		}

		if ( ! $drop ) {
			$kept[] = $item;
		}
	}

	return $kept;
}
add_filter( 'wp_nav_menu_objects', 'queendor_trim_header_menu', 20, 2 );

/**
 * Put a single item back without a code change.
 *
 * add_filter( 'queendor_trim_menu_needles', function ( $n ) {
 *     return array( 'checkout' );   // keeps Cart, drops Checkout
 * } );
 */
