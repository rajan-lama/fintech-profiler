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
        <label for="create_password">Create A Password</label>
        <input type="email" id="email" name="email" required id="create_password">
      </div>
      <ul>
        <li>Min. 8 characters</li>
        <li>Atleast 1 number (0-9)</li>
        <li>Atleast 1 symbol (!#$%^)</li>
        <li>Atleast 1 upper and lower case</li>
      </ul>
      <button type="submit">Create Account</button>
    </form>

    <div class="terms">
      <p>Already have an account? <a href="#">Log in</a></p>
    </div>
  </div>
</div>