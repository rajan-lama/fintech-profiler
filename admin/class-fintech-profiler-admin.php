<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://rajanlama.com.np
 * @since      1.0.0
 *
 * @package    Fintech_Profiler
 * @subpackage Fintech_Profiler/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Fintech_Profiler
 * @subpackage Fintech_Profiler/admin
 * @author     Rajan Lama <rajan.lama786@gmail.com>
 */
class Fintech_Profiler_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Fintech_Profiler_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Fintech_Profiler_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, FINTECH_PROFILER_BASE_URL . 'admin/css/fintech-profiler-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Fintech_Profiler_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Fintech_Profiler_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, FINTECH_PROFILER_BASE_URL . 'admin/js/fintech-profiler-admin.js', array( 'jquery' ), $this->version, false );

	}

}
