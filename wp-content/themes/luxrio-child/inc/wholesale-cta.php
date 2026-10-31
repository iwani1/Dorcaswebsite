<?php
/**
 * Where the wholesale offer is shown.
 *
 * Three placements, all rendered by the child theme so nobody has to build
 * them in Elementor:
 *
 *   1. a band on the home page, directly after the hero slider
 *   2. a line under the price on every product page
 *   3. the wholesale page's copy, while it still contains blank placeholders
 *
 * The band is injected through Elementor's own render filter rather than by
 * editing the saved page, so the client's layout stays untouched and can be
 * edited normally afterwards.
 *
 * @package luxrio-child
 */

defined( 'ABSPATH' ) || exit;

/**
 * URL of the wholesale page.
 *
 * @return string
 */
function queendor_wholesale_page_url() {
	$page = get_page_by_path( 'wholesale' );

	if ( $page ) {
		return get_permalink( $page );
	}

	return home_url( '/wholesale/' );
}

/**
 * The lowest trade price in the catalogue, and the retail price it came from.
 *
 * Cached for half a day and cleared whenever a product is saved — the customer
 * facing cost of this should be one array lookup, not a query.
 *
 * @return array{retail: float, trade: float}|null
 */
function queendor_wholesale_from_price() {
	$cached = get_transient( 'queendor_wholesale_from' );

	if ( is_array( $cached ) ) {
		return $cached['trade'] > 0 ? $cached : null;
	}

	global $wpdb;

	$retail = (float) $wpdb->get_var( // phpcs:ignore WordPress.DB.DirectDatabaseQuery
		"SELECT MIN(CAST(pm.meta_value AS DECIMAL(12,2)))
		 FROM {$wpdb->postmeta} pm
		 INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
		 WHERE pm.meta_key = '_price'
		   AND pm.meta_value <> ''
		   AND pm.meta_value > 0
		   AND p.post_status = 'publish'
		   AND p.post_type IN ('product','product_variation')"
	);

	$data = array(
		'retail' => $retail,
		'trade'  => $retail > 0 ? queendor_wholesale_trade_price( $retail ) : 0,
	);

	set_transient( 'queendor_wholesale_from', $data, 12 * HOUR_IN_SECONDS );

	return $data['trade'] > 0 ? $data : null;
}

/**
 * Drop the cached figure when the catalogue changes.
 */
function queendor_wholesale_clear_from_price() {
	delete_transient( 'queendor_wholesale_from' );
}
add_action( 'save_post_product', 'queendor_wholesale_clear_from_price' );
add_action( 'woocommerce_update_product', 'queendor_wholesale_clear_from_price' );
add_action( 'woocommerce_delete_product', 'queendor_wholesale_clear_from_price' );

/**
 * Plain-text price.
 *
 * wc_price() returns the currency as an HTML entity (&#8373; for the cedi),
 * which survives wp_strip_all_tags() and would print as literal characters in
 * a sentence, so it has to be decoded after the tags come off.
 *
 * @param float $amount Amount in shop currency.
 * @return string
 */
function queendor_wholesale_money( $amount ) {
	if ( ! function_exists( 'wc_price' ) ) {
		return number_format_i18n( (float) $amount, 2 );
	}

	return html_entity_decode( wp_strip_all_tags( wc_price( $amount ) ), ENT_QUOTES, 'UTF-8' );
}

/* -------------------------------------------------------------------------
 * 1. The band, after the hero
 * ---------------------------------------------------------------------- */

/**
 * HTML of the wholesale band.
 *
 * @return string
 */
function queendor_wholesale_band() {
	$from = queendor_wholesale_from_price();

	if ( $from ) {
		$text = sprintf(
			/* translators: %s: lowest trade price, e.g. ₵90.00. */
			__( 'Adinkra jewellery for boutiques and stockists. Trade prices from %1$s a piece, %2$d per style minimum, boxed and retail-ready.', 'luxrio-child' ),
			queendor_wholesale_money( $from['trade'] ),
			(int) QUEENDOR_WHOLESALE_MIN_QTY
		);
	} else {
		$text = __( 'Adinkra jewellery for boutiques and stockists. Trade prices, boxed and retail-ready.', 'luxrio-child' );
	}

	ob_start();
	?>
	<section class="qd-trade">
		<div class="qd-trade__inner">
			<div class="qd-trade__copy">
				<span class="qd-trade__eyebrow"><?php esc_html_e( 'Wholesale', 'luxrio-child' ); ?></span>
				<h2 class="qd-trade__title"><?php esc_html_e( "Stock Queen Dor's", 'luxrio-child' ); ?></h2>
				<p class="qd-trade__text"><?php echo esc_html( $text ); ?></p>
			</div>
			<div class="qd-trade__action">
				<a class="qd-trade__btn" href="<?php echo esc_url( queendor_wholesale_page_url() ); ?>">
					<?php esc_html_e( 'Apply for a trade account', 'luxrio-child' ); ?>
				</a>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

/**
 * Insert the band after the hero slider widget.
 *
 * Elementor renders each widget through this filter, so the band lands exactly
 * where the hero ends without anything being written into the saved page.
 *
 * @param string $content Rendered widget HTML.
 * @param object $widget  Elementor widget instance.
 * @return string
 */
function queendor_wholesale_band_after_hero( $content, $widget ) {
	static $placed = false;

	if ( $placed || ! is_front_page() ) {
		return $content;
	}

	if ( ! is_object( $widget ) || ! method_exists( $widget, 'get_name' ) ) {
		return $content;
	}

	$heroes = array( 'luxrioheroone', 'luxrioherotwo', 'luxrioherothree', 'luxrioherofour' );

	if ( ! in_array( $widget->get_name(), $heroes, true ) ) {
		return $content;
	}

	if ( ! apply_filters( 'queendor_wholesale_show_band', true ) ) {
		return $content;
	}

	$placed = true;

	return $content . queendor_wholesale_band();
}
add_filter( 'elementor/widget/render_content', 'queendor_wholesale_band_after_hero', 10, 2 );

/* -------------------------------------------------------------------------
 * 2. Under the price, on a product
 * ---------------------------------------------------------------------- */

/**
 * A one-line trade nudge for retail visitors looking at a piece.
 */
function queendor_wholesale_product_line() {
	if ( queendor_wholesale_is_wholesale() || ! function_exists( 'is_product' ) || ! is_product() ) {
		return;
	}

	global $product;

	if ( ! $product instanceof WC_Product ) {
		return;
	}

	$retail = (float) $product->get_regular_price();

	if ( $retail <= 0 && $product->is_type( 'variable' ) ) {
		$retail = (float) $product->get_variation_regular_price( 'min', true );
	}

	$link = sprintf(
		'<a href="%s">%s</a>',
		esc_url( queendor_wholesale_page_url() ),
		esc_html__( 'apply for a trade account', 'luxrio-child' )
	);

	$text = $retail > 0
		? sprintf(
			/* translators: 1: trade price, 2: link to the wholesale page. */
			__( 'Stocking a shop? Trade price %1$s &mdash; %2$s.', 'luxrio-child' ),
			esc_html( queendor_wholesale_money( queendor_wholesale_trade_price( $retail ) ) ),
			$link
		)
		: sprintf(
			/* translators: %s: link to the wholesale page. */
			__( 'Stocking a shop? Trade pricing is available &mdash; %s.', 'luxrio-child' ),
			$link
		);

	printf( '<p class="qd-trade-line">%s</p>', wp_kses_post( $text ) );
}
add_action( 'woocommerce_single_product_summary', 'queendor_wholesale_product_line', 15 );

/* -------------------------------------------------------------------------
 * 3. The wholesale page, while it still has blanks in it
 * ---------------------------------------------------------------------- */

/**
 * Replace the placeholder copy on the wholesale page.
 *
 * Only while the page still contains the blank markers it was imported with.
 * The moment somebody edits the page and removes them, this stops running and
 * their own words win — the filter cannot fight an editor.
 *
 * @param string $content Page content.
 * @return string
 */
function queendor_wholesale_page_copy( $content ) {
	if ( ! is_page( 'wholesale' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}

	if ( false === strpos( $content, '________' ) ) {
		return $content;
	}

	$from = queendor_wholesale_from_price();

	$terms = array(
		sprintf(
			/* translators: %d: minimum quantity. */
			__( 'Minimum order: %d pieces per style', 'luxrio-child' ),
			(int) QUEENDOR_WHOLESALE_MIN_QTY
		),
		sprintf(
			/* translators: %d: percentage off retail. */
			__( 'Trade price: %d%% of the retail price', 'luxrio-child' ),
			(int) round( ( 1 - (float) QUEENDOR_WHOLESALE_DISCOUNT ) * 100 )
		),
		__( 'Payment: online at checkout, by card or mobile money', 'luxrio-child' ),
		__( 'Packaging: boxed and retail-ready', 'luxrio-child' ),
		__( 'Delivery: quoted at checkout', 'luxrio-child' ),
	);

	if ( $from ) {
		$terms[] = sprintf(
			/* translators: %s: lowest trade price. */
			__( 'Trade prices from %s a piece', 'luxrio-child' ),
			queendor_wholesale_money( $from['trade'] )
		);
	}

	$html  = '<p>' . esc_html__( "We supply boutiques and stockists with Adinkra jewellery, boxed and ready for the shelf. Apply below and we will review your account within one working day.", 'luxrio-child' ) . '</p>';
	$html .= '<ul class="qd-terms">';

	foreach ( $terms as $term ) {
		$html .= '<li>' . esc_html( $term ) . '</li>';
	}

	$html .= '</ul>';
	$html .= '<h3>' . esc_html__( 'Apply for a trade account', 'luxrio-child' ) . '</h3>';
	$html .= do_shortcode( '[queendor_wholesale_apply]' );

	return $html;
}
add_filter( 'the_content', 'queendor_wholesale_page_copy', 20 );

/* -------------------------------------------------------------------------
 * 4. Styles
 * ---------------------------------------------------------------------- */

/**
 * Load the stylesheet.
 */
function queendor_wholesale_styles() {
	wp_enqueue_style(
		'queendor-wholesale',
		get_stylesheet_directory_uri() . '/assets/css/wholesale.css',
		array(),
		queendor_version()
	);
}
add_action( 'wp_enqueue_scripts', 'queendor_wholesale_styles', 20 );
