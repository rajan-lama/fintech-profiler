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
const CFL_CUSTOM_ROLE_META_KEY = 'custom_role';
// Default redirect after login/registration
const CFL_DEFAULT_REDIRECT = '/';
// Whether to validate role slug against WP roles before applying
const CFL_VALIDATE_ROLE = true;
// Enable reCAPTCHA verification (set to true to validate server-side)
const CFL_RECAPTCHA_ENABLED = true;
// reCAPTCHA secret key (server-side). Obtain from Google reCAPTCHA admin.
const CFL_RECAPTCHA_SECRET = 'YOUR_RECAPTCHA_SECRET_HERE';
// Rate limiting options
const CFL_RATE_LIMIT_WINDOW = 300; // seconds (e.g. 5 minutes)
const CFL_RATE_LIMIT_MAX_ATTEMPTS = 5; // allowed failed attempts within window
const CFL_LOCKOUT_DURATION = 900; // seconds (e.g. 15 minutes) lockout after exceeding attempts

/**
 * ------------------ SHORTCODES ------------------
 * [wp_like_login] - frontend login form
 * [wp_like_register] - frontend registration form
 * [wp_like_reset] - request password reset form (sends email with reset link)
 * [cfl_logout] - logout link
 */

require_once ABSPATH . 'wp-includes/pluggable.php';

add_shortcode('wp_like_login', 'cfl_render_login_shortcode');
add_shortcode('wp_like_register', 'cfl_render_register_shortcode');
add_shortcode('wp_like_reset', 'cfl_render_reset_request_shortcode');
add_shortcode('cfl_logout', function () {
  if (! is_user_logged_in()) return '';
  $logout_url = wp_logout_url(home_url(add_query_arg(null, null)));
  return '<a class="button" href="' . esc_url($logout_url) . '">Log out</a>';
});

/**
 * Render login form
 */
function cfl_render_login_shortcode($atts)
{
  if (is_user_logged_in()) {
    $current = wp_get_current_user();
    $logout_url = wp_logout_url(home_url(add_query_arg(null, null)));
    return '<div class="cfl-wrapper cfl-logged-in"><p>You are logged in as <strong>' . esc_html($current->display_name ?: $current->user_login) . '</strong>.</p><p><a class="button cfl-logout" href="' . esc_url($logout_url) . '">Log out</a></p></div>';
  }

  $error = isset($_GET['cfl_login']) && $_GET['cfl_login'] === 'failed';
  $msg = isset($_GET['cfl_msg']) ? sanitize_text_field(wp_unslash($_GET['cfl_msg'])) : '';
  $redirect = isset($_REQUEST['redirect_to']) ? esc_url_raw(wp_unslash($_REQUEST['redirect_to'])) : home_url(CFL_DEFAULT_REDIRECT);

  ob_start();
?>
  <form class="cfl-form" method="post" action="">
    <?php if ($error) : ?>
      <div class="cfl-notice cfl-error">Login failed. <?php echo $msg ? esc_html($msg) : 'Please check your credentials.'; ?></div>
    <?php elseif ($msg) : ?>
      <div class="cfl-notice cfl-info"><?php echo esc_html($msg); ?></div>
    <?php endif; ?>

    <p class="cfl-field">
      <label for="cfl_user_login">Username or Email</label>
      <input type="text" name="cfl_user_login" id="cfl_user_login" autocomplete="username" required />
    </p>
    <p class="cfl-field">
      <label for="cfl_user_pass">Password</label>
      <input type="password" name="cfl_user_pass" id="cfl_user_pass" autocomplete="current-password" required />
    </p>
    <p class="cfl-field cfl-remember">
      <label>
        <input type="checkbox" name="cfl_remember" value="1" /> Remember Me
      </label>
    </p>

    <?php if (CFL_RECAPTCHA_ENABLED) : ?>
      <p class="cfl-field">
        <!-- Frontend reCAPTCHA widget should be added by theme or manually. We validate server-side on submit. -->
        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" />
      </p>
    <?php endif; ?>

    <input type="hidden" name="cfl_action" value="login" />
    <input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect); ?>" />
    <?php wp_nonce_field('cfl_login_nonce', 'cfl_nonce'); ?>

    <p class="cfl-actions">
      <button type="submit" class="button button-primary">Log In</button>
    </p>
  </form>
  <style>
    .cfl-form {
      max-width: 420px;
      margin: 1rem 0;
      padding: 1rem;
      border: 1px solid #e5e7eb;
      border-radius: 12px;
      background: #fff;
    }

    .cfl-field {
      margin-bottom: 12px;
    }

    .cfl-field label {
      display: block;
      font-weight: 600;
      margin-bottom: 6px;
    }

    .cfl-field input[type="text"],
    .cfl-field input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #d1d5db;
      border-radius: 8px;
    }

    .cfl-remember {
      display: flex;
      align-items: center;
      gap: .5rem;
    }

    .cfl-actions {
      margin-top: 12px;
    }

    .cfl-notice {
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 12px;
    }

    .cfl-error {
      background: #fee2e2;
      border: 1px solid #fecaca;
    }

    .cfl-info {
      background: #eff6ff;
      border: 1px solid #bfdbfe;
    }
  </style>
<?php

  return ob_get_clean();
}

/**
 * Render registration form
 */
function cfl_render_register_shortcode($atts)
{
  if (is_user_logged_in()) return '<p>You are already logged in.</p>';

  $msg = isset($_GET['cfl_reg_msg']) ? sanitize_text_field(wp_unslash($_GET['cfl_reg_msg'])) : '';
  $redirect = isset($_REQUEST['redirect_to']) ? esc_url_raw(wp_unslash($_REQUEST['redirect_to'])) : home_url(CFL_DEFAULT_REDIRECT);

  ob_start();
?>
  <form class="cfl-form" method="post" action="">
    <?php if ($msg) : ?>
      <div class="cfl-notice cfl-info"><?php echo esc_html($msg); ?></div>
    <?php endif; ?>

    <p class="cfl-field">
      <label for="cfl_reg_user">Username</label>
      <input type="text" name="cfl_reg_user" id="cfl_reg_user" required />
    </p>
    <p class="cfl-field">
      <label for="cfl_reg_email">Email</label>
      <input type="email" name="cfl_reg_email" id="cfl_reg_email" required />
    </p>
    <p class="cfl-field">
      <label for="cfl_reg_pass">Password</label>
      <input type="password" name="cfl_reg_pass" id="cfl_reg_pass" required />
    </p>
    <p class="cfl-field">
      <label for="cfl_reg_role">Requested Role (optional)</label>
      <input type="text" name="cfl_reg_role" id="cfl_reg_role" placeholder="subscriber" />
      <small>Provide a role slug (e.g. subscriber). Will be validated if enabled.</small>
    </p>

    <?php if (CFL_RECAPTCHA_ENABLED) : ?>
      <p class="cfl-field">
        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-reg" />
      </p>
    <?php endif; ?>

    <input type="hidden" name="cfl_action" value="register" />
    <input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect); ?>" />
    <?php wp_nonce_field('cfl_register_nonce', 'cfl_nonce'); ?>

    <p class="cfl-actions"><button type="submit" class="button">Register</button></p>
  </form>
<?php
  return ob_get_clean();
}

/**
 * Render password reset request form
 */
function cfl_render_reset_request_shortcode($atts)
{
  if (is_user_logged_in()) return '<p>You are already logged in.</p>';

  $msg = isset($_GET['cfl_reset_msg']) ? sanitize_text_field(wp_unslash($_GET['cfl_reset_msg'])) : '';
  ob_start();
?>
  <form class="cfl-form" method="post" action="">
    <?php if ($msg) : ?>
      <div class="cfl-notice cfl-info"><?php echo esc_html($msg); ?></div>
    <?php endif; ?>

    <p class="cfl-field">
      <label for="cfl_reset_email">Email or Username</label>
      <input type="text" name="cfl_reset_email" id="cfl_reset_email" required />
    </p>

    <?php if (CFL_RECAPTCHA_ENABLED) : ?>
      <p class="cfl-field">
        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-reset" />
      </p>
    <?php endif; ?>

    <input type="hidden" name="cfl_action" value="reset_request" />
    <?php wp_nonce_field('cfl_reset_nonce', 'cfl_nonce'); ?>

    <p class="cfl-actions"><button type="submit" class="button">Send reset email</button></p>
  </form>
<?php
  return ob_get_clean();
}

/**
 * Handle all frontend actions on template_redirect
 */
add_action('template_redirect', 'cfl_handle_frontend_actions');
function cfl_handle_frontend_actions()
{
  if (! isset($_POST['cfl_action'])) return;

  $action = sanitize_text_field(wp_unslash($_POST['cfl_action']));

  if ($action === 'login') {
    cfl_process_login();
  }

  if ($action === 'register') {
    cfl_process_register();
  }

  if ($action === 'reset_request') {
    cfl_process_reset_request();
  }
}

/**
 * Rate limiting helpers (simple IP-based with transients)
 */
function cfl_get_client_ip()
{
  if (! empty($_SERVER['HTTP_CLIENT_IP'])) return sanitize_text_field(wp_unslash($_SERVER['HTTP_CLIENT_IP']));
  if (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return sanitize_text_field(wp_unslash(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]));
  return isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : '0.0.0.0';
}

function cfl_rate_limit_exceeded()
{
  $ip = cfl_get_client_ip();
  $lock_key = 'cfl_lockout_' . md5($ip);
  $attempts_key = 'cfl_attempts_' . md5($ip);

  $lock = get_transient($lock_key);
  if ($lock) return true;

  $attempts = (int) get_transient($attempts_key);
  if ($attempts >= CFL_RATE_LIMIT_MAX_ATTEMPTS) {
    // set lockout
    set_transient($lock_key, true, CFL_LOCKOUT_DURATION);
    delete_transient($attempts_key);
    return true;
  }
  return false;
}

function cfl_increment_failed_attempts()
{
  $ip = cfl_get_client_ip();
  $attempts_key = 'cfl_attempts_' . md5($ip);
  $attempts = (int) get_transient($attempts_key);
  $attempts++;
  set_transient($attempts_key, $attempts, CFL_RATE_LIMIT_WINDOW);
}

function cfl_clear_failed_attempts()
{
  $ip = cfl_get_client_ip();
  $attempts_key = 'cfl_attempts_' . md5($ip);
  delete_transient($attempts_key);
}

/**
 * Verify reCAPTCHA server-side
 */
function cfl_verify_recaptcha($token)
{
  if (! CFL_RECAPTCHA_ENABLED) return true;
  if (empty(CFL_RECAPTCHA_SECRET) || CFL_RECAPTCHA_SECRET === 'YOUR_RECAPTCHA_SECRET_HERE') {
    // If misconfigured, fail safe to false to avoid bypass. You can change to true for testing.
    return false;
  }
  $resp = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', array(
    'body' => array(
      'secret' => CFL_RECAPTCHA_SECRET,
      'response' => $token,
      'remoteip' => cfl_get_client_ip(),
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
function cfl_process_login()
{
  if (! isset($_POST['cfl_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['cfl_nonce'])), 'cfl_login_nonce')) {
    cfl_redirect_with_args(array('cfl_login' => 'failed', 'cfl_msg' => 'Invalid request.'));
  }

  if (cfl_rate_limit_exceeded()) {
    cfl_redirect_with_args(array('cfl_login' => 'failed', 'cfl_msg' => 'Too many attempts. Try again later.'));
  }

  $user_login = isset($_POST['cfl_user_login']) ? sanitize_text_field(wp_unslash($_POST['cfl_user_login'])) : '';
  $user_pass  = isset($_POST['cfl_user_pass']) ? (string) wp_unslash($_POST['cfl_user_pass']) : '';
  $remember   = ! empty($_POST['cfl_remember']);
  $redirect   = isset($_POST['redirect_to']) ? esc_url_raw(wp_unslash($_POST['redirect_to'])) : home_url(CFL_DEFAULT_REDIRECT);

  if (CFL_RECAPTCHA_ENABLED) {
    $token = isset($_POST['g-recaptcha-response']) ? sanitize_text_field(wp_unslash($_POST['g-recaptcha-response'])) : '';
    if (! cfl_verify_recaptcha($token)) {
      cfl_increment_failed_attempts();
      cfl_redirect_with_args(array('cfl_login' => 'failed', 'cfl_msg' => 'reCAPTCHA verification failed.'), $redirect);
    }
  }

  if ('' === $user_login || '' === $user_pass) {
    cfl_increment_failed_attempts();
    cfl_redirect_with_args(array('cfl_login' => 'failed', 'cfl_msg' => 'Missing username or password.'), $redirect);
  }

  if (is_email($user_login)) {
    $user_obj = get_user_by('email', $user_login);
    if ($user_obj) {
      $user_login = $user_obj->user_login;
    }
  }

  $creds = array(
    'user_login'    => $user_login,
    'user_password' => $user_pass,
    'remember'      => $remember,
  );

  $user = wp_signon($creds, is_ssl());

  if (is_wp_error($user)) {
    cfl_increment_failed_attempts();
    cfl_redirect_with_args(array('cfl_login' => 'failed', 'cfl_msg' => cfl_first_error_message($user)), $redirect);
  }

  // successful
  cfl_clear_failed_attempts();
  cfl_apply_custom_role_if_present($user);
  wp_set_current_user($user->ID);
  wp_safe_redirect($redirect ? $redirect : home_url(CFL_DEFAULT_REDIRECT));
  exit;
}

/**
 * Process registration
 */
function cfl_process_register()
{
  if (! isset($_POST['cfl_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['cfl_nonce'])), 'cfl_register_nonce')) {
    cfl_redirect_with_args(array('cfl_reg_msg' => 'Invalid request.'));
  }

  if (cfl_rate_limit_exceeded()) {
    cfl_redirect_with_args(array('cfl_reg_msg' => 'Too many attempts. Try again later.'));
  }

  if (CFL_RECAPTCHA_ENABLED) {
    $token = isset($_POST['g-recaptcha-response']) ? sanitize_text_field(wp_unslash($_POST['g-recaptcha-response'])) : '';
    if (! cfl_verify_recaptcha($token)) {
      cfl_increment_failed_attempts();
      cfl_redirect_with_args(array('cfl_reg_msg' => 'reCAPTCHA verification failed.'));
    }
  }

  $username = isset($_POST['cfl_reg_user']) ? sanitize_user(wp_unslash($_POST['cfl_reg_user']), true) : '';
  $email    = isset($_POST['cfl_reg_email']) ? sanitize_email(wp_unslash($_POST['cfl_reg_email'])) : '';
  $pass     = isset($_POST['cfl_reg_pass']) ? $_POST['cfl_reg_pass'] : '';
  $role     = isset($_POST['cfl_reg_role']) ? sanitize_key(wp_unslash($_POST['cfl_reg_role'])) : '';
  $redirect = isset($_POST['redirect_to']) ? esc_url_raw(wp_unslash($_POST['redirect_to'])) : home_url(CFL_DEFAULT_REDIRECT);

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

  if (! empty($role) && CFL_VALIDATE_ROLE && ! get_role($role)) {
    // ignore invalid role but do not fail the registration - store nothing
    $role = '';
  }

  if ($errors->has_errors()) {
    cfl_increment_failed_attempts();
    cfl_redirect_with_args(array('cfl_reg_msg' => cfl_first_error_message($errors)));
  }

  // Create the user
  $user_id = wp_create_user($username, $pass, $email);
  if (is_wp_error($user_id)) {
    cfl_increment_failed_attempts();
    cfl_redirect_with_args(array('cfl_reg_msg' => cfl_first_error_message($user_id)));
  }

  // Optionally set user role meta — and optionally set role on WP user record
  if (! empty($role)) {
    update_user_meta($user_id, CFL_CUSTOM_ROLE_META_KEY, $role);
    if (CFL_VALIDATE_ROLE && get_role($role)) {
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
  cfl_clear_failed_attempts();
  wp_safe_redirect($redirect);
  exit;
}

/**
 * Process password reset request
 */
function cfl_process_reset_request()
{
  if (! isset($_POST['cfl_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['cfl_nonce'])), 'cfl_reset_nonce')) {
    cfl_redirect_with_args(array('cfl_reset_msg' => 'Invalid request.'));
  }

  if (cfl_rate_limit_exceeded()) {
    cfl_redirect_with_args(array('cfl_reset_msg' => 'Too many attempts. Try again later.'));
  }

  if (CFL_RECAPTCHA_ENABLED) {
    $token = isset($_POST['g-recaptcha-response']) ? sanitize_text_field(wp_unslash($_POST['g-recaptcha-response'])) : '';
    if (! cfl_verify_recaptcha($token)) {
      cfl_increment_failed_attempts();
      cfl_redirect_with_args(array('cfl_reset_msg' => 'reCAPTCHA verification failed.'));
    }
  }

  $user_input = isset($_POST['cfl_reset_email']) ? sanitize_text_field(wp_unslash($_POST['cfl_reset_email'])) : '';
  if (empty($user_input)) {
    cfl_increment_failed_attempts();
    cfl_redirect_with_args(array('cfl_reset_msg' => 'Please provide username or email.'));
  }

  $user = null;
  if (is_email($user_input)) {
    $user = get_user_by('email', $user_input);
  } else {
    $user = get_user_by('login', $user_input);
  }

  if (! $user) {
    // Do not reveal whether user exists; still say success for security
    cfl_redirect_with_args(array('cfl_reset_msg' => 'If the account exists, you will receive an email with reset instructions.'));
  }

  // Use WP core functions to generate reset key and send email
  $allow = apply_filters('allow_password_reset', true, $user->user_login);
  if (! $allow) {
    cfl_redirect_with_args(array('cfl_reset_msg' => 'Password reset is not allowed for this account.'));
  }

  $key = get_password_reset_key($user);
  if (is_wp_error($key)) {
    cfl_redirect_with_args(array('cfl_reset_msg' => 'Could not generate reset key.'));
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

  cfl_clear_failed_attempts();
  cfl_redirect_with_args(array('cfl_reset_msg' => 'If the account exists, you will receive an email with reset instructions.'));
}

/**
 * Apply a role from custom user meta to the user, if present and valid.
 */
function cfl_apply_custom_role_if_present($user)
{
  if (is_numeric($user)) $user = get_userdata($user);
  if (! $user || ! $user->ID) return;

  $meta_key = CFL_CUSTOM_ROLE_META_KEY;
  if (empty($meta_key)) return;
  $desired_role = get_user_meta($user->ID, $meta_key, true);
  if (empty($desired_role)) return;
  $desired_role = sanitize_key($desired_role);

  if (CFL_VALIDATE_ROLE && ! get_role($desired_role)) return;

  $wp_user = new WP_User($user->ID);
  $wp_user->set_role($desired_role);
}

/**
 * Utility: redirect back with query args.
 */
function cfl_redirect_with_args(array $args, $fallback = '')
{
  $referer = wp_get_referer();
  $target  = $referer ? $referer : ($fallback ? $fallback : home_url(CFL_DEFAULT_REDIRECT));
  $target  = add_query_arg(array_map('rawurlencode', $args), $target);
  wp_safe_redirect($target);
  exit;
}

/**
 * Utility: Extract the first meaningful error message from WP_Error.
 */
function cfl_first_error_message($maybe_error)
{
  if (is_wp_error($maybe_error)) {
    $all = $maybe_error->get_error_messages();
    if (! empty($all)) {
      return $all[0];
    }
  }
  if ($maybe_error instanceof WP_Error) {
    $msgs = $maybe_error->get_error_messages();
    return ! empty($msgs) ? $msgs[0] : 'Error.';
  }
  return 'Operation failed.';
}

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
//   update_user_meta($user->ID, 'cfl_password_reset_key', $hashed);
//   update_user_meta($user->ID, 'cfl_password_reset_expires', $expiration);

//   return $key;
// }

/**
 * Security & operational notes (short):
 * - reCAPTCHA: You must add the client-side widget to your page (site key) and set CFL_RECAPTCHA_SECRET.
 *   For example add <script src="https://www.google.com/recaptcha/api.js" async defer></script> and the widget or use v3 token-based flow.
 * - Email deliverability: Use an SMTP plugin (WP Mail SMTP) or ensure wp_mail is configured.
 * - Rate-limiting here is intentionally simple (IP/transient). For cluster sites or advanced needs use persistent storage or a firewall.
 * - Password reset link uses a custom small flow; you may replace with core wp-login.php flow if you prefer.
 * - Always serve forms over HTTPS to protect credentials. 
 */

// End plugin
