<?php
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}

// Check if user can edit financial profiles
// if (!current_user_can('edit_financial_profiles')) {
//   wp_die(__('You do not have permission to access this page.', 'fintech-profiler'));
// }

get_header();

include(FINTECH_PROFILER_BASE . 'public/partials/fintech-profiler-forgot-password.php');

get_footer();
