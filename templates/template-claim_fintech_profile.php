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
      <div class="fp-row">
        <div class="fp-col-6">
          <img src="<?php echo FINTECH_PROFILER_BASE_URL . 'public/img/logo.png'; ?>" alt="Claim Fintech Profile" />
        </div>
        <div class="fp-col-6">
          <p>
            <button type="submit" name="submit_claim" class="btn btn-submit-claim">Proceed</button>
          </p>
        </div>
      </div>
      <div class="fp-page" id="fp-page-1">
        <div class="fp-row">
          <div class="fp-col-6">
            <span class="form-pagination">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.6667 19L4 12M4 12L10.6667 5M4 12L20 12" stroke="black" stroke-opacity="0.4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </span>
          </div>
          <div class="fp-col-6"></div>
          <div class="fp-col-6">
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

            <div class="fp-media-uploader">
              <p>
                <label for="attach_media">Attach Media</label>
              </p>
              <div id="drop-area">
                <svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12.0836 17.1031L11.4372 16.3401L11.4372 16.3401L12.0836 17.1031ZM12.1496 17.0398L11.4371 16.3381L11.4364 16.3389L12.1496 17.0398ZM9.37249 19.4002L8.72604 18.6372L8.72603 18.6372L9.37249 19.4002ZM9.22397 19.5566L10.0448 20.1278L10.0448 20.1278L9.22397 19.5566ZM23.6157 17.199L22.9231 17.9204L22.9231 17.9204L23.6157 17.199ZM21.3018 14.9777L20.6092 15.6991L20.6092 15.6991L21.3018 14.9777ZM20.4425 14.9717L19.7602 14.2406L19.7576 14.243L20.4425 14.9717ZM16.1566 18.9998L16.8389 19.7308L16.8414 19.7285L16.1566 18.9998ZM15.2841 18.9807L14.5681 19.6789L14.5696 19.6803L15.2841 18.9807ZM15.2728 18.9692L14.5562 19.6666L14.5569 19.6673L15.2728 18.9692ZM15.2116 18.9097L15.8663 18.1539L15.8663 18.1538L15.2116 18.9097ZM13.1237 17.1013L13.7784 16.3454L13.7784 16.3454L13.1237 17.1013ZM13.0622 17.0415L13.7791 16.3443L13.7784 16.3436L13.0622 17.0415ZM13.0512 17.0302L13.7674 16.3324L13.766 16.331L13.0512 17.0302ZM12.1615 17.0278L11.4504 16.3247L11.449 16.3261L12.1615 17.0278ZM21.8994 9.24975V8.24975C21.3471 8.24975 20.8994 8.69747 20.8994 9.24975H21.8994ZM22.3284 9.24975H23.3284C23.3284 8.69747 22.8807 8.24975 22.3284 8.24975V9.24975ZM22.3284 9.61303V10.613C22.8807 10.613 23.3284 10.1653 23.3284 9.61303H22.3284ZM21.8994 9.61303H20.8994C20.8994 10.1653 21.3471 10.613 21.8994 10.613V9.61303ZM4.5 8.5H3.5V23.5H4.5H5.5V8.5H4.5ZM9 28V29H24V28V27H9V28ZM28.5 23.5H29.5V8.5H28.5H27.5V23.5H28.5ZM24 4V3H9V4V5H24V4ZM28.5 8.5H29.5C29.5 5.46243 27.0376 3 24 3V4V5C25.933 5 27.5 6.567 27.5 8.5H28.5ZM24 28V29C27.0376 29 29.5 26.5376 29.5 23.5H28.5H27.5C27.5 25.433 25.933 27 24 27V28ZM4.5 23.5H3.5C3.5 26.5376 5.96243 29 9 29V28V27C7.067 27 5.5 25.433 5.5 23.5H4.5ZM4.5 8.5H5.5C5.5 6.567 7.067 5 9 5V4V3C5.96243 3 3.5 5.46243 3.5 8.5H4.5ZM12.0836 17.1031L12.7301 17.866C12.7939 17.8119 12.8469 17.757 12.8629 17.7407L12.1496 17.0398L11.4364 16.3389C11.4307 16.3447 11.4273 16.3481 11.4243 16.3512C11.4215 16.354 11.4203 16.3551 11.4202 16.3553C11.4197 16.3557 11.426 16.3495 11.4372 16.3401L12.0836 17.1031ZM9.37249 19.4002L10.0189 20.1631L12.7301 17.866L12.0836 17.1031L11.4372 16.3401L8.72604 18.6372L9.37249 19.4002ZM9.22397 19.5566L10.0448 20.1278C10.0286 20.1511 10.0154 20.1653 10.0107 20.1701C10.0063 20.1746 10.0074 20.1729 10.0189 20.1631L9.37249 19.4002L8.72603 18.6372C8.64226 18.7082 8.51581 18.8235 8.40316 18.9854L9.22397 19.5566ZM9 20.2706H10C10 20.2193 10.0157 20.1695 10.0448 20.1278L9.22397 19.5566L8.40317 18.9854C8.14158 19.3613 8 19.8095 8 20.2706H9ZM9 22.875H10V20.2706H9H8V22.875H9ZM9.625 23.5V22.5C9.8321 22.5 10 22.6679 10 22.875H9H8C8 23.7725 8.72754 24.5 9.625 24.5V23.5ZM23.375 23.5V22.5H9.625V23.5V24.5H23.375V23.5ZM24 22.875H23C23 22.6679 23.1679 22.5 23.375 22.5V23.5V24.5C24.2725 24.5 25 23.7725 25 22.875H24ZM24 18.1008H23V22.875H24H25V18.1008H24ZM23.6157 17.199L22.9231 17.9204C22.9722 17.9676 23 18.0327 23 18.1008H24H25C25 17.4881 24.7502 16.9019 24.3082 16.4776L23.6157 17.199ZM21.3018 14.9777L20.6092 15.6991L22.9231 17.9204L23.6157 17.199L24.3082 16.4776L21.9943 14.2563L21.3018 14.9777ZM20.4425 14.9717L21.1248 15.7027C20.9793 15.8386 20.7529 15.837 20.6092 15.6991L21.3018 14.9777L21.9943 14.2563C21.3719 13.6588 20.391 13.6519 19.7602 14.2406L20.4425 14.9717ZM16.1566 18.9998L16.8414 19.7285L21.1274 15.7003L20.4425 14.9717L19.7576 14.243L15.4717 18.2711L16.1566 18.9998ZM15.2841 18.9807L14.5696 19.6803C15.1811 20.3049 16.1887 20.3377 16.8389 19.7308L16.1566 18.9998L15.4743 18.2687C15.6246 18.1284 15.8569 18.1363 15.9986 18.2811L15.2841 18.9807ZM15.2728 18.9692L14.5569 19.6673L14.5681 19.6789L15.2841 18.9807L16.0001 18.2826L15.9888 18.271L15.2728 18.9692ZM15.2116 18.9097L14.5569 19.6656C14.5466 19.6567 14.5407 19.6508 14.5412 19.6513C14.5413 19.6514 14.5424 19.6525 14.545 19.6551C14.5478 19.658 14.5509 19.6612 14.5562 19.6666L15.2728 18.9692L15.9895 18.2717C15.9747 18.2565 15.9254 18.205 15.8663 18.1539L15.2116 18.9097ZM13.1237 17.1013L12.469 17.8571L14.5569 19.6656L15.2116 18.9097L15.8663 18.1538L13.7784 16.3454L13.1237 17.1013ZM13.0622 17.0415L12.3453 17.7387C12.3602 17.754 12.4096 17.8057 12.469 17.8571L13.1237 17.1013L13.7784 16.3454C13.7887 16.3543 13.7946 16.3602 13.7942 16.3597C13.794 16.3596 13.793 16.3585 13.7903 16.3559C13.7875 16.353 13.7844 16.3498 13.7791 16.3443L13.0622 17.0415ZM13.0512 17.0302L12.335 17.7281L12.346 17.7394L13.0622 17.0415L13.7784 16.3436L13.7674 16.3324L13.0512 17.0302ZM12.1615 17.0278L12.8726 17.7309C12.7242 17.8809 12.4841 17.8805 12.3363 17.7295L13.0512 17.0302L13.766 16.331C13.1318 15.6826 12.0874 15.6805 11.4504 16.3247L12.1615 17.0278ZM12.1496 17.0398L12.8621 17.7415L12.874 17.7295L12.1615 17.0278L11.449 16.3261L11.4371 16.3381L12.1496 17.0398ZM21.8994 9.24975V10.2498H22.3284V9.24975V8.24975H21.8994V9.24975ZM22.3284 9.24975H21.3284V9.61303H22.3284H23.3284V9.24975H22.3284ZM22.3284 9.61303V8.61303H21.8994V9.61303V10.613H22.3284V9.61303ZM21.8994 9.61303H22.8994V9.24975H21.8994H20.8994V9.61303H21.8994Z" fill="black" fill-opacity="0.8" />
                </svg>
                <p>Drag your file(s) to start uploading</p>
                <p class="content-or">
                  <span class="content">or</span>
                  <span class="content-bg"></span>
                </p>
                <input type="file" name="attach_media[]" id="attach_media" accept="image/*" multiple />
                <input type="hidden" name="attached_images" id="attached_images" value="">
              </div>

              <ul id="preview-container"></ul>

              <input type="hidden" id="current_post_id" value="<?php echo get_the_ID(); ?>">
              <button type="button" id="upload-btn">Upload</button>
            </div>

            <?php wp_nonce_field('claim_fintech_profile', 'claim_fintech_profile_nonce'); ?>
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
          <h2>Your claim has been submitted</h2>
          <p>You will be notified via email about the status of your submission.</p>
          <a href="btn">Back to browsing</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
get_footer();
