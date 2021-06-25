<?php

// define the woocommerce_duplicate_product_exclude_meta callback
//function filter_woocommerce_duplicate_product_exclude_meta( $array ) {
//array_push( $array, '_wc_memberships_membership_plan_ids[]' );
//return $array;
//};

// add the filter
//add_filter( 'woocommerce_duplicate_product_exclude_meta', 'filter_woocommerce_duplicate_product_exclude_meta', 10, 1 );

// duplicate memberships settings for products
//add_action( 'woocommerce_product_duplicate', array( $this, 'duplicate_product_memberships_data' ), 10, 2 );

	add_action ( 'wp_loaded', 'sv_wc_memberships_remove_duplicate_data', 10 );

		function sv_wc_memberships_remove_duplicate_data (){
			if ( function_exists( 'wc_memberships') && wc_memberships()->get_admin_instance() instanceof WC_Memberships_Admin ) {
				$remove_action = remove_action( 'woocommerce_product_duplicate', [ wc_memberships()->get_admin_instance()->get_products_instance(), 'duplicate_product_memberships_data' ], 10 );

				error_log( print_r( $remove_action ? 'true' : 'false', true ) );
			}

			//error_log( print_r( wc_memberships (), true ) );
	}
