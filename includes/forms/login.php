<?php

if (! defined('ABSPATH')) {
  exit;
}

/**
 * Render login form via shortcode.
 */
add_shortcode('fintech_login', function ($atts, $content = '') {
  if (is_user_logged_in()) {
    $current = wp_get_current_user();
    $logout_url = wp_logout_url(home_url(add_query_arg(null, null)));
    ob_start();
?>
    <div class="fp-wrapper fp-logged-in">
      <p>You are logged in as <strong><?php echo esc_html($current->display_name ?: $current->user_login); ?></strong>.</p>
      <p><a class="button fp-logout" href="<?php echo esc_url($logout_url); ?>">Log out</a></p>
    </div>
<?php
    return ob_get_clean();
  }

  $login_error  = isset($_GET['fp_login']) && $_GET['fp_login'] === 'failed';
  $login_msg    = isset($_GET['fp_msg']) ? sanitize_text_field(wp_unslash($_GET['fp_msg'])) : '';
  $redirect_to  = isset($_REQUEST['redirect_to']) ? esc_url_raw(wp_unslash($_REQUEST['redirect_to'])) : (is_ssl() ? home_url('/') : home_url('/'));

  ob_start();

  include FINTECH_PROFILER_BASE . 'public/partials/fintech-profiler-login.php';

  return ob_get_clean();
});

/**
 * Handle login POST on template_redirect (runs on frontend before rendering template).
 */
add_action('template_redirect', function () {
  if (is_user_logged_in()) {
    return;
  }

  if (! isset($_POST['fp_action']) || 'login' !== $_POST['fp_action']) {
    return;
  }

  // Basic nonce & field checks
  if (! isset($_POST['fp_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['fp_nonce'])), 'fp_login_nonce')) {
    fp_redirect_with_args(array('fp_login' => 'failed', 'fp_msg' => 'Invalid request.'));
  }

  $user_login = isset($_POST['fp_login']) ? sanitize_text_field(wp_unslash($_POST['fp_login'])) : '';
  $user_pass  = isset($_POST['fp_password']) ? (string) wp_unslash($_POST['fp_password']) : '';
  $remember   = ! empty($_POST['fp_remember']);
  $redirect   = isset($_POST['redirect_to']) ? esc_url_raw(wp_unslash($_POST['redirect_to'])) : home_url('/');

  if ('' === $user_login || '' === $user_pass) {
    fp_redirect_with_args(array('fp_login' => 'failed', 'fp_msg' => 'Missing username or password.'), $redirect);
  }

  // Allow email or username.
  if (is_email($user_login)) {
    $user_obj = get_user_by('email', $user_login);
    if ($user_obj) {
      $user_login = $user_obj->user_login; // wp_signon requires username
    }
  }

  $creds = array(
    'user_login'    => $user_login,
    'user_password' => $user_pass,
    'remember'      => $remember,
  );

  // Authenticate and set cookies like wp-login.php.
  $user = wp_signon($creds, is_ssl());

  if (is_wp_error($user)) {
    fp_redirect_with_args(array('fp_login' => 'failed', 'fp_msg' => fp_first_error_message($user)), $redirect);
  }

  // Ensure current user is set for this request.
  wp_set_current_user($user->ID);

  // Final redirect after successful login.
  wp_safe_redirect($redirect ? $redirect : home_url('/'));
  exit;
});

/**
 * Utility: redirect back with query args.
 */
function fp_redirect_with_args(array $args, $fallback = '')
{
  $referer = wp_get_referer();
  $target  = $referer ? $referer : ($fallback ? $fallback : home_url('/'));
  $target  = add_query_arg(array_map('rawurlencode', $args), $target);
  wp_safe_redirect($target);
  exit;
}

/**
 * Utility: Extract the first meaningful error message from WP_Error.
 */
function fp_first_error_message($maybe_error)
{
  if (is_wp_error($maybe_error)) {
    $all = $maybe_error->get_error_messages();
    if (! empty($all)) {
      return $all[0];
    }
  }
  return 'Login failed.';
}

/**
 * Optional: Provide a logout shortcode for convenience. Usage: [fp_logout]
 */
add_shortcode('fintech_logout', function () {
  if (! is_user_logged_in()) {
    return '';
  }
  $logout_url = wp_logout_url(home_url(add_query_arg(null, null)));
  return '<a class="button" href="' . esc_url($logout_url) . '">Log out</a>';
});

/**
 * SECURITY HARDENING NOTES
 * --------------------------------------------------
 * - Consider enabling reCAPTCHA or a challenge on this form to reduce brute force.
 * - Rate-limit login attempts (via a security plugin or custom code).
 * - Enforce strong passwords and two-factor auth where possible.
 * - Because wp_signon() sets the auth cookies, users will be logged in exactly like wp-login.php.
 */
