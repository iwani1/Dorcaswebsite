<?php
/**
 * Single-product blocks: the symbol panel and the care note.
 *
 * The parent theme re-registers the summary hooks at its own priorities
 * (title/price 10, excerpt 40, availability 50, add to cart 60, meta 80),
 * so the slots used here sit between them rather than on WooCommerce's
 * defaults.
 *
 * @package luxrio-child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Print the symbol panel under the short description.
 *
 * @return void
 */
function queendor_summary_symbol_panel() {
	global $product;

	if ( ! $product instanceof WC_Product ) {
		return;
	}

	queendor_symbol_panel( $product );
}
add_action( 'woocommerce_single_product_summary', 'queendor_summary_symbol_panel', 45 );

/**
 * Care copy keyed by the Material attribute value.
 *
 * @return array<string,string>
 */
function queendor_care_notes() {
	$notes = array(
		'gold-plated'    => 'Gold plating is a finish, not the metal. Put your jewellery on last and take it off first — after perfume, after lotion, before the shower. Wipe with a soft dry cloth and store it in its pouch, away from other pieces.',
		'brass'          => 'Solid brass develops a natural patina with wear, which many people prefer. To bring back the shine, polish with a soft dry cloth. Keep it away from water, perfume and chlorine, and store it dry.',
		'sterling-silver' => 'Sterling silver tarnishes naturally when exposed to air. Wear it often — wearing slows tarnishing — and polish with a silver cloth. Store it in a sealed bag, not loose in a drawer.',
		'beaded'         => 'Keep beads away from water, perfume and hair products, which dull the finish over time. Store flat, not hanging, so the thread keeps its shape.',
		'silver'         => 'Polish with a soft silver cloth. Avoid water, perfume and chlorine, and store dry and sealed.',
	);

	/**
	 * Filter the care notes.
	 *
	 * @param array<string,string> $notes Notes keyed by sanitised material name.
	 */
	return apply_filters( 'queendor_care_notes', array_filter( $notes ) );
}

/**
 * Read the material values on a product, global or product-level attribute.
 *
 * @param WC_Product $product Product object.
 * @return string[]
 */
function queendor_product_materials( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return array();
	}

	$raw = $product->get_attribute( 'pa_material' );

	if ( '' === $raw ) {
		$raw = $product->get_attribute( 'material' );
	}

	if ( '' === $raw ) {
		return array();
	}

	return array_filter( array_map( 'trim', explode( ',', wp_strip_all_tags( $raw ) ) ) );
}

/**
 * Print the care block after the add-to-cart button.
 *
 * @return void
 */
function queendor_summary_care_block() {
	global $product;

	if ( ! $product instanceof WC_Product ) {
		return;
	}

	$notes = queendor_care_notes();
	$text  = '';

	foreach ( queendor_product_materials( $product ) as $material ) {
		$key = sanitize_title( $material );

		if ( isset( $notes[ $key ] ) ) {
			$text = $notes[ $key ];
			break;
		}
	}

	if ( '' === $text ) {
		$text = 'Keep your piece away from water, perfume and chlorine, wipe it with a soft dry cloth, and store it in its pouch.';
	}

	echo '<div class="qd-care">';
	echo '<h4 class="qd-care__title">' . esc_html__( 'Care', 'luxrio-child' ) . '</h4>';
	echo '<p class="qd-care__text">' . esc_html( $text ) . '</p>';
	echo '</div>';
}
add_action( 'woocommerce_single_product_summary', 'queendor_summary_care_block', 70 );
