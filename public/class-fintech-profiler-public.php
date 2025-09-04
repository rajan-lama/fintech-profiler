<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://rajanlama.com.np
 * @since      1.0.0
 *
 * @package    Fintech_Profiler
 * @subpackage Fintech_Profiler/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Fintech_Profiler
 * @subpackage Fintech_Profiler/public
 * @author     Rajan Lama <rajan.lama786@gmail.com>
 */
class Fintech_Profiler_Public
{

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_filter('template_include', array($this, 'template_loader'), 99);
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

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
		// wp_enqueue_style('jquery-ui-slider');
		if (is_post_type_archive('fintech')) {
			wp_enqueue_style('jquery-ui', 'https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css', array(), '2.3.4', 'all');
		}
		// wp_enqueue_style( 'jQuery-ui',  FINTECH_PROFILER_BASE_URL . 'public/css/jQuery-ui.css', array(), 'v1.14.1', 'all' );
		wp_enqueue_style('owl-carousel', FINTECH_PROFILER_BASE_URL . 'public/css/owl.carousel.min.css', array(), '2.3.4', 'all');
		wp_enqueue_style('owl-theme', FINTECH_PROFILER_BASE_URL . 'public/css/owl.theme.default.min.css', array(), '2.3.4', 'all');
		wp_enqueue_style('fintech-profiler-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css', array(), '4.7.0', 'all');
		// wp_enqueue_style( 'fintech-profiler-google-fonts', 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap', array(), null, 'all' );


		wp_enqueue_style($this->plugin_name, FINTECH_PROFILER_BASE_URL . 'public/css/fintech-profiler-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

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

		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_script('jquery-ui-accordion');

		wp_enqueue_script('owl-carousel', FINTECH_PROFILER_BASE_URL . 'public/js/owl.carousel.min.js', array('jquery'), '2.3.4', true);

		wp_enqueue_script($this->plugin_name, FINTECH_PROFILER_BASE_URL . 'public/js/fintech-profiler-public.js', array('jquery', 'jquery-ui-tabs', 'jquery-ui-slider', 'jquery-ui-accordion'), $this->version, false);

		wp_localize_script($this->plugin_name, 'fintech_ajax', array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce'    => wp_create_nonce('fintech_filter_nonce'),
			'site_url' => FINTECH_PROFILER_BASE_URL,
		));
	}

	public function template_loader($template)
	{
		if (is_singular('fintech')) {
			$theme_template = locate_template(array('fintech-profiler/single-fintech.php'));
			if ($theme_template) {
				return $theme_template; // Use theme override
			}
			$plugin_template = FINTECH_PROFILER_BASE . 'templates/single-fintech.php';
			if (file_exists($plugin_template)) {
				return $plugin_template; // Fallback to plugin template
			}
		}

		if (is_post_type_archive('fintech')) {
			$theme_template = locate_template(array('fintech-profiler/archive-fintech.php'));
			if ($theme_template) {
				return $theme_template; // Use theme override
			}
			$plugin_template = FINTECH_PROFILER_BASE . 'templates/archive-fintech.php';
			if (file_exists($plugin_template)) {
				return $plugin_template; // Fallback to plugin template
			}
		}

		return $template;
	}
}
