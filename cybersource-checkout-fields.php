<?php //only copy if required!
 
 /*
 * Adjust the font-size of the input fields for Cybersource Credit Card gateway.
 */
function sv_adjust_input_font_size_for_cybersource( $styles ) {
	
	$styles['input']['font-size'] = '1em';
 	return $styles;
}

add_filter( 'wc_cybersource_payment_form_js_args', 'sv_adjust_input_font_size_for_cybersource', 10, 1 );
