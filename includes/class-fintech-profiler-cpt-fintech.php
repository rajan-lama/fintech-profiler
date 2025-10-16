<?php
/* 
  * @package My_Custom_CPT
  * @version 1.0.0 
*/

use function Safe\error_log;

if (! defined('ABSPATH')) {
  exit; // Prevent direct access
}

if (! class_exists('Fintech_Profiler_CPT_Fintech')) {

  class Fintech_Profiler_CPT_Fintech
  {
    public function __construct()
    {
      add_action('init', array($this, 'register_cpt'));
      add_action('init', array($this, 'add_custom_roles_caps'));

      add_action('cmb2_admin_init', array($this, 'fintech_register_pricing_plans_metabox'));
      add_action('cmb2_admin_init', array($this, 'fintech_register_case_studies_metabox'));
      add_action('cmb2_admin_init', array($this, 'fintech_register_more_info_metabox'));
      add_action('cmb2_admin_init', array($this, 'fintech_register_slider_metabox'));

      // add_action('init', array($this, 'fp_handle_fintech_profile_submission'));
      // add_action('init', array($this, 'fp_handle_claim_fintech_profile'));

      // add_action('init', array($this, 'register_cpt'));
      // register_activation_hook(__FILE__, array($this, 'add_custom_roles_caps'));

      add_filter('map_meta_cap', array($this, 'fintech_cap_controller'), 10, 4);
    }

    /**
     * Register Custom Post Types
     */
    public function register_cpt()
    {
      /**
       * Fintech CPT
       */
      $labels = array(
        'name'               => __('Fintech Profiles', 'fintech-profiler'),
        'singular_name'      => __('Fintech Profile', 'fintech-profiler'),
        'menu_name'          => __('Fintech Profiles', 'fintech-profiler'),
        'add_new'            => __('Add New', 'fintech-profiler'),
        'add_new_item'       => __('Add New Fintech Profile', 'fintech-profiler'),
        'edit_item'          => __('Edit Fintech Profile', 'fintech-profiler'),
        'new_item'           => __('New Fintech Profile', 'fintech-profiler'),
        'view_item'          => __('View Fintech Profile', 'fintech-profiler'),
        'all_items'          => __('All Fintech Profiles', 'fintech-profiler'),
        'search_items'       => __('Search Fintech Profiles', 'fintech-profiler'),
        'not_found'          => __('No Fintech Profiles found.', 'fintech-profiler'),
        'not_found_in_trash' => __('No Fintech Profiles found in Trash.', 'fintech-profiler'),
      );

      $fintech_capabilities = array(
        'read_post' => 'read_fintech_profile',
        'delete_post' => 'delete_fintech_profile',
        'edit_posts' => 'edit_fintech_profiles',
        'publish_posts' => 'publish_fintech_profiles',
        'read_private_posts' => 'read_private_fintech_profiles',
        'delete_posts' => 'delete_fintech_profiles',
        'delete_private_posts' => 'delete_private_fintech_profiles',
        'delete_published_posts' => 'delete_published_fintech_profiles',
        'edit_private_posts' => 'edit_private_fintechs_profile',
        'edit_published_posts' => 'edit_published_fintech_profiles',
        'create_posts' => 'edit_fintech_profiles',
      );

      register_post_type('fintech_profiles', array(
        'labels'          => $labels,
        'public'          => true,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'menu_position'   => 5,
        'has_archive'     => true,
        'rewrite'         => array('slug' => 'fintech-profiles'),
        'supports'        => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'menu_icon'       => 'dashicons-buddicons-buddypress-logo',
        'capability_type' => 'fintech_profile',
        'map_meta_cap'    => true,
        'capabilities'    => $fintech_capabilities,
      ));
    }

    /**
     * Add custom capabilities to fintech_manager role
     */
    public function add_custom_roles_caps()
    {
      $caps = array(
        'delete_private_fintech_profiles',
        'delete_published_fintech_profiles',
        'edit_private_fintech_profile',
        'edit_published_fintech_profiles',
        'publish_fintech_profiles',
        'edit_fintech_profiles',
        'edit_others_fintech_profiles',
        'delete_fintech_profiles',
        'delete_others_fintech_profiles',
        'read_private_fintech_profiles',
        'edit_fintech_profile',
        'delete_fintech_profile',
        'read_fintech_profile',
      );

      // // Add caps to fintech_manager
      // $fintech_role = get_role('fintech_manager');
      // if ($fintech_role) {
      //   foreach ($fin_caps as $cap) {
      //     $fintech_role->add_cap($cap, true);
      //   }
      //   $fintech_role->add_cap('upload_files', true);
      // }

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
        'context'      => 'side',
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

    /**
     * Hook in and add a metabox to demonstrate repeatable grouped fields
     */
    public function fintech_register_pricing_plans_metabox()
    {

      /**
       * Repeatable Field Groups
       */
      $cmb_group = new_cmb2_box(array(
        'id'           => 'fintech_pricing_plans_metabox',
        'title'        => esc_html__('Pricing Plans', 'fintech-profiler'),
        'object_types' => array('fintech_profiles',),
      ));

      // $group_field_id is the field id string, so in this case: 'fintech_profiler_group_demo'
      $group_field_id = $cmb_group->add_field(array(
        'id'          => 'fintech_pricing_plans',
        'type'        => 'group',
        'options'     => array(
          'group_title'    => esc_html__('Plan {#}', 'fintech-profiler'), // {#} gets replaced by row number
          'add_button'     => esc_html__('Add Another Pricing Plan', 'fintech-profiler'),
          'remove_button'  => esc_html__('Remove Pricing Plan', 'fintech-profiler'),
          'sortable'       => true,
          'closed'      => true, // true to have the groups closed by default
          'remove_confirm' => esc_html__('Are you sure you want to remove?', 'fintech-profiler'), // Performs confirmation before removing group.
        ),
        'attributes' => [
          'data-conditional-id'    => 'pricing_plan_content_type',
          'data-conditional-value' => 'custom',
        ],
      ));
      $cmb_group->add_group_field($group_field_id, array(
        'name' => esc_html__('Name', 'fintech-profiler'),
        'id'   => 'name',
        'type' => 'text',
      ));

      $cmb_group->add_group_field($group_field_id, array(
        'name' => esc_html__('Description', 'fintech-profiler'),
        'id'   => 'description',
        'type' => 'text',
      ));

      $cmb_group->add_group_field($group_field_id, array(
        'name'       => esc_html__('Cost', 'fintech-profiler'),
        'id'         => 'cost',
        'type'       => 'text',
      ));
    }

    /**
     * Hook in and add a metabox to demonstrate repeatable grouped fields
     */
    public function fintech_register_case_studies_metabox()
    {

      /**
       * Repeatable Field Groups
       */
      $cmb_group = new_cmb2_box(array(
        'id'           => 'fintech_case_studies_metabox',
        'title'        => esc_html__('Case Studies', 'fintech-profiler'),
        'object_types' => array('fintech_profiles'),
      ));


      // $group_field_id is the field id string, so in this case: 'fintech_profiler_group_demo'
      $group_field_id = $cmb_group->add_field(array(
        'id'          => 'fintech_case_studies',
        'type'        => 'group',
        'options'     => array(
          'group_title'    => esc_html__('Case {#}', 'fintech-profiler'), // {#} gets replaced by row number
          'add_button'     => esc_html__('Add Another Case', 'fintech-profiler'),
          'remove_button'  => esc_html__('Remove Case', 'fintech-profiler'),
          'sortable'       => true,
          'closed'      => true, // true to have the groups closed by default
          'remove_confirm' => esc_html__('Are you sure you want to remove?', 'fintech-profiler'), // Performs confirmation before removing group.
        ),
        'attributes' => [
          'data-conditional-id'    => 'case_content_type',
          'data-conditional-value' => 'custom',
        ],
      ));
      $cmb_group->add_group_field($group_field_id, array(
        'name' => esc_html__('Title', 'fintech-profiler'),
        'id'   => 'title',
        'type' => 'text',
      ));

      $cmb_group->add_group_field($group_field_id, array(
        'name' => esc_html__('Link', 'fintech-profiler'),
        'id'   => 'link',
        'type' => 'text_url',
      ));
    }

    /**
     * Hook in and add a metabox to demonstrate repeatable grouped fields
     */
    public function fintech_register_more_info_metabox()
    {
      /**
       * Repeatable Field Groups
       */
      $cmb_group = new_cmb2_box(array(
        'id'           => 'fintech_more_info_metabox',
        'title'        => esc_html__('More Information', 'fintech-profiler'),
        'object_types' => array('fintech_profiles',),
      ));

      $cmb_group->add_field(
        array(
          'name'          => esc_html__('Slogan', 'fintech-profiler'),
          'id'            => 'fintech_slogan',
          'type'          => 'text',
        ),
      );


      $cmb_group->add_field(
        array(
          'name'          => esc_html__('Founded', 'fintech-profiler'),
          'id'            => 'fintech_founded',
          'type'          => 'text',
        ),
      );


      $cmb_group->add_field(
        array(
          'name'          => esc_html__('Company Size', 'fintech-profiler'),
          'id'            => 'fintech_company_size',
          'type'          => 'text',
        ),
      );

      $cmb_group->add_field(
        array(
          'name'          => esc_html__('Pricing Model', 'fintech-profiler'),
          'id'            => 'fintech_pricing_model',
          'type'          => 'text',
        ),
      );

      $cmb_group->add_field(
        array(
          'name'          => esc_html__('Minimum Pricing Range', 'fintech-profiler'),
          'description'   => esc_html__('These currency are in USD.', 'fintech-profiler'),
          'id'            => 'fintech_minimum_pricing',
          'type'           => 'text_money',
          // 'before_field' => '£', // Replaces default '$'
        ),
      );

      $cmb_group->add_field(
        array(
          'name'          => esc_html__('Maximum Pricing Range', 'fintech-profiler'),
          'description'   => esc_html__('These currency are in USD.', 'fintech-profiler'),
          'id'            => 'fintech_maximum_pricing',
          'type'           => 'text_money',

        ),
      );

      $cmb_group->add_field(
        array(
          'name'          => esc_html__('Website', 'fintech-profiler'),
          'id'            => 'fintech_website',
          'type'          => 'text_url',
        ),
      );

      $cmb_group->add_field(
        array(
          'name'          => esc_html__('Email', 'fintech-profiler'),
          'id'            => 'fintech_email',
          'type'          => 'text_email',
        ),
      );

      $cmb_group->add_field(
        array(
          'name'          => esc_html__('Phone', 'fintech-profiler'),
          'id'            => 'fintech_phone',
          'type'          => 'text_medium',
        ),
      );

      // Load countries.json
      $countries_file = FINTECH_PROFILER_BASE . '/public/img/countries.json'; // adjust path
      $countries = array();

      if (file_exists($countries_file)) {
        $json_data = file_get_contents($countries_file);
        $countries_array = json_decode($json_data, true);

        if (!empty($countries_array)) {
          foreach ($countries_array as $country) {
            if (isset($country['name'])) {
              $countries[$country['code']] = $country['name'];
            }
          }
        }
      }

      $cmb_group->add_field(array(
        'name'          => esc_html__('Country', 'fintech-profiler'),
        'id'            => 'fintech_country',
        'type'          => 'select',
        'options_cb' => 'fintech_get_countries_list',
      ));

      $cmb_group->add_field(array(
        'name'          => esc_html__('State', 'fintech-profiler'),
        'id'            => 'fintech_state',
        'type'          => 'text',
      ));

      $cmb_group->add_field(array(
        'name'          => esc_html__('City', 'fintech-profiler'),
        'id'            => 'fintech_city',
        'type'          => 'text',
      ));

      $cmb_group->add_field(array(
        'name'          => esc_html__('Linkedin Url', 'fintech-profiler'),
        'id'            => 'fintech_linkedin_url',
        'type'          => 'text_url',
      ));

      $cmb_group->add_field(array(
        'name'          => esc_html__('X Url', 'fintech-profiler'),
        'id'            => 'fintech_x_url',
        'type'          => 'text_url',
      ));

      $cmb_group->add_field(array(
        'name'          => esc_html__('Instagram Url', 'fintech-profiler'),
        'id'            => 'fintech_instagram_url',
        'type'          => 'text_url',
      ));

      $cmb_group->add_field(array(
        'name'          => esc_html__('Facebook Url', 'fintech-profiler'),
        'id'            => 'fintech_facebook_url',
        'type'          => 'text_url',
      ));

      $cmb_group->add_field(array(
        'name'          => esc_html__('Do you offer a demo?', 'fintech-profiler'),
        'id'            => 'fintech_demo',
        'type'          => 'checkbox',
      ));

      $cmb_group->add_field(array(
        'name'          => esc_html__('Demo Url', 'fintech-profiler'),
        'id'            => 'fintech_demo_url',
        'type'          => 'text_url',
      ));

      $cmb_group->add_field(array(
        'name'       => esc_html__('Financial Manager (Owner)', 'fintech-profiler'),
        'id'         => 'owner',
        'type'       => 'select',
        'options_cb' => 'fintech_profiler_get_users',
      ));
    }

    /**
     * Hook in and add a metabox to demonstrate repeatable grouped fields
     */
    public function fintech_register_slider_metabox()
    {

      /**
       * Repeatable Field Groups
       */
      $cmb_group = new_cmb2_box(array(
        'id'           => 'fintech_featured_slider',
        'title'        => esc_html__('Feature Slider', 'fintech-profiler'),
        'object_types' => array('fintech_profiles',),
      ));

      // $group_field_id is the field id string, so in this case: 'fintech_profiler_group_demo'
      $group_field_id = $cmb_group->add_field(array(
        'id'          => 'fintech_profiler_slides',
        'type'        => 'group',
        'options'     => array(
          'group_title'    => esc_html__('Slide {#}', 'fintech-profiler'), // {#} gets replaced by row number
          'add_button'     => esc_html__('Add Another Slide', 'fintech-profiler'),
          'remove_button'  => esc_html__('Remove Slide', 'fintech-profiler'),
          'sortable'       => true,
          'closed'      => true, // true to have the groups closed by default
          'remove_confirm' => esc_html__('Are you sure you want to remove?', 'fintech-profiler'), // Performs confirmation before removing group.
        ),
        'attributes' => [
          'data-conditional-id'    => 'slider_content_type',
          'data-conditional-value' => 'custom',
        ],
      ));

      // $cmb_group->add_group_field($group_field_id, array(
      //   'name' => esc_html__('Image', 'fintech-profiler'),
      //   'id'   => 'image',
      //   'type' => 'file',
      // ));

      $cmb_group->add_group_field($group_field_id, [
        'name' => 'Slide Image',
        'id'   => 'slide_image',
        'type' => 'text_url',
      ]);

      // $cmb_group->add_group_field($group_field_id, array(
      //   'name'       => esc_html__('URL', 'fintech-profiler'),
      //   'id'         => 'url',
      //   'description' => esc_html__('Enter the Link', 'fintech-profiler'),
      //   'type'       => 'text_url',
      //   // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
      // ));
    }

    function fintech_cap_controller($caps, $cap, $user_id, $args)
    {
      // Target relevant capabilities
      if (in_array($cap, ['edit_post', 'delete_post', 'read_post'])) {
        $post_id = isset($args[0]) ? $args[0] : 0;
        $post = get_post($post_id);

        if ($post && $post->post_type === 'fintech') {
          $post_author = (int) $post->post_author;
          $user_id = (int) $user_id;

          // Admins can do anything
          if (user_can($user_id, 'manage_options')) {
            return ['edit_others_posts'];
          }

          // Restrict fintech_manager to own posts
          if (in_array($cap, ['edit_post', 'delete_post'])) {
            if ($user_id === $post_author) {
              return ['edit_posts'];
            } else {
              return ['do_not_allow'];
            }
          }

          // Allow reading if public or owner
          if ($cap === 'read_post') {
            if ($post->post_status !== 'private' || $user_id === $post_author) {
              return ['read'];
            } else {
              return ['do_not_allow'];
            }
          }
        }
      }

      return $caps;
    }
  }

  new Fintech_Profiler_CPT_Fintech();
}
