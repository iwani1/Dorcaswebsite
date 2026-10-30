<?php
/**
 * Plugin Name:       Queen Dor's — Demo Cleanup
 * Description:       Trashes the Luxrio demo content without touching the client's ten products. Dry run first, trash rather than delete, and nothing is removed until you tick it.
 * Version:           1.0.1
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Arena
 * License:           GPL-2.0-or-later
 *
 * Install, activate, use, then delete. It is deliberately not a mu-plugin:
 * a destructive tool should not stay switched on where nobody remembers it.
 *
 * @package queendor-cleanup
 */

defined( 'ABSPATH' ) || exit;

const QCLEAN_CLIENT_SKU_PREFIX = 'QD-';
const QCLEAN_CAP               = 'manage_options';
const QCLEAN_ACTION            = 'queendor_cleanup_run';

/**
 * Pages that must never be trashed, whatever else is selected.
 *
 * @return int[]
 */
function qclean_protected_pages() {
	$protected = array(
		get_option( 'page_on_front' ),
		get_option( 'page_for_posts' ),
	);

	foreach ( array( 'woocommerce_shop_page_id', 'woocommerce_cart_page_id', 'woocommerce_checkout_page_id', 'woocommerce_myaccount_page_id', 'woocommerce_terms_page_id' ) as $option ) {
		$protected[] = get_option( $option );
	}

	return array_values( array_filter( array_map( 'absint', $protected ) ) );
}

/**
 * Client products, identified by SKU prefix.
 *
 * @return int[]
 */
function qclean_client_product_ids() {
	if ( ! function_exists( 'wc_get_products' ) ) {
		return array();
	}

	$ids = array();

	foreach ( wc_get_products( array( 'limit' => -1, 'return' => 'ids', 'status' => array( 'publish', 'draft', 'private' ) ) ) as $id ) {
		$sku = (string) get_post_meta( $id, '_sku', true );

		if ( 0 === strpos( $sku, QCLEAN_CLIENT_SKU_PREFIX ) ) {
			$ids[] = (int) $id;
		}
	}

	return $ids;
}

/**
 * Products that are not the client's.
 *
 * Guarded: if no client products exist, the caller must refuse, because the
 * rule would otherwise match every product on the site.
 *
 * @return int[]
 */
function qclean_demo_product_ids() {
	if ( ! function_exists( 'wc_get_products' ) ) {
		return array();
	}

	$ids = array();

	foreach ( wc_get_products( array( 'limit' => -1, 'return' => 'ids', 'status' => array( 'publish', 'draft', 'private', 'pending' ) ) ) as $id ) {
		$sku = (string) get_post_meta( $id, '_sku', true );

		if ( 0 !== strpos( $sku, QCLEAN_CLIENT_SKU_PREFIX ) ) {
			$ids[] = (int) $id;
		}

		// Variations inherit no SKU of their own in the demo, so collect them too.
		if ( 'product_variation' === get_post_type( $id ) ) {
			$ids[] = (int) $id;
		}
	}

	return $ids;
}

/**
 * Demo blog posts — the 2024 filler that arrives with the theme.
 *
 * @return int[]
 */
function qclean_demo_post_ids() {
	$query = new WP_Query(
		array(
			'post_type'      => 'post',
			'post_status'    => array( 'publish', 'draft', 'pending', 'future' ),
			'posts_per_page' => -1,
			'fields'         => 'ids',
		)
	);

	$ids = array();

	foreach ( $query->posts as $id ) {
		$post = get_post( $id );

		if ( ! $post instanceof WP_Post ) {
			continue;
		}

		// Demo posts were imported with back-dated stamps.
		$backdated = strtotime( $post->post_date_gmt . ' UTC' ) < strtotime( '2025-01-01 UTC' );

		// WordPress's own first post keeps *today's* date, so a date rule alone
		// misses it — which is exactly what happened on the live site.
		$default_post = ( 'hello-world' === $post->post_name )
			|| false !== strpos( $post->post_content, 'Welcome to WordPress' );

		if ( $backdated || $default_post ) {
			$ids[] = absint( $id );
		}
	}

	return $ids;
}

/**
 * Menu registration.
 *
 * @return void
 */
function qclean_admin_menu() {
	add_management_page(
		__( "Queen Dor's — Demo Cleanup", 'queendor-cleanup' ),
		__( "Queen Dor's Cleanup", 'queendor-cleanup' ),
		QCLEAN_CAP,
		'queendor-cleanup',
		'qclean_render_page'
	);
}
add_action( 'admin_menu', 'qclean_admin_menu' );

/**
 * Shared row renderer.
 *
 * @param string $title Row title.
 * @param string $meta  Secondary text.
 * @return void
 */
function qclean_row( $title, $meta = '' ) {
	printf(
		'<li><strong>%s</strong>%s</li>',
		esc_html( $title ),
		'' !== $meta ? ' <span style="color:#646970">— ' . esc_html( $meta ) . '</span>' : ''
	);
}

/**
 * Preview list, capped so the page stays readable.
 *
 * @param int[]  $ids       Post IDs.
 * @param string $post_type Post type.
 * @param int    $limit     How many to show.
 * @return void
 */
function qclean_preview( $ids, $post_type, $limit = 12 ) {
	if ( ! $ids ) {
		return;
	}

	echo '<ul style="margin:8px 0 14px 18px;list-style:disc;max-height:260px;overflow:auto;">';

	foreach ( array_slice( $ids, 0, $limit ) as $id ) {
		qclean_row( get_the_title( $id ) ?: '#' . $id, '#' . $id . ' · ' . get_post_status( $id ) );
	}

	if ( count( $ids ) > $limit ) {
		qclean_row( sprintf( '…and %d more', count( $ids ) - $limit ) );
	}

	echo '</ul>';
}

/**
 * The admin screen.
 *
 * @return void
 */
function qclean_render_page() {
	if ( ! current_user_can( QCLEAN_CAP ) ) {
		return;
	}

	$client_ids = qclean_client_product_ids();
	$demo_ids   = qclean_demo_product_ids();
	$post_ids   = qclean_demo_post_ids();
	$protected  = qclean_protected_pages();
	$pages      = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => array( 'publish', 'draft', 'private', 'pending' ),
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		)
	);

	echo '<div class="wrap">';
	echo '<h1>' . esc_html__( "Queen Dor's — Demo Cleanup", 'queendor-cleanup' ) . '</h1>';

	echo '<div class="notice notice-warning inline"><p><strong>'
		. esc_html__( 'Everything here moves content to the Trash, where it can be restored for 30 days. Nothing is permanently deleted, and nothing happens until you press a button.', 'queendor-cleanup' )
		. '</strong></p></div>';

	/* ---------------------------------------------------------------- products */
	echo '<h2>' . esc_html__( '1. Demo products', 'queendor-cleanup' ) . '</h2>';
	printf(
		'<p>%s</p>',
		sprintf(
			/* translators: 1: client count, 2: demo count */
			esc_html__( 'Client products (SKU starting %1$s): %2$s. Everything else: %3$s.', 'queendor-cleanup' ),
			'<code>QD-</code>',
			'<strong>' . count( $client_ids ) . '</strong>',
			'<strong>' . count( $demo_ids ) . '</strong>'
		)
	);

	if ( ! $client_ids ) {
		echo '<div class="notice notice-error inline"><p>'
			. esc_html__( 'No product with a QD- SKU was found, so trashing "everything else" would remove every product on the site. Import the catalogue first.', 'queendor-cleanup' )
			. '</p></div>';
	} elseif ( $demo_ids ) {
		qclean_preview( $demo_ids, 'product' );
		qclean_button( 'products', sprintf( 'Trash %d demo products', count( $demo_ids ) ) );
	} else {
		echo '<p><em>' . esc_html__( 'Nothing left to remove.', 'queendor-cleanup' ) . '</em></p>';
	}

	/* ------------------------------------------------------------------- posts */
	echo '<h2>' . esc_html__( '2. Demo blog posts', 'queendor-cleanup' ) . '</h2>';
	printf( '<p>%s</p>', sprintf( esc_html__( 'Posts published before 2025: %s.', 'queendor-cleanup' ), '<strong>' . count( $post_ids ) . '</strong>' ) );

	if ( $post_ids ) {
		qclean_preview( $post_ids, 'post' );
		qclean_button( 'posts', sprintf( 'Trash %d demo posts', count( $post_ids ) ) );
	} else {
		echo '<p><em>' . esc_html__( 'Nothing left to remove.', 'queendor-cleanup' ) . '</em></p>';
	}

	/* ------------------------------------------------------------------- pages */
	echo '<h2>' . esc_html__( '3. Demo pages', 'queendor-cleanup' ) . '</h2>';
	echo '<p>' . esc_html__( 'Tick only what you are replacing. The front page, posts page and every WooCommerce page are protected and cannot be selected — trashing those would take the shop apart.', 'queendor-cleanup' ) . '</p>';

	echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
	wp_nonce_field( QCLEAN_ACTION );
	echo '<input type="hidden" name="action" value="' . esc_attr( QCLEAN_ACTION ) . '">';
	echo '<input type="hidden" name="qclean_kind" value="pages">';
	echo '<table class="widefat striped" style="max-width:820px;"><thead><tr>';
	echo '<th style="width:40px;"></th><th>' . esc_html__( 'Page', 'queendor-cleanup' ) . '</th><th>' . esc_html__( 'Slug', 'queendor-cleanup' ) . '</th><th>' . esc_html__( 'Status', 'queendor-cleanup' ) . '</th></tr></thead><tbody>';

	foreach ( $pages as $page ) {
		$is_protected = in_array( (int) $page->ID, $protected, true );

		echo '<tr><td>';
		if ( $is_protected ) {
			echo '<span title="' . esc_attr__( 'Protected', 'queendor-cleanup' ) . '">🔒</span>';
		} else {
			printf(
				'<input type="checkbox" name="qclean_ids[]" value="%1$d" id="qc-%1$d">',
				(int) $page->ID
			);
		}
		echo '</td><td>';
		printf( '<label for="qc-%1$d">%2$s</label>', (int) $page->ID, esc_html( get_the_title( $page ) ?: '(no title)' ) );
		echo '</td><td><code>' . esc_html( $page->post_name ) . '</code></td><td>';
		echo esc_html( $page->post_status );
		echo '</td></tr>';
	}

	echo '</tbody></table>';
	submit_button( __( 'Trash selected pages', 'queendor-cleanup' ), 'secondary', 'submit', false );
	echo '</form>';

	/* ------------------------------------------------------------------ footer */
	echo '<h2>' . esc_html__( '4. Demo images', 'queendor-cleanup' ) . '</h2>';
	printf(
		'<p>%s</p>',
		sprintf(
			/* translators: %s: attachment count */
			esc_html__( 'The Media Library holds %s files from the demo. They are not deleted here — the client\'s product photography will sit alongside them, and a wrong bulk delete is unrecoverable. Prune them by hand in Media once the real catalogue is photographed.', 'queendor-cleanup' ),
			'<strong>' . count( get_posts( array( 'post_type' => 'attachment', 'post_status' => 'inherit', 'posts_per_page' => -1, 'fields' => 'ids' ) ) ) . '</strong>'
		)
	);

	echo '</div>';
}

/**
 * A single-button form for the bulk actions.
 *
 * @param string $kind  What is being trashed.
 * @param string $label Button label.
 * @return void
 */
function qclean_button( $kind, $label ) {
	echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="margin:0 0 26px;">';
	wp_nonce_field( QCLEAN_ACTION );
	echo '<input type="hidden" name="action" value="' . esc_attr( QCLEAN_ACTION ) . '">';
	printf( '<input type="hidden" name="qclean_kind" value="%s">', esc_attr( $kind ) );
	submit_button( $label, 'secondary', 'submit', false );
	echo '</form>';
}

/**
 * Handle the trash actions.
 *
 * @return void
 */
function qclean_handle() {
	if ( ! current_user_can( QCLEAN_CAP ) ) {
		wp_die( esc_html__( 'Not allowed.', 'queendor-cleanup' ), 403 );
	}

	check_admin_referer( QCLEAN_ACTION );

	$kind  = isset( $_POST['qclean_kind'] ) ? sanitize_key( wp_unslash( $_POST['qclean_kind'] ) ) : '';
	$ids   = array();
	$count = 0;

	switch ( $kind ) {
		case 'products':
			if ( ! qclean_client_product_ids() ) {
				wp_die( esc_html__( 'Refusing: no client products exist, so this would trash the entire catalogue.', 'queendor-cleanup' ) );
			}
			$ids = qclean_demo_product_ids();
			break;

		case 'posts':
			$ids = qclean_demo_post_ids();
			break;

		case 'pages':
			$raw       = isset( $_POST['qclean_ids'] ) ? (array) wp_unslash( $_POST['qclean_ids'] ) : array();
			$protected = qclean_protected_pages();
			$ids       = array_diff( array_map( 'absint', $raw ), $protected );
			break;

		default:
			wp_die( esc_html__( 'Unknown action.', 'queendor-cleanup' ) );
	}

	foreach ( $ids as $id ) {
		if ( $id && wp_trash_post( $id ) ) {
			++$count;
		}
	}

	wp_safe_redirect(
		add_query_arg(
			array(
				'page'        => 'queendor-cleanup',
				'qclean_done' => $count,
			),
			admin_url( 'tools.php' )
		)
	);
	exit;
}
add_action( 'admin_post_' . QCLEAN_ACTION, 'qclean_handle' );

/**
 * Confirmation notice.
 *
 * @return void
 */
function qclean_notice() {
	if ( empty( $_GET['qclean_done'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return;
	}

	printf(
		'<div class="notice notice-success is-dismissible"><p>%s</p></div>',
		sprintf(
			/* translators: %d: number of items trashed */
			esc_html__( '%d items moved to the Trash. Restore them from Pages / Products if that was a mistake.', 'queendor-cleanup' ),
			(int) $_GET['qclean_done'] // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		)
	);
}
add_action( 'admin_notices', 'qclean_notice' );
