<?php
/**
 * Ring sizing: a product tab and a standalone guide.
 *
 * Ring size is the one attribute that turns into a return when it is got
 * wrong, so the guide sits on the product page itself rather than only in
 * the footer.
 *
 * @package luxrio-child
 */

defined( 'ABSPATH' ) || exit;

/**
 * UK ring sizes and their approximate inner circumference.
 *
 * @return array<string,int>
 */
function queendor_ring_sizes() {
	$sizes = array(
		'L' => 51,
		'N' => 54,
		'P' => 56,
		'R' => 59,
		'T' => 61,
		'V' => 64,
		'X' => 67,
		'Z' => 69,
	);

	/**
	 * Filter the published ring chart. Confirm against the supplier before
	 * launch — tolerance varies by manufacturer.
	 *
	 * @param array<string,int> $sizes Letter size => circumference in mm.
	 */
	return apply_filters( 'queendor_ring_sizes', $sizes );
}

/**
 * Whether a product offers a ring size.
 *
 * @param WC_Product $product Product object.
 * @return bool
 */
function queendor_is_ring( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return false;
	}

	foreach ( array( 'pa_ring-size', 'ring-size' ) as $key ) {
		if ( '' !== $product->get_attribute( $key ) ) {
			return true;
		}
	}

	return false;
}

/**
 * The guide markup, shared by the tab and the shortcode.
 *
 * @return string
 */
function queendor_ring_guide_html() {
	$sizes = queendor_ring_sizes();

	$html  = '<div class="qd-ring-guide">';
	$html .= '<h3 class="qd-ring-guide__title">' . esc_html__( 'Find your ring size', 'luxrio-child' ) . '</h3>';
	$html .= '<p>' . esc_html__( 'Measuring a ring you already own is more accurate than measuring your finger. Take a ring that fits the finger you are buying for, measure its inside diameter in millimetres, and read across.', 'luxrio-child' ) . '</p>';

	$html .= '<table class="qd-ring-guide__table"><thead><tr>';
	$html .= '<th scope="col">' . esc_html__( 'UK size', 'luxrio-child' ) . '</th>';
	$html .= '<th scope="col">' . esc_html__( 'Inside diameter', 'luxrio-child' ) . '</th>';
	$html .= '<th scope="col">' . esc_html__( 'Finger circumference', 'luxrio-child' ) . '</th>';
	$html .= '</tr></thead><tbody>';

	foreach ( $sizes as $label => $circumference ) {
		$diameter = round( $circumference / M_PI, 1 );

		$html .= '<tr>';
		$html .= '<th scope="row">' . esc_html( $label ) . '</th>';
		$html .= '<td>' . esc_html( $diameter . ' mm' ) . '</td>';
		$html .= '<td>' . esc_html( $circumference . ' mm' ) . '</td>';
		$html .= '</tr>';
	}

	$html .= '</tbody></table>';

	$html .= '<ul class="qd-ring-guide__notes">';
	$html .= '<li>' . esc_html__( 'Measure at the end of the day — fingers are slightly larger then than in the morning.', 'luxrio-child' ) . '</li>';
	$html .= '<li>' . esc_html__( 'If you are between two sizes, size up.', 'luxrio-child' ) . '</li>';
	$html .= '<li>' . esc_html__( 'Wide bands fit tighter than thin ones. On a wide band, take the next size up.', 'luxrio-child' ) . '</li>';
	$html .= '</ul>';

	$html .= '<p class="qd-ring-guide__made">' . esc_html__( 'Not sure, or between sizes? Choose “Made to order” and we will confirm your size before we start the piece.', 'luxrio-child' ) . '</p>';
	$html .= '</div>';

	return $html;
}

/**
 * Add the ring guide tab to ring products.
 *
 * @param array<string,array<string,mixed>> $tabs Product tabs.
 * @return array<string,array<string,mixed>>
 */
function queendor_ring_guide_tab( $tabs ) {
	global $product;

	if ( ! queendor_is_ring( $product ) ) {
		return $tabs;
	}

	$tabs['queendor_ring_guide'] = array(
		'title'    => __( 'Ring size guide', 'luxrio-child' ),
		'priority' => 15,
		'callback' => 'queendor_ring_guide_tab_content',
	);

	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'queendor_ring_guide_tab', 20 );

/**
 * Tab content.
 *
 * @return void
 */
function queendor_ring_guide_tab_content() {
	echo queendor_ring_guide_html(); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in the builder.
}

/**
 * `[queendor_ring_guide]` for a standalone Size Guide page.
 *
 * @return string
 */
function queendor_sc_ring_guide() {
	return queendor_ring_guide_html();
}
add_shortcode( 'queendor_ring_guide', 'queendor_sc_ring_guide' );
