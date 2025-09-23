<?php

/**
 * Plugin Name: Custom Frontend WordPress-Like Auth
 * Description: Frontend login, registration, password reset, reCAPTCHA verification and simple rate-limiting. Auth uses wp_signon so WP auth cookies/sessions behave exactly like wp-login.php. Supports mapping a usermeta role (default: `custom_role`).
 * Version: 1.1.0
 * Author: Your Name
 */

if (! defined('ABSPATH')) {
  exit;
}

/**
 * ------------------ SETTINGS ------------------
 * Edit these constants to fit your site.
 */
// Usermeta key that contains the desired role slug for that user.
const fp_CUSTOM_ROLE_META_KEY = 'custom_role';
// Default redirect after login/registration
const fp_DEFAULT_REDIRECT = '/create-fintech-profile';
// Whether to validate role slug against WP roles before applying
const fp_VALIDATE_ROLE = true;
// Enable reCAPTCHA verification (set to true to validate server-side)
const fp_RECAPTCHA_ENABLED = false;
// reCAPTCHA secret key (server-side). Obtain from Google reCAPTCHA admin.
const fp_RECAPTCHA_SECRET = 'YOUR_RECAPTCHA_SECRET_HERE';
// Rate limiting options
const fp_RATE_LIMIT_WINDOW = 300; // seconds (e.g. 5 minutes)
const fp_RATE_LIMIT_MAX_ATTEMPTS = 5; // allowed failed attempts within window
const fp_LOCKOUT_DURATION = 900; // seconds (e.g. 15 minutes) lockout after exceeding attempts

/**
 * ------------------ SHORTCODES ------------------
 * [financial_login] - frontend login form
 * [fintech_register] - frontend registration form
 * [fintech_reset] - request password reset form (sends email with reset link)
 * [fp_logout] - logout link
 */

require_once ABSPATH . 'wp-includes/pluggable.php';

add_shortcode('fintech_register', 'fp_render_register_shortcode');
add_shortcode('fintech_reset', 'fp_render_reset_request_shortcode');


/**
 * Render registration form
 */
function fp_render_register_shortcode($atts)
{
  if (is_user_logged_in()) return '<p>You are already logged in.</p>';

  $msg = isset($_GET['fp_reg_msg']) ? sanitize_text_field(wp_unslash($_GET['fp_reg_msg'])) : '';
  $redirect = isset($_REQUEST['redirect_to']) ? esc_url_raw(wp_unslash($_REQUEST['redirect_to'])) : home_url(fp_DEFAULT_REDIRECT);

  ob_start();

  include FINTECH_PROFILER_BASE . 'public/partials/fintech-profiler-fintech-signup.php';
?>
  <!-- <form class="fp-form" method="post" action="">
    <?php if ($msg) : ?>
      <div class="fp-notice fp-info"><?php echo esc_html($msg); ?></div>
    <?php endif; ?>

    <p class="fp-field">
      <label for="fp_reg_user">Username</label>
      <input type="text" name="fp_reg_user" id="fp_reg_user" required />
    </p>
    <p class="fp-field">
      <label for="fp_reg_email">Email</label>
      <input type="email" name="fp_reg_email" id="fp_reg_email" required />
    </p>
    <p class="fp-field">
      <label for="fp_reg_pass">Password</label>
      <input type="password" name="fp_reg_pass" id="fp_reg_pass" required />
    </p>

    <?php if (fp_RECAPTCHA_ENABLED) : ?>
      <p class="fp-field">
        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-reg" />
      </p>
    <?php endif; ?>

    <input type="hidden" name="fp_action" value="register" />
    <input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect); ?>" />
    <?php wp_nonce_field('fp_register_nonce', 'fp_nonce'); ?>

    <p class="fp-actions"><button type="submit" class="button">Register</button></p>
  </form> -->
<?php
  return ob_get_clean();
}

/**
 * Render password reset request form
 */
function fp_render_reset_request_shortcode($atts)
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

/**
 * Handle all frontend actions on template_redirect
 */
add_action('template_redirect', 'fp_handle_frontend_actions');
function fp_handle_frontend_actions()
{
  if (! isset($_POST['fp_action'])) return;

  $action = sanitize_text_field(wp_unslash($_POST['fp_action']));

  // if ($action === 'login') {
  //   fp_process_login();
  // }

  if ($action === 'fintech_register') {
    fp_process_register();
  }

  if ($action === 'financial_register') {
    financial_process_register();
  }

  if ($action === 'reset_request') {
    fp_process_reset_request();
  }
}

/**
 * Rate limiting helpers (simple IP-based with transients)
 */
function fp_get_client_ip()
{
  if (! empty($_SERVER['HTTP_CLIENT_IP'])) return sanitize_text_field(wp_unslash($_SERVER['HTTP_CLIENT_IP']));
  if (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return sanitize_text_field(wp_unslash(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]));
  return isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : '0.0.0.0';
}

function fp_rate_limit_exceeded()
{
  $ip = fp_get_client_ip();
  $lock_key = 'fp_lockout_' . md5($ip);
  $attempts_key = 'fp_attempts_' . md5($ip);

  $lock = get_transient($lock_key);
  if ($lock) return true;

  $attempts = (int) get_transient($attempts_key);
  if ($attempts >= fp_RATE_LIMIT_MAX_ATTEMPTS) {
    // set lockout
    set_transient($lock_key, true, fp_LOCKOUT_DURATION);
    delete_transient($attempts_key);
    return true;
  }
  return false;
}

function fp_increment_failed_attempts()
{
  $ip = fp_get_client_ip();
  $attempts_key = 'fp_attempts_' . md5($ip);
  $attempts = (int) get_transient($attempts_key);
  $attempts++;
  set_transient($attempts_key, $attempts, fp_RATE_LIMIT_WINDOW);
}

function fp_clear_failed_attempts()
{
  $ip = fp_get_client_ip();
  $attempts_key = 'fp_attempts_' . md5($ip);
  delete_transient($attempts_key);
}

/**
 * Verify reCAPTCHA server-side
 */
function fp_verify_recaptcha($token)
{
  if (! fp_RECAPTCHA_ENABLED) return true;
  if (empty(fp_RECAPTCHA_SECRET) || fp_RECAPTCHA_SECRET === 'YOUR_RECAPTCHA_SECRET_HERE') {
    // If misconfigured, fail safe to false to avoid bypass. You can change to true for testing.
    return false;
  }
  $resp = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', array(
    'body' => array(
      'secret' => fp_RECAPTCHA_SECRET,
      'response' => $token,
      'remoteip' => fp_get_client_ip(),
    ),
    'timeout' => 10,
  ));

  if (is_wp_error($resp)) return false;
  $body = wp_remote_retrieve_body($resp);
  $data = json_decode($body, true);
  return ! empty($data['success']);
}

/**
 * Process login attempt
 */
// function fp_process_login()
// {
//   if (! isset($_POST['fp_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['fp_nonce'])), 'fp_login_nonce')) {
//     fp_redirect_with_args(array('fp_login' => 'failed', 'fp_msg' => 'Invalid request.'));
//   }

//   if (fp_rate_limit_exceeded()) {
//     fp_redirect_with_args(array('fp_login' => 'failed', 'fp_msg' => 'Too many attempts. Try again later.'));
//   }

//   $user_login = isset($_POST['fp_user_login']) ? sanitize_text_field(wp_unslash($_POST['fp_user_login'])) : '';
//   $user_pass  = isset($_POST['fp_user_pass']) ? (string) wp_unslash($_POST['fp_user_pass']) : '';
//   $remember   = ! empty($_POST['fp_remember']);
//   $redirect   = isset($_POST['redirect_to']) ? esc_url_raw(wp_unslash($_POST['redirect_to'])) : home_url(fp_DEFAULT_REDIRECT);

//   if (fp_RECAPTCHA_ENABLED) {
//     $token = isset($_POST['g-recaptcha-response']) ? sanitize_text_field(wp_unslash($_POST['g-recaptcha-response'])) : '';
//     if (! fp_verify_recaptcha($token)) {
//       fp_increment_failed_attempts();
//       fp_redirect_with_args(array('fp_login' => 'failed', 'fp_msg' => 'reCAPTCHA verification failed.'), $redirect);
//     }
//   }

//   if ('' === $user_login || '' === $user_pass) {
//     fp_increment_failed_attempts();
//     fp_redirect_with_args(array('fp_login' => 'failed', 'fp_msg' => 'Missing username or password.'), $redirect);
//   }

//   if (is_email($user_login)) {
//     $user_obj = get_user_by('email', $user_login);
//     if ($user_obj) {
//       $user_login = $user_obj->user_login;
//     }
//   }

//   $creds = array(
//     'user_login'    => $user_login,
//     'user_password' => $user_pass,
//     'remember'      => $remember,
//   );

//   $user = wp_signon($creds, is_ssl());

//   if (is_wp_error($user)) {
//     fp_increment_failed_attempts();
//     fp_redirect_with_args(array('fp_login' => 'failed', 'fp_msg' => fp_first_error_message($user)), $redirect);
//   }

//   // successful
//   fp_clear_failed_attempts();
//   fp_apply_custom_role_if_present($user);
//   wp_set_current_user($user->ID);
//   wp_safe_redirect($redirect ? $redirect : home_url(fp_DEFAULT_REDIRECT));
//   exit;
// }

function fp_generate_unique_username_from_email($email)
{
  $parts = explode('@', $email);
  $base_username = sanitize_user($parts[0], true); // Sanitize the email handle

  $username = $base_username;
  $counter = 1;

  // Check if the username already exists and add a number if it does
  while (username_exists($username)) {
    $username = $base_username . '_' . $counter;
    $counter++;
  }

  return $username;
}

/**
 * Process registration
 */
function fp_process_register()
{
  if (! isset($_POST['fp_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['fp_nonce'])), 'fp_register_nonce')) {
    fp_redirect_with_args(array('fp_reg_msg' => 'Invalid request.'));
  }

  if (fp_rate_limit_exceeded()) {
    fp_redirect_with_args(array('fp_reg_msg' => 'Too many attempts. Try again later.'));
  }

  if (fp_RECAPTCHA_ENABLED) {
    $token = isset($_POST['g-recaptcha-response']) ? sanitize_text_field(wp_unslash($_POST['g-recaptcha-response'])) : '';
    if (! fp_verify_recaptcha($token)) {
      fp_increment_failed_attempts();
      fp_redirect_with_args(array('fp_reg_msg' => 'reCAPTCHA verification failed.'));
    }
  }

  $username = isset($_POST['fp_reg_user']) ? sanitize_user(wp_unslash($_POST['fp_reg_user']), true) : fp_generate_unique_username_from_email(isset($_POST['fp_reg_email']) ? sanitize_email(wp_unslash($_POST['fp_reg_email'])) : '');
  $email    = isset($_POST['fp_reg_email']) ? sanitize_email(wp_unslash($_POST['fp_reg_email'])) : '';
  $pass     = isset($_POST['fp_reg_pass']) ? $_POST['fp_reg_pass'] : '';
  $role     = isset($_POST['fp_reg_role']) ? sanitize_key(wp_unslash($_POST['fp_reg_role'])) : 'fintech_manager';
  $redirect = isset($_POST['redirect_to']) ? esc_url_raw(wp_unslash($_POST['redirect_to'])) : home_url(fp_DEFAULT_REDIRECT);

  $errors = new WP_Error();

  if (empty($username) || empty($email) || empty($pass)) {
    $errors->add('missing', 'Please fill all required fields.');
  }

  if (! is_email($email)) {
    $errors->add('email', 'Invalid email address.');
  }

  if (username_exists($username)) {
    $errors->add('username_exists', 'Username already exists.');
  }

  if (email_exists($email)) {
    $errors->add('email_exists', 'Email already registered.');
  }

  if (! empty($role) && fp_VALIDATE_ROLE && ! get_role($role)) {
    // ignore invalid role but do not fail the registration - store nothing
    $role = '';
  }

  if ($errors->has_errors()) {
    fp_increment_failed_attempts();
    fp_redirect_with_args(array('fp_reg_msg' => fp_first_error_message($errors)));
  }

  // Create the user
  $user_id = wp_create_user($username, $pass, $email);
  if (is_wp_error($user_id)) {
    fp_increment_failed_attempts();
    fp_redirect_with_args(array('fp_reg_msg' => fp_first_error_message($user_id)));
  }

  // Optionally set user role meta — and optionally set role on WP user record
  if (! empty($role)) {
    update_user_meta($user_id, fp_CUSTOM_ROLE_META_KEY, $role);
    if (fp_VALIDATE_ROLE && get_role($role)) {
      $u = new WP_User($user_id);
      $u->set_role($role);
    }
  }

  // Notify admin and user (WP default emails) — use wp_new_user_notification if desired
  if (function_exists('wp_new_user_notification')) {
    // WP 4.9+ function. For modern WP use wp_new_user_notification( $user_id, null, 'both' );
    try {
      wp_new_user_notification($user_id, null, 'user');
    } catch (Exception $e) {
      // ignore
    }
  }

  // Auto-login newly registered user
  wp_set_current_user($user_id);
  wp_set_auth_cookie($user_id);
  fp_clear_failed_attempts();
  wp_safe_redirect($redirect);
  exit;
}

/**
 * Process password reset request
 */
function fp_process_reset_request()
{
  if (! isset($_POST['fp_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['fp_nonce'])), 'fp_reset_nonce')) {
    fp_redirect_with_args(array('fp_reset_msg' => 'Invalid request.'));
  }

  if (fp_rate_limit_exceeded()) {
    fp_redirect_with_args(array('fp_reset_msg' => 'Too many attempts. Try again later.'));
  }

  if (fp_RECAPTCHA_ENABLED) {
    $token = isset($_POST['g-recaptcha-response']) ? sanitize_text_field(wp_unslash($_POST['g-recaptcha-response'])) : '';
    if (! fp_verify_recaptcha($token)) {
      fp_increment_failed_attempts();
      fp_redirect_with_args(array('fp_reset_msg' => 'reCAPTCHA verification failed.'));
    }
  }

  $user_input = isset($_POST['fp_reset_email']) ? sanitize_text_field(wp_unslash($_POST['fp_reset_email'])) : '';
  if (empty($user_input)) {
    fp_increment_failed_attempts();
    fp_redirect_with_args(array('fp_reset_msg' => 'Please provide username or email.'));
  }

  $user = null;
  if (is_email($user_input)) {
    $user = get_user_by('email', $user_input);
  } else {
    $user = get_user_by('login', $user_input);
  }

  if (! $user) {
    // Do not reveal whether user exists; still say success for security
    fp_redirect_with_args(array('fp_reset_msg' => 'If the account exists, you will receive an email with reset instructions.'));
  }

  // Use WP core functions to generate reset key and send email
  $allow = apply_filters('allow_password_reset', true, $user->user_login);
  if (! $allow) {
    fp_redirect_with_args(array('fp_reset_msg' => 'Password reset is not allowed for this account.'));
  }

  $key = get_password_reset_key($user);
  if (is_wp_error($key)) {
    fp_redirect_with_args(array('fp_reset_msg' => 'Could not generate reset key.'));
  }

  $reset_link = network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user->user_login), 'login');

  $message = "Someone requested a password reset for the following account:

";
  $message .= network_home_url('/') . "

";
  $message .= 'Username: ' . $user->user_login . "

";
  $message .= 'To reset your password visit the following address:

';
  $message .= $reset_link . "

";
  $message .= "If you did not request this, please ignore this email.
";

  wp_mail($user->user_email, 'Password Reset', $message);

  fp_clear_failed_attempts();
  fp_redirect_with_args(array('fp_reset_msg' => 'If the account exists, you will receive an email with reset instructions.'));
}

/**
 * Apply a role from custom user meta to the user, if present and valid.
 */
function fp_apply_custom_role_if_present($user)
{
  if (is_numeric($user)) $user = get_userdata($user);
  if (! $user || ! $user->ID) return;

  $meta_key = fp_CUSTOM_ROLE_META_KEY;
  if (empty($meta_key)) return;
  $desired_role = get_user_meta($user->ID, $meta_key, true);
  if (empty($desired_role)) return;
  $desired_role = sanitize_key($desired_role);

  if (fp_VALIDATE_ROLE && ! get_role($desired_role)) return;

  $wp_user = new WP_User($user->ID);
  $wp_user->set_role($desired_role);
}

/**
 * Utility: redirect back with query args.
 */
// function fp_redirect_with_args(array $args, $fallback = '')
// {
//   $referer = wp_get_referer();
//   $target  = $referer ? $referer : ($fallback ? $fallback : home_url(fp_DEFAULT_REDIRECT));
//   $target  = add_query_arg(array_map('rawurlencode', $args), $target);
//   wp_safe_redirect($target);
//   exit;
// }

/**
 * Utility: Extract the first meaningful error message from WP_Error.
 */
// function fp_first_error_message($maybe_error)
// {
//   if (is_wp_error($maybe_error)) {
//     $all = $maybe_error->get_error_messages();
//     if (! empty($all)) {
//       return $all[0];
//     }
//   }
//   if ($maybe_error instanceof WP_Error) {
//     $msgs = $maybe_error->get_error_messages();
//     return ! empty($msgs) ? $msgs[0] : 'Error.';
//   }
//   return 'Operation failed.';
// }

/**
 * Helpers for password reset key generation (wraps WP core function located in wp-login.php in XML-RPC/REST unavailable contexts)
 */
// function get_password_reset_key($user)
// {
//   if (! $user) return new WP_Error('invalid_user', 'Invalid user.');

//   // Use WP core function if available
//   if (function_exists('get_password_reset_key') && ! function_exists('wp_generate_password')) {
//     // unlikely path; fallback to core process below
//   }

//   // replicate core behaviour to create key
//   $key = wp_generate_password(20, false);
//   $expiration = time() + (60 * 60); // 1 hour
//   $hashed = wp_hash_password($key);

//   // store hashed key in user meta so core rp processing can verify
//   update_user_meta($user->ID, 'fp_password_reset_key', $hashed);
//   update_user_meta($user->ID, 'fp_password_reset_expires', $expiration);

//   return $key;
// }

/**
 * Security & operational notes (short):
 * - reCAPTCHA: You must add the client-side widget to your page (site key) and set fp_RECAPTCHA_SECRET.
 *   For example add <script src="https://www.google.com/recaptcha/api.js" async defer></script> and the widget or use v3 token-based flow.
 * - Email deliverability: Use an SMTP plugin (WP Mail SMTP) or ensure wp_mail is configured.
 * - Rate-limiting here is intentionally simple (IP/transient). For cluster sites or advanced needs use persistent storage or a firewall.
 * - Password reset link uses a custom small flow; you may replace with core wp-login.php flow if you prefer.
 * - Always serve forms over HTTPS to protect credentials. 
 */

// End plugin
