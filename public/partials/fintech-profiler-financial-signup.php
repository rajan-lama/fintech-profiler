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
<div class="container">
  <div class="login-form">
    <h3>Create An Account</h3>
    <p>Create for a Fintech Company instead? <a href="#">Switch</a></p>
    <form id="company-login-form" method="post" enctype="multipart/form-data">
      <div>
        <label for="email">Email </label>
        <input type="email" id="email" name="email" required>
      </div>
      <button type="submit">Get Started</button>
    </form>

    <div class="terms">
      <p>Already have an account? <a href="#">Log in</a></p>
    </div>
  </div>
</div>