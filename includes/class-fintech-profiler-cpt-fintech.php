<?php
/* 
  * @package My_Custom_CPT
  * @version 1.0.0 
*/

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

      add_action('init', array($this, 'fp_handle_fintech_profile_submission'));
      add_action('init', array($this, 'fp_handle_claim_fintech_profile'));

      // add_action('init', array($this, 'register_cpt'));
      // register_activation_hook(__FILE__, array($this, 'add_custom_roles_caps'));
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
        'edit_others_posts' => 'edit_others_fintech_profiles',
        'publish_posts' => 'publish_fintech_profiles',
        'read_private_posts' => 'read_private_fintech_profiles',
        'delete_posts' => 'delete_fintech_profiles',
        'delete_private_posts' => 'delete_private_fintech_profiles',
        'delete_published_posts' => 'delete_published_fintech_profiles',
        'delete_others_posts' => 'delete_others_fintech_profiles',
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

      // Add caps to fintech_manager
      $fintech_role = get_role('fintech_manager');
      if ($fintech_role) {
        foreach ($caps as $cap) {
          $fintech_role->add_cap($cap, true);
        }
        $fintech_role->add_cap('upload_files', true);
      }

      // 🔑 Add caps to administrator
      $admin_role = get_role('administrator');
      if ($admin_role) {
        foreach ($caps as $cap) {
          $admin_role->add_cap($cap, true);
        }
      }
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
        'type'       => 'text_money',
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
          // 'description'   => esc_html__( 'Select the type of content to display in the slider', 'fintech-profiler' ),
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
        'type'          => 'select',
        'options' => [],
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

      /**
       * Group fields works the same, except ids only need
       * to be unique to the group. Prefix is not needed.
       *
       * The parent field's id needs to be passed as the first argument.
       */

      $cmb_group->add_group_field($group_field_id, array(
        'name' => esc_html__('Image', 'fintech-profiler'),
        'id'   => 'image',
        'type' => 'file',
      ));

      $cmb_group->add_group_field($group_field_id, array(
        'name'       => esc_html__('URL', 'fintech-profiler'),
        'id'         => 'url',
        'description' => esc_html__('Enter the Link', 'fintech-profiler'),
        'type'       => 'text_url',
        // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
      ));
    }

    public function fp_handle_fintech_profile_submission()
    {
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

      if (
        isset($_POST['create_fintech_profile'])
        && isset($_POST['create_fintech_profile_nonce'])
        && wp_verify_nonce($_POST['create_fintech_profile_nonce'], 'create_fintech_profile')
      ) {

        // Sanitize inputs
        $company_name   = sanitize_text_field($_POST['company_name']);
        $website_link   = esc_url_raw($_POST['website_link']);
        $founded_in     = intval($_POST['founded_in']);
        $company_size   = sanitize_text_field($_POST['company_size']);
        $slogan         = sanitize_text_field($_POST['slogan']);
        $services       = sanitize_text_field($_POST['services']);
        $description    = sanitize_textarea_field($_POST['objective_and_description']);
        // $plan_type      = sanitize_text_field($_POST['plan_type']);
        // $plan_desc      = sanitize_text_field($_POST['description']);
        // $plan_cost      = sanitize_text_field($_POST['cost']);
        $country        = sanitize_text_field($_POST['country']);
        $state          = sanitize_text_field($_POST['state']);
        $city           = sanitize_text_field($_POST['city']);
        $business_email = sanitize_email($_POST['business_email']);
        $business_phone    = sanitize_text_field($_POST['business_phone']);
        $business_phone_code    = sanitize_text_field($_POST['business_phone_code']);

        $linkedin_url   = esc_url_raw($_POST['linkedin_url']);
        $x_url          = esc_url_raw($_POST['x_url']);
        $instagram_url  = esc_url_raw($_POST['instagram_url']);
        $facebook_url   = esc_url_raw($_POST['facebook_url']);
        $demo           = sanitize_text_field($_POST['demo']);
        $demo_link      = esc_url_raw($_POST['demo_link']);
        // $case_title     = sanitize_text_field($_POST['case_title']);
        // $case_link      = esc_url_raw($_POST['case_link']);

        // $plan_type      = sanitize_text_field($_POST['pricing_plans']);


        // Prepare array for CMB2 group field
        $pricing_plans = [];
        $plan_types = $_POST['plan_type'];
        $plan_descriptions = $_POST['plan_description'];
        $plan_costs = $_POST['plan_cost'];

        foreach ($plan_types as $index => $type) {
          // if (empty($type) && empty($plan_descriptions[$index]) && empty($plan_costs[$index])) {
          //   continue; // Skip empty rows
          // }

          $pricing_plans[] = [
            'name'        => sanitize_text_field($plan_types[$index]),
            'description' => sanitize_text_field($plan_descriptions[$index]),
            'cost'        => sanitize_text_field($plan_costs[$index]),
          ];
        }

        // Prepare array for CMB2 group field
        $cases = [];
        $case_title = $_POST['case_title'];
        $case_link = $_POST['case_link'];

        foreach ($case_title as $index => $case) {
          $cases[] = [
            'title'        => sanitize_text_field($case_title[$index]),
            'link' => sanitize_text_field($case_link[$index]),
          ];
        }

        // Create CPT post
        $post_id = wp_insert_post([
          'post_type'   => 'fintech_profiles',
          'post_status' => 'publish',
          'post_title'  => $company_name,
          'post_content' => $description,
        ]);

        if ($post_id) {
          // Save extra fields as post meta
          if ($demo === 'yes') {
            $demo = 1;
          } else {
            $demo = 0;
          }

          update_post_meta($post_id, 'fintech_website', $website_link);
          update_post_meta($post_id, 'fintech_founded', $founded_in);
          update_post_meta($post_id, 'fintech_company_size', $company_size);
          update_post_meta($post_id, 'fintech_country', $country);
          update_post_meta($post_id, 'fintech_state', $state);
          update_post_meta($post_id, 'fintech_city', $city);
          update_post_meta($post_id, 'fintech_email', $business_email);
          update_post_meta($post_id, 'fintech_phone', $business_phone_code . ' ' . $business_phone);
          update_post_meta($post_id, 'fintech_linkedin_url', $linkedin_url);
          update_post_meta($post_id, 'fintech_x_url', $x_url);
          update_post_meta($post_id, 'fintech_instagram_url', $instagram_url);
          update_post_meta($post_id, 'fintech_facebook_url', $facebook_url);
          update_post_meta($post_id, 'fintech_slogan', $slogan);
          update_post_meta($post_id, 'fintech_demo', $demo);
          update_post_meta($post_id, 'fintech_demo_url', $demo_link);

          // update_post_meta($post_id, 'case_title', $case_title);
          // update_post_meta($post_id, 'case_link', $case_link);
          //update_post_meta($post_id, 'services', $services);
          // update_post_meta($post_id, 'plan_type', $plan_type);
          // update_post_meta($post_id, 'plan_description', $plan_desc);
          // update_post_meta($post_id, 'plan_cost', $plan_cost);


          // Save to CMB2 meta (group field)
          update_post_meta($post_id, 'fintech_pricing_plans', $pricing_plans);
          update_post_meta($post_id, 'fintech_case_studies', $cases);


          if (!empty($_POST['plan_type'])) {
            $plans = [];
            foreach ($_POST['plan_type'] as $i => $type) {
              $plans[] = [
                'type'        => sanitize_text_field($type),
                'description' => sanitize_text_field($_POST['plan_description'][$i] ?? ''),
                'cost'        => sanitize_text_field($_POST['plan_cost'][$i] ?? ''),
              ];
            }
            update_post_meta($post_id, 'pricing_plans', $plans);
          }

          // Save Case Studies
          if (!empty($_POST['case_title'])) {
            $cases = [];
            foreach ($_POST['case_title'] as $i => $title) {
              $cases[] = [
                'title' => sanitize_text_field($title),
                'link'  => esc_url_raw($_POST['case_link'][$i] ?? ''),
              ];
            }
            update_post_meta($post_id, 'case_studies', $cases);
          }


          // Handle file upload (company logo)
          if (!empty($_FILES['company_logo']['name'])) {

            if (!function_exists('media_handle_upload')) {
              require_once(ABSPATH . 'wp-admin/includes/image.php');
              require_once(ABSPATH . 'wp-admin/includes/file.php');
              require_once(ABSPATH . 'wp-admin/includes/media.php');
            }

            $uploaded = media_handle_upload('company_logo', $post_id);
            if (!is_wp_error($uploaded)) {
              set_post_thumbnail($post_id, $uploaded);
            }
          }

          // Redirect after submission
          wp_redirect(get_permalink($post_id));
          exit;
        }
      }
    }

    public function fp_handle_claim_fintech_profile()
    {
      if (isset($_POST['submit_claim'])) {

        if (!empty($_FILES['attach_media']['name'])) {
          require_once(ABSPATH . 'wp-admin/includes/file.php');
          $uploaded = media_handle_upload('attach_media', 0);

          if (!is_wp_error($uploaded)) {
            $file_url = wp_get_attachment_url($uploaded);
            $message .= "\nUploaded File: $file_url";
          }
        }

        // Verify nonce
        if (
          !isset($_POST['claim_fintech_profile_nonce']) ||
          !wp_verify_nonce($_POST['claim_fintech_profile_nonce'], 'claim_fintech_profile')
        ) {
          wp_die('Security check failed.');
        }

        // Sanitize inputs
        $existing_profile = sanitize_text_field($_POST['existing_profile'] ?? '');
        $website_link     = sanitize_text_field($_POST['website_link'] ?? '');
        $email            = sanitize_email($_POST['email'] ?? '');
        $contact_number   = sanitize_text_field($_POST['contact_number'] ?? '');

        // Prepare email
        $to = get_option('admin_email'); // send to admin email
        $subject = "New Claim Request from $email";
        $message  = "A new claim form was submitted:\n\n";
        $message .= "Existing Profile: " . $existing_profile . "\n";
        $message .= "Website Link: " . $website_link . "\n";
        $message .= "Email: " . $email . "\n";
        $message .= "Contact Number: " . $contact_number . "\n";

        // Send email
        wp_mail($to, $subject, $message);

        // Redirect or show success
        wp_redirect(add_query_arg('claim_submitted', '1', wp_get_referer()));
        exit;
      }
    }
  }

  new Fintech_Profiler_CPT_Fintech();
}
