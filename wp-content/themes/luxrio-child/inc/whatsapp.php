<?php
/**
 * WhatsApp ordering.
 *
 * The bio says "Shop / Order on WhatsApp" — that channel already works, so the
 * site feeds it rather than competing with it. Number is set in
 * Settings → Queen Dor's, so it can be changed without touching code.
 *
 * @package luxrio-child
 */

defined( 'ABSPATH' ) || exit;

const QUEENDOR_OPTION_PHONE   = 'queendor_whatsapp';
const QUEENDOR_OPTION_FLOATING = 'queendor_whatsapp_floating';

/**
 * Whether a number can plausibly be dialled.
 *
 * Ghana numbers are 233 plus nine digits — twelve in total. A short number
 * still produces a link, and that link silently goes nowhere, so it is worth
 * refusing rather than saving.
 *
 * @param string $digits Digits only.
 * @return bool
 */
function queendor_phone_is_valid( $digits ) {
	$length = strlen( $digits );

	if ( $length < 10 || $length > 15 ) {
		return false;
	}

	if ( 0 === strpos( $digits, '233' ) && 12 !== $length ) {
		return false;
	}

	return true;
}

/**
 * Strip a phone number to digits and make sure it carries a country code.
 *
 * @param string $value Raw input.
 * @return string Sanitised digits, or the previously saved value if invalid.
 */
function queendor_sanitize_phone( $value ) {
	$digits = preg_replace( '/[^0-9]/', '', (string) $value );

	if ( '' === $digits ) {
		return '';
	}

	// A local Ghanaian number written as 024 123 4567 needs 233 and no leading zero.
	if ( 0 === strpos( $digits, '0' ) ) {
		$digits = '233' . substr( $digits, 1 );
	}

	if ( ! queendor_phone_is_valid( $digits ) ) {
		add_settings_error(
			'queendor_settings',
			'queendor_phone_invalid',
			sprintf(
				/* translators: %s: the rejected digits */
				esc_html__( '"%s" is not a dialable number, so it was not saved. A Ghanaian mobile needs 233 followed by nine digits — 024 123 4567 becomes 233241234567.', 'luxrio-child' ),
				esc_html( $digits )
			),
			'error'
		);

		return (string) get_option( QUEENDOR_OPTION_PHONE, '' );
	}

	return $digits;
}

/**
 * The configured number, or an empty string.
 *
 * @return string
 */
function queendor_whatsapp_number() {
	$number = get_option( QUEENDOR_OPTION_PHONE, '' );

	return queendor_sanitize_phone( $number );
}

/**
 * Build a wa.me link with an optional prefilled message.
 *
 * @param string $message Message body.
 * @return string Empty string when no number is configured.
 */
function queendor_whatsapp_url( $message = '' ) {
	$number = queendor_whatsapp_number();

	if ( '' === $number ) {
		return '';
	}

	$url = 'https://wa.me/' . $number;

	if ( '' !== $message ) {
		$url .= '?text=' . rawurlencode( $message );
	}

	return $url;
}

/**
 * Register the settings screen.
 *
 * @return void
 */
function queendor_register_settings() {
	register_setting(
		'queendor_settings',
		QUEENDOR_OPTION_PHONE,
		array(
			'type'              => 'string',
			'sanitize_callback' => 'queendor_sanitize_phone',
			'default'           => '',
		)
	);

	register_setting(
		'queendor_settings',
		QUEENDOR_OPTION_FLOATING,
		array(
			'type'              => 'string',
			'sanitize_callback' => 'queendor_sanitize_checkbox',
			'default'           => '1',
		)
	);

	add_settings_section(
		'queendor_main',
		__( 'WhatsApp ordering', 'luxrio-child' ),
		'queendor_settings_intro',
		'queendor'
	);

	add_settings_field(
		QUEENDOR_OPTION_PHONE,
		__( 'WhatsApp number', 'luxrio-child' ),
		'queendor_field_phone',
		'queendor',
		'queendor_main'
	);

	add_settings_field(
		QUEENDOR_OPTION_FLOATING,
		__( 'Floating button', 'luxrio-child' ),
		'queendor_field_floating',
		'queendor',
		'queendor_main'
	);
}
add_action( 'admin_init', 'queendor_register_settings' );

/**
 * Normalise a checkbox value.
 *
 * @param mixed $value Raw value.
 * @return string
 */
function queendor_sanitize_checkbox( $value ) {
	return ( '1' === (string) $value || 'on' === (string) $value ) ? '1' : '0';
}

/**
 * Intro copy.
 *
 * @return void
 */
function queendor_settings_intro() {
	echo '<p>' . esc_html__( 'Enter the number in international format, digits only. A local number is converted for you: 024 123 4567 is saved as 233241234567.', 'luxrio-child' ) . '</p>';
}

/**
 * Phone field.
 *
 * @return void
 */
function queendor_field_phone() {
	$value = queendor_whatsapp_number();

	printf(
		'<input type="text" name="%1$s" id="%1$s" value="%2$s" class="regular-text" placeholder="233241234567" inputmode="numeric" />',
		esc_attr( QUEENDOR_OPTION_PHONE ),
		esc_attr( $value )
	);

	if ( '' === $value ) {
		echo '<p class="description" style="color:#b32d2e;"><strong>'
			. esc_html__( 'No number saved — the WhatsApp buttons are hidden until you add one.', 'luxrio-child' )
			. '</strong></p>';
		return;
	}

	echo '<p class="description">' . esc_html__( 'Saved. Your buttons link to:', 'luxrio-child' ) . ' ';
	echo '<a href="' . esc_url( 'https://wa.me/' . $value ) . '" target="_blank" rel="noopener">'
		. esc_html( 'https://wa.me/' . $value ) . '</a></p>';

	if ( ! queendor_phone_is_valid( $value ) ) {
		echo '<p class="description" style="color:#b32d2e;"><strong>'
			. esc_html__( 'This number is too short to reach WhatsApp. Re-enter it as 233 followed by nine digits.', 'luxrio-child' )
			. '</strong></p>';
	}
}

/**
 * Floating button field.
 *
 * @return void
 */
function queendor_field_floating() {
	$value = get_option( QUEENDOR_OPTION_FLOATING, '1' );

	printf(
		'<label><input type="checkbox" name="%1$s" id="%1$s" value="1" %2$s /> %3$s</label>',
		esc_attr( QUEENDOR_OPTION_FLOATING ),
		checked( '1', $value, false ),
		esc_html__( 'Show a floating WhatsApp button on every page', 'luxrio-child' )
	);
}

/**
 * Add the settings page.
 *
 * @return void
 */
function queendor_add_settings_page() {
	add_options_page(
		__( "Queen Dor's", 'luxrio-child' ),
		__( "Queen Dor's", 'luxrio-child' ),
		'manage_options',
		'queendor',
		'queendor_render_settings_page'
	);
}
add_action( 'admin_menu', 'queendor_add_settings_page' );

/**
 * Render the settings page.
 *
 * @return void
 */
function queendor_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	echo '<div class="wrap">';
	echo '<h1>' . esc_html__( "Queen Dor's — shop settings", 'luxrio-child' ) . '</h1>';
	echo '<form method="post" action="options.php">';

	settings_fields( 'queendor_settings' );
	do_settings_sections( 'queendor' );
	submit_button();

	echo '</form></div>';
}

/**
 * "Order on WhatsApp" on the product page.
 *
 * @return void
 */
function queendor_product_whatsapp_button() {
	global $product;

	if ( ! $product instanceof WC_Product ) {
		return;
	}

	$name  = $product->get_name();
	$sku   = $product->get_sku();
	$price = wp_strip_all_tags( wc_price( $product->get_price() ) );
	$link  = get_permalink( $product->get_id() );

	$message = sprintf(
		/* translators: 1: product name, 2: price, 3: product URL */
		__( "Hello Queen Dor's, I'd like to order:%1\$s\nPrice: %2\$s\n%3\$s", 'luxrio-child' ),
		$name,
		$price,
		$link
	);

	if ( '' !== $sku ) {
		$message .= "\n" . sprintf( __( 'Ref: %s', 'luxrio-child' ), $sku );
	}

	$url = queendor_whatsapp_url( $message );

	if ( '' === $url ) {
		return;
	}

	echo '<a class="qd-wa-button" href="' . esc_url( $url ) . '" target="_blank" rel="noopener nofollow">'
		. esc_html__( 'Order on WhatsApp', 'luxrio-child' )
		. '</a>';
}
add_action( 'woocommerce_single_product_summary', 'queendor_product_whatsapp_button', 65 );

/**
 * Floating button, site-wide except on cart and checkout where it distracts
 * from finishing the order.
 *
 * @return void
 */
function queendor_floating_whatsapp() {
	if ( '1' !== get_option( QUEENDOR_OPTION_FLOATING, '1' ) ) {
		return;
	}

	if ( function_exists( 'is_cart' ) && ( is_cart() || is_checkout() ) ) {
		return;
	}

	$url = queendor_whatsapp_url( __( "Hello Queen Dor's, I'd like to ask about a piece.", 'luxrio-child' ) );

	if ( '' === $url ) {
		return;
	}

	echo '<a class="qd-wa-float" href="' . esc_url( $url ) . '" target="_blank" rel="noopener nofollow" aria-label="'
		. esc_attr__( 'Chat with us on WhatsApp', 'luxrio-child' ) . '">';
	echo '<svg viewBox="0 0 24 24" width="26" height="26" aria-hidden="true" focusable="false">'
		. '<path fill="currentColor" d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2Zm0 18.2a8.2 8.2 0 0 1-4.2-1.2l-.3-.2-3 .8.8-2.9-.2-.3A8.2 8.2 0 1 1 12 20.2Zm4.5-6.1c-.2-.1-1.5-.7-1.7-.8s-.4-.1-.6.1-.7.8-.8 1-.3.2-.5.1a6.7 6.7 0 0 1-3.3-2.9c-.3-.4.2-.4.5-1.1.1-.2 0-.4 0-.5l-.8-1.8c-.2-.5-.4-.4-.6-.4h-.5a1 1 0 0 0-.7.3A2.9 2.9 0 0 0 6.6 10a5 5 0 0 0 1 2.7 11.4 11.4 0 0 0 4.4 3.9c1.6.6 2.2.7 3 .6a2.6 2.6 0 0 0 1.7-1.2 2.1 2.1 0 0 0 .1-1.2c0-.1-.2-.2-.3-.3Z"/>'
		. '</svg>';
	echo '<span class="qd-wa-float__label">' . esc_html__( 'WhatsApp', 'luxrio-child' ) . '</span>';
	echo '</a>';
}
add_action( 'wp_footer', 'queendor_floating_whatsapp', 20 );
