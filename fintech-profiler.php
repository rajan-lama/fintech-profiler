<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://rajanlama.com.np
 * @since             1.0.15
 * @package           Fintech_Profiler
 *
 * @wordpress-plugin
 * Plugin Name:       Fintech Profiler
 * Plugin URI:        https://rajanlama.com.np/wp/fintech-profiler
 * Description:       This is a simple plugin to handle Fintach Profiler.
 * Version:           1.0.15
 * Author:            Rajan Lama
 * Author URI:        https://rajanlama.com.np/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fintech-profiler
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('FINTECH_PROFILER_VERSION', '1.0.15');
define('FINTECH_PROFILER_BASE', plugin_dir_path(__FILE__));
define('FINTECH_PROFILER_BASE_URL', plugin_dir_url(__FILE__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-fintech-profiler-activator.php
 */
function activate_fintech_profiler()
{
	require_once FINTECH_PROFILER_BASE . 'includes/class-fintech-profiler-activator.php';
	Fintech_Profiler_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-fintech-profiler-deactivator.php
 */
function deactivate_fintech_profiler()
{
	require_once FINTECH_PROFILER_BASE . 'includes/class-fintech-profiler-deactivator.php';
	Fintech_Profiler_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_fintech_profiler');
register_deactivation_hook(__FILE__, 'deactivate_fintech_profiler');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require FINTECH_PROFILER_BASE . 'includes/class-fintech-profiler.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_fintech_profiler()
{

	$plugin = new Fintech_Profiler();
	$plugin->run();
}
run_fintech_profiler();

add_action('after_setup_theme', function () {
	add_image_size('fintech_profiler_slider', 615, 400, true);
	add_image_size('fintech-profiler-three-col', 350, 227, true);
	// if (!current_user_can('administrator')) {
	// 	show_admin_bar(false);
	// }
});

add_filter('show_admin_bar', '__return_false');


// add_action('init', function () {
// 	if (class_exists('WooCommerce')) {
// 		add_shortcode('fintech_checkout', function () {
// 			// Load WooCommerce assets for checkout
// 			// Initialize WooCommerce objects if not already done
// 			// if (null === WC()->session) {
// 			// 	$session_class = apply_filters('woocommerce_session_handler', 'WC_Session_Handler');
// 			// 	WC()->session = new $session_class();
// 			// 	WC()->session->init();
// 			// }

// 			// if (null === WC()->customer) {
// 			// 	WC()->customer = new WC_Customer(get_current_user_id(), true);
// 			// }

// 			// if (null === WC()->cart) {
// 			// 	WC()->cart = new WC_Cart();
// 			// }

// 			ob_start();
// 			echo do_shortcode('[woocommerce_checkout]');
// 			return ob_get_clean();
// 			ob_start();
// 		});
// 	}
// });


// Treat your custom checkout page as WooCommerce's checkout page
add_filter('woocommerce_is_checkout', function ($is_checkout) {
	if (is_page('fintech-dashboard')) { // change to your page slug
		return true;
	}
	return $is_checkout;
});

// Define the shortcode
add_action('init', function () {
	if (class_exists('WooCommerce')) {
		add_shortcode('fintech_checkout', function () {

			// wc()->frontend_includes();
			// wc()->cart = new WC_Cart();
			// wc()->session = new WC_Session_Handler();
			// wc()->customer = new WC_Customer(get_current_user_id(), true);

			if (null === WC()->session) {
				// $session_class = apply_filters('woocommerce_session_handler', 'WC_Session_Handler');
				// WC()->session = new $session_class();
				// WC()->session->init();

				// WC()->customer = new WC_Customer(get_current_user_id(), true);



				// var_dump(WC()->session);
			}

			// var_dump('ID:', get_current_user_id());
			// var_dump(WC()->customer);
			// var_dump(WC());

			// var_dump(WC()->payment_gateways->get_available_payment_gateways());

			ob_start();
			echo do_shortcode('[woocommerce_checkout]');
			return ob_get_clean();
		});
	}
});
