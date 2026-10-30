<?php
/**
 * Adinkra symbol content.
 *
 * The symbol is the product story: every piece carries a name and a meaning.
 * Copy lives here in one place so it can be corrected in a single edit rather
 * than across forty product descriptions.
 *
 * @package luxrio-child
 */

defined( 'ABSPATH' ) || exit;

/**
 * The house symbol library.
 *
 * `short`  — the literal meaning, shown as a label.
 * `line`   — the one-line product-page line.
 * `story`  — the longer paragraph used on symbol landing pages.
 *
 * @return array<string,array<string,string>>
 */
function queendor_symbols() {
	$symbols = array(
		'gye-nyame'         => array(
			'name'  => 'Gye Nyame',
			'short' => 'Except for God',
			'line'  => 'Wear the reminder that nothing happens outside God\'s knowledge.',
			'story' => 'Gye Nyame is the most widely worn of all Adinkra symbols. It speaks to the supremacy of the divine — that everything that has happened, is happening, and will happen, is already known. It is worn as reassurance as much as declaration.',
		),
		'sankofa'           => array(
			'name'  => 'Sankofa',
			'short' => 'Go back and fetch it',
			'line'  => 'Carry where you come from into where you\'re going.',
			'story' => 'The Sankofa bird flies forward while its head turns back to take an egg from its tail. The symbol says that it is not wrong to return for what was left behind — wisdom, heritage, a way of doing things. It is the most gifted of the Adinkra symbols, because it can mean both "remember" and "go and learn".',
		),
		'duafe'             => array(
			'name'  => 'Duafe',
			'short' => 'The wooden comb',
			'line'  => 'A symbol of beauty that is looked after, not just worn.',
			'story' => 'Duafe is the Akan wooden comb, given as a token of love and care. It speaks to beauty, cleanliness, and the feminine — and to the idea that beauty is something tended rather than something owned.',
		),
		'akoma'             => array(
			'name'  => 'Akoma',
			'short' => 'The heart',
			'line'  => 'For the days that ask for patience.',
			'story' => 'Akoma is the heart, and it stands for patience, tolerance, and endurance. It is worn as a promise to oneself — that the heart can hold more than the moment it is in.',
		),
		'bese-saka'         => array(
			'name'  => 'Bese Saka',
			'short' => 'The sack of cola nuts',
			'line'  => 'Abundance shared is abundance kept.',
			'story' => 'A sack of cola nuts was a symbol of affluence and of trade, and of the unity of the people who grew and sold them. Bese Saka means abundance — and the responsibility that comes with it.',
		),
		'dwennimmen'        => array(
			'name'  => 'Dwennimmen',
			'short' => 'The ram\'s horns',
			'line'  => 'Strength that doesn\'t need to announce itself.',
			'story' => 'The ram fights with its horns, but the same horns are also a symbol of humility. Dwennimmen holds both at once: power and restraint, strength and the wisdom to keep it quiet.',
		),
		'adinkrahene'       => array(
			'name'  => 'Adinkrahene',
			'short' => 'Chief of all Adinkra symbols',
			'line'  => 'The symbol all other symbols answer to.',
			'story' => 'Three concentric circles, and the king of the Adinkra symbols. Adinkrahene stands for leadership, greatness, and charisma — the standard that the others are measured against.',
		),
		'nkyinkyim'         => array(
			'name'  => 'Nkyinkyim',
			'short' => 'The twisting',
			'line'  => 'For the ones who change shape and keep going.',
			'story' => 'From the proverb, "the twisting of the hair" — one should adapt to the twists and turns of life. Nkyinkyim stands for initiative, dynamism, and the versatility to find another way when the first one closes.',
		),
		'nsaa'              => array(
			'name'  => 'Nsaa',
			'short' => 'The hand-woven blanket',
			'line'  => 'Excellence is a standard, not a finish.',
			'story' => 'From the saying that one who knows the Nsaa cloth reweaves the defective one, Nsaa stands for quality and excellence — the rule that good work is redone, not excused.',
		),
		'eban'              => array(
			'name'  => 'Eban',
			'short' => 'The fence',
			'line'  => 'Home, worn close.',
			'story' => 'Eban is the fence around the home, and it stands for safety and security. It is a protective symbol, often given as a blessing on a new home or a new household.',
		),
		'nkonsonkonson'     => array(
			'name'  => 'Nkonsonkonson',
			'short' => 'Chain links',
			'line'  => 'We are held together.',
			'story' => 'Linked chain, and a proverb about community — the link that breaks is the one that separates. Nkonsonkonson stands for unity, and for the idea that belonging is what makes strength hold.',
		),
		'odo-nnyew-fie-kwan' => array(
			'name'  => 'Odo Nnyew Fie Kwan',
			'short' => 'Love never loses its way home',
			'line'  => 'For the ones you come back to.',
			'story' => 'Literally, "love never loses its way home". The symbol is used for faithfulness and enduring affection, and it is the strongest bridal and gifting symbol in the Adinkra set.',
		),
	);

	/**
	 * Filter the symbol library so the client's house interpretation can
	 * replace ours without touching code.
	 *
	 * @param array<string,array<string,string>> $symbols Symbol data.
	 */
	return apply_filters( 'queendor_symbols', $symbols );
}

/**
 * Look up a symbol by term name, slug or sanitised label.
 *
 * @param string $name Symbol name or slug.
 * @return array<string,string>|null
 */
function queendor_symbol_data( $name ) {
	$symbols = queendor_symbols();
	$slug    = sanitize_title( $name );

	if ( isset( $symbols[ $slug ] ) ) {
		return $symbols[ $slug ];
	}

	foreach ( $symbols as $key => $data ) {
		if ( sanitize_title( $data['name'] ) === $slug ) {
			return $data;
		}
	}

	return null;
}

/**
 * Read the symbol values assigned to a product.
 *
 * Works whether the attribute is the global taxonomy `pa_symbol` or a
 * product-level attribute called simply "Symbol", because a half-migrated
 * catalogue should not make the page fall apart.
 *
 * @param WC_Product $product Product object.
 * @return string[] Symbol labels.
 */
function queendor_product_symbols( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return array();
	}

	$raw = $product->get_attribute( 'pa_symbol' );

	if ( '' === $raw ) {
		$raw = $product->get_attribute( 'symbol' );
	}

	if ( '' === $raw ) {
		return array();
	}

	$out = array();

	foreach ( explode( ',', $raw ) as $label ) {
		$label = trim( wp_strip_all_tags( $label ) );

		if ( '' !== $label ) {
			$out[] = $label;
		}
	}

	return $out;
}

/**
 * Whether a product carries any symbol we have copy for.
 *
 * @param WC_Product $product Product object.
 * @return bool
 */
function queendor_has_symbol_copy( $product ) {
	foreach ( queendor_product_symbols( $product ) as $label ) {
		if ( queendor_symbol_data( $label ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Render the symbol panel.
 *
 * @param WC_Product $product Product object.
 * @param bool       $echo    Print or return.
 * @return string
 */
function queendor_symbol_panel( $product, $echo = true ) {
	$labels = queendor_product_symbols( $product );
	$found  = array();

	foreach ( $labels as $label ) {
		$data = queendor_symbol_data( $label );

		if ( $data ) {
			$found[] = $data;
		}
	}

	if ( ! $found ) {
		return '';
	}

	$html = '<div class="qd-symbol">';

	foreach ( $found as $data ) {
		$html .= '<div class="qd-symbol__item">';
		$html .= '<p class="qd-symbol__kicker">' . esc_html__( 'Adinkra', 'luxrio-child' ) . '</p>';
		$html .= '<h3 class="qd-symbol__name">' . esc_html( $data['name'] ) . '</h3>';
		$html .= '<p class="qd-symbol__short">' . esc_html( $data['short'] ) . '</p>';
		$html .= '<p class="qd-symbol__line">' . esc_html( $data['line'] ) . '</p>';
		$html .= '</div>';
	}

	$html .= '</div>';

	if ( $echo ) {
		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above.
	}

	return $html;
}

/**
 * `[queendor_symbol_index]` — a symbol directory for the "Symbols" page.
 *
 * @return string
 */
function queendor_sc_symbol_index() {
	$symbols = queendor_symbols();

	$html = '<div class="qd-symbol-index">';

	foreach ( $symbols as $slug => $data ) {
		$link = get_term_link( $slug, 'pa_symbol' );

		$html .= '<article class="qd-symbol-index__item">';
		$html .= '<h3 class="qd-symbol-index__name">' . esc_html( $data['name'] ) . '</h3>';
		$html .= '<p class="qd-symbol-index__short">' . esc_html( $data['short'] ) . '</p>';
		$html .= '<p class="qd-symbol-index__story">' . esc_html( $data['story'] ) . '</p>';

		if ( ! is_wp_error( $link ) ) {
			$html .= '<a class="qd-symbol-index__link" href="' . esc_url( $link ) . '">'
				. esc_html__( 'Shop this symbol', 'luxrio-child' ) . '</a>';
		}

		$html .= '</article>';
	}

	$html .= '</div>';

	return $html;
}
add_shortcode( 'queendor_symbol_index', 'queendor_sc_symbol_index' );

/**
 * `[queendor_symbol slug="sankofa"]` — a single symbol block for an Elementor
 * section or an About page.
 *
 * @param array<string,string> $atts Shortcode attributes.
 * @return string
 */
function queendor_sc_symbol( $atts ) {
	$atts = shortcode_atts(
		array(
			'slug'  => '',
			'story' => 'yes',
		),
		$atts,
		'queendor_symbol'
	);

	$data = queendor_symbol_data( $atts['slug'] );

	if ( ! $data ) {
		return '';
	}

	$html  = '<div class="qd-symbol qd-symbol--page">';
	$html .= '<h3 class="qd-symbol__name">' . esc_html( $data['name'] ) . '</h3>';
	$html .= '<p class="qd-symbol__short">' . esc_html( $data['short'] ) . '</p>';
	$html .= '<p class="qd-symbol__line">' . esc_html( $data['line'] ) . '</p>';

	if ( 'no' !== $atts['story'] ) {
		$html .= '<p class="qd-symbol__story">' . esc_html( $data['story'] ) . '</p>';
	}

	$html .= '</div>';

	return $html;
}
add_shortcode( 'queendor_symbol', 'queendor_sc_symbol' );
