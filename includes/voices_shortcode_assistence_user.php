<?php

add_shortcode("voa_assistence_user","voa_assistence_user_short_fn");
	function voa_assistence_user_short_fn(){
		ob_start();
			include_once("templates/voices_template_shortcode_assistance_user.php");
	    return ob_get_clean();

}
