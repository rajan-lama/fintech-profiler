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
    $templates['template-create_financial_profile.php'] = __('Create Financial Profile', 'fintech-profiler');
    return $templates;
  }

  // Load plugin template if assigned
  public function load_plugin_template($template)
  {

    if (is_page()) {
      $page_template = get_post_meta(get_the_ID(), '_wp_page_template', true);
      $theme_template = locate_template(array('fintech-profiler/template-create_financial_profile.php'));
      if ($theme_template) {
        return $theme_template; // Use theme override
      }

      if ($page_template === 'template-create_financial_profile.php') {
        $plugin_template = FINTECH_PROFILER_BASE . 'templates/template-create_financial_profile.php';

        if (file_exists($plugin_template)) {
          return $plugin_template;
        }
      }
    }

    return $template;
  }
}

new Fintech_Profiler_Template();
