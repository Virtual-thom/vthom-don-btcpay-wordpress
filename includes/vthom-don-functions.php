<?php
/*
 * Add my new menu to the Admin Control Panel
 */

add_action( 'admin_menu', 'vthom_Add_My_Admin_Link' );
 
// Add a new top level menu link to the ACP
function vthom_Add_My_Admin_Link()
{
	add_menu_page(
        'Donaters', // Title of the page
        'Donaters', // Text to show on the menu link
        'manage_options', // Capability requirement to see the link
        'vthom-acp-page', // The 'slug' - file to display when clicking the link
        'vthom_acp_render' 
    );
}
function vthom_acp_render() {
  include( plugin_dir_path(__FILE__) . 'vthom-acp-page.php');
}

add_action( 'rest_api_init', 'vthom_add_callback_url_endpoint' );
function vthom_add_callback_url_endpoint(){
    register_rest_route(
        'vthom/', // Namespace
        'webhook-callback', // Endpoint
        array(
            'methods'  => 'POST',
            'callback' => 'vthom_webhook_callback'
        )
    );
}


function vthom_webhook_callback( $request ) {
	global $vthom_request ;
	$vthom_request = $request ; 

	include ( plugin_dir_path(__FILE__) . 'vthom-don-webhook.php' );
	return;
}


add_shortcode('vthom_don_shortcode_donaters', 'vthom_don_shortcode_donaters');
function vthom_don_shortcode_donaters(){
	ob_start();
	include ( plugin_dir_path(__FILE__) . 'vthom-don-display-donaters.php' );
	return ob_get_clean();
}
