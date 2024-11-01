<?php

if (!defined('WP_UNINSTALL_PLUGIN') || !WP_UNINSTALL_PLUGIN || dirname(WP_UNINSTALL_PLUGIN) != dirname(plugin_basename( __FILE__ ))) {
	status_header(404);
	exit;
}

class Google_Languages_Translator_Uninstall { 
 
 	public static function initialize() {
		
		delete_option('glt-site-language');
		delete_option('glt-multi-language');
		delete_option('glt-languages');
		delete_option('glt-languages-list');
		delete_option('glt-display-mode');
		delete_option('glt-inline-display-mode');
		delete_option('glt-tabbed-display-mode');
		delete_option('glt-flags');
		delete_option('glt-flags-list');
		delete_option('glt-flags-order');
		delete_option('glt-toolbar');
		delete_option('glt-align');
		delete_option('glt-active');
		delete_option('glt-analytics');
		delete_option('glt-analytics-id');
		delete_option('glt-css');

	}
	
}

Google_Languages_Translator_Uninstall::initialize();