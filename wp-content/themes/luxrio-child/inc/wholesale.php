<?php
/**
 * Wholesale purchasing.
 *
 * Trade customers get a trade price, a minimum order and an approval workflow.
 * Everything is role-based: the prices exist only for users holding the
 * wholesale role, so a retail visitor never receives the numbers at all — they
 * are not hidden with CSS, they are never computed.
 *
 * Three values decide the behaviour. Change them here, not in the database:
 *
 *   QUEENDOR_WHOLESALE_DISCOUNT  trade price as a fraction of retail regular price
 *   QUEENDOR_WHOLESALE_MIN_QTY   minimum units per line
 *   QUEENDOR_WHOLESALE_MIN_ORDER minimum order value, 0 to disable
 *
 * @package luxrio-child
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'QUEENDOR_WHOLESALE_ROLE' ) ) {
	define( 'QUEENDOR_WHOLESALE_ROLE', 'wholesale_customer' );
}
if ( ! defined( 'QUEENDOR_WHOLESALE_DISCOUNT' ) ) {
	define( 'QUEENDOR_WHOLESALE_DISCOUNT', 0.5 );
}
if ( ! defined( 'QUEENDOR_WHOLESALE_MIN_QTY' ) ) {
	define( 'QUEENDOR_WHOLESALE_MIN_QTY', 6 );
}
if ( ! defined( 'QUEENDOR_WHOLESALE_MIN_ORDER' ) ) {
	define( 'QUEENDOR_WHOLESALE_MIN_ORDER', 0 );
}
if ( ! defined( 'QUEENDOR_WHOLESALE_VERSION' ) ) {
	define( 'QUEENDOR_WHOLESALE_VERSION', '1.2.0' );
}

/* -------------------------------------------------------------------------
 * 1. The role
 * ---------------------------------------------------------------------- */

/**
 * Create the wholesale role once, and again if this file's version changes.
 *
 * Runs on init rather than on activation: a child theme has no activation
 * hook, and the switch-theme hook never fires on a theme update.
 */
function queendor_wholesale_install_role() {
	if ( get_option( 'queendor_wholesale_role_version' ) === QUEENDOR_WHOLESALE_VERSION ) {
		return;
	}

	add_role(
		QUEENDOR_WHOLESALE_ROLE,
		__( 'Wholesale customer', 'luxrio-child' ),
		array( 'read' => true )
	);

	update_option( 'queendor_wholesale_role_version', QUEENDOR_WHOLESALE_VERSION );
}
add_action( 'init', 'queendor_wholesale_install_role' );

/**
 * Is the current visitor a trade customer?
 *
 * @param int|null $user_id Optional user to test instead of the current one.
 * @return bool
 */
function queendor_wholesale_is_wholesale( $user_id = null ) {
	$is = false;

	if ( $user_id ) {
		$user = get_userdata( absint( $user_id ) );
		$is   = $user && in_array( QUEENDOR_WHOLESALE_ROLE, (array) $user->roles, true );
	} elseif ( is_user_logged_in() ) {
		$is = in_array( QUEENDOR_WHOLESALE_ROLE, (array) wp_get_current_user()->roles, true );
	}

	/**
	 * Filter whether trade pricing applies to this request.
	 *
	 * @param bool $is Current result.
	 */
	return (bool) apply_filters( 'queendor_wholesale_is_wholesale', $is );
}

/* -------------------------------------------------------------------------
 * 2. Trade pricing
 * ---------------------------------------------------------------------- */

/**
 * Trade price for a retail figure.
 *
 * @param float $retail Retail regular price.
 * @return float
 */
function queendor_wholesale_trade_price( $retail ) {
	$retail = (float) $retail;

	if ( $retail <= 0 ) {
		return 0.0;
	}

	$trade = $retail * (float) QUEENDOR_WHOLESALE_DISCOUNT;

	/**
	 * Filter the computed trade price.
	 *
	 * @param float $trade  Trade price.
	 * @param float $retail Retail price it came from.
	 */
	return (float) apply_filters( 'queendor_wholesale_trade_price', round( $trade, 2 ), $retail );
}

/**
 * Read the retail regular price straight from post meta.
 *
 * The filter callbacks below run *inside* WooCommerce's price getters, so they
 * must not call those same getters — that recurses until PHP dies. Post meta is
 * the raw value and is safe.
 *
 * @param WC_Product $product Product or variation.
 * @return float
 */
function queendor_wholesale_raw_regular_price( $product ) {
	$id = $product instanceof WC_Product ? $product->get_id() : 0;

	if ( ! $id ) {
		return 0.0;
	}

	return (float) get_post_meta( $id, '_regular_price', true );
}

/**
 * Replace the active price with the trade price.
 *
 * @param string     $price   Current price.
 * @param WC_Product $product Product.
 * @return string
 */
function queendor_wholesale_filter_price( $price, $product ) {
	if ( ! queendor_wholesale_is_wholesale() || ! $product instanceof WC_Product ) {
		return $price;
	}

	// A variable product's own price is a range placeholder; its variations
	// are filtered individually.
	if ( $product->is_type( 'variable' ) ) {
		return $price;
	}

	$retail = queendor_wholesale_raw_regular_price( $product );

	return $retail > 0 ? (string) queendor_wholesale_trade_price( $retail ) : $price;
}
add_filter( 'woocommerce_product_get_price', 'queendor_wholesale_filter_price', 20, 2 );
add_filter( 'woocommerce_product_variation_get_price', 'queendor_wholesale_filter_price', 20, 2 );

/**
 * Make the regular price match the trade price.
 *
 * Otherwise the product page would show a struck-through retail price and tell
 * the trade customer they are saving half on every visit.
 *
 * @param string     $price   Current regular price.
 * @param WC_Product $product Product.
 * @return string
 */
function queendor_wholesale_filter_regular_price( $price, $product ) {
	if ( ! queendor_wholesale_is_wholesale() || ! $product instanceof WC_Product ) {
		return $price;
	}

	if ( $product->is_type( 'variable' ) ) {
		return $price;
	}

	$retail = queendor_wholesale_raw_regular_price( $product );

	return $retail > 0 ? (string) queendor_wholesale_trade_price( $retail ) : $price;
}
add_filter( 'woocommerce_product_get_regular_price', 'queendor_wholesale_filter_regular_price', 20, 2 );
add_filter( 'woocommerce_product_variation_get_regular_price', 'queendor_wholesale_filter_regular_price', 20, 2 );

/**
 * Suppress retail sale prices for trade customers.
 *
 * A trade price is already the agreement. Stacking a retail promotion on top
 * of it gives away margin nobody agreed to, and a struck-through price next to
 * a trade price reads as a double discount.
 *
 * @param string     $price   Sale price.
 * @param WC_Product $product Product.
 * @return string
 */
function queendor_wholesale_suppress_sale_price( $price, $product ) {
	if ( queendor_wholesale_is_wholesale() ) {
		return '';
	}

	return $price;
}
add_filter( 'woocommerce_product_get_sale_price', 'queendor_wholesale_suppress_sale_price', 20, 2 );
add_filter( 'woocommerce_product_variation_get_sale_price', 'queendor_wholesale_suppress_sale_price', 20, 2 );

/**
 * Say so, on the product page.
 */
function queendor_wholesale_price_notice() {
	if ( ! queendor_wholesale_is_wholesale() ) {
		return;
	}

	printf(
		'<p class="queendor-trade-note">%s</p>',
		esc_html(
			sprintf(
				/* translators: %d: minimum quantity. */
				__( 'Trade price. Minimum %d units per style.', 'luxrio-child' ),
				QUEENDOR_WHOLESALE_MIN_QTY
			)
		)
	);
}
add_action( 'woocommerce_single_product_summary', 'queendor_wholesale_price_notice', 11 );

/* -------------------------------------------------------------------------
 * 3. Minimum order
 * ---------------------------------------------------------------------- */

/**
 * Set the quantity field's minimum and step for trade customers.
 *
 * @param array $args Quantity input arguments.
 * @return array
 */
function queendor_wholesale_quantity_args( $args ) {
	if ( ! queendor_wholesale_is_wholesale() ) {
		return $args;
	}

	$args['min_value'] = QUEENDOR_WHOLESALE_MIN_QTY;
	$args['step']      = QUEENDOR_WHOLESALE_MIN_QTY;

	return $args;
}
add_filter( 'woocommerce_quantity_input_args', 'queendor_wholesale_quantity_args', 20 );

/**
 * Refuse an add-to-cart below the minimum.
 *
 * @param bool $passed     Whether validation passed.
 * @param int  $product_id Product being added.
 * @param int  $quantity   Quantity requested.
 * @return bool
 */
function queendor_wholesale_validate_add( $passed, $product_id, $quantity ) {
	if ( ! queendor_wholesale_is_wholesale() || ! $passed ) {
		return $passed;
	}

	if ( (int) $quantity < QUEENDOR_WHOLESALE_MIN_QTY ) {
		wc_add_notice(
			sprintf(
				/* translators: %d: minimum quantity. */
				esc_html__( 'Wholesale orders start at %d units per style.', 'luxrio-child' ),
				QUEENDOR_WHOLESALE_MIN_QTY
			),
			'error'
		);

		return false;
	}

	return $passed;
}
add_filter( 'woocommerce_add_to_cart_validation', 'queendor_wholesale_validate_add', 20, 3 );

/**
 * Re-check at checkout, because the cart can be edited there.
 */
function queendor_wholesale_validate_cart() {
	if ( ! queendor_wholesale_is_wholesale() || ! WC()->cart ) {
		return;
	}

	foreach ( WC()->cart->get_cart() as $item ) {
		if ( (int) $item['quantity'] < QUEENDOR_WHOLESALE_MIN_QTY ) {
			$name = $item['data'] instanceof WC_Product ? $item['data']->get_name() : __( 'An item', 'luxrio-child' );

			wc_add_notice(
				sprintf(
					/* translators: 1: product name, 2: minimum quantity. */
					esc_html__( '%1$s needs at least %2$d units on a wholesale order.', 'luxrio-child' ),
					esc_html( $name ),
					QUEENDOR_WHOLESALE_MIN_QTY
				),
				'error'
			);

			return;
		}
	}

	if ( QUEENDOR_WHOLESALE_MIN_ORDER > 0 && WC()->cart->get_subtotal() < QUEENDOR_WHOLESALE_MIN_ORDER ) {
		wc_add_notice(
			sprintf(
				/* translators: %s: formatted minimum order value. */
				esc_html__( 'Wholesale orders start at %s.', 'luxrio-child' ),
				wp_strip_all_tags( wc_price( QUEENDOR_WHOLESALE_MIN_ORDER ) )
			),
			'error'
		);
	}
}
// One hook covers both screens: WooCommerce calls check_cart_items() on the
// cart page and again during checkout validation, so hooking checkout as well
// would stack two copies of the same error message.
add_action( 'woocommerce_check_cart_items', 'queendor_wholesale_validate_cart' );

/* -------------------------------------------------------------------------
 * 4. Applying for an account
 * ---------------------------------------------------------------------- */

/**
 * Add the application fields to the WooCommerce registration form.
 */
function queendor_wholesale_register_fields() {
	?>
	<p class="form-row form-row-wide">
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
			<input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox"
				name="queendor_wholesale_apply" id="queendor_wholesale_apply" value="1" />
			<span><?php esc_html_e( 'Apply for a wholesale account', 'luxrio-child' ); ?></span>
		</label>
	</p>
	<p class="form-row form-row-first">
		<label for="queendor_business_name"><?php esc_html_e( 'Business name', 'luxrio-child' ); ?></label>
		<input type="text" class="input-text" name="queendor_business_name" id="queendor_business_name" value="" />
	</p>
	<p class="form-row form-row-last">
		<label for="queendor_business_phone"><?php esc_html_e( 'Business phone', 'luxrio-child' ); ?></label>
		<input type="tel" class="input-text" name="queendor_business_phone" id="queendor_business_phone" value="" />
	</p>
	<p class="form-row form-row-wide">
		<label for="queendor_business_city"><?php esc_html_e( 'Town or city', 'luxrio-child' ); ?></label>
		<input type="text" class="input-text" name="queendor_business_city" id="queendor_business_city" value="" />
	</p>
	<?php
}
add_action( 'woocommerce_register_form', 'queendor_wholesale_register_fields' );

/**
 * Require the business fields when the applicant ticked the box.
 *
 * @param WP_Error $errors           Registration errors.
 * @param string   $username         Username.
 * @param string   $email            Email.
 */
function queendor_wholesale_validate_registration( $errors, $username, $email ) {
	unset( $username, $email );

	if ( empty( $_POST['queendor_wholesale_apply'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- WooCommerce verifies the form.
		return;
	}

	$name  = isset( $_POST['queendor_business_name'] ) ? sanitize_text_field( wp_unslash( $_POST['queendor_business_name'] ) ) : '';
	$phone = isset( $_POST['queendor_business_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['queendor_business_phone'] ) ) : '';

	if ( '' === $name ) {
		$errors->add( 'queendor_business_name', __( 'Please tell us your business name.', 'luxrio-child' ) );
	}

	if ( '' === $phone ) {
		$errors->add( 'queendor_business_phone', __( 'Please add a phone number we can reach you on.', 'luxrio-child' ) );
	}
}
add_action( 'woocommerce_register_post', 'queendor_wholesale_validate_registration', 10, 3 );

/**
 * Save the application and tell the shop owner.
 *
 * @param int $customer_id New user ID.
 */
function queendor_wholesale_saved_registration( $customer_id ) {
	if ( empty( $_POST['queendor_wholesale_apply'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- WooCommerce verifies the form.
		return;
	}

	$fields = array(
		'queendor_business_name'  => 'business_name',
		'queendor_business_phone' => 'business_phone',
		'queendor_business_city'  => 'business_city',
	);

	foreach ( $fields as $post_key => $meta_key ) {
		$value = isset( $_POST[ $post_key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $post_key ] ) ) : '';

		if ( '' !== $value ) {
			update_user_meta( $customer_id, $meta_key, $value );
		}
	}

	update_user_meta( $customer_id, 'queendor_wholesale_status', 'pending' );

	$user = get_userdata( $customer_id );

	wp_mail(
		get_option( 'admin_email' ),
		sprintf(
			/* translators: %s: business name. */
			__( 'Wholesale application: %s', 'luxrio-child' ),
			get_user_meta( $customer_id, 'business_name', true )
		),
		sprintf(
			/* translators: 1: business name, 2: email, 3: phone, 4: approval URL. */
			__( "A wholesale account has been requested.\n\nBusiness: %1\$s\nEmail: %2\$s\nPhone: %3\$s\n\nApprove or decline:\n%4\$s", 'luxrio-child' ),
			get_user_meta( $customer_id, 'business_name', true ),
			$user ? $user->user_email : '',
			get_user_meta( $customer_id, 'business_phone', true ),
			admin_url( 'users.php' )
		)
	);
}
add_action( 'woocommerce_created_customer', 'queendor_wholesale_saved_registration' );

/**
 * Tell the customer where their application stands.
 */
function queendor_wholesale_account_notice() {
	$status = get_user_meta( get_current_user_id(), 'queendor_wholesale_status', true );

	if ( 'pending' !== $status ) {
		return;
	}

	printf(
		'<div class="woocommerce-info">%s</div>',
		esc_html__( 'Your wholesale application is with us. We will email you once it is approved.', 'luxrio-child' )
	);
}
add_action( 'woocommerce_account_dashboard', 'queendor_wholesale_account_notice' );

/* -------------------------------------------------------------------------
 * 5. Approving, in the Users screen
 * ---------------------------------------------------------------------- */

/**
 * Add a Wholesale column to the Users list.
 *
 * @param array $columns Existing columns.
 * @return array
 */
function queendor_wholesale_user_column( $columns ) {
	$columns['queendor_wholesale'] = __( 'Wholesale', 'luxrio-child' );

	return $columns;
}
add_filter( 'manage_users_columns', 'queendor_wholesale_user_column' );

/**
 * Fill the column with a status and an action.
 *
 * @param string $value       Column output.
 * @param string $column_name Column key.
 * @param int    $user_id     User ID.
 * @return string
 */
function queendor_wholesale_user_column_content( $value, $column_name, $user_id ) {
	if ( 'queendor_wholesale' !== $column_name ) {
		return $value;
	}

	if ( ! current_user_can( 'edit_users' ) ) {
		return esc_html__( '—', 'luxrio-child' );
	}

	$is_wholesale = queendor_wholesale_is_wholesale( $user_id );
	$status       = get_user_meta( $user_id, 'queendor_wholesale_status', true );

	if ( $is_wholesale ) {
		return sprintf(
			'<strong>%1$s</strong><br><a href="%2$s">%3$s</a>',
			esc_html__( 'Approved', 'luxrio-child' ),
			esc_url( queendor_wholesale_action_url( $user_id, 'revoke' ) ),
			esc_html__( 'Revoke', 'luxrio-child' )
		);
	}

	$label = 'pending' === $status ? __( 'Pending', 'luxrio-child' ) : __( 'Retail', 'luxrio-child' );

	return sprintf(
		'%1$s<br><a href="%2$s">%3$s</a>',
		esc_html( $label ),
		esc_url( queendor_wholesale_action_url( $user_id, 'approve' ) ),
		esc_html__( 'Approve', 'luxrio-child' )
	);
}
add_filter( 'manage_users_custom_column', 'queendor_wholesale_user_column_content', 10, 3 );

/**
 * Build a nonced approval link.
 *
 * @param int    $user_id User ID.
 * @param string $do      'approve' or 'revoke'.
 * @return string
 */
function queendor_wholesale_action_url( $user_id, $do ) {
	return wp_nonce_url(
		admin_url( 'admin-post.php?action=queendor_wholesale_role&do=' . rawurlencode( $do ) . '&user=' . absint( $user_id ) ),
		'queendor_wholesale_role_' . absint( $user_id )
	);
}

/**
 * Apply the approval or revocation.
 */
function queendor_wholesale_handle_role_action() {
	if ( ! current_user_can( 'edit_users' ) ) {
		wp_die( esc_html__( 'You are not allowed to do that.', 'luxrio-child' ), 403 );
	}

	$user_id = isset( $_GET['user'] ) ? absint( $_GET['user'] ) : 0;

	check_admin_referer( 'queendor_wholesale_role_' . $user_id );

	$user = get_userdata( $user_id );

	if ( ! $user ) {
		wp_die( esc_html__( 'No such user.', 'luxrio-child' ), 404 );
	}

	$do = isset( $_GET['do'] ) ? sanitize_key( wp_unslash( $_GET['do'] ) ) : '';

	if ( 'approve' === $do ) {
		$user->set_role( QUEENDOR_WHOLESALE_ROLE );
		update_user_meta( $user_id, 'queendor_wholesale_status', 'approved' );

		wp_mail(
			$user->user_email,
			__( 'Your wholesale account is open', 'luxrio-child' ),
			__( "Your wholesale account has been approved. Trade prices are now shown when you are logged in.\n\nPlease sign in to see them.", 'luxrio-child' )
		);
	} elseif ( 'revoke' === $do ) {
		$user->set_role( 'customer' );
		update_user_meta( $user_id, 'queendor_wholesale_status', 'revoked' );
	}

	wp_safe_redirect( wp_get_referer() ? wp_get_referer() : admin_url( 'users.php' ) );
	exit;
}
add_action( 'admin_post_queendor_wholesale_role', 'queendor_wholesale_handle_role_action' );

/* -------------------------------------------------------------------------
 * 6. Caching
 * ---------------------------------------------------------------------- */

/**
 * Keep trade prices out of the page cache.
 *
 * This is the one way wholesale pricing leaks: a cached page rendered for a
 * logged-in trade customer served to an anonymous visitor. The cache key is
 * built before the page is rendered, so the page has to be excluded outright.
 */
function queendor_wholesale_nocache() {
	if ( ! queendor_wholesale_is_wholesale() ) {
		return;
	}

	if ( ! defined( 'DONOTCACHEPAGE' ) ) {
		define( 'DONOTCACHEPAGE', true );
	}
	if ( ! defined( 'DONOTCACHEOBJECT' ) ) {
		define( 'DONOTCACHEOBJECT', true );
	}
	if ( ! defined( 'DONOTCACHEDB' ) ) {
		define( 'DONOTCACHEDB', true );
	}
}
add_action( 'template_redirect', 'queendor_wholesale_nocache', 0 );

/* -------------------------------------------------------------------------
 * 7. Marking trade orders, so nobody mistakes one for a pricing error
 * ---------------------------------------------------------------------- */

/**
 * Flag the order at the moment it is created.
 *
 * A ₵160 line on a product the shop lists at ₵320 looks like someone broke
 * the pricing. The flag follows the order everywhere afterwards.
 *
 * @param WC_Order $order Order being created.
 */
function queendor_wholesale_flag_order( $order ) {
	if ( ! $order instanceof WC_Order || ! queendor_wholesale_is_wholesale() ) {
		return;
	}

	$order->update_meta_data( '_queendor_wholesale', 'yes' );
}
add_action( 'woocommerce_checkout_create_order', 'queendor_wholesale_flag_order' );

/**
 * Add an internal note once the order exists.
 *
 * @param int $order_id New order ID.
 */
function queendor_wholesale_order_note( $order_id ) {
	$order = wc_get_order( $order_id );

	if ( ! $order || 'yes' !== $order->get_meta( '_queendor_wholesale' ) ) {
		return;
	}

	$order->add_order_note(
		sprintf(
			/* translators: %d: discount percentage. */
			esc_html__( 'Wholesale account: trade pricing applied (%d%% off retail).', 'luxrio-child' ),
			(int) round( ( 1 - (float) QUEENDOR_WHOLESALE_DISCOUNT ) * 100 )
		)
	);
}
add_action( 'woocommerce_new_order', 'queendor_wholesale_order_note' );

/**
 * Show the flag in the order emails.
 *
 * @param array    $fields        Extra email fields.
 * @param bool     $sent_to_admin Whether this copy goes to staff.
 * @param WC_Order $order         Order.
 * @return array
 */
function queendor_wholesale_email_field( $fields, $sent_to_admin, $order ) {
	unset( $sent_to_admin );

	if ( $order instanceof WC_Order && 'yes' === $order->get_meta( '_queendor_wholesale' ) ) {
		$fields['queendor_wholesale'] = array(
			'label' => __( 'Account', 'luxrio-child' ),
			'value' => __( 'Wholesale — trade pricing applied', 'luxrio-child' ),
		);
	}

	return $fields;
}
add_filter( 'woocommerce_email_order_meta_fields', 'queendor_wholesale_email_field', 10, 3 );

/**
 * Add a column to the orders table.
 *
 * WooCommerce 8 moved orders out of wp_posts; both list tables are supported
 * so the flag survives the site switching between them.
 *
 * @param array $columns Existing columns.
 * @return array
 */
function queendor_wholesale_order_column( $columns ) {
	$columns['queendor_wholesale'] = __( 'Wholesale', 'luxrio-child' );

	return $columns;
}
add_filter( 'manage_edit-shop_order_columns', 'queendor_wholesale_order_column', 20 );
add_filter( 'manage_woocommerce_page_wc-orders_columns', 'queendor_wholesale_order_column', 20 );

/**
 * Fill the column.
 *
 * @param string $column  Column key.
 * @param int    $post_id Order ID (legacy list) or 0.
 */
function queendor_wholesale_order_column_content( $column, $post_id ) {
	if ( 'queendor_wholesale' !== $column ) {
		return;
	}

	$order = wc_get_order( $post_id );

	if ( $order && 'yes' === $order->get_meta( '_queendor_wholesale' ) ) {
		echo '<span style="display:inline-block;padding:2px 8px;border-radius:3px;background:#f0b849;color:#1d2327;font-weight:600;font-size:11px;">' . esc_html__( 'Trade', 'luxrio-child' ) . '</span>';
	} else {
		echo '&mdash;';
	}
}
add_action( 'manage_shop_order_posts_custom_column', 'queendor_wholesale_order_column_content', 20, 2 );
add_action( 'manage_woocommerce_page_wc-orders_custom_column', 'queendor_wholesale_order_column_content', 20, 2 );

/* -------------------------------------------------------------------------
 * 8. The application form
 * ---------------------------------------------------------------------- */

/**
 * Handle a submitted application.
 *
 * Accounts created here are ordinary customers with a pending flag — they see
 * retail prices until a human approves them, so a spam account gains nothing
 * but a row in the Users list.
 */
function queendor_wholesale_handle_application() {
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/wholesale/' );

	if ( ! isset( $_POST['queendor_application_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['queendor_application_nonce'] ) ), 'queendor_application' ) ) {
		wp_safe_redirect( add_query_arg( 'queendor_apply', 'failed', $redirect ) );
		exit;
	}

	// A field a human never fills in, and a form a human cannot submit this fast.
	if ( ! empty( $_POST['queendor_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'queendor_apply', 'failed', $redirect ) );
		exit;
	}

	$started = isset( $_POST['queendor_started'] ) ? absint( $_POST['queendor_started'] ) : 0;

	if ( $started && ( time() - $started ) < 3 ) {
		wp_safe_redirect( add_query_arg( 'queendor_apply', 'failed', $redirect ) );
		exit;
	}

	$business = isset( $_POST['queendor_business_name'] ) ? sanitize_text_field( wp_unslash( $_POST['queendor_business_name'] ) ) : '';
	$contact  = isset( $_POST['queendor_contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['queendor_contact_name'] ) ) : '';
	$email    = isset( $_POST['queendor_email'] ) ? sanitize_email( wp_unslash( $_POST['queendor_email'] ) ) : '';
	$phone    = isset( $_POST['queendor_business_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['queendor_business_phone'] ) ) : '';
	$city     = isset( $_POST['queendor_business_city'] ) ? sanitize_text_field( wp_unslash( $_POST['queendor_business_city'] ) ) : '';
	$note     = isset( $_POST['queendor_note'] ) ? sanitize_textarea_field( wp_unslash( $_POST['queendor_note'] ) ) : '';

	if ( '' === $business || '' === $email || '' === $phone || ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'queendor_apply', 'incomplete', $redirect ) );
		exit;
	}

	if ( email_exists( $email ) ) {
		wp_safe_redirect( add_query_arg( 'queendor_apply', 'exists', $redirect ) );
		exit;
	}

	$username = sanitize_user( current( explode( '@', $email ) ), true );
	$username = $username ? $username : 'trade';
	$suffix   = 1;

	while ( username_exists( $username ) ) {
		$username = sanitize_user( current( explode( '@', $email ) ), true ) . $suffix;
		$suffix++;
	}

	$user_id = wp_create_user( $username, wp_generate_password( 24 ), $email );

	if ( is_wp_error( $user_id ) ) {
		wp_safe_redirect( add_query_arg( 'queendor_apply', 'failed', $redirect ) );
		exit;
	}

	$user = new WP_User( $user_id );
	$user->set_role( 'customer' );

	update_user_meta( $user_id, 'business_name', $business );
	update_user_meta( $user_id, 'business_phone', $phone );
	update_user_meta( $user_id, 'business_city', $city );
	update_user_meta( $user_id, 'queendor_wholesale_status', 'pending' );

	if ( '' !== $contact ) {
		update_user_meta( $user_id, 'first_name', $contact );
	}

	wp_new_user_notification( $user_id, null, 'user' );

	wp_mail(
		get_option( 'admin_email' ),
		sprintf(
			/* translators: %s: business name. */
			__( 'Wholesale application: %s', 'luxrio-child' ),
			$business
		),
		sprintf(
			/* translators: 1: business, 2: contact, 3: email, 4: phone, 5: city, 6: note, 7: URL. */
			__( "A wholesale account has been requested.\n\nBusiness: %1\$s\nContact: %2\$s\nEmail: %3\$s\nPhone: %4\$s\nTown: %5\$s\n\n%6\$s\n\nApprove or decline:\n%7\$s", 'luxrio-child' ),
			$business,
			$contact,
			$email,
			$phone,
			$city,
			$note,
			admin_url( 'users.php' )
		)
	);

	wp_safe_redirect( add_query_arg( 'queendor_apply', 'sent', $redirect ) );
	exit;
}
add_action( 'admin_post_queendor_wholesale_apply', 'queendor_wholesale_handle_application' );
add_action( 'admin_post_nopriv_queendor_wholesale_apply', 'queendor_wholesale_handle_application' );

/**
 * The form itself.
 *
 * @return string
 */
function queendor_wholesale_apply_form() {
	if ( is_user_logged_in() ) {
		$status = get_user_meta( get_current_user_id(), 'queendor_wholesale_status', true );

		if ( queendor_wholesale_is_wholesale() ) {
			return '<p class="queendor-apply__note">' . esc_html__( 'Your trade account is open. Trade prices are shown throughout the shop while you are signed in.', 'luxrio-child' ) . '</p>';
		}

		if ( 'pending' === $status ) {
			return '<p class="queendor-apply__note">' . esc_html__( 'Your application is with us and will be reviewed within one working day.', 'luxrio-child' ) . '</p>';
		}

		return '';
	}

	$status = isset( $_GET['queendor_apply'] ) ? sanitize_key( wp_unslash( $_GET['queendor_apply'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	if ( 'sent' === $status ) {
		return '<div class="queendor-apply__done"><h3>' . esc_html__( 'Application received', 'luxrio-child' ) . '</h3><p>'
			. esc_html__( 'We will review it and email you within one working day. You have been sent a link to set your password — trade prices appear once the account is approved.', 'luxrio-child' )
			. '</p></div>';
	}

	$messages = array(
		'incomplete' => __( 'Please add your business name, a phone number and a valid email.', 'luxrio-child' ),
		'exists'     => __( 'There is already an account with that email. Sign in and ask us to upgrade it to a trade account.', 'luxrio-child' ),
		'failed'     => __( 'That did not go through. Please try again, or email us directly.', 'luxrio-child' ),
	);

	$notice = isset( $messages[ $status ] ) ? '<p class="queendor-apply__error">' . esc_html( $messages[ $status ] ) . '</p>' : '';

	ob_start();
	?>
	<form class="queendor-apply" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<?php echo $notice; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above. ?>
		<input type="hidden" name="action" value="queendor_wholesale_apply" />
		<input type="hidden" name="queendor_started" value="<?php echo esc_attr( time() ); ?>" />
		<?php wp_nonce_field( 'queendor_application', 'queendor_application_nonce' ); ?>
		<p class="queendor-apply__hp"><label>Website<input type="text" name="queendor_website" value="" tabindex="-1" autocomplete="off" /></label></p>

		<p><label for="qa-business"><?php esc_html_e( 'Business name', 'luxrio-child' ); ?> *</label>
			<input type="text" id="qa-business" name="queendor_business_name" required /></p>

		<p><label for="qa-contact"><?php esc_html_e( 'Your name', 'luxrio-child' ); ?></label>
			<input type="text" id="qa-contact" name="queendor_contact_name" /></p>

		<p><label for="qa-email"><?php esc_html_e( 'Email', 'luxrio-child' ); ?> *</label>
			<input type="email" id="qa-email" name="queendor_email" required /></p>

		<p><label for="qa-phone"><?php esc_html_e( 'Phone', 'luxrio-child' ); ?> *</label>
			<input type="tel" id="qa-phone" name="queendor_business_phone" required /></p>

		<p><label for="qa-city"><?php esc_html_e( 'Town or city', 'luxrio-child' ); ?></label>
			<input type="text" id="qa-city" name="queendor_business_city" /></p>

		<p><label for="qa-note"><?php esc_html_e( 'Anything we should know?', 'luxrio-child' ); ?></label>
			<textarea id="qa-note" name="queendor_note" rows="3"></textarea></p>

		<p><button type="submit" class="queendor-apply__submit"><?php esc_html_e( 'Apply for a trade account', 'luxrio-child' ); ?></button></p>
		<p class="queendor-apply__small"><?php esc_html_e( 'We review applications within one working day. Trade prices are visible only after approval.', 'luxrio-child' ); ?></p>
	</form>
	<?php
	return ob_get_clean();
}
add_shortcode( 'queendor_wholesale_apply', 'queendor_wholesale_apply_form' );
