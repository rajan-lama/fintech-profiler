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
                  <input type="file" name="company_logo" id="company_logo" accept="image/*" value="<?php echo esc_url($company_logo); ?>">
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
                    <p>Choose a strong password to keep your profile secure</p>
                  </div>
                  <div class="password-settings" id="password-settings-1">
                    <p class="current-password">
                      <label for="current_password">Current Password</label>
                      <input type="password" name="current_password" id="current_password" required>
                      <input type="hidden" name="action" value="upload_company_logo">
                    </p>

                    <a href="#" id="link-changepw">Change Password</a>
                  </div>
                  <div class="password-settings" id="password-settings-2" style="display: none;">
                    <p class="your-current-password">
                      <label for="your_current_password">Type Your Current Password</label>
                      <input type="password" name="your_current_password" id="your_current_password" required>
                    </p>

                    <a href="#">Forgot Password</a>

                    <p class="new-password">
                      <label for="new_password">New Password</label>
                      <input type="password" name="new_password" id="new_password" required>
                    </p>
                    <ul>
                      <li>Min. 8 characters</li>
                      <li>Atleast 1 number (0-9)</li>
                      <li>Atleast 1 symbol (!#$%^)</li>
                      <li>Atleast 1 upper and lower case</li>
                    </ul>

                    <p class="retype-password">
                      <label for="retype_password">Retype Password</label>
                      <input type="password" name="retype_password" id="retype_password" required>
                    </p>

                    <button type="button">Cancel</button>
                    <button type="submit">Update Password</button>
                  </div>
                  <hr />

                  <div>
                    <label for="remove_account">Remove Account</label>
                    <span>Permanently deletes your companies account from FinExplore 360</span>
                  </div>

                  <a href="#" id="btn-delete-account" class="btn btn-danger">Delete Account</a>
                  <!-- Account Delete Modal -->
                  <div class="account-holder" id="account-delete-modal" style="display: none;">
                    <div class="account-delete-overlay"></div>
                    <div class="account-delete-box">
                      <a id="btn-cross" href="#"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M18 6L6 18M18 18L6 6" stroke="black" stroke-opacity="0.8" stroke-width="2" stroke-linecap="round" />
                        </svg>
                      </a>
                      <div class="account-delete-box-item">

                        <h5>Confirm Permanent Account Deletion?</h5>
                        <p>
                          You are about to delete this account permanently. This action is irreversible once the process is initiated; you won’t be able to retrieve any of the content or information you might have added to this profile.
                        </p>
                        <p class="account-delete-password">
                          <label for="retype_password_modal">Password</label>
                          <input type="password" name="retype_password" id="retype_password_modal" required>
                        </p>
                        <hr class="horizontal-rule">
                        <div class="account-delete-buttons">
                          <button type="button" id="cancel-delete">Cancel</button>
                          <button type="submit" id="confirm-delete"><svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M10 9.90003V5.41447M10 13.2248V13.2642M15.6699 17H4.33007C2.7811 17 1.47392 15.9763 1.06265 14.5757C0.887092 13.9778 1.10281 13.3551 1.43276 12.8249L7.10269 2.60102C8.4311 0.466323 11.5689 0.466326 12.8973 2.60103L18.5672 12.8249C18.8972 13.3551 19.1129 13.9778 18.9373 14.5757C18.5261 15.9763 17.2189 17 15.6699 17Z" stroke="#FDFDFD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Confirm Deletion</button>
                        </div>
                      </div>
                    </div>
                  </div>
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
