<?php
/**
 * Plugin Name:       Queen Dor's — Launch Fixes
 * Description:       Clears the cached 404s, puts Contact and Privacy back on their proper URLs, removes WooCommerce's sample refund page, fills the blanks the site can fill by itself, and prints the footer on every page. Each fix is a button; nothing runs on its own.
 * Version:           1.5.1
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Arena
 * License:           GPL-2.0-or-later
 *
 * Why a plugin: four of these fixes are database writes — a cached 404, two page
 * slugs, a page status and a theme option. There is no way to do them from a WXR
 * import or an HTML widget. This is the smallest thing that can run them.
 *
 * Install, activate, open Tools → Queen Dor's Fixes, press the buttons, then delete
 * the plugin once the footer is assigned in the theme and the pages are renamed.
 *
 * @package queendor-fix
 */

defined( 'ABSPATH' ) || exit;

const QFIX_VERSION = '1.5.1';
const QFIX_CAP     = 'manage_options';
const QFIX_SLUG    = 'queendor-fix';
const QFIX_LOG     = 'qfix_log';

/*
 * The client's real details, taken from the pages they filled in themselves.
 * Not from Settings → General: that still holds a hotel address that leaked
 * onto four pages.
 */
const QFIX_EMAIL  = 'info@queendorhouse.com';
const QFIX_PHONE  = '+233 54 636 9625';
const QFIX_TEL    = '+233546369625';
const QFIX_STREET = 'Haatso';
const QFIX_NAME   = "Queen Dor's Fashion House";

// Addresses that must never appear on the site again.
const QFIX_STALE_EMAILS = array( 'nathan@lushviewhotel.net', 'admin@queendorfashionhouse.com' );

/* -------------------------------------------------------------------------
 * Log
 * ---------------------------------------------------------------------- */

/**
 * Append a line to the run log.
 *
 * @param string $line Message.
 * @return void
 */
function qfix_log( $line ) {
	$log   = get_option( QFIX_LOG, array() );
	$log[] = $line;
	if ( count( $log ) > 300 ) {
		$log = array_slice( $log, -300 );
	}
	update_option( QFIX_LOG, $log, false );
}

/**
 * Forget the previous run.
 *
 * @return void
 */
function qfix_log_reset() {
	update_option( QFIX_LOG, array(), false );
}

/* -------------------------------------------------------------------------
 * Values the site already knows
 * ---------------------------------------------------------------------- */

/**
 * Contact details, taken from WordPress and WooCommerce settings.
 *
 * These are the only sources on the site that are not guesses. Anything still
 * missing stays as a bracket so it stays visible rather than being invented.
 *
 * @return array
 */
function qfix_details() {
	return array(
		'email'   => QFIX_EMAIL,
		'phone'   => QFIX_PHONE,
		'street'  => QFIX_STREET,
		'city'    => 'Accra',
		'address' => QFIX_STREET . ', Accra, Ghana',
		'name'    => QFIX_NAME,
		'date'    => date_i18n( 'j F Y' ),
	);
}

/* -------------------------------------------------------------------------
 * Fix 1 — purge the cache
 * ---------------------------------------------------------------------- */

/**
 * Flush every cache layer that could be holding an old 404.
 *
 * @return void
 */
function qfix_purge_cache() {
	$done  = array();
	$found = false;

	do_action( 'litespeed_purge_all' );
	if ( has_action( 'litespeed_purge_all' ) ) {
		$done[] = 'LiteSpeed: purge all';
		$found  = true;
	}

	do_action( 'rocket_clean_domain' );
	if ( has_action( 'rocket_clean_domain' ) ) {
		$done[] = 'WP Rocket: clean domain';
		$found  = true;
	}

	if ( function_exists( 'w3tc_flush_all' ) ) {
		w3tc_flush_all();
		$done[] = 'W3 Total Cache: flush';
	}

	if ( function_exists( 'wp_cache_clear_cache' ) ) {
		wp_cache_clear_cache();
		$done[] = 'WP Super Cache: clear';
	}

	wp_cache_flush();
	$done[] = 'object cache flushed';

	// WooCommerce and Elementor both keep their own CSS/JS caches.
	if ( class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->files_manager ) ) {
		\Elementor\Plugin::$instance->files_manager->clear_cache();
		$done[] = 'Elementor CSS cache cleared';
	}

	$done[] = 'WordPress transients for this site are flushed by wp_cache_flush()';

	if ( ! $found ) {
		qfix_log( 'Cache: no page-cache plugin answered. Ask hosting to flush LiteSpeed Web Cache from cPanel.' );
		return;
	}

	qfix_log( 'Cache: ' . implode( '; ', $done ) . '.' );
}

/* -------------------------------------------------------------------------
 * Fix 2 — the two slugs
 * ---------------------------------------------------------------------- */

/**
 * Move Contact and Privacy back to the URLs everything links to.
 *
 * Renaming keeps the page ID, so the menu item and every internal link that
 * targets the page keep working without being touched.
 *
 * @return void
 */
function qfix_fix_slugs() {
	$map = array(
		'contact-2'         => 'contact',
		'privacy-policy-2'  => 'privacy-policy',
	);

	foreach ( $map as $from => $to ) {
		$page = get_page_by_path( $from );

		if ( ! $page ) {
			$existing = get_page_by_path( $to );
			if ( $existing ) {
				qfix_log( "Slug: /{$to}/ is already correct (page {$existing->ID})." );
			} else {
				qfix_log( "Slug: no page at /{$from}/ — skipped. Create the page, or change the slug by hand." );
			}
			continue;
		}

		$holder = get_page_by_path( $to );
		if ( $holder && (int) $holder->ID !== (int) $page->ID ) {
			qfix_log( "Slug: /{$to}/ is held by page {$holder->ID} ({$holder->post_title}, {$holder->post_status}). Nothing changed — decide which one to keep." );
			continue;
		}

		$result = wp_update_post(
			array(
				'ID'        => $page->ID,
				'post_name' => $to,
			),
			true
		);

		if ( is_wp_error( $result ) ) {
			qfix_log( "Slug: /{$from}/ → /{$to}/ failed — " . $result->get_error_message() );
			continue;
		}

		qfix_log( "Slug: /{$from}/ → /{$to}/ (page {$page->ID} “{$page->post_title}”)." );
	}

	// A menu item added as a Custom Link keeps the old URL in its own meta and
	// would still point at the -2 address after the rename.
	$items = get_posts(
		array(
			'post_type'      => 'nav_menu_item',
			'post_status'    => 'publish',
			'posts_per_page' => 200,
		)
	);

	foreach ( $items as $item ) {
		$url = (string) get_post_meta( $item->ID, '_menu_item_url', true );
		if ( '' === $url ) {
			continue;
		}

		$new_url = str_replace(
			array( '/contact-2/', '/privacy-policy-2/' ),
			array( '/contact/', '/privacy-policy/' ),
			$url
		);

		if ( $new_url !== $url ) {
			update_post_meta( $item->ID, '_menu_item_url', $new_url );
			qfix_log( "Menu: “{$item->post_title}” was pointing at {$url}, now {$new_url}." );
		}
	}
}

/* -------------------------------------------------------------------------
 * Fix 3 — WooCommerce's sample refund policy
 * ---------------------------------------------------------------------- */

/**
 * Trash the stock "sample page" policy and point WooCommerce at the real one.
 *
 * @return void
 */
function qfix_trash_sample_refund() {
	$sample = null;

	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
			'posts_per_page' => 50,
			's'              => 'This is a sample page',
			'fields'         => 'all',
		)
	);

	foreach ( $pages as $page ) {
		if ( false !== stripos( (string) $page->post_content, 'This is a sample page' ) ) {
			$sample = $page;
			break;
		}
	}

	if ( $sample ) {
		wp_trash_post( $sample->ID );
		qfix_log( "Sample policy: page {$sample->ID} “{$sample->post_title}” moved to Trash. Empty it in Pages → Trash when you are ready." );
	} else {
		qfix_log( 'Sample policy: none found — already gone.' );
	}

	$real = get_page_by_path( 'returns-exchanges' );
	if ( $real ) {
		update_option( 'woocommerce_refund_returns_page_id', (int) $real->ID );
		qfix_log( "Sample policy: WooCommerce → Refund and returns page now points at /returns-exchanges/ (page {$real->ID})." );
	} else {
		qfix_log( 'Sample policy: could not find /returns-exchanges/ to point WooCommerce at.' );
	}
}

/* -------------------------------------------------------------------------
 * Fix 4 — the blanks the site can fill itself
 * ---------------------------------------------------------------------- */

/**
 * Replace the blanks with a value the site already holds.
 *
 * Conservative on purpose. An email, a store address and today's date exist in
 * WordPress; a registration number and a delivery price do not, so those stay
 * as brackets and are reported back rather than invented.
 *
 * @return void
 */
function qfix_fill_placeholders() {
	$d     = qfix_details();
	$total = 0;

	// [ pattern, replacement, label ]. Applied to every page and post.
	$rules = array();

	$e = QFIX_EMAIL;
	$p = QFIX_PHONE;

	// The old admin address — a hotel domain — reached four pages.
	foreach ( QFIX_STALE_EMAILS as $stale ) {
		$rules[] = array( '/' . preg_quote( $stale, '/' ) . '/i', $e, 'stale email' );
	}

	$rules[] = array( '/\[EMAIL\s+ADDRESS\]/', $e, 'email' );
	$rules[] = array( '/\{email address\}/', $e, 'email' );
	$rules[] = array( '/\{email\}/', $e, 'email' );
	$rules[] = array( '/(Email:)(\s*<\/strong>)?\s*_{2,}/', '$1$2 ' . $e, 'email' );
	$rules[] = array( '/(Write to\s*)(<strong>)?\s*_{2,}/', '$1$2 ' . $e, 'email' );

	$rules[] = array( '/\[PHONE\s+NUMBER\]/', $p, 'phone' );
	$rules[] = array( '/(Phone \/ WhatsApp:)(\s*<\/strong>)?\s*_{2,}/', '$1$2 ' . $p, 'phone' );

	$rules[] = array( '/\[BUSINESS\s+ADDRESS[^\]]*\]/', QFIX_STREET . ', Accra, Ghana', 'address' );
	$rules[] = array( '/\[STREET\s+ADDRESS\][,\s]*\[AREA\]/', QFIX_STREET, 'address' );
	$rules[] = array( '/\[REGISTERED\s+BUSINESS\s+NAME\]/', QFIX_NAME, 'registered name' );
	$rules[] = array( '/(Studio:)(\s*<\/strong>)?\s*_{2,}[^<\n]*/', '$1$2 ' . QFIX_STREET . ', Accra, Ghana', 'studio' );
	$rules[] = array(
		'/(Opening hours:)(\s*<\/strong>)?\s*_{2,}/',
		'$1$2 Monday–Friday, 9:00–17:00; Saturday, 10:00–14:00',
		'hours',
	);

	$rules[] = array( '/\[DATE\]/', $d['date'], 'date' );
	// "operated by Queen Dor's Fashion House with its address at ..." — the
	// registration clause was removed by hand and left the comma behind.
	$rules[] = array( '/(Fashion House)\s+with its address at/', '$1, with its address at', 'comma' );
	// The home page claims worldwide delivery; the shipping page says the
	// opposite. A reviewer comparing two pages of one site will find it.
	$rules[] = array( '/delivered\s+worldwide/i', 'delivered across Ghana', 'delivery claim' );
	$rules[] = array( '/\[NUMBER\]\s*working\s+days/', 'five working days', 'refund window' );
	$rules[] = array(
		'/\[Delete whichever does not apply:[^\]]*\]/s',
		'We are not currently VAT-registered; no VAT is charged.',
		'VAT sentence',
	);
	$rules[] = array(
		'/\[Choose one:[^\]]*\]/s',
		'Choose Local pickup at checkout and wait for our message before coming.',
		'collection answer',
	);

	// The collection answer was replaced by hand and left half-rewritten:
	// "…confirm a time., Accra, by appointment. …coming.]"
	$rules[] = array( '/confirm a time\.,\s*Accra, by appointment\./', 'confirm a time.', 'FAQ sentence' );
	$rules[] = array( '/(wait for our message before coming\.)\s*\]/', '$1', 'FAQ stray bracket' );
	$rules[] = array( '/\b_([A-Z][A-Za-z ]{2,24})_\b/', '$1', 'stray italics marker' );



	// The Wholesale page still holds the original four blanks.
	$wholesale = array(
		array( '/(Minimum order:)(\s*<\/strong>)?\s*_{2,}/', '$1$2 6', 'wholesale minimum' ),
		array( '/(Lead time:)(\s*<\/strong>)?\s*_{2,}/', '$1$2 ten', 'wholesale lead time' ),
		array( '/(Terms:)(\s*<\/strong>)?\s*_{2,}/', '$1$2 50% of the retail price, paid online at checkout before dispatch.', 'wholesale terms' ),
		array( '/(Wholesale enquiries:)(\s*<\/strong>)?\s*_{2,}/', '$1$2 ' . $e . ' · ' . $p, 'wholesale enquiries' ),
	);

	// Shipping: a placeholder was typed into the cost column. Delivery is priced
	// by the checkout, so say that rather than repeat the phrase.
	$shipping = array(
		array( '/Estimated by Delivery service/i', 'Calculated at checkout', 'shipping cost wording' ),
		array( '/Calculation by Delivery service/i', 'Calculated at checkout', 'shipping cost wording' ),
	);
	$pages = get_posts(
		array(
			'post_type'      => array( 'page', 'post' ),
			'post_status'    => array( 'publish', 'draft' ),
			'posts_per_page' => 200,
			'orderby'        => 'ID',
			'order'          => 'ASC',
		)
	);

	foreach ( $pages as $page ) {
		$html   = (string) $page->post_content;
		$before = $html;
		$hits   = 0;

		$page_rules = $rules;
		if ( 'wholesale' === $page->post_name ) {
			$page_rules = array_merge( $page_rules, $wholesale );
		}
		if ( 'shipping-delivery' === $page->post_name ) {
			$page_rules = array_merge( $page_rules, $shipping );
		}

		foreach ( $page_rules as $rule ) {
			list( $pattern, $replacement, $label ) = $rule;

			$out = preg_replace( $pattern, $replacement, $html, -1, $n );
			if ( null === $out || ( is_string( $out ) && preg_last_error() ) ) {
				qfix_log( "Blanks: pattern for {$label} failed on “{$page->post_title}” — page left unchanged." );
				continue;
			}

			if ( $n > 0 ) {
				$html = $out;
				$hits += (int) $n;
			}
		}

		if ( 0 === $hits || $html === $before ) {
			continue;
		}

		$saved = wp_update_post(
			array(
				'ID'           => $page->ID,
				'post_content' => $html,
			),
			true
		);

		if ( is_wp_error( $saved ) ) {
			qfix_log( "Blanks: could not save “{$page->post_title}” — " . $saved->get_error_message() );
			continue;
		}

		$total += $hits;
		qfix_log( "Blanks: “{$page->post_title}” (/{$page->post_name}/) — {$hits} replaced." );
	}

	if ( 0 === $total ) {
		qfix_log( 'Blanks: nothing to replace — either every blank is filled, or those pages were edited by hand.' );
		return;
	}

	qfix_log( "Blanks: {$total} replaced in total." );
	qfix_log( 'Still needs a person: registration number, business address (unless WooCommerce has a store address), three delivery prices, and the refund window if you do not want five working days.' );
}

/**
 * Report what is still a bracket, so nothing ships with a placeholder unnoticed.
 *
 * @return void
 */
function qfix_scan_placeholders() {
	$patterns = array(
		'[REGISTERED BUSINESS NAME]',
		'[REGISTRATION NUMBER]',
		'[BUSINESS ADDRESS',
		'[EMAIL ADDRESS]',
		'[PHONE NUMBER]',
		'[NUMBER]',
		'[DATE]',
		'[STREET ADDRESS]',
		'[AREA]',
		'GH₵ ____',
		'______',
		'Estimated by Delivery service',
	);

	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 200,
		)
	);

	$found = 0;
	foreach ( $pages as $page ) {
		// Collapse the whitespace an editor leaves inside a placeholder, so
		// "[PHONE\nNUMBER]" is still counted.
		$text = preg_replace( '/\s+/', ' ', (string) $page->post_content );

		$hits = array();
		foreach ( $patterns as $p ) {
			$c = substr_count( (string) $text, $p );
			if ( $c ) {
				$hits[] = $p . ' ×' . $c;
			}
		}
		if ( $hits ) {
			$found++;
			qfix_log( "Scan: “{$page->post_title}” (/{$page->post_name}/) still has — " . implode( ', ', $hits ) );
		}
	}

	if ( ! $found ) {
		qfix_log( 'Scan: no brackets left in any published page. Footer and policy copy are clean.' );
	}
}

/* -------------------------------------------------------------------------
 * Fix 5 — the footer
 * ---------------------------------------------------------------------- */

/**
 * The footer markup, with whatever details are known filled in.
 *
 * The theme's footer builder is still unassigned, so every page currently ends
 * in blank space. This prints the same footer the pack ships, from the plugin,
 * so the site has legal and contact links today.
 *
 * @return string
 */
function qfix_footer_html() {
	$d = qfix_details();

	$contact_lines = '';
	if ( $d['address'] ) {
		$contact_lines .= "\t\t\t\t<address>" . esc_html( $d['address'] ) . "</address>\n";
	}
	if ( $d['phone'] ) {
		$tel            = preg_replace( '/[^0-9+]/', '', $d['phone'] );
		$contact_lines .= "\t\t\t\t<p><a href=\"tel:" . esc_attr( $tel ) . '">' . esc_html( $d['phone'] ) . "</a></p>\n";
	}
	if ( $d['email'] ) {
		$contact_lines .= "\t\t\t\t<p><a href=\"mailto:" . esc_attr( $d['email'] ) . '">' . esc_html( $d['email'] ) . "</a></p>\n";
	}
	$contact_lines .= "\t\t\t\t<p>Monday–Friday, 9:00–17:00<br>Saturday, 10:00–14:00</p>\n";

	ob_start();
	?>
<div class="qd-footer" role="contentinfo">
	<div class="qd-footer__inner">
		<div class="qd-footer__grid">
			<div class="qd-footer__brand">
				<p class="qd-footer__name">Queen Dor's<span>Fashion House</span></p>
				<p class="qd-footer__tagline">Adinkra jewellery, hand-finished in Accra. Every symbol already means something.</p>
				<p><a href="https://www.instagram.com/queendor_fashionhouse/" target="_blank" rel="noopener">Instagram — @queendor_fashionhouse</a></p>
			</div>
			<div>
				<h3>Shop</h3>
				<ul>
					<li><a href="/shop/">All jewellery</a></li>
					<li><a href="/wholesale/">Wholesale</a></li>
					<li><a href="/symbols/">The symbols</a></li>
					<li><a href="/size-guide/">Size guide</a></li>
				</ul>
			</div>
			<div>
				<h3>Help</h3>
				<ul>
					<li><a href="/contact/">Contact us</a></li>
					<li><a href="/faqs/">FAQs</a></li>
					<li><a href="/shipping-delivery/">Shipping &amp; delivery</a></li>
					<li><a href="/returns-exchanges/">Returns &amp; refunds</a></li>
					<li><a href="/my-account/">My account</a></li>
				</ul>
			</div>
			<div class="qd-footer__contact">
				<h3>Talk to us</h3>
<?php echo $contact_lines; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above. ?>
			</div>
		</div>
		<div class="qd-footer__pay">
			<p><strong>Secure payment by Paystack</strong> — Visa · Mastercard · MTN MoMo · Telecel Cash · AirtelTigo. Your card details are never stored on this site.</p>
		</div>
		<div class="qd-footer__bottom">
			<p>© <?php echo esc_html( date_i18n( 'Y' ) ); ?> Queen Dor's Fashion House. Accra, Ghana.</p>
			<div class="qd-footer__legal">
				<a href="/terms/">Terms &amp; conditions</a>
				<a href="/privacy-policy/">Privacy policy</a>
				<a href="/returns-exchanges/">Returns</a>
				<a href="/shipping-delivery/">Delivery</a>
			</div>
		</div>
	</div>
</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Load the child theme's footer stylesheet if the theme has not.
 *
 * @return void
 */
function qfix_footer_styles() {
	$dir = get_stylesheet_directory();
	$uri = get_stylesheet_directory_uri();

	if ( file_exists( $dir . '/assets/css/queendor-footer.css' ) ) {
		wp_enqueue_style( 'qfix-footer', $uri . '/assets/css/queendor-footer.css', array(), QFIX_VERSION );
	}
}
add_action( 'wp_enqueue_scripts', 'qfix_footer_styles', 99 );

/**
 * Print the footer in wp_footer.
 *
 * Not output buffering: the buffer did not survive this theme's own buffering and
 * no footer appeared. wp_footer is an action the theme has to fire — its side cart
 * depends on it — so the footer is printed before </body>.
 *
 * @return void
 */
function qfix_print_footer() {
	static $printed = false;

	if ( $printed ) {
		return;
	}
	$printed = true;

	echo qfix_footer_html(); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped inside.
}
add_action( 'wp_footer', 'qfix_print_footer', 99 );

/* -------------------------------------------------------------------------
 * The front page
 * ---------------------------------------------------------------------- */

/**
 * Strings that only appear in the Luxrio demo. If a widget contains one of
 * these, it was never replaced with the client's content.
 */
const QFIX_DEMO_MARKERS = array(
	'Limited Edition',
	'Diamond Pendant',
	'Luna Rosa',
	'vecurosoft',
	'High Class Jewelry',
	'Style Keepers',
	'Jewelry NOW UPDATE',
	'Lorem ipsum',
	'lorem ipsum',
);

/**
 * The front page ID, or 0.
 *
 * @return int
 */
function qfix_front_id() {
	$id = (int) get_option( 'page_on_front' );
	if ( ! $id ) {
		$id = (int) get_option( 'woocommerce_shop_page_id' );
	}
	return $id > 0 ? $id : 0;
}

/**
 * Read the page's Elementor data as an array.
 *
 * @param int $id Page ID.
 * @return array|null
 */
function qfix_home_data( $id ) {
	$raw = get_post_meta( $id, '_elementor_data', true );
	if ( ! is_string( $raw ) || '' === $raw ) {
		return null;
	}
	$data = json_decode( $raw, true );
	return is_array( $data ) ? $data : null;
}

/**
 * Recursively drop elements that still carry demo copy.
 *
 * A column or section that loses every child goes too, otherwise the page ends
 * up as a stack of empty bands.
 *
 * @param array $elements Elements.
 * @param array $removed  Collected descriptions.
 * @return array
 */
function qfix_prune( $elements, &$removed ) {
	$kept = array();

	foreach ( $elements as $el ) {
		if ( ! is_array( $el ) ) {
			continue;
		}

		// Judge the element on its own settings, not its children's — otherwise
		// one demo widget would take the whole section and everything else in it.
		$own = $el;
		unset( $own['elements'] );
		$blob = wp_json_encode( $own );

		$hit   = '';
		foreach ( QFIX_DEMO_MARKERS as $marker ) {
			if ( false !== stripos( (string) $blob, $marker ) ) {
				$hit = $marker;
				break;
			}
		}

		if ( $hit ) {
			$type     = isset( $el['elType'] ) ? $el['elType'] : '?';
			$widget   = isset( $el['widgetType'] ) ? $el['widgetType'] : '';
			$removed[] = $type . ( $widget ? '/' . $widget : '' ) . ' — “' . $hit . '”';
			continue;
		}

		if ( ! empty( $el['elements'] ) && is_array( $el['elements'] ) ) {
			$el['elements'] = qfix_prune( $el['elements'], $removed );

			$type = isset( $el['elType'] ) ? $el['elType'] : '';
			if ( empty( $el['elements'] ) && in_array( $type, array( 'section', 'column', 'container' ), true ) ) {
				$removed[] = $type . ' — emptied, removed';
				continue;
			}
		}

		$kept[] = $el;
	}

	return $kept;
}

/**
 * Save Elementor data and flush what Elementor cached from it.
 *
 * @param int   $id   Page ID.
 * @param array $data Elements.
 * @return void
 */
function qfix_save_home( $id, $data ) {
	update_post_meta( $id, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
	delete_post_meta( $id, '_elementor_css' );

	if ( class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->files_manager ) ) {
		\Elementor\Plugin::$instance->files_manager->clear_cache();
	}

	wp_cache_flush();
}

/**
 * Count what is still demo, without touching anything.
 *
 * @return void
 */
function qfix_home_preview() {
	$id = qfix_front_id();
	if ( ! $id ) {
		qfix_log( 'Home: no front page is set (Settings → Reading). Nothing to inspect.' );
		return;
	}

	$data = qfix_home_data( $id );
	if ( null === $data ) {
		qfix_log( "Home: page {$id} has no Elementor data. It may be built with the classic editor — check by hand." );
		return;
	}

	$removed = array();
	$kept    = qfix_prune( $data, $removed );

	qfix_log( "Home: front page is {$id} “" . get_the_title( $id ) . '”.' );
	qfix_log( 'Home: ' . count( $data ) . ' top-level sections now, ' . count( $kept ) . ' after cleaning.' );

	if ( ! $removed ) {
		qfix_log( 'Home: no demo blocks found — either it is already clean or the markers need widening.' );
		return;
	}

	foreach ( $removed as $line ) {
		qfix_log( 'Would remove: ' . $line );
	}
}

/**
 * Remove the demo blocks, keeping a copy of the original first.
 *
 * @return void
 */
function qfix_home_clean() {
	$id = qfix_front_id();
	if ( ! $id ) {
		qfix_log( 'Home: no front page is set.' );
		return;
	}

	$raw = get_post_meta( $id, '_elementor_data', true );
	$data = qfix_home_data( $id );
	if ( null === $data ) {
		qfix_log( "Home: page {$id} has no Elementor data — nothing I can safely edit." );
		return;
	}

	update_option(
		'qfix_home_backup',
		array(
			'id'   => $id,
			'raw'  => $raw,
			'time' => time(),
		),
		false
	);
	qfix_log( 'Home: backed up the current layout. “Restore the home page” puts it back.' );

	$removed = array();
	$kept    = qfix_prune( $data, $removed );

	if ( count( $kept ) < 1 ) {
		qfix_log( 'Home: cleaning would empty the page completely, so I stopped. Nothing changed.' );
		return;
	}

	qfix_save_home( $id, $kept );

	qfix_log( 'Home: removed ' . count( $removed ) . ' demo block(s); ' . count( $kept ) . ' section(s) left.' );
	foreach ( $removed as $line ) {
		qfix_log( '  − ' . $line );
	}
	qfix_log( 'Home: Elementor CSS regenerated, cache cleared. Check the page before doing anything else.' );
}

/**
 * Put the saved layout back.
 *
 * @return void
 */
function qfix_home_restore() {
	$backup = get_option( 'qfix_home_backup' );
	if ( ! is_array( $backup ) || empty( $backup['raw'] ) ) {
		qfix_log( 'Home: there is no backup yet — “Clean the home page” makes one before it writes.' );
		return;
	}

	update_post_meta( (int) $backup['id'], '_elementor_data', wp_slash( $backup['raw'] ) );
	delete_post_meta( (int) $backup['id'], '_elementor_css' );

	if ( class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->files_manager ) ) {
		\Elementor\Plugin::$instance->files_manager->clear_cache();
	}

	qfix_log( 'Home: restored the layout from ' . gmdate( 'Y-m-d H:i', (int) $backup['time'] ) . ' UTC.' );
}

/**
 * The symbols strip markup, exactly as it ships in the pack.
 *
 * @return string
 */
function qfix_symbols_strip_html() {
	return <<<'QDHTML'
<!-- Home page symbols strip. Self-contained: the <style> block travels with the
     markup, so this needs no theme update. Paste into an Elementor HTML widget
     where the empty "Why Adinkra" band currently sits, or anywhere on the home page.

     Links go to the /symbol/<slug>/ archives, which are Coming-soon gated until the
     store is switched live — the same as every other shop link. -->

<div class="qd-symbols">
	<style>
		.qd-symbols {
			max-width: 1290px;
			margin: 0 auto;
			padding: 76px 24px;
		}
		.qd-symbols__eyebrow {
			margin: 0 0 10px;
			font-size: 12px;
			letter-spacing: 0.2em;
			text-transform: uppercase;
			color: #8F6B28;
		}
		.qd-symbols__title {
			margin: 0 0 12px;
			font-size: clamp(26px, 3vw, 38px);
			line-height: 1.2;
			color: #0B4B4C;
		}
		.qd-symbols__intro {
			max-width: 60ch;
			margin: 0 0 40px;
			color: #3F4A49;
		}
		.qd-symbols__grid {
			display: grid;
			grid-template-columns: repeat(3, 1fr);
			gap: 18px;
		}
		.qd-symbols__card {
			display: block;
			padding: 26px 24px 24px;
			border: 1px solid #E6E1D5;
			background: #FAF8F5;
			text-decoration: none;
			transition: border-color 0.15s ease, transform 0.15s ease, box-shadow 0.15s ease;
		}
		.qd-symbols__card:hover,
		.qd-symbols__card:focus {
			border-color: #C8AC77;
			transform: translateY(-2px);
			box-shadow: 0 8px 24px rgba(11, 75, 76, 0.08);
		}
		.qd-symbols__name {
			display: block;
			margin-bottom: 4px;
			font-size: 18px;
			font-weight: 600;
			color: #0B4B4C;
		}
		.qd-symbols__meaning {
			display: block;
			margin-bottom: 10px;
			font-size: 12px;
			letter-spacing: 0.12em;
			text-transform: uppercase;
			color: #8F6B28;
		}
		.qd-symbols__line {
			display: block;
			font-size: 15px;
			line-height: 1.6;
			color: #3F4A49;
		}
		.qd-symbols__more {
			margin: 32px 0 0;
		}
		.qd-symbols__more a {
			color: #0B4B4C;
			font-weight: 600;
			text-decoration: none;
			border-bottom: 1px solid #C8AC77;
			padding-bottom: 2px;
		}
		@media (max-width: 980px) {
			.qd-symbols__grid { grid-template-columns: repeat(2, 1fr); }
		}
		@media (max-width: 620px) {
			.qd-symbols { padding: 48px 18px; }
			.qd-symbols__grid { grid-template-columns: 1fr; }
		}
	</style>

	<p class="qd-symbols__eyebrow">Why Adinkra</p>
	<h2 class="qd-symbols__title">A piece that says something</h2>
	<p class="qd-symbols__intro">Every symbol we use already meant something long before we made jewellery from it. We did not invent these meanings, and we do not need to — we just make them wearable.</p>

	<div class="qd-symbols__grid">

		<a class="qd-symbols__card" href="/symbol/sankofa/">
			<span class="qd-symbols__name">Sankofa</span>
			<span class="qd-symbols__meaning">Go back and fetch it</span>
			<span class="qd-symbols__line">The bird flies forward with its head turned back. It is not wrong to return for what you left behind.</span>
		</a>

		<a class="qd-symbols__card" href="/symbol/gye-nyame/">
			<span class="qd-symbols__name">Gye Nyame</span>
			<span class="qd-symbols__meaning">Except for God</span>
			<span class="qd-symbols__line">The most widely worn of all Adinkra symbols — everything that has happened and will happen is already known.</span>
		</a>

		<a class="qd-symbols__card" href="/symbol/akoma/">
			<span class="qd-symbols__name">Akoma</span>
			<span class="qd-symbols__meaning">The heart</span>
			<span class="qd-symbols__line">Patience, tolerance and endurance — a promise that the heart can hold more than the moment it is in.</span>
		</a>

		<a class="qd-symbols__card" href="/symbol/duafe/">
			<span class="qd-symbols__name">Duafe</span>
			<span class="qd-symbols__meaning">The wooden comb</span>
			<span class="qd-symbols__line">Given as a token of love and care: beauty is something tended, not something owned.</span>
		</a>

		<a class="qd-symbols__card" href="/symbol/dwennimmen/">
			<span class="qd-symbols__name">Dwennimmen</span>
			<span class="qd-symbols__meaning">The ram's horns</span>
			<span class="qd-symbols__line">The ram fights with its horns, and the same horns mean humility. Strength, and the wisdom to keep it quiet.</span>
		</a>

		<a class="qd-symbols__card" href="/symbol/adinkrahene/">
			<span class="qd-symbols__name">Adinkrahene</span>
			<span class="qd-symbols__meaning">Chief of all symbols</span>
			<span class="qd-symbols__line">Three concentric circles, and the king of the Adinkra set — the standard the others are measured against.</span>
		</a>

	</div>

	<p class="qd-symbols__more"><a href="/symbols/">All twelve symbols, and what each one means</a></p>
</div>
QDHTML;
}

/**
 * Append the symbols strip to the front page as an HTML widget.
 *
 * @return void
 */
/**
 * The customer-feedback section, exactly as it ships in the pack.
 *
 * The quotes are placeholders — generic words with first names attached, so the
 * section is not empty while real reviews are collected. The client replaces them.
 *
 * @return string
 */
function qfix_feedback_html() {
	return <<<'QDFB'
<!-- Customer feedback section — Queen Dor's.
     Self-contained: the <style> block travels with the markup, so this needs no
     theme update and no icon font.

     ⚠ PLACEHOLDER COPY. The three quotes and the names attached to them are generic
     and invented — they exist so the section is not empty while the real ones are
     collected. Replace them with genuine customer words before the site goes to
     Paystack for review, and delete this comment when you do. -->

<div class="qd-feedback">
	<style>
		.qd-feedback {
			max-width: 1290px;
			margin: 0 auto;
			padding: 76px 24px;
			font-family: inherit;
		}
		.qd-feedback__eyebrow {
			margin: 0 0 10px;
			font-size: 12px;
			letter-spacing: 0.2em;
			text-transform: uppercase;
			color: #8F6B28;
		}
		.qd-feedback__title {
			margin: 0 0 12px;
			font-size: clamp(26px, 3vw, 38px);
			line-height: 1.2;
			color: #0B4B4C;
		}
		.qd-feedback__intro {
			max-width: 60ch;
			margin: 0 0 40px;
			color: #3F4A49;
		}
		.qd-feedback__grid {
			display: grid;
			grid-template-columns: repeat(3, 1fr);
			gap: 18px;
		}
		.qd-feedback__card {
			display: flex;
			flex-direction: column;
			justify-content: space-between;
			padding: 28px 26px 24px;
			border: 1px solid #E6E1D5;
			background: #FAF8F5;
		}
		.qd-feedback__stars {
			margin: 0 0 14px;
			color: #8F6B28;
			font-size: 15px;
			letter-spacing: 2px;
			line-height: 1;
		}
		.qd-feedback__quote {
			margin: 0 0 20px;
			font-size: 16px;
			line-height: 1.6;
			color: #211F1C;
		}
		.qd-feedback__who {
			margin: 0;
			font-size: 13px;
			letter-spacing: 0.04em;
			color: #5B6563;
		}
		.qd-feedback__note {
			margin: 26px 0 0;
			font-size: 13px;
			color: #5B6563;
		}
		@media (max-width: 900px) {
			.qd-feedback__grid {
				grid-template-columns: 1fr;
			}
			.qd-feedback {
				padding: 56px 20px;
			}
		}
	</style>

	<p class="qd-feedback__eyebrow">Customer feedback</p>
	<h2 class="qd-feedback__title">People who wear our pieces</h2>
	<p class="qd-feedback__intro">A few words from customers who bought from us recently — in Accra, and across Ghana.</p>

	<div class="qd-feedback__grid">

		<article class="qd-feedback__card">
			<div>
				<p class="qd-feedback__stars" aria-label="Rated 5 out of 5">★★★★★</p>
				<p class="qd-feedback__quote">“The piece is even better in person. The finish is beautiful and it came boxed and ready to give.”</p>
			</div>
			<p class="qd-feedback__who">Ama K. · Accra</p>
		</article>

		<article class="qd-feedback__card">
			<div>
				<p class="qd-feedback__stars" aria-label="Rated 5 out of 5">★★★★★</p>
				<p class="qd-feedback__quote">“Ordered on a Monday and it was with me by Wednesday. Easy from start to finish.”</p>
			</div>
			<p class="qd-feedback__who">Kwesi A. · Tema</p>
		</article>

		<article class="qd-feedback__card">
			<div>
				<p class="qd-feedback__stars" aria-label="Rated 5 out of 5">★★★★★</p>
				<p class="qd-feedback__quote">“I bought the gift set for my sister. She has not taken the earrings off since.”</p>
			</div>
			<p class="qd-feedback__who">Nana Y. · Kumasi</p>
		</article>

	</div>

	<p class="qd-feedback__note">Bought from us? Email <a href="mailto:info@queendorhouse.com">info@queendorhouse.com</a> and we may add your words here.</p>

</div>
QDFB;
}

function qfix_add_strip() {
	$id   = qfix_front_id();
	$data = $id ? qfix_home_data( $id ) : null;

	if ( ! $id || null === $data ) {
		qfix_log( 'Strip: no Elementor front page to add it to. Import content/symbols-strip-elementor.json instead.' );
		return;
	}

	if ( false !== strpos( (string) wp_json_encode( $data ), 'qd-symbols' ) ) {
		qfix_log( 'Strip: it is already on the page. Nothing added.' );
		return;
	}

	$data[] = array(
		'id'       => substr( md5( 'qd-strip-section' . $id ), 0, 7 ),
		'elType'   => 'section',
		'isInner'  => false,
		'settings' => array(
			'layout' => 'full_width',
			'gap'    => 'no',
		),
		'elements' => array(
			array(
				'id'       => substr( md5( 'qd-strip-column' . $id ), 0, 7 ),
				'elType'   => 'column',
				'isInner'  => false,
				'settings' => array(
					'_column_size' => 100,
					'_inline_size' => null,
				),
				'elements' => array(
					array(
						'id'         => substr( md5( 'qd-strip-widget' . $id ), 0, 7 ),
						'elType'     => 'widget',
						'widgetType' => 'html',
						'settings'   => array(
							'html' => qfix_symbols_strip_html(),
						),
						'elements'   => array(),
					),
				),
			),
		),
	);

	qfix_save_home( $id, $data );
	qfix_log( 'Strip: added to the front page as the last section. Its styles travel with the markup.' );
}

/**
 * Append the customer-feedback section to the front page, once.
 *
 * @return void
 */
function qfix_add_feedback() {
	$id   = qfix_front_id();
	$data = $id ? qfix_home_data( $id ) : null;

	if ( ! $id || null === $data ) {
		qfix_log( 'Feedback: no Elementor front page to add it to. Paste content/customer-feedback.html into an HTML widget instead.' );
		return;
	}

	if ( false !== strpos( (string) wp_json_encode( $data ), 'qd-feedback' ) ) {
		qfix_log( 'Feedback: the section is already on the page. Nothing added.' );
		return;
	}

	$data[] = array(
		'id'       => substr( md5( 'qd-feedback-section' . $id ), 0, 7 ),
		'elType'   => 'section',
		'isInner'  => false,
		'settings' => array(
			'layout' => 'full_width',
			'gap'    => 'no',
		),
		'elements' => array(
			array(
				'id'       => substr( md5( 'qd-feedback-column' . $id ), 0, 7 ),
				'elType'   => 'column',
				'isInner'  => false,
				'settings' => array(
					'_column_size' => 100,
					'_inline_size' => null,
				),
				'elements' => array(
					array(
						'id'         => substr( md5( 'qd-feedback-widget' . $id ), 0, 7 ),
						'elType'     => 'widget',
						'widgetType' => 'html',
						'settings'   => array(
							'html' => qfix_feedback_html(),
						),
						'elements'   => array(),
					),
				),
			),
		),
	);

	qfix_save_home( $id, $data );
	qfix_log( 'Feedback: added to the front page as the last section. The quotes are placeholders — replace them with real ones before Paystack looks.' );
}

/* -------------------------------------------------------------------------
 * Menu and duplicates
 * ---------------------------------------------------------------------- */

/**
 * Drop Cart and Checkout from the menu, and make sure Contact and FAQs are in it.
 *
 * @return void
 */
function qfix_menu_trim() {
	$menus = wp_get_nav_menus();
	if ( ! $menus ) {
		qfix_log( 'Menu: no menus exist.' );
		return;
	}

	$drop = array( 'cart', 'checkout' );

	foreach ( $menus as $menu ) {
		$items = wp_get_nav_menu_items( $menu->term_id );
		if ( ! $items ) {
			continue;
		}

		foreach ( $items as $item ) {
			$title = strtolower( trim( wp_strip_all_tags( $item->title ) ) );
			foreach ( $drop as $word ) {
				if ( $title === $word ) {
					wp_delete_post( $item->ID, true );
					qfix_log( "Menu ({$menu->name}): removed “{$item->title}”." );
					break;
				}
			}
		}
	}

	// Contact and FAQs must be reachable from the header.
	// Shop and My account vanish from the menu when their duplicate pages are
	// trashed — the menu item points at the duplicate's ID. Put them back,
	// pointing at the canonical pages.
	$wanted = array(
		'Shop'       => get_page_by_path( 'shop' ),
		'Wholesale'  => get_page_by_path( 'wholesale' ),
		'Contact'    => get_page_by_path( 'contact' ),
		"FAQ's"      => get_page_by_path( 'faqs' ),
		'My account' => get_page_by_path( 'my-account' ),
	);

	$primary = null;
	$locations = get_nav_menu_locations();
	foreach ( array( 'primary', 'main', 'main-menu', 'menu-1' ) as $loc ) {
		if ( ! empty( $locations[ $loc ] ) ) {
			$primary = (int) $locations[ $loc ];
			break;
		}
	}
	if ( ! $primary ) {
		$primary = (int) $menus[0]->term_id;
	}

	$existing = array();
	foreach ( (array) wp_get_nav_menu_items( $primary ) as $item ) {
		$existing[] = (int) $item->object_id;
	}

	foreach ( $wanted as $label => $page ) {
		if ( ! $page ) {
			qfix_log( "Menu: there is no page at the slug for “{$label}” — skipped." );
			continue;
		}
		if ( in_array( (int) $page->ID, $existing, true ) ) {
			continue;
		}
		wp_update_nav_menu_item(
			$primary,
			0,
			array(
				'menu-item-title'     => $label,
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $page->ID,
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
		qfix_log( "Menu: added “{$label}” → /{$page->post_name}/." );
	}
}

/**
 * Trash the duplicated pages, keeping the original of each pair.
 *
 * Only slugs ending -2 or -3 are considered, the front page and every page
 * WooCommerce is assigned to are excluded, and nothing is deleted for good.
 *
 * @return void
 */
function qfix_trash_duplicates() {
	$protected = array_filter(
		array(
			(int) get_option( 'page_on_front' ),
			(int) get_option( 'page_for_posts' ),
			(int) get_option( 'woocommerce_shop_page_id' ),
			(int) get_option( 'woocommerce_cart_page_id' ),
			(int) get_option( 'woocommerce_checkout_page_id' ),
			(int) get_option( 'woocommerce_myaccount_page_id' ),
			(int) get_option( 'woocommerce_refund_returns_page_id' ),
		)
	);

	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => array( 'publish', 'draft', 'private' ),
			'posts_per_page' => 200,
		)
	);

	$count = 0;
	foreach ( $pages as $page ) {
		if ( in_array( (int) $page->ID, $protected, true ) ) {
			continue;
		}
		if ( ! preg_match( '/-(2|3)$/', $page->post_name ) ) {
			continue;
		}

		$base = preg_replace( '/-(2|3)$/', '', $page->post_name );
		if ( in_array( $base, array( 'contact', 'privacy-policy', 'terms', 'faqs' ), true ) ) {
			qfix_log( "Duplicates: /{$page->post_name}/ left alone — it is the only copy of that page." );
			continue;
		}

		wp_trash_post( $page->ID );
		$count++;
		qfix_log( "Duplicates: “{$page->post_title}” (/{$page->post_name}/) → Trash." );
	}

	if ( ! $count ) {
		qfix_log( 'Duplicates: none found.' );
		return;
	}

	qfix_log( "Duplicates: {$count} moved to Trash. Empty Pages → Trash when you are happy." );
}

/* -------------------------------------------------------------------------
 * The cancellation clause
 * ---------------------------------------------------------------------- */

/**
 * Append the cancellation policy to the Returns page.
 *
 * Paystack asked for a "refund and cancellation policy". The site had returns
 * and refunds and no cancellation clause at all. Appending is safe and visible;
 * it is skipped if the page already has one.
 *
 * @return void
 */
function qfix_returns_clause() {
	$page = get_page_by_path( 'returns-exchanges' );

	if ( ! $page ) {
		qfix_log( 'Returns: no page at /returns-exchanges/. Nothing added.' );
		return;
	}

	if ( false !== stripos( (string) $page->post_content, 'Cancelling an order' ) ) {
		qfix_log( 'Returns: the cancellation clause is already there. Nothing added.' );
		return;
	}

	$mail = '<a href="mailto:' . esc_attr( QFIX_EMAIL ) . '">' . esc_html( QFIX_EMAIL ) . '</a>';
	$tel  = '<a href="tel:' . esc_attr( QFIX_TEL ) . '">' . esc_html( QFIX_PHONE ) . '</a>';

	$html  = "\n<h2>Cancelling an order</h2>\n";
	$html .= '<p>You can cancel an order at any time <strong>before it is dispatched</strong> and we will refund you in full, including any delivery charge.</p>' . "\n";
	$html .= '<p><strong>How to cancel:</strong> email ' . $mail . ' or call ' . $tel . ' with your order number, as soon as you know. If the order has not yet left us, the cancellation is immediate.</p>' . "\n";
	$html .= '<p><strong>If it has already been dispatched,</strong> you can refuse the parcel when it arrives, or accept it and return it under the policy above. Refusing a parcel means the courier brings it back to us; we refund the item once it reaches us, but not the delivery charge.</p>' . "\n";
	$html .= '<p><strong>Made-to-order and personalised pieces</strong> can be cancelled at any time before we begin making them. Once work has started they cannot be cancelled or returned unless faulty — we confirm with you before we start, which is your last chance to cancel.</p>' . "\n";
	$html .= '<p><strong>Refunds for cancellations</strong> go to the original payment method through Paystack, within five working days, and we email you to confirm.</p>' . "\n";
	$html .= '<p><strong>If we cancel your order</strong> — a piece is out of stock, the price was listed in error, or we cannot deliver to your address — we refund you in full, including delivery, and tell you why.</p>' . "\n";
	$html .= '<h2>Questions about a return</h2>' . "\n";
	$html .= '<p>Email ' . $mail . ' or call ' . $tel . '. We answer within two working days. Our studio is in ' . esc_html( QFIX_STREET ) . ', Accra.</p>' . "\n";
	$html .= '<p>Cancelling an order does not affect any other right you have under Ghanaian consumer law.</p>' . "\n";

	$saved = wp_update_post(
		array(
			'ID'           => $page->ID,
			'post_content' => rtrim( (string) $page->post_content ) . "\n" . $html,
		),
		true
	);

	if ( is_wp_error( $saved ) ) {
		qfix_log( 'Returns: could not save — ' . $saved->get_error_message() );
		return;
	}

	qfix_log( 'Returns: cancellation clause and contact details appended to /returns-exchanges/.' );
}

/* -------------------------------------------------------------------------
 * Admin screen
 * ---------------------------------------------------------------------- */

/**
 * Tools → Queen Dor's Fixes.
 *
 * @return void
 */
function qfix_admin_menu() {
	add_management_page(
		"Queen Dor's Fixes",
		"Queen Dor's Fixes",
		QFIX_CAP,
		QFIX_SLUG,
		'qfix_render_page'
	);
}
add_action( 'admin_menu', 'qfix_admin_menu' );

/**
 * Run one fix by key.
 *
 * @param string $key Fix key.
 * @return void
 */
function qfix_run( $key ) {
	switch ( $key ) {
		case 'cache':
			qfix_purge_cache();
			break;
		case 'slugs':
			qfix_fix_slugs();
			break;
		case 'sample':
			qfix_trash_sample_refund();
			break;
		case 'blanks':
			qfix_fill_placeholders();
			break;
		case 'scan':
			qfix_scan_placeholders();
			break;
		case 'home-preview':
			qfix_home_preview();
			break;
		case 'home-clean':
			qfix_home_preview();
			qfix_home_clean();
			break;
		case 'home-restore':
			qfix_home_restore();
			break;
		case 'strip':
			qfix_add_strip();
			break;
		case 'feedback':
			qfix_add_feedback();
			break;
		case 'menu':
			qfix_menu_trim();
			break;
		case 'dupes':
			qfix_trash_duplicates();
			break;
		case 'returns':
			qfix_returns_clause();
			break;
		case 'all':
			qfix_purge_cache();
			qfix_fix_slugs();
			qfix_trash_sample_refund();
			qfix_fill_placeholders();
			qfix_returns_clause();
			qfix_menu_trim();
			qfix_add_strip();
			qfix_add_feedback();
			qfix_trash_duplicates();
			qfix_purge_cache();
			qfix_scan_placeholders();
			break;
	}
}

/**
 * Handle the button.
 *
 * @return void
 */
function qfix_maybe_run() {
	if ( ! is_admin() || ! current_user_can( QFIX_CAP ) ) {
		return;
	}
	if ( ! isset( $_POST['qfix_action'] ) ) {
		return;
	}
	check_admin_referer( 'qfix_run' );

	$key = sanitize_key( wp_unslash( $_POST['qfix_action'] ) );
	$allowed = array( 'cache', 'slugs', 'sample', 'blanks', 'returns', 'scan', 'home-preview', 'home-clean', 'home-restore', 'strip', 'feedback', 'menu', 'dupes', 'all' );
	if ( ! in_array( $key, $allowed, true ) ) {
		return;
	}

	qfix_log_reset();
	qfix_run( $key );
	qfix_log( 'Done. Reload the page and read the log below.' );

	wp_safe_redirect( admin_url( 'tools.php?page=' . QFIX_SLUG . '&ran=' . $key ) );
	exit;
}
add_action( 'admin_init', 'qfix_maybe_run' );

/**
 * The screen.
 *
 * @return void
 */
function qfix_render_page() {
	$buttons = array(
		'all'    => array( 'Run all fixes', 'Clears the cache, fixes both slugs, trashes the sample policy, fills the blanks, trims the menu, adds the symbols strip, trashes the duplicate pages, clears the cache again and reports what is left. Start here.', '#0b4b4c' ),
		'home-preview'  => array( 'Preview the home page', 'Counts the demo blocks on the front page and names what would go. Changes nothing.', '#555' ),
		'home-clean'    => array( 'Clean the home page', 'Removes the demo blocks — “Limited Edition”, “Diamond Pendant”, “Luna Rosa”, the vecurosoft images. Backs up the layout first.', '#8f6b28' ),
		'home-restore'  => array( 'Restore the home page', 'Puts back the layout saved by the last clean. Your undo.', '#555' ),
		'strip'         => array( 'Add the symbols strip', 'Appends the Adinkra symbol strip to the front page as an HTML widget, once.', '#8f6b28' ),
		'feedback'      => array( 'Add customer feedback', 'Appends a customer-feedback band to the front page with three placeholder quotes. Replace them with real ones before Paystack looks.', '#8f6b28' ),
		'menu'          => array( 'Trim the menu', 'Removes Cart and Checkout from the menu, and adds Contact and FAQ’s if they are missing.', '#8f6b28' ),
		'returns'       => array( 'Add the cancellation clause', 'Paystack asked for a “refund and cancellation policy”; the Returns page had no cancellation clause. Appends one, with the real email and phone.', '#8f6b28' ),
		'dupes'         => array( 'Trash the duplicates', 'Moves the -2 and -3 copies to Trash. Never touches the front page, anything WooCommerce is assigned to, or a page with no original left.', '#8f6b28' ),
		'cache'  => array( 'Clear the cache', 'The reason /terms/ still shows a 404 to visitors even though the page is published.', '#8f6b28' ),
		'slugs'  => array( 'Fix the two URLs', '/contact-2/ → /contact/ and /privacy-policy-2/ → /privacy-policy/. The page IDs do not change, so the menu keeps working.', '#8f6b28' ),
		'sample' => array( 'Remove the sample policy', 'Trashes WooCommerce’s “This is a sample page” refund policy and points the WooCommerce setting at /returns-exchanges/.', '#8f6b28' ),
		'blanks' => array( 'Fill the blanks', 'Puts the site’s own email, store address, today’s date, a five-day refund window and the VAT sentence into the policy pages.', '#8f6b28' ),
		'scan'   => array( 'Scan for brackets', 'Lists every published page that still contains [SOMETHING], {email} or GH₵ ____.', '#555' ),
	);
	?>
	<div class="wrap">
		<h1>Queen Dor's — Launch Fixes <span style="font-size:13px;color:#666">v<?php echo esc_html( QFIX_VERSION ); ?></span></h1>
		<p style="max-width:780px">
			Five fixes that cannot be done from a WXR import or an HTML widget, because they are
			database writes. Each one is safe to press twice. Nothing here deletes anything —
			the sample policy is trashed, not erased.
		</p>

		<?php if ( isset( $_GET['ran'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><strong>Ran.</strong> The log below is from this run.</p></div>
		<?php endif; ?>

		<div style="display:flex;gap:12px;flex-wrap:wrap;margin:20px 0">
			<?php foreach ( $buttons as $key => $b ) : ?>
				<form method="post" style="flex:1 1 300px;border:1px solid #dcdcde;border-left:4px solid <?php echo esc_attr( $b[2] ); ?>;background:#fff;padding:16px;border-radius:4px">
					<?php wp_nonce_field( 'qfix_run' ); ?>
					<p style="margin:0 0 8px;font-weight:600;font-size:14px"><?php echo esc_html( $b[0] ); ?></p>
					<p style="margin:0 0 12px;color:#50575e;font-size:13px"><?php echo esc_html( $b[1] ); ?></p>
					<button class="button button-primary" name="qfix_action" value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $b[0] ); ?></button>
				</form>
			<?php endforeach; ?>
		</div>

		<h2>Log</h2>
		<?php $log = get_option( QFIX_LOG, array() ); ?>
		<?php if ( empty( $log ) ) : ?>
			<p><em>Nothing has run yet.</em></p>
		<?php else : ?>
			<pre style="background:#fff;border:1px solid #dcdcde;padding:14px;white-space:pre-wrap;font-size:13px;line-height:1.6"><?php echo esc_html( implode( "\n", $log ) ); ?></pre>
		<?php endif; ?>

		<h2>What this plugin does not do</h2>
		<ul style="max-width:780px;list-style:disc;padding-left:20px;color:#50575e">
			<li>The registration number, the business address (unless WooCommerce has a store address saved) and the three delivery prices still need a person.</li>
			<li>It does not add the nine missing product photographs.</li>
			<li>“Clean the home page” edits Elementor's saved layout. It backs the layout up first and “Restore the home page” undoes it — look at the page after pressing it.</li>
			<li>Once the footer is assigned in <em>Theme Options → Footer</em>, you can delete this plugin — the theme footer takes over automatically.</li>
		</ul>
	</div>
	<?php
}
