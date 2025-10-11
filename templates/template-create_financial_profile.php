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
          <div class="fp-col-6">
            <span class="form-pagination">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.6667 19L4 12M4 12L10.6667 5M4 12L20 12" stroke="black" stroke-opacity="0.4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </span>
            <h2>Lets set up your account</h2>
            <p>Complete your profile with accurate and up-to-date information to ensure maximum visibility and credibility.</p>
          </div>
          <div class="fp-col-6">
            <p class="fp-logo-label">
              <label for="company_logo">Company Logo</label>
            </p>
            <div class="fp-logo-upload">
              <div class="fp-logo-preview">
                <img src="<?php echo FINTECH_PROFILER_BASE_URL . '/public/img/fallback-img.png'; ?>" id="logo-preview" />
              </div class="fp-logo-btn">
              <div class="fp-logo-file-input">
                <input type="file" name="company_logo" id="company_logo" accept="image/*">
                <input type="hidden" name="action" value="upload_company_logo">
                <span>Supports .jpg, .png and .svg and zip files</span>
              </div>
            </div>

            <p>
              <label for="company_name">Company Name</label>
              <input type="text" name="user_name" id="company_name" placeholder="Enter company name">
            </p>
            <p>
              <label for="website_link">Website Link</label>
              <input type="text" name="user_profile_website" id="website_link" placeholder="Enter website link">
            </p>
            </p>
            <button type="submit" class="button">Create Profile</button>
            </p>

            <input type="hidden" name="fp_action" value="create_financial_profile" />
            <input type="hidden" name="redirect_to" value="<?php echo home_url('/financial-dashboard'); ?>" />
            <?php wp_nonce_field('create_financial_profile', 'create_financial_profile_nonce'); ?>
            <input type="hidden" name="_wp_http_referer" value="/create-financial-profile/">
            <input type="hidden" id="currentPage" name=" currentPage" value="1">
          </div>
        </div>
      </div>
    </form>
    <div class="fintech-welcome-notice-holder">
      <div class="fintech-welcome-notice">
        <div class="fintect-welcome-logo">
          <svg width="147" height="147" viewBox="0 0 147 147" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M128.25 73.5C128.25 103.738 103.738 128.25 73.5 128.25C43.2624 128.25 18.75 103.738 18.75 73.5C18.75 43.2624 43.2624 18.75 73.5 18.75C82.09 18.75 90.2179 20.7282 97.4531 24.254M117.984 39.2812L70.0781 87.1875L56.3906 73.5" stroke="#6BC229" stroke-width="12.1667" stroke-linecap="round" stroke-linejoin="round" />
          </svg>

        </div>
        <div class="fintech-welcome-info">
          <h2>Well done! Everything is ready to go</h2>
          <p>Quick reminder: Accurate and complete profiles get higher engagement and trust from financial institutions. So, its recommended to fill out any information you might have left</p>
          <a href="btn">Proceed to Profile</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
get_footer();
