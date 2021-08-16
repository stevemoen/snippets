<?php // Only copy this line if needed.

/**
 * Add admin custom fields data to order notes
 *
 * @param \WC_Order $order order object
 * @param 
 */
function sv_wc_admin_custom_order_fields_add_to_notes( $order_id, $post) {
	error_log( 'sv_wc_admin_custom_order_fields_add_to_notes1 $order_id:' . print_r( $order_id, true ) );

	//error_log( 'method_name1 $var:' . print_r( $var, true ) );

	$updated_custom_fields = isset( $_POST['wc-admin-custom-order-fields'] ) ? $_POST['wc-admin-custom-order-fields'] : null;

	if ( empty( $updated_custom_fields ) ) {
		return;
	}
	error_log( 'sv_wc_admin_custom_order_fields_add_to_notes2 $order_id:' . print_r( $order_id, true ) );

	$order        = wc_get_order( $post );
	$order_fields = wc_admin_custom_order_fields()->get_order_fields();

	foreach ( $order_fields as $custom_field ) {
		error_log( 'sv_wc_admin_custom_order_fields_add_to_notes3 $order_id:' . print_r( $order_id, true ) );

		$field_id       = $custom_field->get_id();
		$field_meta_key = $custom_field->get_meta_key();
		$updated_value  = isset( $updated_custom_fields[ $field_id ] ) ? $updated_custom_fields[ $field_id ] : '';

		// Update a custom field value unless it's empty...
		// A value of 0 is valid, so check for that first.
		// Empty string is also allowed to clear out custom fields completely.
		if ( '0' === $updated_value || '' === $updated_value || ! empty( $updated_value ) ) {
			error_log( 'sv_wc_admin_custom_order_fields_add_to_notes4 $order_id:' . print_r( $order_id, true ) );

			// Special handling for date fields.
			if ( 'date' === $order_fields[ $field_id ]->get_type() ) {
				error_log( 'sv_wc_admin_custom_order_fields_add_to_notes5 $order_id:' . print_r( $order_id, true ) );

				$updated_value = strtotime( $updated_value );
				// Add Order Note
				$order->add_order_note( $order, 'updated value: ' . $updated_value);

				$order_fields[ $field_id ]->set_value( $updated_value );

				$order->update_meta_data( $field_meta_key, $order_fields[ $field_id ]->get_value() );

				// This column is used so that date fields can be searchable.
				$order->update_meta_data( $field_meta_key . '_formatted', $order_fields[ $field_id ]->get_value_formatted() );

			} else {
				error_log( 'sv_wc_admin_custom_order_fields_add_to_notes6 $order_id:' . print_r( $order_id, true ) );

				$order->update_meta_data( $field_meta_key, $updated_value );
			}

		// ...Or if it's empty, delete the custom field meta altogether.
		} else {

			error_log( 'sv_wc_admin_custom_order_fields_add_to_notes7 $order_id:' . print_r( $order_id, true ) );

				// Remove order note
			$order->add_order_note( $order, 'removed value/set blank: ' . $updated_value);
			
			$order->delete_meta_data( $field_meta_key );
			$order->delete_meta_data( $field_meta_key . '_formatted' );
		}

		$order->save_meta_data();
	}
	
}
add_action( 'woocommerce_process_shop_order_meta', 'sv_wc_admin_custom_order_fields_add_to_notes', 15, 2 );
