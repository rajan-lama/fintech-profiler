<?php

/**
 * Template Name: Create Financial Profile
 * Description: A custom template to create financial profiles.
 */
if (!defined('ABSPATH')) exit;

class Fintech_Profiler_Template
{
  private $templates;

  public function __construct()
  {
    $this->templates = array();

    // Add filters
    add_filter('theme_page_templates', array($this, 'add_plugin_template_to_dropdown'));
    add_filter('template_include', array($this, 'load_plugin_template'));
  }

  // Add plugin template to page editor dropdown
  public function add_plugin_template_to_dropdown($templates)
  {
    $templates['template-create_fintech_profile.php'] = __('Create Fintech Profile', 'fintech-profiler');
    $templates['template-claim_fintech_profile.php'] = __('Claim Fintech Profile', 'fintech-profiler');
    $templates['template-edit_fintech_profile.php'] = __('Edit Fintech Profile', 'fintech-profiler');
    $templates['template-fintech_profile_dashboard.php'] = __('Fintech  Dashboard', 'fintech-profiler');
    $templates['template-forget_password.php'] = __('Forget Password', 'fintech-profiler');
    $templates['template-listing_fintech.php'] = __('Listing Fintech', 'fintech-profiler');

    $templates['template-create_financial_profile.php'] = __('Create Financial Profile', 'fintech-profiler');
    $templates['template-edit_financial_profile.php'] = __('Edit Financial Profile', 'fintech-profiler');
    $templates['template-financial_profile_dashboard.php'] = __('Financial Dashboard', 'fintech-profiler');

    return $templates;
  }

  // Load plugin template if assigned
  public function load_plugin_template($template)
  {

    if (is_page()) {
      $page_template = get_post_meta(get_the_ID(), '_wp_page_template', true);

      // List of plugin-supported templates
      $supported_templates = array(
        'template-create_fintech_profile.php',
        'template-edit_fintech_profile.php',
        'template-fintech_profile_dashboard.php',
        'template-listing_fintech.php',

        'template-forget_password.php',
        'template-claim_fintech_profile.php',

        'template-create_financial_profile.php',
        'template-edit_financial_profile.php',
        'template-financial_profile_dashboard.php',
      );

      // Check if theme has override
      foreach ($supported_templates as $tpl) {
        $theme_template = locate_template(array('fintech-profiler/' . $tpl));
        if ($page_template === $tpl && $theme_template) {
          return $theme_template; // Use theme override if exists
        }
      }

      // Fallback to plugin templates
      if (in_array($page_template, $supported_templates, true)) {
        $plugin_template = FINTECH_PROFILER_BASE . 'templates/' . $page_template;
        if (file_exists($plugin_template)) {
          return $plugin_template;
        }
      }
    }

    return $template;
  }
}

new Fintech_Profiler_Template();
