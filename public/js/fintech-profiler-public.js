(function ($) {
  "use strict";

  /**
   * All of the code for your public-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */
})(jQuery);


/*** Custom JS */

jQuery(document).ready(function($) {
  // Tab switching functionality
  $('.finx-nav-links li').on('click', function() {
    // Remove active class from all tabs
    $('.finx-nav-links li').removeClass('active');
    
    // Add active class to clicked tab
    $(this).addClass('active');
    
    // Get the tab id from data attribute
    var tabId = $(this).data('tab');
    
    // Hide all tab content
    $('.finx-tab-content').removeClass('active');
    
    // Show the selected tab content
    $('#' + tabId + '-tab').addClass('active');
    
    // Update breadcrumb based on active tab
    updateBreadcrumb(tabId);
  });

  // Function to update breadcrumb based on active tab
  function updateBreadcrumb(tabId) {
    var breadcrumbHtml = '';
    
    switch(tabId) {
      case 'dashboard':
        breadcrumbHtml = `
          <img src="https://jamesw705.sg-host.com/wp-content/uploads/2025/10/star-01.png" alt="Icon" class="breadcrumb-icon">
          <span class="breadcrumb-payment">Dashboard</span>
        `;
        break;
    case 'general-info':
breadcrumbHtml = `
<div class="finx-breadcrumb-wrapper">
  <div class="finx-breadcrumb-left">
    <img src="https://jamesw705.sg-host.com/wp-content/uploads/2025/10/information-circle-contained.png" alt="Icon" class="breadcrumb-icon">
    <span class="breadcrumb-payment">General Info</span>
  </div>
  <div class="finx-breadcrumb-right">
    <button class="finx-btn-cancel">Preview</button>
    <button class="finx-btn-save">Save Changes</button>
  </div>
</div>
`;
break;

    case 'overview':
breadcrumbHtml = `
  <div class="finx-breadcrumb-wrapper">
    <div class="finx-breadcrumb-left">
      <img src="https://jamesw705.sg-host.com/wp-content/uploads/2025/10/file-02.png" alt="Icon" class="breadcrumb-icon">
      <span class="breadcrumb-payment">Overview</span>
    </div>
    <div class="finx-breadcrumb-right">
      <button class="finx-btn-cancel">Preview</button>
      <button class="finx-btn-save">Save Changes</button>
    </div>
  </div>
`;
break;
  case 'images-videos':
breadcrumbHtml = `
<div class="finx-breadcrumb-wrapper">
  <div class="finx-breadcrumb-left">
    <img src="https://jamesw705.sg-host.com/wp-content/uploads/2025/10/camera-02.png" alt="Icon" class="breadcrumb-icon">
    <span class="breadcrumb-payment">Images & Videos</span>
  </div>
  <div class="finx-breadcrumb-right">
    <button class="finx-btn-cancel">Preview</button>
    <button class="finx-btn-save">Save Changes</button>
  </div>
</div>
`;
break;
      case 'pricing-plans':
        breadcrumbHtml = `
          <img src="https://jamesw705.sg-host.com/wp-content/uploads/2025/10/tag-1.png" alt="Icon" class="breadcrumb-icon">
          <span class="breadcrumb-payment">Pricing Plans</span>
        `;
        break;
    case 'case-studies':
breadcrumbHtml = `
<div class="finx-breadcrumb-wrapper">
  <div class="finx-breadcrumb-left">
    <img src="https://jamesw705.sg-host.com/wp-content/uploads/2025/11/book-02-1.png" alt="Icon" class="breadcrumb-icon">
    <span class="breadcrumb-payment">Case Studies & Demo</span>
  </div>
  <div class="finx-breadcrumb-right">
    <button class="finx-btn-cancel">Preview</button>
    <button class="finx-btn-save">Save Changes</button>
  </div>
</div>
`;
break;
    case 'contact-info':
  breadcrumbHtml = `
    <div class="finx-breadcrumb-wrapper">
      <div class="finx-breadcrumb-left">
        <img src="https://jamesw705.sg-host.com/wp-content/uploads/2025/11/send-01-1.png" alt="Icon" class="finx-breadcrumb-icon">
        <span class="finx-breadcrumb-payment">Contact Info</span>
      </div>
      <div class="finx-breadcrumb-right">
        <button class="finx-btn-cancel">Preview</button>
        <button class="finx-btn-save">Save Changes</button>
      </div>
    </div>
  `;
  break;
      case 'plans-payment':
        breadcrumbHtml = `
          <img src="https://jamesw705.sg-host.com/wp-content/uploads/2025/10/tag-2.png" alt="Icon" class="breadcrumb-icon">
          <span class="breadcrumb-plan">Plans</span>
          <span class="breadcrumb-separator"> / </span>
          <span class="breadcrumb-payment">Payment</span>
        `;
        break;
      default:
        breadcrumbHtml = `
          <img src="https://jamesw705.sg-host.com/wp-content/uploads/2025/10/tag-2.png" alt="Icon" class="breadcrumb-icon">
          <span class="breadcrumb-payment">${tabId}</span>
        `;
    }
    
    $('#dynamic-breadcrumb').html(breadcrumbHtml);
  }

  // Show popup when Confirm Payment is clicked
  $(".finx-confirm-btn").on("click", function(e) {
    e.preventDefault(); // Prevent default (remove if not needed)
    $("#paymentPopup").fadeIn(300).addClass("show");
  });

  // Close popup on button click
  $("#closePopupBtn").on("click", function() {
    $("#paymentPopup").fadeOut(200, function() {
      $(this).removeClass("show");
    });
  });

  // Close popup when clicking outside the box
  $("#paymentPopup").on("click", function(e) {
    if ($(e.target).is("#paymentPopup")) {
      $(this).fadeOut(200, function() {
        $(this).removeClass("show");
      });
    }
  });

  // Billing toggle functionality for Pricing Plans tab
  $("#billingToggle").on("change", function() {
    if ($(this).is(":checked")) {
      // Yearly billing selected
      $(".finx-plan-price").each(function() {
        var monthlyPrice = $(this).text().replace('$', '');
        var yearlyPrice = monthlyPrice * 12 * 0.8; // 20% discount
        $(this).text('$' + yearlyPrice.toFixed(0));
      });
      $(".finx-plan-period").text("per year");
    } else {
      // Monthly billing selected
      $(".finx-plan-price").each(function() {
        var yearlyPrice = $(this).text().replace('$', '');
        var monthlyPrice = yearlyPrice / 12 / 0.8; // Reverse calculation
        $(this).text('$' + monthlyPrice.toFixed(0));
      });
      $(".finx-plan-period").text("per month");
    }
  });
});


const toggle = document.getElementById('billingToggle');
toggle.addEventListener('change', function() {
  const isYearly = this.checked;
  document.querySelectorAll('.price-switch').forEach(el => {
    const monthly = el.getAttribute('data-monthly');
    const yearly = el.getAttribute('data-yearly');
    if (isYearly) {
      el.innerHTML = `$${yearly} <span class="fs-6 fw-normal">/Yearly</span>`;
    } else {
      el.innerHTML = `$${monthly} <span class="fs-6 fw-normal">/Monthly</span>`;
    }
  });
});


  // Add more demo fields
  document.getElementById("addDemo").addEventListener("click", function () {
    const demoContainer = document.getElementById("demoFields");
    const newField = document.createElement("input");
    newField.type = "text";
    newField.className = "form-control mb-2";
    newField.placeholder = "myawesomecompany.com/demo";
    demoContainer.appendChild(newField);
  });


  $(document).ready(function() {
    $('#addCase').click(function() {
      var newCaseField = `
        <div class="caseField p-3 mb-2 border rounded">
          <div class="row g-2 mb-2">
            <div class="col-12">
              <label class="form-label small text-muted">Title</label>
              <input type="text" class="form-control" placeholder="Name the plan">
            </div>
            <div class="col-12">
              <label class="form-label small text-muted">Link</label>
              <input type="text" class="form-control" placeholder="Plan benefits">
            </div>
          </div>
        </div>
      `;
      $('#caseContainer').append(newCaseField);
    });
  });


$(document).ready(function() {
    $('.service-option').on('change', function() {
        const value = $(this).val();
        const selectedBox = $('#selected-services');

        if ($(this).is(':checked')) {
            // Add tag if checked
            if (selectedBox.find(`[data-value="${value}"]`).length === 0) {
                const tag = $(`<div class="multi-tag" data-value="${value}">${value} <span>&times;</span></div>`);
                selectedBox.append(tag);
            }
        } else {
            // Remove tag if unchecked
            selectedBox.find(`[data-value="${value}"]`).remove();
        }
    });

    // Remove tag and uncheck box when × clicked
    $('#selected-services').on('click', 'span', function() {
        const tag = $(this).closest('.multi-tag');
        const value = tag.data('value');
        tag.remove();
        $(`.service-option[value="${value}"]`).prop('checked', false);
    });
});


$(document).ready(function(){
    // Trigger file input when button is clicked
    $('#uploadButton').click(function(){
        $('#companyImageInput').click();
    });

    // Preview uploaded image
    $('#companyImageInput').on('change', function(e){
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#companyImagePreview').attr('src', e.target.result).removeClass('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            alert('Please upload a valid image file (.jpg, .png, .svg)');
        }
    });
});

<!-- Initialize Quill -->

  var quill = new Quill('#editor', {
    theme: 'snow',
    placeholder: 'Introduce your company...',
    modules: {
      toolbar: [
        [{ header: [1, 2, false] }],
        ['bold', 'italic', 'underline'],
        ['blockquote', 'code-block'],
        [{ list: 'ordered' }, { list: 'bullet' }],
        ['link'],
        ['clean']
      ]
    }
  });


$(document).ready(function () {
  var file;

  // Open modal
  $(".finx-media-upload-btn").click(function () {
    $("#uploadModal").modal("show");
  });

  // Browse file
  $("#browseFiles").click(function () {
    $("#fileInput").click();
  });

  // Handle file select
  $("#fileInput").change(function (e) {
    file = e.target.files[0];
    if (file) {
      $("#fileList").html(`
        <div class="upload-file-info">
          <div>
            <strong>${file.name}</strong><br>
            <small>${(file.size / 1024 / 1024).toFixed(2)} MB</small>
          </div>
          <button class="btn btn-sm btn-link text-danger p-0" id="removeFile">✕</button>
        </div>
        <div class="upload-progress mt-2">
          <div class="upload-progress-bar" id="uploadProgressBar"></div>
        </div>
        <div class="small text-muted mt-1" id="uploadStatus">Waiting to upload...</div>
      `);
    }
  });

  // Remove file
  $(document).on("click", "#removeFile", function () {
    $("#fileList").empty();
    $("#fileInput").val("");
    file = null;
  });

  // Simulated upload progress with time remaining
  $("#uploadBtn").click(function () {
    if (!file) {
      alert("Please select a file first.");
      return;
    }

    var progress = 0;
    var uploadSpeedMBps = 0.2; // Simulated upload speed: 0.2 MB per second
    var totalMB = file.size / 1024 / 1024; // File size in MB
    var totalSeconds = totalMB / uploadSpeedMBps; // Total simulated upload time in seconds
    var elapsedSeconds = 0;

    $("#uploadStatus").text(`Uploading... ${totalMB.toFixed(2)} MB`);

    var interval = setInterval(function () {
      elapsedSeconds += 0.2; // increment elapsed time (interval is 200ms)
      progress += (0.2 / totalSeconds) * 100; // progress percentage
      if (progress > 100) progress = 100;

      // Update progress bar
      $("#uploadProgressBar").css("width", progress + "%");

      // Calculate remaining time
      var remainingSeconds = totalSeconds - elapsedSeconds;
      if (remainingSeconds < 0) remainingSeconds = 0;

      // Update status text
      $("#uploadStatus").text(`${totalMB.toFixed(2)} MB • ${remainingSeconds.toFixed(1)} sec remaining`);

      // Complete
      if (progress >= 100) {
        clearInterval(interval);
        $("#uploadStatus").text(`Upload complete! ${totalMB.toFixed(2)} MB`);
      }
    }, 200); // 200ms interval
  });
});