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
    <h3>Verification</h3>
    <p>A 6 number verification code has been sent to you email address ending with ***********ny@gmail.com</p>
    <form id="company-login-form" method="post" enctype="multipart/form-data">
      <div>
        <label for="enter_code">Enter Code </label>
        <div>
          <input type="text" id="enter_code[0]" name="enter_code[0]" required>
          <input type="text" id="enter_code[1]" name="enter_code[1]" required>
          <input type="text" id="enter_code[2]" name="enter_code[2]" required>
          <input type="text" id="enter_code[3]" name="enter_code[3]" required>
          <input type="text" id="enter_code[4]" name="enter_code[4]" required>
        </div>
      </div>

      <button type="submit">Verify</button>
    </form>
  </div>
</div>


<!------------------------- Update password------------------------------------------>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="container">
  <div class="login-form">
    <h3>Please update your password</h3>
    <p>A 6 number verification code has been sent to you email address ending with ***********ny@gmail.com</p>
    <form id="company-login-form" method="post" enctype="multipart/form-data">
      <div>
        <label for="new_password">New Password</label>
        <input type="password" id="new_password" name="new_password" required>
      </div>
      <ul>
        <li>Min. 8 characters</li>
        <li>Atleast 1 number (0-9)</li>
        <li>Atleast 1 symbol (!#$%^)</li>
        <li>Atleast 1 upper and lower case</li>
      </ul>

      <div>
        <label for="retype_password">Retype Password</label>
        <input type="password" id="retype_password" name="retype_password" required>
      </div>
      <button type="submit">Change Password</button>
    </form>

  </div>
</div>