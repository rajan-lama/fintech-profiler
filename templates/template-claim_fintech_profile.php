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
      <div class="fp-page" id="fp-page-1">
        <div class="fp-row">
          <div class="fp-col-6"></div>
          <div class="fp-col-6">
            <p>
              <button type="submit" name="submit_claim" class="btn">Submit</button>
            </p>
          </div>

          <div class="fp-col-6">
            <span class="form-pagination">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.6667 19L4 12M4 12L10.6667 5M4 12L20 12" stroke="black" stroke-opacity="0.4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </span>
            <h2>Account Verification </h2>
            <p>Upload necessary documents and information and we will verify your account to claim</p>
          </div>
          <div class="fp-col-6">
            <p>
              <label for="existing_profile">Existing Profile</label>
            <div class="desc">Provide link to existing profile in FinExplore 360 that you want to claim</div>
            <input type="text" name="existing_profile" id="existing_profile" placeholder="finexplore360.com/profile" required>
            </p>
            <hr />

            <p>
            <h4>Website Link</h4>
            <div class="desc">Provide link to your existing website</div>
            <label for="website_link">Website Link</label>
            <input type="text" name="website_link" id="website_link" placeholder="Enter website link" required>
            </p>

            <p>
            <h4>Contact information</h4>
            <span class="desc">Incase we need to get in contact with you for further verification, how do we reach you?</span>
            </p>

            <p>
              <label for="email">Email</label>
              <input type="text" name="email" id="email" required>
            </p>

            <p>
              <label for="contact_number">Contact number</label>
              <input type="text" name="contact_number" id="contact_number" required>
            </p>

            <hr />

            <p>
            <h4>Upload Documents</h4>
            <span class="desc">These will be used to verify your authenticity.</span>
            <ul>
              <li>A small video proving with showing you are real</li>
              <li>Any documents that may help</li>
            </ul>
            </p>

            <p>
              <label for="attach_media">Attach media</label>
              <img src="http://jamesw705.sg-host.com/wp-content/uploads/2025/09/Frame-1707480130.png" />
              <input type="file" name="attach_media" id="attach_media" accept="image/*" required>
              <input type="hidden" name="action" value="upload_company_logo">
            </p>

            <?php wp_nonce_field('claim_fintech_profile', 'claim_fintech_profile_nonce'); ?>
            <input type="hidden" id="currentPage" name=" currentPage" value="1">

          </div>
        </div>
      </div>
    </form>
    <div class="fintech-welcome-notice">
      <div class="fintect-welcome-logo">
        <svg width="147" height="147" viewBox="0 0 147 147" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M128.25 73.5C128.25 103.738 103.738 128.25 73.5 128.25C43.2624 128.25 18.75 103.738 18.75 73.5C18.75 43.2624 43.2624 18.75 73.5 18.75C82.09 18.75 90.2179 20.7282 97.4531 24.254M117.984 39.2812L70.0781 87.1875L56.3906 73.5" stroke="#6BC229" stroke-width="12.1667" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </div>
      <div class="fintech-welcome-info">
        <h2>Your claim has been submitted</h2>
        <p>You will be notified via email about the status of your submission.</p>
        <a href="btn">Back to browsing</a>
      </div>
    </div>
  </div>
</div>

<?php
get_footer();
