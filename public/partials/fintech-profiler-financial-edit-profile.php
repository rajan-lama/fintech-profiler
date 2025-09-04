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
<div class="edit-profile-form">
  <h3>Edit Profile</h3>

  <form id="company-logo-form" method="post" enctype="multipart/form-data">
    <div>
      <label id="company_logo">Company Logo</label>
      <input type="file" name="company_logo" accept="image/*" required>
      <input type="hidden" name="action" value="upload_company_logo">
      <!-- <button type="submit">Upload Logo</button> -->
    </div>
    <div>
      <label for="company_name">Company Name</label>
      <input type="text" id="company_name" name="company_name" required>
    </div>
    <div>
      <label for="company_website">Website Link</label>
      <input type="url" id="company_website" name="company_website" required>
    </div>

    <button type="submit">Upload Profile</button>
  </form>

</div>