<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 11.0.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); ?>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>
    <div class="row">
        <p class="col-sm-6 mb-30">
            <input type="text" class="form-control" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" placeholder="<?php echo esc_attr__('First Name', 'luxrio')  ?>"/>
        </p>
        <p class="col-sm-6 mb-30">
            <input type="text" class="form-control" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" placeholder="<?php echo esc_attr__('Last Name', 'luxrio')  ?>"/>
        </p>

        <p class="col-sm-6 mb-30">
            <input type="text" class="form-control" name="account_display_name" id="account_display_name" aria-describedby="account_display_name_description" value="<?php echo esc_attr( $user->display_name ); ?>" placeholder="<?php echo esc_attr__('Display Name', 'luxrio')  ?>"/>
            <span id="account_display_name_description"><em><?php echo wc_reviews_enabled() ? esc_html__( 'This will be how your name will be displayed in the account section and in reviews', 'luxrio' ) : esc_html__( 'This will be how your name will be displayed in the account section', 'luxrio' ); ?></em></span>
        </p>
        <p class="col-sm-6 mb-30">
            <input type="email" class="form-control" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" placeholder="<?php echo esc_attr__('Your Email', 'luxrio')  ?>"/>
        </p>
    </div>

	<fieldset class="row">
		<h6 class="col-12 mb-3"><?php esc_html_e( 'Password Change', 'luxrio' ); ?></h6>

		<p class="col-12 mb-30">
			<input type="password" class="form-control" name="password_current" id="password_current" autocomplete="current-password" placeholder="<?php echo esc_attr__('Current Password', 'luxrio') ?>"/>
		</p>
		<p class="col-12 mb-30">
			<input type="password" class="form-control" name="password_1" id="password_1" autocomplete="new-password" placeholder="<?php echo esc_attr__('New Password', 'luxrio') ?>"/>
		</p>
		<p class="col-12 mb-4">
			<input type="password" class="form-control" name="password_2" id="password_2" autocomplete="new-password" placeholder="<?php echo esc_attr__('Confirm Password', 'luxrio') ?>"/>
		</p>
	</fieldset>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<p>
		<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
		<button type="submit" class="vs-btn mask-style1 rounded-0 mt-3" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'luxrio' ); ?>"><?php esc_html_e( 'Save changes', 'luxrio' ); ?></button>
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
