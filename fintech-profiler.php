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
 * @since             1.0.6
 * @package           Fintech_Profiler
 *
 * @wordpress-plugin
 * Plugin Name:       Fintech Profiler
 * Plugin URI:        https://rajanlama.com.np/wp/fintech-profiler
 * Description:       This is a simple plugin to handle Fintach Profiler.
 * Version:           1.0.6
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
define('FINTECH_PROFILER_VERSION', '1.0.6');
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
});


function add_category_to_custom_post_type()
{
	register_taxonomy_for_object_type('category', 'fintech_profiles');
}
add_action('init', 'add_category_to_custom_post_type');
