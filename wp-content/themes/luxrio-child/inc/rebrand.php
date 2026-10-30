<?php
/**
 * Rebrand: the vendor's name out, the client's name in.
 *
 * The parent theme hardcodes "Luxrio" and "Vecuro" in a few places and ships
 * them as the default footer credit. Rather than editing vendor files — which
 * the next theme update would overwrite — the strings are rewritten on their
 * way to the page.
 *
 * Replacements are deliberately case-sensitive. The theme's own directory is
 * `themes/luxrio/`, and a case-insensitive replace would rewrite that path in
 * every asset URL and take the styling with it.
 *
 * @package luxrio-child
 */

defined( 'ABSPATH' ) || exit;

/**
 * The name to show instead.
 *
 * @return string
 */
function queendor_brand_name() {
	/**
	 * Filter the displayed business name.
	 *
	 * @param string $name Business name.
	 */
	return apply_filters( 'queendor_brand_name', "Queen Dor's Fashion House" );
}

/**
 * Rewrite the vendor's strings in the theme's own text domains.
 *
 * Scoped by domain so this cannot touch a plugin's unrelated copy, and
 * case-sensitive so `luxrio` in a path is left alone.
 *
 * @param string $translated Translated text.
 * @param string $text       Original text.
 * @param string $domain     Text domain.
 * @return string
 */
function queendor_rebrand_gettext( $translated, $text, $domain ) {
	if ( ! in_array( $domain, array( 'luxrio', 'luxrio-core' ), true ) ) {
		return $translated;
	}

	$name = queendor_brand_name();

	$map = array(
		'Luxrio.' => $name,
		'Luxrio'  => $name,
		'Vecuro'  => $name,
	);

	return strtr( $translated, $map );
}
add_filter( 'gettext', 'queendor_rebrand_gettext', 20, 3 );

/**
 * Replace the demo's stored footer credit.
 *
 * The theme imports a copyright line into its options, so the string is in the
 * database rather than in code — a gettext filter never sees it. The value is
 * rewritten on read; saving the options panel afterwards persists the clean
 * line.
 *
 * @param mixed $value Option value.
 * @return mixed
 */
function queendor_rebrand_copyright_option( $value ) {
	if ( ! is_array( $value ) || empty( $value['luxrio_copyright_text'] ) ) {
		return $value;
	}

	$stored = (string) $value['luxrio_copyright_text'];

	if ( false === stripos( $stored, 'luxrio' ) && false === stripos( $stored, 'vecuro' ) ) {
		return $value;
	}

	$value['luxrio_copyright_text'] = sprintf(
		'&copy; %s %s. All rights reserved.',
		esc_html( gmdate( 'Y' ) ),
		esc_html( queendor_brand_name() )
	);

	return $value;
}
add_filter( 'option_luxrio_opt', 'queendor_rebrand_copyright_option' );

/**
 * Replace the installer's placeholder site name only.
 *
 * Filtering `blogname` catches the browser tab, the schema.org block, order
 * emails and the admin — but only while the value is still one WordPress or
 * the theme put there. A name the client has chosen is never overridden.
 *
 * @param string $value Site name.
 * @return string
 */
function queendor_rebrand_site_name( $value ) {
	$placeholders = array( 'My WordPress', 'Luxrio', 'Queen Dor' );

	if ( in_array( trim( (string) $value ), $placeholders, true ) ) {
		return queendor_brand_name();
	}

	return $value;
}
add_filter( 'option_blogname', 'queendor_rebrand_site_name' );

/**
 * Same treatment for the tagline, which ships as "Blank".
 *
 * @param string $value Tagline.
 * @return string
 */
function queendor_rebrand_site_tagline( $value ) {
	$placeholders = array( 'Blank', 'Just another WordPress site' );

	if ( in_array( trim( (string) $value ), $placeholders, true ) ) {
		return __( 'Elegant jewellery for every occasion', 'luxrio-child' );
	}

	return $value;
}
add_filter( 'option_blogdescription', 'queendor_rebrand_site_tagline' );
