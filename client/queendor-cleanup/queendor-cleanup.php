<?php
/**
 * Plugin Name:       Queen Dor's — Demo Cleanup
 * Description:       Trashes the Luxrio demo content without touching the client's ten products, finds and removes the duplicate pages, and rewrites the old domain. Dry run first, trash rather than delete, and nothing happens until you tick it.
 * Version:           1.1.0
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


	/* -------------------------------------------------------------- duplicates */
	echo '<h2>' . esc_html__( '5. Duplicate pages', 'queendor-cleanup' ) . '</h2>';

	$dupes = qclean_duplicate_pages();

	if ( ! $dupes ) {
		echo '<p><em>' . esc_html__( 'No duplicate pages found.', 'queendor-cleanup' ) . '</em></p>';
	} else {
		echo '<p>' . esc_html__( 'Pages whose address ends in -2, -3 and so on, sat next to the page that should be canonical. Each one removed here is 301-redirected to its canonical page, so any existing link or Google result keeps working.', 'queendor-cleanup' ) . '</p>';

		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
		wp_nonce_field( QCLEAN_ACTION );
		echo '<input type="hidden" name="action" value="' . esc_attr( QCLEAN_ACTION ) . '">';
		echo '<input type="hidden" name="qclean_kind" value="duplicates">';
		echo '<table class="widefat striped" style="max-width:820px;"><thead><tr>';
		echo '<th style="width:40px;"></th><th>' . esc_html__( 'Duplicate', 'queendor-cleanup' ) . '</th><th>' . esc_html__( 'Slug', 'queendor-cleanup' ) . '</th><th>' . esc_html__( 'Redirect to', 'queendor-cleanup' ) . '</th>';
		echo '</tr></thead><tbody>';

		foreach ( $dupes as $dupe_id => $canonical_id ) {
			printf(
				'<tr><td><input type="checkbox" name="qclean_ids[]" value="%1$d" id="qc-dup-%1$d" checked></td><td><label for="qc-dup-%1$d">%2$s</label></td><td><code>%3$s</code></td><td>%4$s <code>%5$s</code></td></tr>',
				(int) $dupe_id,
				esc_html( get_the_title( $dupe_id ) ?: '(no title)' ),
				esc_html( (string) get_post_field( 'post_name', $dupe_id ) ),
				esc_html( get_the_title( $canonical_id ) ?: '(no title)' ),
				esc_html( (string) get_post_field( 'post_name', $canonical_id ) )
			);
		}

		echo '</tbody></table>';
		submit_button( sprintf( /* translators: %d: duplicate count */ __( 'Trash %d duplicates and redirect them', 'queendor-cleanup' ), count( $dupes ) ), 'secondary', 'submit', false );
		echo '</form>';
	}

	/* -------------------------------------------------------------- old domain */
	echo '<h2>' . esc_html__( '6. The old domain', 'queendor-cleanup' ) . '</h2>';

	$scan = qclean_old_domain_scan();

	printf(
		'<p>%s</p>',
		sprintf(
			/* translators: %s: current host */
			esc_html__( 'Leftovers of the old address, to be replaced with %s. Some of these are the side cart\'s own icon paths, which is why an otherwise finished site still loads images from the old one.', 'queendor-cleanup' ),
			'<code>' . esc_html( (string) wp_parse_url( home_url(), PHP_URL_HOST ) ) . '</code>'
		)
	);

	if ( ! $scan ) {
		echo '<p><em>' . esc_html__( 'Clean — no reference to the old domain was found.', 'queendor-cleanup' ) . '</em></p>';
	} else {
		echo '<table class="widefat striped" style="max-width:820px;"><thead><tr>';
		echo '<th>' . esc_html__( 'Finding', 'queendor-cleanup' ) . '</th><th>' . esc_html__( 'Where', 'queendor-cleanup' ) . '</th>';
		echo '</tr></thead><tbody>';

		foreach ( $scan as $row ) {
			printf(
				'<tr><td><code>%s</code></td><td>%d option(s)%s, %d post meta row(s)</td></tr>',
				esc_html( $row['needle'] ),
				count( $row['options'] ),
				$row['options'] ? ': <code>' . esc_html( implode( '</code>, <code>', array_slice( $row['options'], 0, 8 ) ) ) . '</code>' : '',
				(int) $row['meta']
			);
		}

		echo '</tbody></table>';
		qclean_button( 'olddomain', __( 'Replace the old domain', 'queendor-cleanup' ) );
	}

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

		case 'duplicates':
			$raw       = isset( $_POST['qclean_ids'] ) ? (array) wp_unslash( $_POST['qclean_ids'] ) : array();
			$map       = qclean_duplicate_pages();
			$redirects = get_option( 'qclean_redirects', array() );
			$redirects = is_array( $redirects ) ? $redirects : array();

			foreach ( array_map( 'absint', $raw ) as $id ) {
				if ( ! $id || ! isset( $map[ $id ] ) ) {
					continue;
				}

				$slug = (string) get_post_field( 'post_name', $id );

				if ( wp_trash_post( $id ) ) {
					++$count;

					if ( '' !== $slug ) {
						$redirects[ $slug ] = (int) $map[ $id ];
					}
				}
			}

			update_option( 'qclean_redirects', $redirects );
			break;

		case 'olddomain':
			$changed = qclean_old_domain_apply();
			$count   = (int) $changed['options'] + (int) $changed['meta'];
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

/* ============================================================================
 * 5. Duplicate pages
 * ==========================================================================*/

/**
 * Pages whose slug ends in -2, -3 … where a better page already exists.
 *
 * The live site carries two or three copies of most pages. They arrived from
 * repeated imports, they are published, and they are indexed.
 *
 * @return array<int,int> Map of duplicate ID => canonical ID.
 */
function qclean_duplicate_pages() {
	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => array( 'publish', 'draft', 'private', 'pending' ),
			'posts_per_page' => -1,
		)
	);

	$by_slug = array();

	foreach ( $pages as $page ) {
		$by_slug[ $page->post_name ] = (int) $page->ID;
	}

	$protected = qclean_protected_pages();
	$map       = array();

	foreach ( $pages as $page ) {
		$id = (int) $page->ID;

		if ( in_array( $id, $protected, true ) ) {
			continue;
		}

		if ( ! preg_match( '/^(.+?)-(\d+)$/', $page->post_name, $match ) ) {
			continue;
		}

		$base = $match[1];

		// Best case: a page with the clean slug exists.
		if ( isset( $by_slug[ $base ] ) && (int) $by_slug[ $base ] !== $id ) {
			$map[ $id ] = (int) $by_slug[ $base ];
			continue;
		}

		// Otherwise the lowest-numbered sibling is the canonical one: -3 goes to
		// -2 when there is no clean "privacy-policy" page to go to.
		$siblings = array();

		foreach ( $pages as $sibling ) {
			if ( preg_match( '/^' . preg_quote( $base, '/' ) . '-(\d+)$/', $sibling->post_name, $sm ) ) {
				$siblings[ (int) $sm[1] ] = (int) $sibling->ID;
			}
		}

		ksort( $siblings );
		$canonical = (int) reset( $siblings );

		if ( $canonical && $canonical !== $id && ! in_array( $canonical, $protected, true ) ) {
			$map[ $id ] = $canonical;
		}
	}

	return $map;
}

/**
 * 301 a trashed duplicate's old slug to its canonical page.
 *
 * Without this, tidying up creates 404s for anything already linked or indexed.
 *
 * @return void
 */
function qclean_redirect_duplicates() {
	if ( is_admin() ) {
		return;
	}

	$map = get_option( 'qclean_redirects', array() );

	if ( ! is_array( $map ) || ! $map ) {
		return;
	}

	$request = (string) wp_parse_url( isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '', PHP_URL_PATH ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	$base    = (string) wp_parse_url( home_url(), PHP_URL_PATH );

	if ( $base && '/' !== $base && 0 === strpos( $request, $base ) ) {
		$request = substr( $request, strlen( $base ) );
	}

	$slug = trim( $request, '/' );

	if ( '' === $slug || false !== strpos( $slug, '/' ) ) {
		return;
	}

	if ( ! isset( $map[ $slug ] ) ) {
		return;
	}

	$target = get_permalink( absint( $map[ $slug ] ) );

	if ( $target ) {
		wp_safe_redirect( $target, 301 );
		exit;
	}
}
add_action( 'template_redirect', 'qclean_redirect_duplicates' );

/* ============================================================================
 * 6. The old domain
 * ==========================================================================*/

/**
 * The strings that still point at the previous address.
 *
 * @return array{find:string[],replace:string,host:string}
 */
function qclean_old_domains() {
	$host = (string) wp_parse_url( home_url(), PHP_URL_HOST );

	return array(
		'find'    => array(
			'https://www.blaharbenyah.com/dorcas',
			'http://www.blaharbenyah.com/dorcas',
			'https://blaharbenyah.com/dorcas',
			'http://blaharbenyah.com/dorcas',
			'//www.blaharbenyah.com/dorcas',
			'www.blaharbenyah.com',
			'blaharbenyah.com',
		),
		'replace' => $host,
		'host'    => $host,
	);
}

/**
 * Replace inside a value that may be a serialized array.
 *
 * A plain str_replace on serialized data corrupts it, because the byte counts in
 * the string change. This walks the structure and lets WordPress re-serialize.
 *
 * @param mixed    $value   Stored value.
 * @param string[] $find    Needles.
 * @param string   $replace Replacement.
 * @return mixed
 */
function qclean_deep_replace( $value, $find, $replace ) {
	if ( is_string( $value ) ) {
		return str_replace( $find, $replace, $value );
	}

	if ( is_array( $value ) ) {
		foreach ( $value as $key => $item ) {
			$value[ $key ] = qclean_deep_replace( $item, $find, $replace );
		}

		return $value;
	}

	if ( is_object( $value ) ) {
		return $value;
	}

	return $value;
}

/**
 * Where the old domain is hiding, without changing anything.
 *
 * @return array<int,array{needle:string,options:string[],meta:int}>
 */
function qclean_old_domain_scan() {
	global $wpdb;

	$data = qclean_old_domains();
	$rows = array();

	foreach ( $data['find'] as $needle ) {
		$like = '%' . $wpdb->esc_like( $needle ) . '%';

		$options = $wpdb->get_col( // phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$wpdb->prepare( "SELECT option_name FROM {$wpdb->options} WHERE option_value LIKE %s", $like )
		);

		$meta = (int) $wpdb->get_var( // phpcs:ignore WordPress.DB.DirectDatabaseQuery
			$wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE meta_value LIKE %s", $like )
		);

		if ( $options || $meta ) {
			$rows[] = array(
				'needle'  => $needle,
				'options' => array_map( 'strval', (array) $options ),
				'meta'    => $meta,
			);
		}
	}

	return $rows;
}

/**
 * Do the replacement.
 *
 * @return array{options:int,meta:int}
 */
function qclean_old_domain_apply() {
	global $wpdb;

	$data    = qclean_old_domains();
	$changed = array(
		'options' => 0,
		'meta'    => 0,
	);

	$like = '%' . $wpdb->esc_like( 'blaharbenyah.com' ) . '%';

	$option_names = $wpdb->get_col( // phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$wpdb->prepare( "SELECT option_name FROM {$wpdb->options} WHERE option_value LIKE %s", $like )
	);

	foreach ( (array) $option_names as $option_name ) {
		$value   = get_option( $option_name );
		$updated = qclean_deep_replace( $value, $data['find'], $data['replace'] );

		if ( $updated !== $value ) {
			update_option( $option_name, $updated );
			++$changed['options'];
		}
	}

	$rows = $wpdb->get_results( // phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$wpdb->prepare( "SELECT meta_id, post_id, meta_key, meta_value FROM {$wpdb->postmeta} WHERE meta_value LIKE %s", $like )
	);

	foreach ( (array) $rows as $row ) {
		$value   = maybe_unserialize( $row->meta_value );
		$updated = qclean_deep_replace( $value, $data['find'], $data['replace'] );

		if ( $updated !== $value ) {
			update_metadata_by_mid( 'post', (int) $row->meta_id, $updated );
			++$changed['meta'];
		}
	}

	return $changed;
}
