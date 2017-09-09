<?php
	
	add_shortcode("voa_payment","voa_payment_short_fn");
	function voa_payment_short_fn(){
		include_once("templates/voices_template_shortcode_payment.php");
	}
	add_action("admin_ajax_voa_filter_payment","voa_filter_payment_callback");

	add_action("wp_ajax_nopriv_voa_filter_payment","voa_filter_payment_callback");

	function voa_filter_payment_callback(){
		print "Hola";
		wp_die();
	}