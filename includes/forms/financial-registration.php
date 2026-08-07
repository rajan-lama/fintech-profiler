<?php

/**
 * Frontend auth forms for Financial Profiles.
 *
 * Rendering only. Registration / password reset processing is shared with the
 * fintech forms and lives in fintech-registration.php (see fp_process_register,
 * fp_process_reset_request and fp_handle_frontend_actions). Both forms post to
 * the same handler; the target role and redirect differ per action.
 */

if (! defined('ABSPATH')) {
  exit;
}

/**
 * ------------------ SHORTCODES ------------------
 * [financial_register] - frontend registration form
 * [financial_reset] - request password reset form (sends email with reset link)
 */

add_shortcode('financial_register', 'financial_render_register_shortcode');
add_shortcode('financial_reset', 'financial_render_reset_request_shortcode');


/**
 * Render registration form
 */
function financial_render_register_shortcode($atts)
{
  if (is_user_logged_in()) return '<p>You are already logged in.</p>';

  $msg = isset($_GET['fp_reg_msg']) ? sanitize_text_field(wp_unslash($_GET['fp_reg_msg'])) : '';
  $redirect = isset($_REQUEST['redirect_to']) ? esc_url_raw(wp_unslash($_REQUEST['redirect_to'])) : home_url('/create-financial-profile');

  ob_start();

  include FINTECH_PROFILER_BASE . 'public/partials/fintech-profiler-financial-signup.php';
?>
<?php
  return ob_get_clean();
}

/**
 * Render password reset request form
 */
function financial_render_reset_request_shortcode($atts)
{
  if (is_user_logged_in()) return '<p>You are already logged in.</p>';

  $msg = isset($_GET['fp_reset_msg']) ? sanitize_text_field(wp_unslash($_GET['fp_reset_msg'])) : '';
  ob_start();
?>
  <form class="fp-form" method="post" action="">
    <?php if ($msg) : ?>
      <div class="fp-notice fp-info"><?php echo esc_html($msg); ?></div>
    <?php endif; ?>

    <p class="fp-field">
      <label for="fp_reset_email">Email or Username</label>
      <input type="text" name="fp_reset_email" id="fp_reset_email" required />
    </p>

    <?php if (fp_RECAPTCHA_ENABLED) : ?>
      <p class="fp-field">
        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-reset" />
      </p>
    <?php endif; ?>

    <input type="hidden" name="fp_action" value="reset_request" />
    <?php wp_nonce_field('fp_reset_nonce', 'fp_nonce'); ?>

    <p class="fp-actions"><button type="submit" class="button">Send reset email</button></p>
  </form>
<?php
  return ob_get_clean();
}
