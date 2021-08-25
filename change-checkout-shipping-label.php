<?php // only copy if needed

/**
 * Changes the local pickup plus label
 */
	function sv_change_local_pickup_label( $label, $method ) {
	if ( 'local_pickup_plus' === $method->method_id ) {
		$label = "My Custom Pickup Text";
	}

	return $label;
}
add_filter( 'woocommerce_cart_shipping_method_full_label', 'sv_change_local_pickup_label', 10, 2 );
