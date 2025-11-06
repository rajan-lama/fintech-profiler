 <?php get_header();

  if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
  }
  ?>

 <div class="finx-wrapper">

   <?php
    include(FINTECH_PROFILER_BASE . '/template-helper/sidebar.php');
    ?>

   <!-- MAIN CONTENT -->
   <main class="finx-main">
     <!-- Breadcrumb - will be updated dynamically -->
     <div class="finx-breadcrumb" id="dynamic-breadcrumb">
       <img src="https://jamesw705.sg-host.com/wp-content/uploads/2025/10/tag-2.png" alt="Icon" class="breadcrumb-icon">
       <span class="breadcrumb-plan">Plans</span>
       <span class="breadcrumb-separator"> / </span>
       <span class="breadcrumb-payment">Payment</span>
     </div>

     <?php
      $dashboards = array('dashboard', 'general-info', 'get-started', 'overview', 'images-and-videos', 'pricing-plans', 'case-studies', 'contact-info',  'plans-and-payments');

      foreach ($dashboards as $dashboard) {
        include(FINTECH_PROFILER_BASE . '/template-helper/' . $dashboard . '.php');
      }
      ?>

   </main>
 </div>

 <!-- Popup Structure (Hidden by Default) -->
 <div class="popup-overlay" id="paymentPopup">
   <div class="popup-box">
     <img src="https://jamesw705.sg-host.com/wp-content/uploads/2025/10/Icon-3.png" alt="Success Icon" class="popup-icon">
     <h2>Congratulations!</h2>
     <p>Your monthly subscription has been activated</p>
     <button class="popup-btn" id="closePopupBtn">Great! Take me back to the Dashboard</button>
   </div>
 </div>
 <!-- Upload Modal -->
 <div class="modal fade upload-modal" id="uploadModal" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content">
       <h5 class="mb-3">Upload Images & Videos</h5>
       <p>
         Choose files to upload
       </p>

       <div class="upload-dropzone mb-3" id="dropzone">
         <img src="https://jamesw705.sg-host.com/wp-content/uploads/2025/11/Icon-7.png" alt="Upload Icon" class="upload-icon">
         <p class="mb-1 fw-semibold">Drag your file(s) to start uploading</p>
         <p class="text-muted small mb-2">OR</p>
         <button class="btn btn-outline-secondary btn-sm" id="browseFiles">Browse files</button>
         <p class="text-muted small mt-2">Only supports .jpg, .png, .svg and MP4 files</p>
         <input type="file" id="fileInput" hidden>
       </div>

       <div id="fileList"></div>

       <div class="d-flex justify-content-end mt-4">
         <button class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
         <button class="btn btn-primary" id="uploadBtn">Upload</button>
       </div>
     </div>
   </div>
 </div>

 <?php get_footer(); ?>