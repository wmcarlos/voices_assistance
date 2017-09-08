<?php
	
	add_shortcode("voa_assistence","voa_assistence_short_fn");
	function voa_assistence_short_fn(){
		include_once("templates/voices_template_shortcode_assistance.php");
	}
	add_action("admin_ajax_voa_filter_assitance","voa_filter_assitance_callback");
	function voa_filter_assistance_callback(){
		
		
	}