<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://rajanlama.com.np
 * @since      1.0.0
 *
 * @package    Fintech_Profiler
 * @subpackage Fintech_Profiler/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="fintech-profiler-login-container">
  <div class="login-form">
    <h3>Log in to your account</h3>
    <p> Create for a Fintech Company instead? <a href="#">Switch</a></p>
    <form id="company-login-form" method="post" enctype="multipart/form-data">

      <?php if ($login_error) : ?>
        <div class="fintech-notice fintech-error">Login failed. Please check your credentials and try again.</div>
      <?php elseif ($login_msg) : ?>
        <div class="fintech-notice fintech-info"><?php echo esc_html($login_msg); ?></div>
      <?php endif; ?>

      <div class="fp-form-username">
        <label for="fp_login">Username or Email </label>
        <input type="text" id="fp_login" name="fp_login" autocomplete="username" required>
      </div>

      <div class="fp-form-password">
        <label for="fp_password">Password </label>
        <input type="password" id="fp_password" name="fp_password" autocomplete="current-password" required>
      </div>

      <input type="hidden" name="fp_action" value="login" />
      <input type="hidden" name="redirect_to" value="<?php echo esc_url($redirect_to); ?>" />
      <?php wp_nonce_field('fp_login_nonce', 'fp_nonce'); ?>

      <div class="fp-form-actions">
        <button type="submit" class="button button-primary">Sign In</button>
      </div>
    </form>

    <div class="fp-form-options">
      <div>
        <label>
          <input type="checkbox" name="fp_remember" value="1" /> Remember Me
        </label>
      </div>
      <a href="#" class="fp_forgot-pw">Forgot Password?</a>
    </div>

    <!--- shortcode for google login --->

    <div>Already Have an Account? <a href="#">Sign Up</a></div>

  </div>
</div>



<!---
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
  </form> --->