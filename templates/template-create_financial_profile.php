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
            <p>
              <label for="company_logo">Company Logo</label>
              <input type="file" name="company_logo" id="company_logo" accept="image/*">
              <input type="hidden" name="action" value="upload_company_logo">
            </p>
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
    <div class="fintech-welcome-notice">
      <div class="fintect-welcome-logo">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M10.6667 19L4 12M4 12L10.6667 5M4 12L20 12" stroke="black" stroke-opacity="0.4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
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

<?php
get_footer();
