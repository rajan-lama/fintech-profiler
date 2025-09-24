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
<div class="container full-width">
  <div class="row">
    <div class="left-sidebar">
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Get Started</a></li>
          <li><a href="#tabs-2">General Info</a></li>
          <li><a href="#tabs-3">Overview</a></li>
          <li><a href="#tabs-4">Images & videos</a></li>
          <li><a href="#tabs-5">Pricing Plans</a></li>
          <li><a href="#tabs-6">Case Studies & Demo</a></li>
          <li><a href="#tabs-7">Contact Info</a></li>
          <li><a href="#tabs-8">Plans & Payment</a></li>
        </ul>
        <div id="tabs-1">
          <h2>Let Get Started</h2>
          <p>Follow the steps below to setup your profile and unlock dashboard for more insights for your company profile</p>

          <div class="profile-getting-started">
            <h2>Complete Your Profile</h2>
            <p>A complete profile attracts 72% more financial institutions</p>
            <span>1/4 Steps Completed</span>

            <div id="accordion">
              <h3>Overview and Description</h3>
              <div>
                <p>Introduce your company to financial institutions along with information about services you offer, multimedias etc</p>
                <a href="#">Proceed</a>
              </div>
              <h3>Images and Videos</h3>
              <div>
                <p>Upload media to showcase your product</p>
                <a href="#">Proceed</a>
              </div>
              <h3>Plans and Pricing Models</h3>
              <div>
                <p>Define the plans you offer with accurate pricing models</p>
                <a href="#">Proceed</a>

              </div>
              <h3>Contact Information and Socials</h3>
              <div>
                <p>Information needed to reach out to you</p>
                <a href="#">Proceed</a>
              </div>
            </div>
          </div>
        </div>
        <div id="tabs-2">
          <div class="dashboard-page-title">
            <h2>General Info</h2>
            <div class="dashboard-button-holder">
              <button class="btn-preview" id="btn-preview">Preview</button>
              <button class="btn-save" id="btn-save">Save Changes</button>
            </div>
          </div>
          <div class="dashboard-page-body">
            <div class="dashboard-page-header">
              <h3>Basic Information</h3>
              <p>The most basic required information needed to qualify for listing</p>
            </div>
            <div class="dashboard-page-sections">
              <div class="dashboard-section">
                <div class="dashboard-left">
                  <label for="attach_media">Company Profile Picture</label>
                </div>
                <div class="dashboard-right">
                  <input type="file" name="attach_media" id="attach_media" accept="image/*">
                  <input type="hidden" name="action" value="upload_company_logo">
                </div>
              </div>
              <div class="dashboard-section">
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
                  <p>
                    <label for="founded_in">Founded in</label>
                    <input type="number" name="founded_in" id="founded_in">
                  </p>
                  <p>
                    <label for="company_size">Company Size</label>
                    <select name="company_size" id="company_size">
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
                </div>
              </div>

              <div class="dashboard-section">
                <div class="dashboard-left">
                  <label for="attach_media">Services Provided</label>
                </div>
                <div class="dashboard-right">
                  <p>
                    <label for="services">What services do you offer?</label>
                    <select name="services" id="services">
                      <option value="">Select Size</option>
                      <option value="1-10">1-10</option>
                      <option value="11-50">11-50</option>
                      <option value="51-200">51-200</option>
                      <option value="201-500">201-500</option>
                      <option value="501-1000">501-1000</option>
                      <option value="1001+">1001+</option>
                    </select>
                  </p>
                  <P>Category selection checkbox</P>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div id="tabs-3">
          <div class="dashboard-page-title">
            <h2>Overview</h2>
            <div class="dashboard-button-holder">
              <button class="btn-preview" id="btn-preview">Preview</button>
              <button class="btn-save" id="btn-save">Save Changes</button>
            </div>
          </div>
          <div class="dashboard-page-body">
            <div class="dashboard-page-header">
              <h3>Describe your Company</h3>
              <p>Write something about your company that clicks for the financial institutions</p>
            </div>
            <div class="dashboard-page-sections">
              <div class="dashboard-section">
                <div class="dashboard-left">
                  <label for="attach_media">About</label>
                  <p>What is company does, services, advantages and key features you provide</p>
                </div>
                <div class="dashboard-right">
                  <textarea cols="30" rows="10" name="objective_and_description" id="objective_and_description" placeholder="Enter company Description"></textarea>
                </div>
                </p>
              </div>
            </div>
          </div>
        </div>
        <div id="tabs-4">
          <div class="dashboard-page-title">
            <h2>Images & Videos</h2>
            <div class="dashboard-button-holder">
              <button class="btn-preview" id="btn-preview">Preview</button>
              <button class="btn-save" id="btn-save">Save Changes</button>
            </div>
          </div>
          <div class="dashboard-page-body">

            <div class="dashboard-page-sections">
              <div class="dashboard-section">
                <div class="dashboard-left">
                  <label for="attach_media">Upload Multimedia</label>
                  <p>Add images and videos of your product giving glimpses of your service and stand out</p>

                  <span>Limited to 1 video and 4 images</span>
                  <button class="btn-upload" id="btn-upload">Preview</button>
                </div>
                <div class="dashboard-right">
                  <img src="#" />
                </div>
              </div>
              <div class="dashboard-section">
                <h4>Upload Multimedia</h4>
                <p>Uploaded files will be shown in order in the detail page </p>

                <table>
                  <thead>
                    <tr>
                      <td>No.</td>
                      <td>File Name</td>
                      <td>Up. Date</td>
                      <td>Size</td>
                      <td>Actions</td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>Cover-Video.mp4</td>
                      <td>24 Jan 2025</td>
                      <td>12.8 MB</td>
                      <td><a href="#">download</a><a href="delete">Delete</a></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div id="tabs-5">
          <div class="dashboard-page-title">
            <h2>Pricing Plans</h2>
            <div class="dashboard-button-holder">
              <button class="btn-preview" id="btn-preview">Preview</button>
              <button class="btn-save" id="btn-save">Save Changes</button>
            </div>
          </div>
          <div class="dashboard-page-body">

            <div class="dashboard-page-sections">
              <div class="dashboard-section">
                <div class="dashboard-left">
                  <label for="attach_media">Plans and Pricing Models</label>
                  <p>Mention the pricing models and plans your company offers</p>
                </div>
                <div class="dashboard-right">
                  <img src="#" />
                </div>
              </div>
              <div class="dashboard-section">
                <div class="dashboard-left">
                  <h4>Link to Pricing Page</h4>
                  <p>For cases of unsynced information.</p>
                </div>
                <div class="dashboard-right">
                  <p>
                    <input type="text" name="pricing_plan_link" id="pricing_plan_link">
                  </p>
                </div>
              </div>
              <div class="dashboard-section">
                <div class="dashboard-left">
                  <h4>Pricing Model</h4>
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
              <div class="dashboard-section">
                <div class="dashboard-left">
                  <h4>Description</h4>
                </div>
                <div class="dashboard-right">
                  <p>
                    <textarea cols="30" rows="10" name="pricing_plan_description" id="pricing_plan_description" placeholder="Enter company Description"></textarea>
                  </p>
                </div>
              </div>
              <div class="dashboard-section">
                <div class="dashboard-left">
                  <h4>Pricing Plans</h4>
                </div>
                <div class="dashboard-right">
                  <p>
                    We will have repeater here
                  </p>
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
              <div class="dashboard-section">
                <div class="dashboard-left">
                  <label for="attach_media">Showcase your Product</label>
                  <p>Help your users to decide why they should choose you by showing your experiences</p>
                </div>
                <div class="dashboard-right">

                </div>
              </div>
              <div class="dashboard-section">
                <div class="dashboard-left">
                  <label for="attach_media">Demo</label>
                </div>
                <div class="dashboard-right">
                  <label for="demo_link"> Demo Link</label>
                  <input type="text" name="demo_link" id="demo_link" placeholder="myawesomecompany.com/demo">
                  Repeater here
                </div>
              </div>

              <div class="dashboard-section">
                <div class="dashboard-left">
                  <label for="attach_media">Case Study</label>
                </div>
                <div class="dashboard-right">
                  <label for="demo_link"> Demo Link</label>
                  <div>
                    <input type="text" name="title" id="title">
                    <input type="text" name="link" id="link" placeholder="myawesomecompany.com/demo">
                  </div>
                  Repeater here
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
              <div class="dashboard-section">
                <div class="dashboard-left">
                  <h4>How to Reach Out to You?</h4>
                  <p>Help your users to decide why they should choose you by showing your experiences</p>
                </div>
                <div class="dashboard-right">

                </div>
              </div>
              <div class="dashboard-section">
                <div class="dashboard-left">
                  <label for="attach_media">Contact Information</label>
                </div>
                <div class="dashboard-right">
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
                    <input type="text" name="business_phone_code" id="business_phone" placeholder="+91">
                    <input type="text" name="business_phone" id="business_phone" placeholder="Enter business Phone">
                  </p>
                </div>
              </div>

              <div class="dashboard-section">
                <div class="dashboard-left">
                  <label for="attach_media">Socials</label>
                </div>
                <div class="dashboard-right">
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
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="main"></div>
    </div>
  </div>

  <?php
  get_footer();
