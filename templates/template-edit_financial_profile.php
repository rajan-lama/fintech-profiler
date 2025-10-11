<?php
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}

// Check if user can edit financial profiles
if (!current_user_can('edit_financial_profiles')) {
  wp_die(__('You do not have permission to access this page.', 'fintech-profiler'));
}

get_header();

// Get current user data
$current_user = wp_get_current_user();
$company_logo = get_user_meta($current_user->ID, '_profile_picture', true); // Fetch company logo (profile picture)
$company_name = $current_user->display_name; // Fetch display name (company name)
$website_link = $current_user->user_url; // Fetch website link

?>

<div class="container">
  <div class="row">
    <div class="fp-page" id="fp-page-1">
      <div class="fp-row">
        <div id="tabs" class="edit-financial-profile-tabs">
          <div class="fp-row">
            <div class="fp-col-3">
              <h2>Settings</h2>
              <ul>
                <li><a href="#tabs-1">Edit Account</a></li>
                <li><a href="#tabs-2">Account</a></li>
              </ul>
            </div>
            <div class="fp-col-9">
              <div id="tabs-1">
                <h2>Edit Profile</h2>

                <form method="post" enctype="multipart/form-data" class="fp-form">
                  <!-- <p>
                  <div>
                    <?php // if ($company_logo) : 
                    ?>
                      <img src="<?php // echo esc_url($company_logo); 
                                ?>" alt="Company Logo" style="max-width: 150px;">
                    <?php // endif; 
                    ?>
                  </div>
                  <label for="company_logo">Company Logo</label>
                  <img src="http://jamesw705.sg-host.com/wp-content/uploads/2025/09/Frame-1707480130.png" />
                  <input type="file" name="company_logo" id="company_logo" accept="image/*" value="<?php // echo esc_url($company_logo); 
                                                                                                    ?>">
                  <input type="hidden" name="action" value="upload_company_logo">
                  </p> -->

                  <p class="fp-logo-label">
                    <label for="company_logo">Company Logo</label>
                  </p>
                  <div class="fp-logo-upload">
                    <div class="fp-logo-preview">
                      <img src="http://jamesw705.sg-host.com/wp-content/uploads/2025/09/Frame-1707480130.png" id="logo-preview" />
                    </div class="fp-logo-btn">
                    <div class="fp-logo-file-input">
                      <input type="file" name="company_logo" id="company_logo" accept="image/*">
                      <input type="hidden" name="action" value="upload_company_logo">
                      <span>Supports .jpg, .png and .svg and zip files</span>
                    </div>
                  </div>

                  <p class="section-company-name">
                    <label for="company_name">Company Name</label>
                    <input type="text" name="company_name" id="company_name" value="<?php echo esc_attr($company_name); ?>" placeholder="Enter company name">
                  </p>
                  <p class="section-website-link">
                    <label for="website_link">Website Link</label>
                    <input type="text" name="website_link" id="website_link" value="<?php echo esc_url($website_link); ?>" placeholder="Enter website link">
                  </p>

                  <?php wp_nonce_field('edit_financial_profile', 'edit_financial_profile_nonce'); ?>
                  <input type="hidden" name="fp_action" value="edit_financial_profile" />
                  <input type="hidden" name="redirect_to" value="<?php echo home_url('/financial-dashboard'); ?>" />
                  <input type="hidden" id="currentPage" name=" currentPage" value="1">
                  <button type="submit" name="update_profile">Update Profile</button>
                </form>
              </div>
              <div id="tabs-2">
                <h2>Account</h2>
                <form method="post" enctype="multipart/form-data" class="fp-form">
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

                    <a href="<?php echo home_url('/forgot-password'); ?>">Change Password</a>
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
                    <button type="submit">Save Password</button>
                  </div>
                  <hr />

                  <div>
                    <label for="remove_account">Remove Account</label>
                    <span>Permanently deletes your companies account from FinExplore 360</span>
                  </div>

                  <a href="#">Delete Account</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
get_footer();
