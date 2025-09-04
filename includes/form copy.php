<?php

if (! defined('ABSPATH')) {
  exit;
}

/**
 * SETTINGS
 * --------------------------------------------------
 * Change these as needed.
 */
// Custom user meta key where your desired role is stored, e.g. 'subscriber', 'editor', etc.
// If empty or invalid, no role mapping will be applied.
const CFL_CUSTOM_ROLE_META_KEY = 'custom_role';

// Shortcode name: [wp_like_login]
const CFL_SHORTCODE = 'fintech_login';

// Where to redirect after login if none provided via redirect_to field.
const CFL_DEFAULT_REDIRECT = '/';

// Whether to strictly validate custom role against existing WP roles before applying.
const CFL_VALIDATE_ROLE = true;

/**
 * Render login form via shortcode.
 */
add_shortcode(CFL_SHORTCODE, function ($atts, $content = '') {
  if (is_user_logged_in()) {
    $current = wp_get_current_user();
    $logout_url = wp_logout_url(home_url(add_query_arg(null, null)));
    ob_start();
?>
    <div class="cfl-wrapper cfl-logged-in">
      <p>You are logged in as <strong><?php echo esc_html($current->display_name ?: $current->user_login); ?></strong>.</p>
      <p><a class="button cfl-logout" href="<?php echo esc_url($logout_url); ?>">Log out</a></p>
    </div>
  <?php
    return ob_get_clean();
  }

  $login_error  = isset($_GET['cfl_login']) && $_GET['cfl_login'] === 'failed';
  $login_msg    = isset($_GET['cfl_msg']) ? sanitize_text_field(wp_unslash($_GET['cfl_msg'])) : '';
  $redirect_to  = isset($_REQUEST['redirect_to']) ? esc_url_raw(wp_unslash($_REQUEST['redirect_to'])) : (is_ssl() ? home_url(CFL_DEFAULT_REDIRECT) : home_url(CFL_DEFAULT_REDIRECT));

  ob_start();
  ?>
  <form class="cfl-form" method="post" action="">
    <?php if ($login_error) : ?>
      <div class="cfl-notice cfl-error">Login failed. Please check your credentials and try again.</div>
    <?php elseif ($login_msg) : ?>
      <div class="cfl-notice cfl-info"><?php echo esc_html($login_msg); ?></div>
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

    <input type="hidden" name="cfl_action" value="login" />
    <input type="hidden" name="redirect_to" value="<?php echo esc_url($redirect_to); ?>" />
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

    .cfl-wrapper.cfl-logged-in {
      padding: 1rem;
      border: 1px dashed #cbd5e1;
      border-radius: 12px;
    }

    .cfl-logout.button {
      display: inline-block;
      padding: .6rem 1rem;
      border: 1px solid #cbd5e1;
      border-radius: 8px;
      text-decoration: none;
    }
  </style>
<?php
  return ob_get_clean();
});

/**
 * Handle login POST on template_redirect (runs on frontend before rendering template).
 */
add_action('template_redirect', function () {
  if (is_user_logged_in()) {
    return;
  }

  if (! isset($_POST['cfl_action']) || 'login' !== $_POST['cfl_action']) {
    return;
  }

  // Basic nonce & field checks
  if (! isset($_POST['cfl_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['cfl_nonce'])), 'cfl_login_nonce')) {
    cfl_redirect_with_args(array('cfl_login' => 'failed', 'cfl_msg' => 'Invalid request.'));
  }

  $user_login = isset($_POST['cfl_user_login']) ? sanitize_text_field(wp_unslash($_POST['cfl_user_login'])) : '';
  $user_pass  = isset($_POST['cfl_user_pass']) ? (string) wp_unslash($_POST['cfl_user_pass']) : '';
  $remember   = ! empty($_POST['cfl_remember']);
  $redirect   = isset($_POST['redirect_to']) ? esc_url_raw(wp_unslash($_POST['redirect_to'])) : home_url(CFL_DEFAULT_REDIRECT);

  if ('' === $user_login || '' === $user_pass) {
    cfl_redirect_with_args(array('cfl_login' => 'failed', 'cfl_msg' => 'Missing username or password.'), $redirect);
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
    cfl_redirect_with_args(array('cfl_login' => 'failed', 'cfl_msg' => cfl_first_error_message($user)), $redirect);
  }

  // (Optional) Map custom user meta role to WP role.
  // cfl_apply_custom_role_if_present($user);

  // Ensure current user is set for this request.
  wp_set_current_user($user->ID);

  // Final redirect after successful login.
  wp_safe_redirect($redirect ? $redirect : home_url(CFL_DEFAULT_REDIRECT));
  exit;
});

/**
 * Apply a role from custom user meta to the user, if present and valid.
 * - Reads CFL_CUSTOM_ROLE_META_KEY from usermeta
 * - If valid role exists in WP, assigns it (replacing existing roles)
 */
// function fintech_apply_custom_role_if_present(WP_User $user)
// {
//   $meta_key = CFL_CUSTOM_ROLE_META_KEY;
//   if (empty($meta_key)) {
//     return;
//   }
//   $desired_role = get_user_meta($user->ID, $meta_key, true);
//   if (empty($desired_role)) {
//     return;
//   }
//   $desired_role = sanitize_key($desired_role);

//   if (CFL_VALIDATE_ROLE && ! get_role($desired_role)) {
//     return; // Invalid role slug; do nothing
//   }

//   // Assign the role (replace any existing roles). Use add_role() instead if you want multiple roles.
//   $user->set_role($desired_role);
// }

/**
 * Utility: redirect back with query args.
 */
function fintech_redirect_with_args(array $args, $fallback = '')
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
function fintech_first_error_message($maybe_error)
{
  if (is_wp_error($maybe_error)) {
    $all = $maybe_error->get_error_messages();
    if (! empty($all)) {
      return $all[0];
    }
  }
  return 'Login failed.';
}

// /**
//  * Optional: Add a helper function to register or update a user's custom role meta.
//  * Usage example: cfl_set_user_custom_role( $user_id, 'editor' );
//  */
// function fintech_set_user_custom_role($user_id, $role_slug)
// {
//   update_user_meta($user_id, CFL_CUSTOM_ROLE_META_KEY, sanitize_key($role_slug));
// }

/**
 * Optional: Provide a logout shortcode for convenience. Usage: [cfl_logout]
 */
add_shortcode('cfl_logout', function () {
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
