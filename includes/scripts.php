<?php
/**
 * Scripts
 *
 * @package     WPeMatico\PluginName\Scripts
 * @since       1.0.0
 */


// Exit if accessed directly
if ( !defined('ABSPATH') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

/**
 * Load admin scripts
 *
 * @since       1.0.0
 * @global      array $wpematico_settings_page The slug for the WPeMatico settings page
 * @global      string $post_type The type of post that we are editing
 * @return      void
 */
function voice_assistances_admin_scripts($hooks) {
          //styles
    global $post_type;
    if( (($hooks == 'post.php' OR $hooks=='post-new.php') && $post_type == 'voa_cpt_assistence')) {

        wp_enqueue_style( 'voice_assistances_admin_css', VOICES_ASSISTANCE_URL . '/assets/css/admin.css' );
        //scripts
        wp_enqueue_script( 'voice_assistances_admin_js', VOICES_ASSISTANCE_URL . '/assets/js/admin.js', array( 'jquery' ) );
      
        //JQUERY UI
        wp_enqueue_script( 'jquery-ui-datepicker' ,array( 'jquery' ));
        // You need styling for the datepicker. For simplicity I've linked to Google's hosted jQuery UI CSS.
        wp_register_style( 'jquery-ui', 'http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css' );
        wp_enqueue_style( 'jquery-ui' ); 

    }   
}
add_action( 'admin_enqueue_scripts', 'voice_assistances_admin_scripts', 100 );
