<?php
/**
 * Plugin Name:     Voices Assistance
 * Plugin URI:      
 * Description:     Exclusive plugin for taking attendance at chorus events as well as record payments made
 * Version:         1.0.0
 * Author:          frontuari C.A
 * Author URI:      frontuari.com
 * Text Domain:     voices_assistance
 *
 * @package        	frontuari\Voices Assistance
 * @author          Alberto Vargas
 * @copyright       Copyright (c) 2017
 *
 *
 * - Find all instances of @todo in the plugin and update the relevant
 *   areas as necessary.
 *
 * - All functions that are not class methods MUST be prefixed with the
 *   plugin name, replacing spaces with underscores. NOT PREFIXING YOUR
 *   FUNCTIONS CAN CAUSE PLUGIN CONFLICTS!
 */


// Plugin version
if ( ! defined('VOICES_ASSISTANCE_VERSION' ) ) define('VOICES_ASSISTANCE_VERSION', '1.0' ); 

if ( ! class_exists( 'VOICES_ASSISTANCE' ) ) :

class VOICES_ASSISTANCE {
	private static $instance = null;
	public static function getInstance() {
		if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
	}
	function __construct() {
		$this->setupGlobals();
		$this->includes();
		$this->loadTextDomain();
		
	}
	private function includes() {
		//API REST CPANEL
		require_once VOICES_ASSISTANCE_PLUGIN_DIR.'includes/voices_postype_assistence.php';
		require_once VOICES_ASSISTANCE_PLUGIN_DIR.'includes/voices_postype_payment.php';
		require_once VOICES_ASSISTANCE_PLUGIN_DIR.'includes/voices_postype_payment_type.php';
		require_once VOICES_ASSISTANCE_PLUGIN_DIR.'includes/scripts.php';
		//Shortcode
		require_once VOICES_ASSISTANCE_PLUGIN_DIR.'includes/voices_shortcode_assistence.php';
		require_once VOICES_ASSISTANCE_PLUGIN_DIR.'includes/voices_shortcode_payment.php';


		do_action('wpemails_cpve_include_files');

	}
	
	private function setupGlobals() {
		// Plugin Folder Path
		if (!defined('VOICES_ASSISTANCE_PLUGIN_DIR')) {
			define('VOICES_ASSISTANCE_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
		}

		// Plugin Folder URL
		if (!defined('VOICES_ASSISTANCE_PLUGIN_URL')) {
			define('VOICES_ASSISTANCE_PLUGIN_URL', plugin_dir_url(__FILE__));
		}

		// Plugin Root File
		if (!defined('VOICES_ASSISTANCE_PLUGIN_FILE')) {
			define('VOICES_ASSISTANCE_PLUGIN_FILE', __FILE__ );
		}
		
		// Plugin text domain
		if (!defined('VOICES_ASSISTANCE_TEXT_DOMAIN')) {
			define('VOICES_ASSISTANCE_TEXT_DOMAIN', 'voices_assistance' );
		}
		 // Plugin URL
            if(!defined('VOICES_ASSISTANCE_URL')) {
                define('VOICES_ASSISTANCE_URL', plugin_dir_url( __FILE__ ) );
            }

	}
	public function loadTextDomain() {
		// Set filter for plugin's languages directory
		$lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
		$lang_dir = apply_filters('wpemails_cpve_languages_directory', $lang_dir );

		// Traditional WordPress plugin locale filter
		$locale        = apply_filters( 'plugin_locale',  get_locale(), 'VOICES_ASSISTANCE' );
		$mofile        = sprintf( '%1$s-%2$s.mo', 'VOICES_ASSISTANCE', $locale );

		// Setup paths to current locale file
		$mofile_local  = $lang_dir . $mofile;
		$mofile_global = WP_LANG_DIR . '/VOICES_ASSISTANCE/' . $mofile;

		if ( file_exists( $mofile_global ) ) {
			// Look in global /wp-content/languages/TESTPRO/ folder
			load_textdomain( 'VOICES_ASSISTANCE', $mofile_global );
		} elseif ( file_exists( $mofile_local ) ) {
			// Look in local /wp-content/plugins/TESTPRO/languages/ folder
			load_textdomain( 'VOICES_ASSISTANCE', $mofile_local );
		} else {
			// Load the default language files
			load_plugin_textdomain( 'VOICES_ASSISTANCE', false, $lang_dir );
		}
		
	}
}

endif; // End if class_exists check

$voices_assistance = null;
function getClassvoices_assistance() {
	global $voices_assistance;
	if (is_null($voices_assistance)) {
		$voices_assistance = VOICES_ASSISTANCE::getInstance();
	}
	return $voices_assistance;
}
getClassvoices_assistance();
