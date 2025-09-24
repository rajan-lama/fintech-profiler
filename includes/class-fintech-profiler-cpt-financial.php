<?php
/* 
  * @package My_Custom_CPT
  * @version 1.0.0 
*/

if (! defined('ABSPATH')) {
  exit; // Prevent direct access
}

if (! class_exists('Fintech_Profiler_CPT_Financial')) {

  class Fintech_Profiler_CPT_Financial
  {
    public function __construct()
    {
      //add_action('init', array($this, 'register_cpt'));
      add_action('init', array($this, 'add_custom_roles_caps'));

      add_action('get_avatar', array($this, 'custom_avatar'), 10, 5);

      add_action('cmb2_admin_init', array($this, 'register_profile_picture_meta_box'));

      add_action('init', array($this, 'fp_handle_create_financial_profile_submission'));
      add_action('init', array($this, 'fp_handle_update_financial_profile_submission'));
    }

    /**
     * Register Custom Post Types
     */
    public function register_cpt()
    {
      /**
       * Financial CPT
       */
      $labels = array(
        'name'               => __('Financial Profiles', 'fintech-profiler'),
        'singular_name'      => __('Financial Profile', 'fintech-profiler'),
        'menu_name'          => __('Financial Profiles', 'fintech-profiler'),
        'add_new'            => __('Add New', 'fintech-profiler'),
        'add_new_item'       => __('Add New Financial Profile', 'fintech-profiler'),
        'edit_item'          => __('Edit Financial Profile', 'fintech-profiler'),
        'new_item'           => __('New Financial Profile', 'fintech-profiler'),
        'view_item'          => __('View Financial Profile', 'fintech-profiler'),
        'all_items'          => __('All Financial Profiles', 'fintech-profiler'),
        'search_items'       => __('Search Financial Profiles', 'fintech-profiler'),
        'not_found'          => __('No Financial Profiles found.', 'fintech-profiler'),
        'not_found_in_trash' => __('No Financial Profiles found in Trash.', 'fintech-profiler'),
      );

      $financial_capabilities = array(
        'publish_posts'         => 'publish_financial_profiles',
        'edit_posts'            => 'edit_financial_profiles',
        'edit_others_posts'     => 'edit_others_financial_profiles',
        'delete_posts'          => 'delete_financial_profiles',
        'delete_others_posts'   => 'delete_others_financial_profiles',
        'read_private_posts'    => 'read_private_financial_profiles',
        'edit_post'             => 'edit_financial_profile',
        'delete_post'           => 'delete_financial_profile',
        'read_post'             => 'read_financial_profile',
      );

      register_post_type('financial_profiles', array(
        'labels'          => $labels,
        'public'          => true,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'menu_position'   => 5,
        'has_archive'     => true,
        'rewrite'         => array('slug' => 'financial-profiles'),
        'supports'        => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'menu_icon'       => 'dashicons-buddicons-buddypress-logo',
        'capability_type' => 'financial_profile',
        'map_meta_cap'    => true,
        'capabilities'    => $financial_capabilities,
      ));
    }

    /**
     * Add custom capabilities to financial_manager role
     */
    public function add_custom_roles_caps()
    {
      $caps = array(
        'publish_financial_profiles',
        'edit_financial_profiles',
        'edit_others_financial_profiles',
        'delete_financial_profiles',
        'delete_others_financial_profiles',
        'read_private_financial_profiles',
        'edit_financial_profile',
        'delete_financial_profile',
        'read_financial_profile',
      );

      // Add caps to financial_manager
      $financial_role = get_role('financial_manager');
      if ($financial_role) {
        foreach ($caps as $cap) {
          $financial_role->add_cap($cap, true);
        }
        $financial_role->add_cap('upload_files', true);
      }

      // 🔑 Add caps to administrator
      $admin_role = get_role('administrator');
      if ($admin_role) {
        foreach ($caps as $cap) {
          $admin_role->add_cap($cap, true);
        }
      }
    }


    function register_profile_picture_meta_box()
    {

      /**
       * Repeatable Field Groups
       */
      $cmb = new_cmb2_box(array(
        'id'           => 'user_profile_picture',
        'title'        => 'Profile Picture',
        'object_types' => array('user'), // Use 'user' to display this for user profiles
        'context'      => 'normal',
        'priority'     => 'default',
      ));

      // Add the profile picture upload field
      $cmb->add_field(array(
        'name'    => 'Profile Picture',
        'desc'    => 'Upload your profile picture.',
        'id'      => '_profile_picture', // Meta field ID
        'type'    => 'file', // File upload field
        'options' => array(
          'url' => true, // Allow storing the URL of the image
        ),
        'text' => array(
          'add_upload_file_text' => 'Upload Profile Picture' // Custom text for the upload button
        ),
        'preview_size' => 'medium', // Optional: set image preview size
      ));
    }

    public function fp_handle_create_financial_profile_submission()
    {
      if (
        isset($_POST['fp_action'])
        && $_POST['fp_action'] === 'create_financial_profile'
        && isset($_POST['create_financial_profile_nonce'])
        && wp_verify_nonce($_POST['create_financial_profile_nonce'], 'create_financial_profile')
      ) {

        // Get current user ID
        $user_id = get_current_user_id();

        if ($user_id) {
          // Sanitize form inputs
          $user_name = sanitize_text_field($_POST['user_name']);
          $user_profile_website = esc_url_raw($_POST['user_profile_website']);

          // Update user meta for profile information
          update_user_meta($user_id, 'user_profile_name', $user_name);
          update_user_meta($user_id, 'user_profile_website', $user_profile_website);

          // Handle file upload for company logo
          if (isset($_FILES['company_logo']) && ! empty($_FILES['company_logo']['name'])) {
            // If a new file is uploaded, handle the file
            if (! function_exists('media_handle_upload')) {
              require_once(ABSPATH . 'wp-admin/includes/image.php');
              require_once(ABSPATH . 'wp-admin/includes/file.php');
              require_once(ABSPATH . 'wp-admin/includes/media.php');
            }

            // Upload the file
            // $upload = media_handle_upload('company_logo', 0);

            // if (! is_wp_error($upload)) {
            //   // Update the user meta with the uploaded file URL
            //   update_user_meta($user_id, '_profile_picture', wp_get_attachment_url($upload));
            // }
            $upload = media_handle_upload('company_logo', 0);

            if (! is_wp_error($upload)) {
              // Save the attachment ID instead of URL
              update_user_meta($user_id, '_profile_picture', $upload);
            }
          }

          // Optionally, update WordPress user data (name, website)
          wp_update_user([
            'ID' => $user_id,
            'display_name' => $user_name,
            'user_nicename'  => $user_name, // Set the user's display name
            'user_url' => $user_profile_website // Set the user's website URL
          ]);

          // Redirect to the user profile page or confirmation page
          wp_redirect($_POST['redirect_to']);
          exit;
        }
      }
    }

    public function fp_handle_update_financial_profile_submission()
    {
      if (
        isset($_POST['fp_action'])
        && $_POST['fp_action'] === 'edit_financial_profile'
        && isset($_POST['edit_financial_profile_nonce'])
        && wp_verify_nonce($_POST['edit_financial_profile_nonce'], 'edit_financial_profile')
      ) {

        // Get current user ID
        $user_id = get_current_user_id();

        if ($user_id) {

          $arg = array(
            'ID' => $user_id,
          );

          // Sanitize form inputs
          $user_name = sanitize_text_field($_POST['company_name']);
          $user_profile_website = esc_url_raw($_POST['website_link']);

          // Update user meta for profile information
          if (!empty($user_name)) {
            update_user_meta($user_id, 'user_profile_name', $user_name);
            $arg['display_name'] = $user_name;
            $arg['user_nicename']  = $user_name;
          }

          if (!empty($user_profile_website)) {
            update_user_meta($user_id, 'user_profile_website', $user_profile_website);
            $arg['user_url'] = $user_profile_website;
          }

          // Handle file upload for company logo
          if (isset($_FILES['company_logo']) && ! empty($_FILES['company_logo']['name'])) {
            // If a new file is uploaded, handle the file
            if (! function_exists('media_handle_upload')) {
              require_once(ABSPATH . 'wp-admin/includes/image.php');
              require_once(ABSPATH . 'wp-admin/includes/file.php');
              require_once(ABSPATH . 'wp-admin/includes/media.php');
            }

            // Upload the file
            $upload = media_handle_upload('company_logo', 0);

            if (! is_wp_error($upload)) {
              // Update the user meta with the uploaded file URL
              update_user_meta($user_id, '_profile_picture', wp_get_attachment_url($upload));
            }
          }

          // Optionally, update WordPress user data (name, website)
          wp_update_user($arg);

          // Redirect to the user profile page or confirmation page
          wp_redirect($_POST['redirect_to']);
          exit;
        }
      }
    }

    public  function custom_avatar($avatar, $id_or_email, $size, $default, $alt)
    {
      $user_id = is_object($id_or_email) ? $id_or_email->user_id : (int) $id_or_email;

      $profile_picture_url = get_user_meta($user_id, '_profile_picture', true);

      if (! empty($profile_picture_url)) {
        // Return the custom profile picture URL
        return '<img src="' . esc_url($profile_picture_url) . '" alt="' . esc_attr($alt) . '" width="' . $size . '" height="' . $size . '" />';
      }

      return $avatar; // Return default if no custom avatar
    }
  }

  new Fintech_Profiler_CPT_Financial();
}
