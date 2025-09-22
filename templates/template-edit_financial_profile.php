<?php
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}

// Check if user can edit financial profiles
if (!current_user_can('edit_financial_profiles')) {
  wp_die(__('You do not have permission to access this page.', 'fintech-profiler'));
}

get_header();
?>

<div class="container">
  <div class="row">
    <form method="post" enctype="multipart/form-data" class="fp-form">
      <?php wp_nonce_field('create_financial_profile', 'create_financial_profile_nonce'); ?>
      <input type="hidden" id="currentPage" name=" currentPage" value="1">
      <div class="fp-row reversed">
        <div class="fp-submit-buttons">
          <button type="button" class="button" id="prevBtn" disabled>Previous</button>
          <button type="button" class="button" id="skipBtn">Skip</button>
          <button type="button" class="button" id="nextBtn">Next</button>
          <button type="submit" name="submit_profile" id="fp-submit-btn" class="button button-primary" style="display: none;">Create Profile</button>
        </div>
      </div>
      <div class="fp-page" id="fp-page-1">
        <div class="fp-row">
          <div id="tabs">
            <div class="fp-col-6">
              <h2>Settings</h2>
              <ul>
                <li><a href="#tabs-1">Edit Account</a></li>
                <li><a href="#tabs-2">Account</a></li>
              </ul>
            </div>
            <div class="fp-col-6">
              <div id="tabs-1">
                <h2>Edit Profile</h2>
                <p>
                  <label for="company_logo">Company Logo</label>
                  <input type="file" name="company_logo" id="company_logo" accept="image/*" required>
                  <input type="hidden" name="action" value="upload_company_logo">
                </p>
                <p>
                  <label for="company_name">Company Name</label>
                  <input type="text" name="company_name" id="company_name" placeholder="Enter company name" required>
                </p>
                <p>
                  <label for="website_link">Website Link</label>
                  <input type="text" name="website_link" id="website_link" placeholder="Enter website link" required>
                </p>
                <button type="button">Update Profile</button>
              </div>
              <div id="tabs-2">
                <h2>Account</h2>
                <div class="password-setting-header">
                  <label for="password_setting">Password Setting</label>
                  <span>Choose a strong password to keep your profile secure</span>
                </div>
                <div class="password-settings" id="password-settings-1">
                  <p>
                    <label for="current_password">Current Password</label>
                    <input type="password" name="current_password" id="current_password" required>
                    <input type="hidden" name="action" value="upload_company_logo">
                  </p>

                  <a href="#">Change Password</a>
                </div>
                <div class="password-settings" id="password-settings-2">
                  <p>
                    <label for="your_current_password">Type Your Current Password</label>
                    <input type="password" name="your_current_password" id="your_current_password" required>
                  </p>

                  <a href="#">Forgot Password</a>

                  <p>
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" id="new_password" required>
                  </p>
                  <ul>
                    <li>Min. 8 characters</li>
                    <li>Atleast 1 number (0-9)</li>
                    <li>Atleast 1 symbol (!#$%^)</li>
                    <li>Atleast 1 upper and lower case</li>
                  </ul>

                  <p>
                    <label for="retype_password">Retype Password</label>
                    <input type="password" name="retype_password" id="retype_password" required>
                  </p>

                  <button type="button">Cancel</button>
                  <button type="submit"></button>
                </div>
                <hr />

                <div>
                  <label for="remove_account">Remove Account</label>
                  <span>Permanently deletes your companies account from FinExplore 360</span>
                </div>

                <a href="#">Delete Account</a>
              </div>


            </div>
          </div>
        </div>
      </div>
  </div>
</div>

<?php
get_footer();
