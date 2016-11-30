<?php 
/*
 *	Made by Samerton
 *  https://github.com/NamelessMC/Nameless/
 *  NamelessMC version 2.0.0-dev
 *
 *  License: MIT
 *
 *  Server Statistics module initialisation file
 */

// Ensure module has been installed
$module_installed = $cache->retrieve('module_server_statistics');
if(!$module_installed){
	// Hasn't been installed
	// Need to initialise any additional tables...
	
} else {
	// Installed
}

// Custom language
$ss_language = new Language('modules/Server_Statistics/language');

// Define URLs which belong to this module
$pages->add('Server_Statistics', '/admin/server', 'pages/server.php');

// Add link to admin sidebar
if(!isset($admin_sidebar)) $admin_sidebar = array();
$admin_sidebar['server'] = array(
	'title' => $ss_language->get('language', 'server_stats'),
	'url' => URL::build('/admin/server')
);