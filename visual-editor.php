<?php
/*
Plugin Name: AIO WP Builder
Plugin URI: http://allinonewpbuilder.com/
Description: Build pages, popup, widgets or anything you can think of with simple drag and drop builder.
Author: AIO WP Builder
Version: 2.0.2
Author URI: http://allinonewpbuilder.com/
*/
define('VE_DIR',dirname(__FILE__));
define('VE_URL',plugins_url('',__FILE__));
define('VE_CONFIG',VE_DIR.'/config');
define('VE_CORE',VE_DIR.'/core');
define('VE_MODULE',VE_DIR.'/modules');
define('VE_VIEW',VE_DIR.'/view');
define('VE_PAGE_TEMPLATE_DIR',VE_VIEW.'/page-templates');
define('VE_VERSION','2.0.2');
require_once VE_CORE.'/load.php';
$ve_loader=new VE_Loader();

$ve_loader->init()->ve_manager()->run(require VE_CONFIG.'/ve-config.php');

register_activation_hook( __FILE__, array($ve_loader->ve_manager(), 'plugin_activate'));

add_action('admin_init', 'aio_get_media');

function aio_get_media()
{
	wp_enqueue_media();
}
