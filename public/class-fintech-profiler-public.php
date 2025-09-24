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
		if (is_post_type_archive('fintech') || is_page_template('templates/create_fintech_profile.php')) {
			wp_enqueue_style('jquery-ui', 'https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css', array(), '2.3.4', 'all');
		}

		wp_enqueue_style('select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', array(), '4.1.0-rc.0', 'all');

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

		wp_enqueue_script('select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), '4.1.0-rc.0', true);

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
		if (is_singular('fintech_profiles')) {
			$theme_template = locate_template(array('fintech-profiler/single-fintech_profiles.php'));
			if ($theme_template) {
				return $theme_template; // Use theme override
			}
			$plugin_template = FINTECH_PROFILER_BASE . 'templates/single-fintech_profiles.php';
			if (file_exists($plugin_template)) {
				return $plugin_template; // Fallback to plugin template
			}
		}

		if (is_post_type_archive('fintech_profiles')) {
			$theme_template = locate_template(array('fintech-profiler/archive-fintech_profiles.php'));
			if ($theme_template) {
				return $theme_template; // Use theme override
			}
			$plugin_template = FINTECH_PROFILER_BASE . 'templates/archive-fintech_profiles.php';
			if (file_exists($plugin_template)) {
				return $plugin_template; // Fallback to plugin template
			}
		}

		if (isset($_GET['create_fintech_profile'])) {
			$plugin_template = plugin_dir_path(__FILE__) . 'templates/template-create_profile.php';
			if (file_exists($plugin_template)) {
				return $plugin_template;
			}
		}

		return $template;
	}
}


/*

add_action('template_redirect', array($this, 'handle_create_profile_form'));

public function handle_create_profile_form() {
    if (!isset($_POST['submit_profile'])) return;

    if (!isset($_POST['create_fintech_profile_nonce']) || !wp_verify_nonce($_POST['create_fintech_profile_nonce'], 'create_fintech_profile')) {
        wp_die(__('Nonce verification failed', 'fintech-profiler'));
    }
s
    if (!current_user_can('edit_financial_profiles')) {
        wp_die(__('You do not have permission to create a profile.', 'fintech-profiler'));
    }

    $title = sanitize_text_field($_POST['profile_title']);
    $content = wp_kses_post($_POST['profile_content']);

    $post_id = wp_insert_post(array(
        'post_title'   => $title,
        'post_content' => $content,
        'post_status'  => 'publish',
        'post_type'    => 'financial_profiles',
    ));

    if (is_wp_error($post_id)) {
        wp_die(__('Error creating profile', 'fintech-profiler'));
    }

    // Handle featured image upload
    if (!empty($_FILES['profile_image']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        $attachment_id = media_handle_upload('profile_image', $post_id);
        if (!is_wp_error($attachment_id)) {
            set_post_thumbnail($post_id, $attachment_id);
        }
    }

    // Redirect to profile page after creation
    wp_redirect(get_permalink($post_id));
    exit;
}


add_filter('template_include', array($this, 'load_create_profile_template'));

public function load_create_profile_template($template) {
    if (isset($_GET['create_fintech_profile'])) {
        $plugin_template = plugin_dir_path(__FILE__) . 'templates/template-create_profile.php';
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }
    return $template;
}
 */
