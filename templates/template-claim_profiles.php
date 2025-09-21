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
          <button type="submit" name="submit_profile" id="fp-submit-btn" class="button button-primary" style="display: none;">Proceed</button>

        </div>
      </div>
      <div class="fp-page" id="fp-page-1">
        <div class="fp-row">
          <div class="fp-col-6">
            <span class="form-pagination">
              <==>
            </span>
            <h2>Account Verification </h2>
            <p>Upload necessary documents and information and we will verify your account to claim</p>
          </div>
          <div class="fp-col-6">
            <p>
              <label for="existing_profile">Existing Profile</label>
              <span class="desc">Provide link to existing profile in FinExplore 360 that you want to claim</span>
              <input type="text" name="existing_profile" id="existing_profile" placeholder="finexplore360.com/profile" required>
            </p>
            <hr />

            <p>
            <h4>Website Link</h4>
            <span class="desc">Provide link to your existing website</span>
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
              <input type="file" name="attach_media" id="attach_media" accept="image/*" required>
              <input type="hidden" name="action" value="upload_company_logo">
            </p>
          </div>
        </div>
      </div>

      <div class="fp-page" id="fp-page-2">
        <div class="fp-row">
          <div class="fp-col-6">
            <span class="">2/4</span>
            <h2>Overview and description</h2>
            <p>Write something about your company that clicks for the financial institutions</p>
          </div>
          <div class="fp-col-6">
            <p>
              <label for="objective_and_description">Company Name</label>
              <textarea cols="30" rows="10" name="objective_and_description" id="objective_and_description" placeholder="Enter company Description" required></textarea>
            </p>
          </div>
        </div>
      </div>

      <div class="fp-page" id="fp-page-3">
        <div class="fp-row">
          <div class="fp-col-6">
            <span class="">3/4</span>
            <h2>Plans and Pricing Models</h2>
            <p>Mention the pricing models and plans your company offers</p>
          </div>
          <div class="fp-col-6">
            <p>
              <label for="plan_type">Plan Type</label>
              <input type="text" name="plan_type" id="plan_type" placeholder="Name the plan" required>
            </p>
            <p>
              <label for="description">Description</label>
              <input type="text" name="description" id="description" placeholder="Plan benefits" required>
            </p>
            <p>
              <label for="cost">Cost</label>
              <input type="text" name="cost" id="cost" placeholder="Price" required>
            </p>
          </div>
        </div>
      </div>

      <div class="fp-page" id="fp-page-4">
        <div class="fp-row">
          <div class="fp-col-6">
            <span class="">4/4</span>
            <h2>Demo, Case study and Contact information</h2>
            <p>Add some final information and we are good to go</p>
          </div>
          <div class="fp-col-6">
            <h4 for="company_size">Contact Information</h4>
            <p>
              <label for="country">Country</label>
              <select name="country" id="country" required>
                <option value="">Select Size</option>
                <option value="1-10">1-10</option>
                <option value="11-50">11-50</option>
                <option value="51-200">51-200</option>
                <option value="201-500">201-500</option>
                <option value="501-1000">501-1000</option>
                <option value="1001+">1001+</option>
              </select>
            </p>
            <p>
              <label for="state">State <span>(opt.)</span></label>
              <select name="state" id="state" required>
                <option value="">Select Size</option>
                <option value="1-10">1-10</option>
                <option value="11-50">11-50</option>
                <option value="51-200">51-200</option>
                <option value="201-500">201-500</option>
                <option value="501-1000">501-1000</option>
                <option value="1001+">1001+</option>
              </select>
            </p>

            <p>
              <label for="city">City <span>(opt.)</span></label>
              <input type="text" name="city" id="city" placeholder="Enter city" required>
            </p>
            <p>
              <label for="business_email">Business Email</label>
              <input type="text" name="business_email" id="business_email" placeholder="Enter business email" required>
            </p>
            <hr />
            <h4>Social Links</h4>
            <div class="fp-social-links">
              <p>
                <label for="linkedin_url">Linkedin Url</label>
                <input type="text" name="linkedin_url" id="linkedin_url" required>
              </p>
              <p>
                <label for="x_url">x Url</label>
                <input type="text" name="x_url" id="x_url" required>
              </p>
              <p>
                <label for="instagram_url">Instagram Url</label>
                <input type="text" name="instagram_url" id="instagram_url" required>
              </p>
              <p>
                <label for="facebook_url">Facebook Url</label>
                <input type="text" name="facebook_url" id="facebook_url" required>
              </p>
            </div>
            <p>
              <label for="demo">Demo</label>
            <p>Do you offer demo?</p>
            <input type="radio" id="yes" name="demo" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="demo" value="no">
            <label for="no">No</label><br>
            </p>

            <p>
              <label for="demo_link"> Demo Link</span></label>
              <input type="text" name="demo_link" id="demo_link" placeholder="example.com">
            </p>
            <hr />

            <h4>Case Study</h4>
            <div class="fp-social-links">
              <p>
                <label for="case_title">Title</label>
                <input type="text" name="case_title" id="case_title" required>
              </p>
              <p>
                <label for="case_link">Link</label>
                <input type="text" name="case_link" id="case_link" required>
              </p>
            </div>
            <button type="button" class="button">Add More</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<?php
get_footer();
