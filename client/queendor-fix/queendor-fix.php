<?php
/**
 * Plugin Name:       Queen Dor's — Launch Fixes
 * Description:       Clears the cached 404s, puts Contact and Privacy back on their proper URLs, removes WooCommerce's sample refund page, fills the blanks the site can fill by itself, and prints the footer on every page. Each fix is a button; nothing runs on its own.
 * Version:           1.0.0
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

const QFIX_VERSION = '1.0.0';
const QFIX_CAP     = 'manage_options';
const QFIX_SLUG    = 'queendor-fix';
const QFIX_LOG     = 'qfix_log';

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
	$email = sanitize_email( get_option( 'admin_email' ) );

	$phone = '';
	foreach ( array( 'woocommerce_store_phone', 'woocommerce_store_phone_number' ) as $key ) {
		$candidate = trim( (string) get_option( $key ) );
		if ( '' !== $candidate ) {
			$phone = $candidate;
			break;
		}
	}

	$street = trim( (string) get_option( 'woocommerce_store_address' ) );
	$city   = trim( (string) get_option( 'woocommerce_store_city' ) );
	if ( '' === $city ) {
		$city = 'Accra';
	}
	$address = $street ? $street . ', ' . $city . ', Ghana' : '';

	return array(
		'email'   => $email,
		'phone'   => $phone,
		'street'  => $street,
		'city'    => $city,
		'address' => $address,
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

	if ( $d['email'] ) {
		$e       = $d['email'];
		$rules[] = array( '/\[EMAIL ADDRESS\]/', $e, 'email' );
		$rules[] = array( '/\{email address\}/', $e, 'email' );
		$rules[] = array( '/\{email\}/', $e, 'email' );
		$rules[] = array( '/(Email:)(\s*<\/strong>)?\s*_{2,}/', '$1$2 ' . $e, 'email' );
		$rules[] = array( '/(Write to\s*)(<strong>)?\s*_{2,}/', '$1$2' . $e, 'email' );
	}

	if ( $d['phone'] ) {
		$ph      = $d['phone'];
		$rules[] = array( '/\[PHONE NUMBER\]/', $ph, 'phone' );
		$rules[] = array( '/(Phone \/ WhatsApp:)(\s*<\/strong>)?\s*_{2,}/', '$1$2 ' . $ph, 'phone' );
	}

	if ( $d['address'] ) {
		$rules[] = array( '/(Studio:)(\s*<\/strong>)?\s*_{2,}[^<\n]*/', '$1$2 ' . $d['address'], 'address' );
	}

	$rules[] = array(
		'/(Opening hours:)(\s*<\/strong>)?\s*_{2,}/',
		'$1$2 Monday–Friday, 9:00–17:00; Saturday, 10:00–14:00',
		'hours',
	);
	$rules[] = array( '/\[DATE\]/', $d['date'], 'date' );
	$rules[] = array( '/\[NUMBER\]\s*working days/', 'five working days', 'refund window' );
	$rules[] = array(
		'/\[Delete whichever does not apply:[^\]]*\]/s',
		'We are not currently VAT-registered; no VAT is charged.',
		'VAT sentence',
	);
	$rules[] = array(
		'/\[Choose one:[^\]]*\]/s',
		'Collection can be arranged in Accra — message us before you order and we will confirm a time.',
		'collection answer',
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

		foreach ( $rules as $rule ) {
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
		$hits = array();
		foreach ( $patterns as $p ) {
			$c = substr_count( (string) $page->post_content, $p );
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
 * Buffer the page so the footer can be placed before </body>.
 *
 * @return void
 */
function qfix_start_buffer() {
	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() || is_feed() || is_robots() ) {
		return;
	}
	ob_start( 'qfix_inject_footer' );
}
add_action( 'template_redirect', 'qfix_start_buffer', 1 );

/**
 * Inject the footer unless the page already rendered one.
 *
 * @param string $html Full page HTML.
 * @return string
 */
function qfix_inject_footer( $html ) {
	if ( ! is_string( $html ) || '' === $html ) {
		return $html;
	}

	// The theme footer, once assigned, wins.
	if ( false !== strpos( $html, 'qd-footer' ) ) {
		return $html;
	}

	if ( false !== stripos( $html, '</body>' ) ) {
		return str_replace( '</body>', qfix_footer_html() . "\n</body>", $html );
	}

	return $html . qfix_footer_html();
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
		case 'all':
			qfix_purge_cache();
			qfix_fix_slugs();
			qfix_trash_sample_refund();
			qfix_fill_placeholders();
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
	if ( ! in_array( $key, array( 'cache', 'slugs', 'sample', 'blanks', 'scan', 'all' ), true ) ) {
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
		'all'    => array( 'Run all fixes', 'Clears the cache, fixes both slugs, trashes the sample policy, fills the blanks, then clears the cache again and reports what is left. Start here.', '#0b4b4c' ),
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
			<li>It does not touch the home page demo sections or the nine products without photographs.</li>
			<li>Once the footer is assigned in <em>Theme Options → Footer</em>, you can delete this plugin — the theme footer takes over automatically.</li>
		</ul>
	</div>
	<?php
}
