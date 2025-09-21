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
      add_action('init', array($this, 'register_cpt'));
      add_action('init', array($this, 'add_custom_roles_caps'));
      // add_action('init', array($this, 'register_cpt'));
      // register_activation_hook(__FILE__, array($this, 'add_custom_roles_caps'));
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
  }

  new Fintech_Profiler_CPT_Financial();
}
