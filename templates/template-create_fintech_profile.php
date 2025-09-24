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
            <p>
              <label for="founded_in">Founded in</label>
              <input type="number" name="founded_in" id="founded_in" required>
            </p>
            <p>
              <label for="company_size">Company Size</label>
              <select name="company_size" id="company_size" required>
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
              <label for="slogan"> Slogan <span>(opt.)</span></label>
              <input type="text" name="slogan" id="slogan" placeholder="Enter company slogan">
            </p>
            <hr />
            <p>
              <label for="services">What services do you offer?</label>
            <div class="sidebar-section category-filter">
              <?php
              $selected_cats = !empty($_GET['category']) ? (array) $_GET['category'] : [];

              $taxonomy = 'category';

              $selected_cats = !empty($_GET['category']) ? (array) $_GET['category'] : [];

              echo '<select class="multi-select" multiple="multiple" style="width:100%;" name="services" id="services" required>';
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
            <div id="pricing-plans-wrapper">
              <div class="pricing-plan-item">
                <p>
                  <label>Plan Type</label>
                  <input type="text" name="plan_type[]" placeholder="Name the plan" required>
                </p>
                <p>
                  <label>Description</label>
                  <input type="text" name="plan_description[]" placeholder="Plan benefits" required>
                </p>
                <p>
                  <label>Cost</label>
                  <input type="text" name="plan_cost[]" placeholder="Price" required>
                </p>
                <button type="button" class="remove-plan button">Remove</button>
              </div>
            </div>
            <button type="button" id="add-pricing-plan" class="button">+ Add Another Plan</button>
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
              <select name="country" id="country" required>
                <option value="">Select country</option>
              </select>
            </p>
            <p>
              <label for="state">State <span>(opt.)</span></label>
              <select name="state" id="state" required>
                <option value="">Select state</option>
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

            <p>
              <label for="business_phone">Phone Number</label>
            <div class="phone-input">
              <input type="text" name="business_phone_code" id="business_phone_code" placeholder="+91" required>
              <input type="text" name="business_phone" id="business_phone" placeholder="Enter business Phone" required>
            </div>
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
            <div id="case-studies-wrapper">
              <div class="case-study-item">
                <p>
                  <label>Case Title</label>
                  <input type="text" name="case_title[]" placeholder="Case title" required>
                </p>
                <p>
                  <label>Case Link</label>
                  <input type="text" name="case_link[]" placeholder="Case link" required>
                </p>
                <button type="button" class="remove-case button">Remove</button>
              </div>
            </div>
            <button type="button" id="add-case-study" class="button">+ Add More</button>
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
