<?php

/**
 * Fintech Profiler Login Form
 */

if (!defined('WPINC')) {
  die;
}

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://rajanlama.com.np
 * @since      1.0.0
 *
 * @package    Fintech_Profiler
 */

class Fintech_Profiler_Login
{

  /**
   * Render the login form
   *
   * @return string The HTML content of the login form.
   */
  public static function render_login_form()
  {
    // Check for login errors or messages
    $login_error  = isset($_GET['fp_login']) && $_GET['fp_login'] === 'failed';
    $login_msg    = isset($_GET['fp_msg']) ? sanitize_text_field(wp_unslash($_GET['fp_msg'])) : '';
    $redirect_to  = isset($_REQUEST['redirect_to']) ? esc_url_raw(wp_unslash($_REQUEST['redirect_to'])) : (is_ssl() ? home_url(CFL_DEFAULT_REDIRECT) : home_url(CFL_DEFAULT_REDIRECT)); // Default redirect URL 
    ob_start();
    include FINTECH_PROFILER_BASE . 'public/partials/fintech-profiler-login.php';
    return ob_get_clean();
  }
}

/**
 * Shortcode to display the login form
 */
add_shortcode('fintech_profiler_login', function () {
  if (is_user_logged_in()) {
    // User is already logged in, no need to show the login form.
    ob_start();
    echo '<p>You are already logged in.</p>';
?>
    <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>">Log out</a>
<?php
    return ob_get_clean();
  }
  return Fintech_Profiler_Login::render_login_form();
});

/**
 * Handle login POST on template_redirect (runs on frontend before rendering template).
 */
add_action('template_redirect', function () {
  if (is_user_logged_in()) {
    return;
  }

  if (!isset($_POST['fp_action']) || 'login' !== $_POST['fp_action']) {
    return;
  }

  // Basic nonce & field checks
  if (!isset($_POST['fp_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['fp_nonce'])), 'fp_login_nonce')) {
    fintech_profiler_redirect_with_args(array('fp_login' => 'failed', 'fp_msg' => 'Invalid request.'));
  }

  $user_login = isset($_POST['fp_user_login']) ? sanitize_text_field(wp_unslash($_POST['fp_user_login'])) : '';
  $user_pass  = isset($_POST['fp_user_pass']) ? (string) wp_unslash($_POST['fp_user_pass']) : '';
  $remember   = !empty($_POST['fp_user_remember']);
  $redirect   = isset($_POST['redirect_to']) ? esc_url_raw(wp_unslash($_POST['redirect_to'])) : home_url(CFL_DEFAULT_REDIRECT);

  if ('' === $user_login || '' === $user_pass) {
    fintech_profiler_redirect_with_args(array('fp_login' => 'failed', 'fp_msg' => 'Missing username or password.'), $redirect);
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

  $user = wp_signon($creds, is_ssl());

  if (is_wp_error($user)) {
    fintech_profiler_redirect_with_args(array('fp_login' => 'failed', 'fp_msg' => 'Login failed. Please check your credentials and try again.'), $redirect);
  }

  // Successful login
  wp_set_current_user($user->ID);
  do_action('wp_login', $user->user_login, $user);
  wp_safe_redirect($redirect);
  exit;
});

/**
 * Redirect helper with query args
 *
 * @param array  $args     Query args to add.
 * @param string $redirect Optional. URL to redirect to. Defaults to home_url().
 */
function fintech_profiler_redirect_with_args($args = array(), $redirect = '')
{
  $redirect = $redirect ? $redirect : home_url();
  $redirect = add_query_arg($args, $redirect);
  wp_safe_redirect($redirect);
  exit;
}
