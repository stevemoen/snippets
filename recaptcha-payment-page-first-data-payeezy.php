<?php
/*
 * Triggers the `woocommerce_pay_order_before_submit` action on the /order-pay/ page.
 * This is used by the WooCommerce reCaptcha plugin, otherwise reCaptcha is not enabled.
 */
function sv_trigger_woo_action_for_recaptcha() {
	
	do_action( 'woocommerce_pay_order_before_submit' );
}

add_action( 'wc_first_data_payeezy_credit_card_payment_form', 'sv_trigger_woo_action_for_recaptcha' );
