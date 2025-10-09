<?php
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}

// Check if user can edit fintech profiles
if (!current_user_can('edit_fintech_profiles')) {
  wp_die(__('You do not have permission to access this page.', 'fintech-profiler'));
}

get_header();
?>

<div class="container">
  <div class="row">
    <form method="post" enctype="multipart/form-data" class="fp-form">
      <?php wp_nonce_field('create_fintech_profile', 'create_fintech_profile_nonce'); ?>
      <input type="hidden" id="currentPage" name=" currentPage" value="1">
      <div class="fp-row reversed">
        <div class="fp-submit-buttons">
          <button type="button" class="button" id="prevBtn" disabled>Previous</button>
          <button type="button" class="button" id="skipBtn">Skip</button>
          <button type="button" class="button" id="nextBtn">Next</button>
          <button type="submit" name="create_fintech_profile" id="fp-submit-btn" class="button button-primary" style="display: none;">Create Profile</button>

        </div>
      </div>
      <div class="fp-page" id="fp-page-1">
        <div class="fp-row">
          <div class="fp-col-6">
            <span class="form-pagination">1/4</span>
            <h2>Lets set up your account</h2>
            <p>Complete your profile with accurate and up-to-date information to ensure maximum visibility and credibility.</p>
          </div>
          <div class="fp-col-6">
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
            <p>
              <label for="company_name">Company Name</label>
              <input type="text" name="company_name" id="company_name" placeholder="Enter company name">
            </p>
            <p>
              <label for="website_link">Website Link</label>
              <input type="text" name="website_link" id="website_link" placeholder="Enter website link">
            </p>
            <p>
              <label for="founded_in">Founded in</label>
              <input type="number" name="founded_in" id="founded_in">
            </p>
            <p>
              <label for="company_size">Company Size</label>
              <select name="company_size" id="company_size">
                <option value="">Select Size</option>
                <option value="small">Small</option>
                <option value="medium">Medium</option>
                <option value="large">Large</option>
              </select>
            </p>
            <p>
              <label for="slogan"> Slogan <span>(opt.)</span></label>
              <input type="text" name="slogan" id="slogan" placeholder="Enter company slogan">
            </p>
            <hr />
            <p>
              <label for="services">What services do you offer?</label>
            <div class="sidebar-section category-filter">
              <?php
              $selected_cats = !empty($_GET['category']) ? (array) $_GET['category'] : [];

              $taxonomy = 'fintech-category';

              $selected_cats = !empty($_GET['category']) ? (array) $_GET['category'] : [];

              echo '<select class="multi-select" multiple="multiple" style="width:100%;" name="services" id="services" >';
              $terms = get_terms([
                'taxonomy'   => $taxonomy,
                'hide_empty' => false,
                'parent'     => 0
              ]);

              if (!empty($terms) && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                  $checked = in_array($term->slug, $selected_cats) ? 'checked' : '';
                  echo '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                }
              }
              echo '</select>';
              ?>

              <div class="sidebar-section category-filter">
                <?php
                $categories = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]);

                $selected_cats = !empty($_GET['category']) ? (array) $_GET['category'] : [];

                $terms = get_terms([
                  'taxonomy'   => $taxonomy,
                  'hide_empty' => false,
                  'parent'     => 0
                ]);

                if (!empty($terms) && !is_wp_error($terms)) {
                  echo '<ul>';
                  foreach ($terms as $term) {
                    $children = get_terms([
                      'taxonomy'   => $taxonomy,
                      'hide_empty' => false,
                      'parent'     => $term->term_id
                    ]);

                    $checked = in_array($term->slug, $selected_cats) ? 'checked' : '';

                    // Add class if has children
                    $li_class = !empty($children) ? 'has-children' : '';

                    echo '<li class="parent-list category-' . esc_html($term->slug) . ' ' . esc_attr($li_class) . '">';
                    echo '<label class="parent-label">' . esc_html($term->name) . '</label>';
                    // Recursively render children
                    if (!empty($children)) {
                      echo '<ul class="children">';
                      render_taxonomy_tree($taxonomy, $term->term_id, $selected_cats);
                      echo '</ul>';
                    }

                    echo '</li>';
                  }
                  echo '</ul>';
                }
                ?>
              </div>
            </div>
            </p>
          </div>
        </div>
      </div>

      <div class="fp-page" id="fp-page-2" style="display:none">
        <div class="fp-row">
          <div class="fp-col-6">
            <span class="">2/4</span>
            <h2>Overview and description</h2>
            <p>Write something about your company that clicks for the financial institutions</p>
          </div>
          <div class="fp-col-6">
            <p>
              <label for="objective_and_description">Overview and Description</label>
              <?php
              $content = '';
              $editor_id = 'objective_and_description';
              $settings = array(
                'textarea_name' => 'objective_and_description',
                'media_buttons' => false,
                'teeny'         => true,
                'quicktags'     => true,
                'textarea_rows' => 10,
                'editor_height' => 300,
              );
              wp_editor($content, $editor_id, $settings);
              ?>
            </p>

          </div>
        </div>
      </div>

      <div class="fp-page" id="fp-page-3" style="display:none">
        <div class="fp-row">
          <div class="fp-col-6">
            <span class="">3/4</span>
            <h2>Plans and Pricing Models</h2>
            <p>Mention the pricing models and plans your company offers</p>
          </div>
          <div class="fp-col-6">
            <h5>Pricing Plan</h5>
            <div id="pricing-plans-wrapper">
              <div class="pricing-plan-item">
                <p>
                  <button type="button" class="remove-plan button">x</button>
                </p>
                <p>
                  <label>Plan Type</label>
                  <input type="text" name="plan_type[]" placeholder="Name the plan">
                </p>
                <p>
                  <label>Description</label>
                  <input type="text" name="plan_description[]" placeholder="Plan benefits">
                </p>
                <p>
                  <label>Cost</label>
                  <input type="text" name="plan_cost[]" placeholder="Price">
                </p>
              </div>
            </div>
            <button type="button" id="add-pricing-plan" class="button">+ Add A Plan</button>
          </div>
        </div>
      </div>

      <div class="fp-page" id="fp-page-4" style="display:none">
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
              <select name="country" id="country">
                <option value="">Select country</option>
              </select>
            </p>
            <p>
              <label for="state">State <span>(opt.)</span></label>
              <select name="state" id="state">
                <option value="">Select state</option>
              </select>
            </p>

            <p>
              <label for="city">City <span>(opt.)</span></label>
              <input type="text" name="city" id="city" placeholder="Enter city">
            </p>
            <p>
              <label for="business_email">Business Email</label>
              <input type="text" name="business_email" id="business_email" placeholder="Enter business email">
            </p>

            <p>
              <label for="business_phone">Phone Number</label>
            <div class="phone-input">
              <input type="text" name="business_phone_code" id="business_phone_code" placeholder="+91">
              <input type="text" name="business_phone" id="business_phone" placeholder="Enter business Phone">
            </div>
            </p>
            <hr />
            <h4>Social Links</h4>
            <div class="fp-social-links">
              <p>
                <label for="linkedin_url">Linkedin Url</label>
                <input type="text" name="linkedin_url" id="linkedin_url">
              </p>
              <p>
                <label for="x_url">x Url</label>
                <input type="text" name="x_url" id="x_url">
              </p>
              <p>
                <label for="instagram_url">Instagram Url</label>
                <input type="text" name="instagram_url" id="instagram_url">
              </p>
              <p>
                <label for="facebook_url">Facebook Url</label>
                <input type="text" name="facebook_url" id="facebook_url">
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
            <div id="case-studies-wrapper">
              <div class="case-study-item">
                <p>
                  <label>Case Title</label>
                  <input type="text" name="case_title[]" placeholder="Case title">
                </p>
                <p>
                  <label>Case Link</label>
                  <input type="text" name="case_link[]" placeholder="Case link">
                </p>
                <button type="button" class="remove-case button">x</button>
              </div>
            </div>
            <button type="button" id="add-case-study" class="button">+ Add More</button>
          </div>
        </div>
      </div>
    </form>
    <div class="fintech-welcome-notice-holder">
      <div class="fintech-welcome-notice">
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
