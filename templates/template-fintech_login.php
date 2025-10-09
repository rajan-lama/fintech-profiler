<?php
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}

// Check if user can edit financial profiles
// if (!current_user_can('edit_financial_profiles')) {
//   wp_die(__('You do not have permission to access this page.', 'fintech-profiler'));
// }

get_header();
?>

<div class="container">
  <div class="row">
    <?php echo do_shortcode('[fintech_login]'); ?>
  </div>
</div>

<?php
get_footer();
