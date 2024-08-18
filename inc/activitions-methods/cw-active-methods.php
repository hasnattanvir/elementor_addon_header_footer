<?php

defined( 'ABSPATH' ) || die();

/**
 * Currently plugin deactivation.
 * This plugin deactive id curlware theme not activate
 * Define every theme slug name when use this plugin
 */

//==================== Theme Active Check ==========================
add_action('switch_theme', 'handle_theme_change');

 function handle_theme_change() {
	 
	 if (!function_exists('is_plugin_active')) {
		 include_once(ABSPATH . 'wp-admin/includes/plugin.php');
	 }
	 $theme_elementor_plugin = 'elementor/elementor.php'; 
	 $theme_cw_hfa_plugin = 'elementor_addon_header_footer/curlware-header-footer-elementor.php';
	 $theme_current_theme = wp_get_theme();
	
	 if (!is_plugin_active($theme_elementor_plugin) || $theme_current_theme->get('Name') !== 'curlware') {
		 if (is_plugin_active($theme_cw_hfa_plugin)) {
			 deactivate_plugins($theme_cw_hfa_plugin);
		 }
		 remove_plugin_menu_items();
	 }
 }
 
//==================== Plugin Active Check ==========================
add_action('plugins_loaded', 'cw_check_and_handle_theme_for_plugin');

function cw_check_and_handle_theme_for_plugin() {
 
    if (!function_exists('is_plugin_active')) {
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }

    $elementor_plugin = 'elementor/elementor.php'; 
    $cw_hfa_plugin = 'elementor_addon_header_footer/curlware-header-footer-elementor.php';
    $current_theme = wp_get_theme();

    if (is_plugin_active($elementor_plugin)) {
        
        if ($current_theme->get('Name') === 'curlware') {
           
            if (!is_plugin_active($cw_hfa_plugin)) {
                activate_plugin($cw_hfa_plugin);
            }
        } else {
            if (is_plugin_active($cw_hfa_plugin)) {
                deactivate_plugins($cw_hfa_plugin);
            }
            add_action('admin_notices', 'notify_admin_to_switch_theme');
        }
    } else {
      
        if (is_plugin_active($cw_hfa_plugin)) {
            deactivate_plugins($cw_hfa_plugin);
        }
        add_action('admin_menu', 'remove_plugin_menu_items', 999);
        add_action('admin_notices', 'notify_admin_to_activate_elementor');
    }
}

if(!function_exists('notify_admin_to_switch_theme')){
    function notify_admin_to_switch_theme() {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p><?php echo esc_html('The "Curlware Header Footer Elementor Addon" plugin is only active when the "Curlware" theme is active. Please switch back to the "Curlware" theme to use this plugin.', 'curlware-header-footer-elementor'); ?></p>
        </div> 
        <?php
    }
}


function notify_admin_to_activate_elementor() {
    ?>
    <div class="notice notice-error is-dismissible"> 
        <p><?php echo esc_html('The "Curlware Header Footer Elementor Addon" plugin requires the Elementor plugin to be active. Please activate Elementor to use this plugin.', 'curlware-header-footer-elementor'); ?></p> 
    </div> 
    <?php
}

function remove_plugin_menu_items() {
	
	if (function_exists('remove_menu_page')) {
		remove_menu_page('elementor-hf'); 
	}
}
