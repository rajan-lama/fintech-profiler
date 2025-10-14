<?php
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}

// Check if user can edit financial profiles
if (!current_user_can('edit_fintech_profiles')) {
  wp_die(__('You do not have permission to access this page.', 'fintech-profiler'));
}

get_header();
?>
<div class="dashboard-container full-width">
  <div class="dashboard-row">
    <div class="has-left-sidebar">
      <div id="tabs">
        <div class="left-sidebar">
          <?php
          the_custom_logo();
          ?>
          <div class="menu-holder">
            <ul>

              <li>
                <a href="#tabs-1">
                  <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.89102 2.17056C10.272 1.14106 11.7281 1.14106 12.109 2.17056L14.0051 7.2947C14.1249 7.61837 14.3801 7.87356 14.7038 7.99333L19.8279 9.88944C20.8574 10.2704 20.8574 11.7265 19.8279 12.1074L14.7038 14.0035C14.3801 14.1233 14.1249 14.3785 14.0051 14.7022L12.109 19.8263C11.7281 20.8558 10.272 20.8558 9.89102 19.8263L7.99492 14.7022C7.87515 14.3785 7.61996 14.1233 7.29629 14.0035L2.17215 12.1074C1.14265 11.7265 1.14265 10.2704 2.17215 9.88944L7.29629 7.99333C7.61996 7.87356 7.87515 7.61837 7.99492 7.2947L9.89102 2.17056Z" stroke="#8943E2" stroke-opacity="0.8" stroke-width="2" stroke-linejoin="round" />
                  </svg>
                  Get Started</a>
              </li>
              <li>
                <a href="#tabs-0">
                  <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.89102 2.17056C10.272 1.14106 11.7281 1.14106 12.109 2.17056L14.0051 7.2947C14.1249 7.61837 14.3801 7.87356 14.7038 7.99333L19.8279 9.88944C20.8574 10.2704 20.8574 11.7265 19.8279 12.1074L14.7038 14.0035C14.3801 14.1233 14.1249 14.3785 14.0051 14.7022L12.109 19.8263C11.7281 20.8558 10.272 20.8558 9.89102 19.8263L7.99492 14.7022C7.87515 14.3785 7.61996 14.1233 7.29629 14.0035L2.17215 12.1074C1.14265 11.7265 1.14265 10.2704 2.17215 9.88944L7.29629 7.99333C7.61996 7.87356 7.87515 7.61837 7.99492 7.2947L9.89102 2.17056Z" stroke="#8943E2" stroke-opacity="0.8" stroke-width="2" stroke-linejoin="round" />
                  </svg>
                  Dashboard</a>
              </li>
              <li>
                <a href="#tabs-2">
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 10L10 14.5M10 6.66455V6.625M1 10C1 5.02944 5.02944 1 10 1C14.9706 1 19 5.02944 19 10C19 14.9706 14.9706 19 10 19C5.02944 19 1 14.9706 1 10Z" stroke="black" stroke-opacity="0.8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  General Info</a>
              </li>
              <li>
                <a href="#tabs-3">
                  <svg width="18" height="22" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.4002 6.19844H12.6002M5.4002 9.79844H12.6002M5.4002 13.3984H9.0002M3.59992 1.39844H14.4001C15.7256 1.39844 16.8002 2.47298 16.8001 3.79848L16.7999 18.1985C16.7998 19.524 15.7253 20.5984 14.3999 20.5984L3.59982 20.5984C2.27433 20.5984 1.19982 19.5239 1.19983 18.1984L1.19992 3.79842C1.19993 2.47295 2.27444 1.39844 3.59992 1.39844Z" stroke="black" stroke-opacity="0.8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  Overview</a>
              </li>
              <li>
                <a href="#tabs-4">
                  <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.40002 16.1205V3.88047H0.400024V16.1205H2.40002ZM3.80002 2.48047H18.2V0.480469H3.80002V2.48047ZM19.6 3.88047V16.1205H21.6V3.88047H19.6ZM19.6 16.1205C19.6 16.8937 18.9732 17.5205 18.2 17.5205V19.5205C20.0778 19.5205 21.6 17.9982 21.6 16.1205H19.6ZM18.2 2.48047C18.9732 2.48047 19.6 3.10727 19.6 3.88047H21.6C21.6 2.0027 20.0778 0.480469 18.2 0.480469V2.48047ZM2.40002 3.88047C2.40002 3.10727 3.02682 2.48047 3.80002 2.48047V0.480469C1.92226 0.480469 0.400024 2.0027 0.400024 3.88047H2.40002ZM3.80002 17.5205C3.02683 17.5205 2.40002 16.8937 2.40002 16.1205H0.400024C0.400024 17.9982 1.92226 19.5205 3.80002 19.5205V17.5205ZM13.6 10.0006C13.6 11.4365 12.436 12.6006 11 12.6006V14.6006C13.5405 14.6006 15.6 12.5411 15.6 10.0006H13.6ZM11 12.6006C9.56408 12.6006 8.40002 11.4365 8.40002 10.0006H6.40002C6.40002 12.5411 8.45951 14.6006 11 14.6006V12.6006ZM8.40002 10.0006C8.40002 8.56465 9.56408 7.40059 11 7.40059V5.40059C8.45951 5.40059 6.40002 7.46008 6.40002 10.0006H8.40002ZM11 7.40059C12.436 7.40059 13.6 8.56465 13.6 10.0006H15.6C15.6 7.46008 13.5405 5.40059 11 5.40059V7.40059ZM18.2 17.5205H3.80002V19.5205H18.2V17.5205Z" fill="black" fill-opacity="0.8" />
                  </svg>
                  Images & videos</a>
              </li>
              <li>
                <a href="#tabs-5">
                  <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.354 6.65092L15.3476 6.65089M18.5226 1.84983L12.7222 1.40365C12.2079 1.36409 11.7021 1.55122 11.3374 1.91593L1.91751 11.3358C1.22753 12.0258 1.22753 13.1444 1.9175 13.8344L8.16405 20.081C8.85402 20.7709 9.97269 20.7709 10.6627 20.081L20.0825 10.6611C20.4472 10.2964 20.6344 9.79052 20.5948 9.27627L20.1486 3.47591C20.0818 2.60704 19.3914 1.91667 18.5226 1.84983Z" stroke="black" stroke-opacity="0.8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  Pricing Plans</a>
              </li>
              <li>
                <a href="#tabs-6">
                  <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7257 18.2267V3.41525M10.7257 18.2267L9.26826 16.7692C8.44525 15.9462 7.32949 15.4838 6.16557 15.4838H2.49621C1.89028 15.4838 1.40002 14.9926 1.40002 14.3867V2.86667C1.40002 2.26074 1.89123 1.76953 2.49717 1.76953H6.71365C7.87757 1.76953 8.99382 2.2319 9.81683 3.05491L10.7257 3.96382L11.6346 3.05491C12.4577 2.2319 13.5739 1.76953 14.7378 1.76953H19.5029C20.1088 1.76953 20.6 2.26074 20.6 2.86667V14.3867C20.6 14.9926 20.1088 15.4838 19.5029 15.4838H15.2864C14.1225 15.4838 13.0062 15.9462 12.1832 16.7692L10.7257 18.2267Z" stroke="black" stroke-opacity="0.8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  Case Studies & Demo</a>
              </li>
              <li>
                <a href="#tabs-7">
                  <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20.0704 1.92802L9.40647 12.592M2.27112 7.2337L18.877 1.47247C19.8996 1.11768 20.8808 2.09881 20.526 3.12144L14.7648 19.7273C14.3701 20.865 12.7726 20.8961 12.3338 19.7748L9.69691 13.0361C9.56521 12.6995 9.29894 12.4333 8.96238 12.3016L2.22366 9.66466C1.10232 9.22587 1.13351 7.62839 2.27112 7.2337Z" stroke="black" stroke-opacity="0.8" stroke-width="2" stroke-linecap="round" />
                  </svg>
                  Contact Info</a>
              </li>
              <li>
                <a href="#tabs-8">
                  <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.354 6.65092L15.3476 6.65089M18.5226 1.84983L12.7222 1.40365C12.2079 1.36409 11.7021 1.55122 11.3374 1.91593L1.91751 11.3358C1.22753 12.0258 1.22753 13.1444 1.9175 13.8344L8.16405 20.081C8.85402 20.7709 9.97269 20.7709 10.6627 20.081L20.0825 10.6611C20.4472 10.2964 20.6344 9.79052 20.5948 9.27627L20.1486 3.47591C20.0818 2.60704 19.3914 1.91667 18.5226 1.84983Z" stroke="black" stroke-opacity="0.8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>Plans & Payment</a>
              </li>
            </ul>
            <div class="footer-profile-info">
              <div class="footer-thumbnail"><img src="<?php echo FINTECH_PROFILER_BASE_URL; ?>/public/img/company-logo.png" /></div>
              <div class="footer-info">
                <h4 class="footer-info-header">My Awesome Company</h4>
                <span class="truncate-text">myawesomecomapny@email.com</span>
              </div>
              <div class="footer-chevron">
                <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1 1L6 6L1 11" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>

              </div>
            </div>
          </div>
        </div>
        <div class="main-sidebar">
          <div id="tabs-1">
            <div class="dashboard-white-space"></div>
            <div class="dashboard-page-body">
              <div class="fp-dashboard-icon">
                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M16.891 9.17056C17.272 8.14106 18.7281 8.14106 19.109 9.17056L21.0051 14.2947C21.1249 14.6184 21.3801 14.8736 21.7038 14.9933L26.8279 16.8894C27.8574 17.2704 27.8574 18.7265 26.8279 19.1074L21.7038 21.0035C21.3801 21.1233 21.1249 21.3785 21.0051 21.7022L19.109 26.8263C18.7281 27.8558 17.272 27.8558 16.891 26.8263L14.9949 21.7022C14.8752 21.3785 14.62 21.1233 14.2963 21.0035L9.17215 19.1074C8.14265 18.7265 8.14265 17.2704 9.17215 16.8894L14.2963 14.9933C14.62 14.8736 14.8752 14.6184 14.9949 14.2947L16.891 9.17056Z" fill="white" />
                </svg>
              </div>

              <div class="dashboard-page-title-holder">
                <h2>
                  Let Get Started
                </h2>
                <p>Follow the steps below to setup your profile and unlock dashboard for more insights for your company profile</p>
              </div>

              <div class="profile-getting-started">
                <div class="dashboard-page-section-title">
                  <h2>Complete Your Profile</h2>
                  <p>A complete profile attracts 72% more financial institutions</p>

                  <div class="progress-holder">
                    <span class="progress-label">1/4 Steps Completed</span>
                    <div class="progress-container">
                      <div class="progress-bar"></div>
                    </div>
                  </div>
                </div>

                <div id="accordion">
                  <h6>Overview and Description</h6>
                  <div>
                    <p>Introduce your company to financial institutions along with information about services you offer, multimedias etc</p>
                    <a href="#" class="btn btn-primary">Proceed</a>
                  </div>
                  <h6>Images and Videos</h6>
                  <div>
                    <p>Upload media to showcase your product</p>
                    <a href="#" class="btn btn-primary">Proceed</a>
                  </div>
                  <h6>Plans and Pricing Models</h6>
                  <div>
                    <p>Define the plans you offer with accurate pricing models</p>
                    <a href="#" class="btn btn-primary">Proceed</a>

                  </div>
                  <h6>Contact Information and Socials</h6>
                  <div>
                    <p>Information needed to reach out to you</p>
                    <a href="#" class="btn btn-primary">Proceed</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="tabs-2">
            <div class="dashboard-page-title">
              <h2>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M10 10L10 14.5M10 6.66455V6.625M1 10C1 5.02944 5.02944 1 10 1C14.9706 1 19 5.02944 19 10C19 14.9706 14.9706 19 10 19C5.02944 19 1 14.9706 1 10Z" stroke="black" stroke-opacity="0.8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>General Info
              </h2>
              <div class="dashboard-button-holder">
                <button class="btn btn-secondary btn-preview" id="btn-preview">Preview</button>
                <button class="btn btn-primary btn-save" id="btn-save">Save Changes</button>
              </div>
            </div>
            <div class="dashboard-page-body">
              <div class="dashboard-page-header">
                <h5>Basic Information</h5>
                <p>The most basic required information needed to qualify for listing</p>
              </div>
              <div class="dashboard-page-sections">
                <div class="dashboard-section" id="company-logo">
                  <div class="dashboard-left">
                    <label for="attach_media">Company Profile Picture</label>
                  </div>
                  <div class="dashboard-right">
                    <div class="fp-logo-upload">
                      <div class="fp-logo-preview">
                        <img src="<?php echo FINTECH_PROFILER_BASE_URL . '/public/img/fallback-img.png'; ?>" id="logo-preview" />
                      </div class="fp-logo-btn">
                      <div class="fp-logo-file-input">
                        <input type="file" name="company_logo" id="company_logo" accept="image/*">
                        <input type="hidden" name="action" value="upload_company_logo">
                        <span>Supports .jpg, .png and .svg and zip files</span>
                      </div>
                      <!-- </div>
                    <img src="http://jamesw705.sg-host.com/wp-content/uploads/2025/09/Frame-1707480130.png" />
                    <input type="file" name="attach_media" id="attach_media" accept="image/*">
                    <input type="hidden" name="action" value="upload_company_logo"> -->
                    </div>
                  </div>
                </div>
                <div class="dashboard-section" id="basic-info">
                  <div class="dashboard-left">
                    <label for="attach_media">Basic Information</label>
                  </div>
                  <div class="dashboard-right">
                    <p>
                      <label for="company_name">Company Name</label>
                      <input type="text" name="company_name" id="company_name" placeholder="Enter company name">
                    </p>
                    <p>
                      <label for="website_link">Website Link</label>
                      <input type="text" name="website_link" id="website_link" placeholder="Enter website link">
                    </p>
                    <div class="fp-col-2">
                      <p class="fp-container">
                        <label for="founded_in">Founded in</label>
                        <input type="number" name="founded_in" id="founded_in">
                      </p>
                      <p class="fp-container">
                        <label for="company_size">Company Size</label>
                        <select name="company_size" id="company_size">
                          <option value="">Select Size</option>
                          <option value="small">Small</option>
                          <option value="medium">Medium</option>
                          <option value="large">Large</option>
                        </select>
                      </p>
                    </div>
                    <p>
                      <label for="slogan"> Slogan <span>(opt.)</span></label>
                      <input type="text" name="slogan" id="slogan" placeholder="Enter company slogan">
                    </p>
                  </div>
                </div>

                <div class="dashboard-section" id="services-provided">
                  <div class="dashboard-left">
                    <label for="attach_media">Services Provided</label>
                  </div>
                  <div class="dashboard-right">
                    <p>
                      <label for="services">What services do you offer?</label>
                    </p>
                    <div class="sidebar-section category-filter">
                      <?php
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
                    <!-- <div>
                        <p>
                          <label for="services">What services do you offer?</label>
                        </p>
                        <select name="services" id="services" class="services-selector">
                          <option value="">Select Size</option>
                        </select>
                      </div>
                      <P>Category selection checkbox</P> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="tabs-3">
            <div class="dashboard-page-title">
              <h2>
                <svg width="18" height="22" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M5.4002 6.19844H12.6002M5.4002 9.79844H12.6002M5.4002 13.3984H9.0002M3.59992 1.39844H14.4001C15.7256 1.39844 16.8002 2.47298 16.8001 3.79848L16.7999 18.1985C16.7998 19.524 15.7253 20.5984 14.3999 20.5984L3.59982 20.5984C2.27433 20.5984 1.19982 19.5239 1.19983 18.1984L1.19992 3.79842C1.19993 2.47295 2.27444 1.39844 3.59992 1.39844Z" stroke="black" stroke-opacity="0.8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Overview
              </h2>
              <div class="dashboard-button-holder">
                <button class="btn-preview" id="btn-preview">Preview</button>
                <button class="btn-save" id="btn-save">Save Changes</button>
              </div>
            </div>
            <div class="dashboard-page-body">
              <div class="dashboard-page-header">
                <h5>Describe your Company</h5>
                <p>Write something about your company that clicks for the financial institutions</p>
              </div>
              <div class="dashboard-page-sections">
                <div class="dashboard-section" id="objective-and-description">
                  <div class="dashboard-left">
                    <label for="attach_media">About</label>
                    <p>What is company does, services, advantages and key features you provide</p>
                  </div>
                  <div class="dashboard-right">
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
                      'placeholder'   => "Enter company Description",
                    );
                    wp_editor($content, $editor_id, $settings);
                    ?>
                  </div>
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div id="tabs-4">
            <div class="dashboard-page-title">
              <h2>
                <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M2.40002 16.1205V3.88047H0.400024V16.1205H2.40002ZM3.80002 2.48047H18.2V0.480469H3.80002V2.48047ZM19.6 3.88047V16.1205H21.6V3.88047H19.6ZM19.6 16.1205C19.6 16.8937 18.9732 17.5205 18.2 17.5205V19.5205C20.0778 19.5205 21.6 17.9982 21.6 16.1205H19.6ZM18.2 2.48047C18.9732 2.48047 19.6 3.10727 19.6 3.88047H21.6C21.6 2.0027 20.0778 0.480469 18.2 0.480469V2.48047ZM2.40002 3.88047C2.40002 3.10727 3.02682 2.48047 3.80002 2.48047V0.480469C1.92226 0.480469 0.400024 2.0027 0.400024 3.88047H2.40002ZM3.80002 17.5205C3.02683 17.5205 2.40002 16.8937 2.40002 16.1205H0.400024C0.400024 17.9982 1.92226 19.5205 3.80002 19.5205V17.5205ZM13.6 10.0006C13.6 11.4365 12.436 12.6006 11 12.6006V14.6006C13.5405 14.6006 15.6 12.5411 15.6 10.0006H13.6ZM11 12.6006C9.56408 12.6006 8.40002 11.4365 8.40002 10.0006H6.40002C6.40002 12.5411 8.45951 14.6006 11 14.6006V12.6006ZM8.40002 10.0006C8.40002 8.56465 9.56408 7.40059 11 7.40059V5.40059C8.45951 5.40059 6.40002 7.46008 6.40002 10.0006H8.40002ZM11 7.40059C12.436 7.40059 13.6 8.56465 13.6 10.0006H15.6C15.6 7.46008 13.5405 5.40059 11 5.40059V7.40059ZM18.2 17.5205H3.80002V19.5205H18.2V17.5205Z" fill="black" fill-opacity="0.8" />
                </svg>
                Images & Videos
              </h2>
              <div class="dashboard-button-holder">
                <button class="btn-preview" id="btn-preview">Preview</button>
                <button class="btn-save" id="btn-save">Save Changes</button>
              </div>
            </div>
            <div class="dashboard-page-body">

              <div class="dashboard-page-sections">
                <div class="dashboard-section" id="multimedia-upload">
                  <div class="dashboard-left">
                    <div class="top-section">
                      <label for="attach_media">Upload Multimedia</label>
                      <p>Add images and videos of your product giving glimpses of your service and stand out</p>
                    </div>
                    <div class="bottom-section">
                      <span>Limited to 1 video and 4 images</span>
                      <button class="btn btn-primary btn-upload" id="btn-upload">Upload files</button>
                    </div>
                  </div>
                  <div class="dashboard-right">
                    <div class="image-holder">
                      <img src="<?php echo FINTECH_PROFILER_BASE_URL; ?>/public/img/fallback-image.png" />
                    </div>
                  </div>
                </div>
                <div class="dashboard-section has-table" id="multimedia-table">
                  <h5>Upload Multimedia</h5>
                  <p>Uploaded files will be shown in order in the detail page </p>

                  <table>
                    <thead>
                      <tr>
                        <td></td>
                        <td>No.</td>
                        <td>File Name</td>
                        <td>Up. Date</td>
                        <td>Size</td>
                        <td>Actions</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <img src="<?php echo FINTECH_PROFILER_BASE_URL; ?>/public/img/double-elipse.png" />
                        </td>
                        <td>1</td>
                        <td>Cover-Video.mp4</td>
                        <td>24 Jan 2025</td>
                        <td>12.8 MB</td>
                        <td><a href="#"><img src="<?php echo FINTECH_PROFILER_BASE_URL; ?>/public/img/download-01.png" /></a><span style="padding:10px;"></span><a href="delete"><img src="<?php echo FINTECH_PROFILER_BASE_URL; ?>/public/img/trash-04.png" /></a></td>
                      </tr>
                      <tr>
                        <td>
                          <img src="<?php echo FINTECH_PROFILER_BASE_URL; ?>/public/img/double-elipse.png" />
                        </td>
                        <td>2.</td>
                        <td>Cover-Video.mp4</td>
                        <td>24 Jan 2025</td>
                        <td>12.8 MB</td>
                        <td><a href="#"><img src="<?php echo FINTECH_PROFILER_BASE_URL; ?>/public/img/download-01.png" /></a><span style="padding:10px;"></span><a href="delete"><img src="<?php echo FINTECH_PROFILER_BASE_URL; ?>/public/img/trash-04.png" /></a></td>
                      </tr>
                      <tr>
                        <td>
                          <img src="<?php echo FINTECH_PROFILER_BASE_URL; ?>/public/img/double-elipse.png" />
                        </td>
                        <td>3.</td>
                        <td>Cover-Video.mp4</td>
                        <td>24 Jan 2025</td>
                        <td>12.8 MB</td>
                        <td><a href="#"><img src="<?php echo FINTECH_PROFILER_BASE_URL; ?>/public/img/download-01.png" /></a><span style="padding:10px;"></span><a href="delete"><img src="<?php echo FINTECH_PROFILER_BASE_URL; ?>/public/img/trash-04.png" /></a></td>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div id="tabs-5">
            <div class="dashboard-page-title">
              <h2>
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15.354 6.65092L15.3476 6.65089M18.5226 1.84983L12.7222 1.40365C12.2079 1.36409 11.7021 1.55122 11.3374 1.91593L1.91751 11.3358C1.22753 12.0258 1.22753 13.1444 1.9175 13.8344L8.16405 20.081C8.85402 20.7709 9.97269 20.7709 10.6627 20.081L20.0825 10.6611C20.4472 10.2964 20.6344 9.79052 20.5948 9.27627L20.1486 3.47591C20.0818 2.60704 19.3914 1.91667 18.5226 1.84983Z" stroke="black" stroke-opacity="0.8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Pricing Plans
              </h2>
              <div class="dashboard-button-holder">
                <button class="btn-preview" id="btn-preview">Preview</button>
                <button class="btn-save" id="btn-save">Save Changes</button>
              </div>
            </div>
            <div class="dashboard-page-body">

              <div class="dashboard-page-sections">
                <div class="dashboard-section" id="pricing-plan-info">
                  <div class="dashboard-left">
                    <div>
                      <label for="attach_media">Plans and Pricing Models</label>
                      <p>Mention the pricing models and plans your company offers</p>
                    </div>
                  </div>
                  <div class="dashboard-right">
                    <img src="<?php echo FINTECH_PROFILER_BASE_URL; ?>/public/img/fallback-image.png" />
                  </div>
                </div>
                <div class="dashboard-section" id="pricing-plan-link">
                  <div class="dashboard-left">
                    <div class="left">
                      <label>Link to Pricing Page</label>
                      <p>For cases of unsynced information.</p>
                    </div>
                    <div class="right"></div>
                  </div>
                  <div class="dashboard-right">
                    <p>
                      <input type="text" name="pricing_plan_link" id="pricing_plan_link">
                    </p>
                  </div>
                </div>
                <div class="dashboard-section" id="pricing-model">
                  <div class="dashboard-left">
                    <label>Pricing Model</label>
                  </div>
                  <div class="dashboard-right">
                    <p>
                      <input type="checkbox" id="free_trial" name="pricing_model" value="Bike">
                      <label for="free_trial"> Free Trail</label><br>
                      <input type="checkbox" id="subscription_based" name="pricing_model" value="Car">
                      <label for="subscription_based"> Subscription-Based</label><br>
                      <input type="checkbox" id="freemium" name="pricing_model" value="Boat">
                      <label for="freemium"> Freemium</label><br>
                    </p>
                  </div>
                </div>
                <div class="dashboard-section" id="pricing-plan-description">
                  <div class="dashboard-left">
                    <label>Description</label>
                  </div>
                  <div class="dashboard-right">
                    <?php
                    $content = '';
                    $editor_id = 'pricing_plan_description';
                    $settings = array(
                      'textarea_name' => 'pricing_plan_description',
                      'media_buttons' => false,
                      'teeny'         => true,
                      'quicktags'     => true,
                      'textarea_rows' => 5,
                      'editor_height' => 150,
                      'placeholder'   => "Enter company Description",
                    );
                    wp_editor($content, $editor_id, $settings);
                    ?>
                  </div>
                </div>
                <div class="dashboard-section" id="pricing-plans-repeater">
                  <div class="dashboard-left">
                    <label>Pricing Plans</label>
                  </div>
                  <div class="dashboard-right">
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
                    <button type="button" id="add-pricing-plan" class="button btn-tertiary">+ Add A Plan</button>

                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="tabs-6">
            <div class="dashboard-page-title">
              <h2>Case Studies & Demos</h2>
              <div class="dashboard-button-holder">
                <button class="btn-preview" id="btn-preview">Preview</button>
                <button class="btn-save" id="btn-save">Save Changes</button>
              </div>
            </div>
            <div class="dashboard-page-body">

              <div class="dashboard-page-sections">
                <div class="dashboard-section" id="case-study-and-demo">
                  <div class="dashboard-left">
                    <div class="dashboard-header-info">
                      <label for="attach_media">Showcase your Product</label>
                      <p>Help your users to decide why they should choose you by showing your experiences</p>
                    </div>
                  </div>
                  <div class="dashboard-right">

                  </div>
                </div>
                <div class="dashboard-section" id="demo-link">
                  <div class="dashboard-left">
                    <label for="attach_media">Demo</label>
                  </div>
                  <div class="dashboard-right">
                    <label for="demo_link"> Demo Link</label>
                    <input type="text" name="demo_link" id="demo_link" placeholder="myawesomecompany.com/demo">
                    Repeater here
                  </div>
                </div>

                <div class="dashboard-section" id="case-study">
                  <div class="dashboard-left">
                    <label for="attach_media">Case Study</label>
                  </div>
                  <div class="dashboard-right">
                    <div id="case-studies-wrapper">
                      <div class="case-study-item">
                        <p>
                          <button type="button" class="remove-case button">x</button>
                        </p>
                        <p>
                          <label>Case Title</label>
                          <input type="text" name="case_title[]" placeholder="Case title">
                        </p>
                        <p>
                          <label>Case Link</label>
                          <input type="text" name="case_link[]" placeholder="Case link">
                        </p>
                      </div>
                    </div>
                    <button type="button" id="add-case-study" class="button">+ Add More</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="tabs-7">
            <div class="dashboard-page-title">
              <h2>Contact Information</h2>
              <div class="dashboard-button-holder">
                <button class="btn-preview" id="btn-preview">Preview</button>
                <button class="btn-save" id="btn-save">Save Changes</button>
              </div>
            </div>
            <div class="dashboard-page-body">

              <div class="dashboard-page-sections">
                <div class="dashboard-section" id="contact-info">
                  <div class="dashboard-left">
                    <div class="dashboard-header-info">
                      <label>How to Reach Out to You?</label>
                      <p>Help your users to decide why they should choose you by showing your experiences</p>
                    </div>
                  </div>
                  <div class="dashboard-right">

                  </div>
                </div>
                <div class="dashboard-section" id="contact-information">
                  <div class="dashboard-left">
                    <label for="attach_media">Contact Information</label>
                  </div>
                  <div class="dashboard-right">
                    <div class="fp-country-info">
                      <div class="fp-country">
                        <p>
                          <label for="country">Country</label>
                          <select name="country" id="country">
                            <option value="">Select country</option>
                          </select>

                        </p>
                      </div>
                      <div class="fp-state">
                        <p>
                          <label for="state">State <span>(opt.)</span></label>

                          <select name="state" id="state">
                            <option value="">Select state</option>
                          </select>
                        </p>
                      </div>

                    </div>

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
                    </p>
                    <div class="phone-input">
                      <input type="text" name="business_phone_code" id="business_phone_code" placeholder="+91">
                      <input type="text" name="business_phone" id="business_phone" placeholder="Enter business Phone">
                    </div>
                  </div>
                </div>

                <div class="dashboard-section" id="social-links">
                  <div class="dashboard-left">
                    <label for="attach_media">Socials</label>
                  </div>
                  <div class="dashboard-right">
                    <div class="fp-social-links">
                      <p>
                        <label for="linkedin_url">linkedin.com/ company/</label>
                        <input type="text" name="linkedin_url" id="linkedin_url" placeholder="Link">
                      </p>
                      <p>
                        <label for="x_url">x.com/</label>
                        <input type="text" name="x_url" id="x_url" placeholder="Link">
                      </p>
                      <p>
                        <label for="instagram_url">instagram.com/</label>
                        <input type="text" name="instagram_url" id="instagram_url" placeholder="Link">
                      </p>
                      <p>
                        <label for="facebook_url">facebook.com/</label>
                        <input type="text" name="facebook_url" id="facebook_url" placeholder="Link">
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="tabs-8">
            <div class="dashboard-page-title">
              <div class="dashboard-page-title-logo__holder">
                <h2>
                  <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.354 6.65092L15.3476 6.65089M18.5226 1.84983L12.7222 1.40365C12.2079 1.36409 11.7021 1.55122 11.3374 1.91593L1.91751 11.3358C1.22753 12.0258 1.22753 13.1444 1.9175 13.8344L8.16405 20.081C8.85402 20.7709 9.97269 20.7709 10.6627 20.081L20.0825 10.6611C20.4472 10.2964 20.6344 9.79052 20.5948 9.27627L20.1486 3.47591C20.0818 2.60704 19.3914 1.91667 18.5226 1.84983Z" stroke="black" stroke-opacity="0.8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>Plan
                </h2>
              </div>
            </div>
            <div class="dashboard-page-body" id="pricing-page">
              <div class="dashboard-page-sections" id="plans-info">
                <div class="dashboard-section" id="plan-page-title-desc">
                  <div class="dashboard-page-plan">
                    <h4>Checkout Membership Plans</h4>
                    <p>For added benefits and exclusive service</p>
                  </div>
                </div>

                <div class="dashboard-section" id="plans-type-selector">
                  <div class="dashboard-plan-type-selector">
                    <span>Monthly</span>
                    <label class="switch">
                      <input type="checkbox" id="toggle">
                      <span class="slider"></span>
                    </label>
                    <span>Yearly</span>
                  </div>
                </div>

                <div class="dashboard-section" id="plan-pricing-cards">
                  <div class="dashboard-basic-plan">
                    <div class="basic-plan-inner__holder">
                      <div class="basic-plan-heading__holder">
                        <p class="dashboard-plan-type__tag">Basic Plan</p>
                        <h2 class="dashboard-plan-type__pricing">Free</h2>
                        <p class="dashboard-page-plan-status">You are on Basic Plan</p>
                        <a href="<?php echo get_site_url(); ?>/fintech-dashboard/?add-to-cart=324" class="dashboard-page-plan-status">Upgrade</a>
                      </div>
                      <div class="basic-plan-content__holder">
                        <div class="dashboard-page-plan-includes">
                          <h3>Package includes:</h3>
                          <ul>
                            <li>Basic fintech directory access</li>
                            <li>Save up to 5 favorites</li>
                            <li>Messaging service up to 5 months</li>
                            <li>Basic profile listing and visibility</li>
                            <li>Free Articles and content access</li>
                          </ul>
                        </div>
                        <div class="dashboard-page-plan-excludes">
                          <h3>Not included:</h3>
                          <ul>
                            <li>No Analytics</li>
                            <li>No networking events</li>
                            <li>No dedicated support</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="dashboard-professional-plan">
                    <div class="plan-inner__holder">
                      <div class="plan-heading__holder">
                        <div class="dashboard-page-popular-plan-tag__holder">
                          <p class="dashboard-plan-type__tag">Professional Plan</p>
                          <p class="dashboard-popular-plan-type__tag">POPULAR</p>
                        </div>
                        <div class="dashboard-page-plan-price-duration__holder">
                          <h2 class="dashboard-plan-type__pricing">$99</h2><span class="pricing-renewal-duration"> / Yearly</span>
                        </div>
                        <a href="<?php echo get_site_url(); ?>/fintech-dashboard/?add-to-cart=325" class="dashboard-page-plan-status">Upgrade</a>
                      </div>
                      <div class="basic-plan-content__holder">
                        <div class="dashboard-page-plan-includes">
                          <h3>Package includes:</h3>
                          <ul>
                            <li>Enhanced fintech directory access</li>
                            <li>Save unlimited favorites</li>
                            <li>Unlimited Messaging service</li>
                            <li>Basic profile listing and visibility</li>
                            <li>Premium reports and content access</li>
                            <li>Basic engagement Data</li>
                            <li>Basic email support</li>
                          </ul>
                        </div>
                        <div class="dashboard-page-plan-excludes">
                          <h3>Not included:</h3>
                          <ul>
                            <li>No networking events</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="dashboard-premium-plan">
                    <div class="plan-inner__holder">
                      <div class="plan-heading__holder">
                        <p class="dashboard-plan-type__tag">Premium Plan</p>
                        <div class="dashboard-page-plan-price-duration__holder">
                          <h2 class="dashboard-plan-type__pricing">$149</h2><span class="pricing-renewal-duration"> / Yearly</span>
                        </div>
                        <a href="<?php echo get_site_url(); ?>/fintech-dashboard/?add-to-cart=326" class="dashboard-page-plan-status">Upgrade</a>
                      </div>
                      <div class="basic-plan-content__holder">
                        <div class="dashboard-page-plan-includes">
                          <h3>Package includes:</h3>
                          <ul>
                            <li>Featured fintech directory access</li>
                            <li>Save unlimited favorites</li>
                            <li>Unlimited Messaging service</li>
                            <li>Featured profile listing and visibility</li>
                            <li>Publish & showcase own articles</li>
                            <li>Custom reports</li>
                            <li>Account manager</li>
                          </ul>
                        </div>
                        <div class="dashboard-page-plan-premium-note">
                          <p>Includes everything with added 24/7 support</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="dashboard-page-body" id="checkout-page">
              <div class="dashboard-page-sections" id="plans-info">
                <div class="dashboard-section" id="plan-page-title-desc">
                  <div class="dashboard-page-plan">
                    <?php // echo do_shortcode('[fintech_checkout]'); 
                    ?>
                  </div>
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
