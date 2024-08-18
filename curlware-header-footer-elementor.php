<?php
/**
 * Plugin Name: CurlWare Header Footer Elements
 * Plugin URI:  https://themeforest.net/user/CurlWare/portfolio
 * Description: CurlWare header footer builder & Addons
 * Author:      CurlWare 
 * Author URI:  https://themeforest.net/user/CurlWare/portfolio
 * Text Domain: curlware-header-footer-elementor
 * Domain Path: /languages
 * Version: 1.0.0
 */


 defined( 'ABSPATH' ) || die();


define( 'curlwareelements_VER', '1.0.0' );
define( 'curlwareelements_FILE', __FILE__ );
define( 'curlwareelements_DIR', plugin_dir_path( __FILE__ ) );
define( 'curlwareelements_URL', plugins_url( '/', __FILE__ ) );
define( 'curlwareelements_PATH', plugin_basename( __FILE__ ) );
define( 'curlwareelements_DIR_URL_ADMIN', plugin_dir_url( __FILE__ ) );
define( 'curlwareelements_ASSETS_ADMIN', trailingslashit( curlwareelements_DIR_URL_ADMIN ) );
define( 'curlwareelements_PREFIX', 'curlware' );

/**
 * All class loader files.
 */
require_once curlwareelements_DIR . '/inc/class-header-footer-elementor.php';
require_once curlwareelements_DIR . '/inc/meta/curlware-postmeta.php';
require_once curlwareelements_DIR . '/inc/activitions-methods/cw-active-methods.php';
require_once curlwareelements_DIR . '/inc/meta/post-meta.php'; // Post Meta

require_once curlwareelements_DIR . 'widgets/init.php';
require_once curlwareelements_DIR . 'widgets/curlware-widget-fields.php';

/**
 * Active Plugin Class Lade.
 */
function curlwareelements_plugin_activation() {

	$footer_widget = socoders_elements_footer_widget_function();
	update_option( 'socoders_elements_plugin_is_activated', 'yes' );
	update_option( 'curlwareelements_addon_option', $footer_widget );
}
register_activation_hook( curlwareelements_FILE, 'curlwareelements_plugin_activation' );
/**
 * The Plugin Class Load
 */
function curlwareelements_init() {
	Header_Footer_Elementor::instance();
}
add_action( 'plugins_loaded', 'curlwareelements_init' );
function socoders_elements_footer_widget_function() {
	$array = [
        'curlwareelements_copyright' => 'curlwareelements_copyright',
        'curlwareelements_pricing_switcher' => 'curlwareelements_pricing_switcher',
		'curlwareelements_newsletter' => 'curlwareelements_newsletter',
		'curlwareelements_header_button' => 'curlwareelements_header_button',
		'curlwareelements_navigation_menu' => 'curlwareelements_navigation_menu' ,
		'curlwareelements_site_logo' => 'curlwareelements_site_logo',
		'curlwareelements_page_title' => 'curlwareelements_page_title',
		'curlwareelements_search' => 'curlwareelements_search',
		'curlwareelements_service_grid' => 'curlwareelements_service_grid',
		'curlwareelements_counter' => 'curlwareelements_counter',
		'curlwareelements_feature_list' => 'curlwareelements_feature_list',
		'curlwareelements_teamslider' => 'curlwareelements_teamslider',
		'curlwareelements_TeamGrid' => 'curlwareelements_TeamGrid',
		'curlwareelements_blogslider' => 'curlwareelements_blogslider',
		'curlwareelements_BlogGrid' => 'curlwareelements_BlogGrid',
		'curlwareelements_contactform' => 'curlwareelements_contactform',
		'curlwareelements_projectslider' => 'curlwareelements_projectslider',
		'curlwareelements_testimonial' => 'curlwareelements_testimonial',
		'curlwareelements_brandslider' => 'curlwareelements_brandslider',
		'curlwareelements_pricetable' => 'curlwareelements_pricetable',
		'curlwareelements_heroslider' => 'curlwareelements_heroslider',
		'curlwareelements_SC_Accordion' => 'curlwareelements_SC_Accordion',
		'curlwareelements_service_slider' => 'curlwareelements_service_slider',
		'curlwareelements_working_process' => 'curlwareelements_working_process',
		'curlwareelements_sc_breadcrumb' => 'curlwareelements_sc_breadcrumb',
		'curlwareelements_ProjectGrid' => 'curlwareelements_ProjectGrid',
		'curlwareelements_SCoffcanvas' => 'curlwareelements_SCoffcanvas',
		'curlwareelements_SC_AuthorBiopic' => 'curlwareelements_SC_AuthorBiopic',


	];
	return $array;
}
