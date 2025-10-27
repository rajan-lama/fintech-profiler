jQuery(function ($) {
  $("#company_logo").on("change", function () {
    var file_data = this.files[0];
    if (!file_data) return;

    // Preview instantly (local)
    if (file_data.type.startsWith("image/")) {
      var objectUrl = URL.createObjectURL(file_data);
      $("#logo-preview").attr("src", objectUrl);
    }

    // Prepare FormData for AJAX upload
    var formData = new FormData();
    formData.append("action", "upload_company_logo");
    formData.append("company_logo", file_data);
    formData.append("_wpnonce", fp_media.nonce); // pass nonce for security

    $.ajax({
      url: fp_media.ajaxurl, // localized admin-ajax.php
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        if (response.success) {
          // Replace preview with uploaded WordPress URL
          $("#logo-preview").attr("src", response.data.url);
        } else {
          alert("Upload failed: " + response.data);
        }
      },
    });
  });
});

jQuery(document).ready(function ($) {
  const dropArea = $("#drop-area");
  const fileInput = $("#attach_media");
  const previewContainer = $("#preview-container");
  let filesList = [];

  // Enable sorting
  previewContainer.sortable({
    items: ".image-preview",
    update: function () {
      saveOrderToMeta();
    },
  });

  // Remove previous bindings
  dropArea.off();
  fileInput.off();

  dropArea.on("click", function (e) {
    if (!$(e.target).is("#attach_media")) {
      fileInput.trigger("click");
    }
  });

  fileInput.on("change", function (e) {
    handleFiles(e.target.files);
  });

  dropArea.on("dragover", function (e) {
    e.preventDefault();
    e.stopPropagation();
    dropArea.addClass("dragover");
  });

  dropArea.on("dragleave", function (e) {
    e.preventDefault();
    e.stopPropagation();
    dropArea.removeClass("dragover");
  });

  dropArea.on("drop", function (e) {
    e.preventDefault();
    e.stopPropagation();
    dropArea.removeClass("dragover");
    handleFiles(e.originalEvent.dataTransfer.files);
  });

  // Show previews and add to files list
  // function handleFiles(files) {
  //   Array.from(files).forEach((file, index) => {
  //     if (!file.type.startsWith("image/")) return;
  //     filesList.push(file);

  //     // Calculate size in KB
  //     const sizeKB = (file.size / 1024).toFixed(2);

  //     // Generate formatted current date (e.g., 26 Oct 2025)
  //     const now = new Date();
  //     const formattedDate = now.toLocaleDateString("en-GB", {
  //       day: "2-digit",
  //       month: "short",
  //       year: "numeric",
  //     });

  //     console.log(formattedDate);

  //     // Calculate the row index (based on already added files)
  //     const currentIndex = $(".sortable-table-body tr").length + 1;

  //     const reader = new FileReader();
  //     reader.onload = (e) => {
  //       // Preview list
  //       const li = $(`
  //       <li class="image-preview" data-temp="true">
  //         <div class="image-info-holder">
  //           <div class="image-holder">
  //             <img src="${e.target.result}" alt="${file.name}">
  //           </div>
  //           <div class="image-title">
  //             <span class="title">${file.name}</span>
  //             <span class="image-size">${sizeKB} KB</span>
  //           </div>
  //         </div>
  //         <div class="progress-bar"></div>
  //         <button class="remove-image">&times;</button>
  //       </li>
  //     `);

  //       // Table row
  //       const tablelist = $(`
  //       <tr id="row-${currentIndex}">
  //         <td class="handle-cell">
  //           <img class="drag-handle" draggable="false" src="${fintech_ajax.site_url}/public/img/double-elipse.png" alt="drag" />
  //         </td>
  //         <td>${currentIndex}</td>
  //         <td>${file.name}</td>
  //         <td>${formattedDate}</td>
  //         <td>${sizeKB} KB</td>
  //         <td>
  //           <a href="#"><img src="${fintech_ajax.site_url}/public/img/download-01.png" alt="download"></a>
  //           <span style="padding:10px;"></span>
  //           <a href="delete"><img src="${fintech_ajax.site_url}/public/img/trash-04.png" alt="delete"></a>
  //         </td>
  //       </tr>
  //     `);

  //       previewContainer.append(li);
  //       $(".sortable-table-body").append(tablelist);
  //     };
  //     reader.readAsDataURL(file);
  //   });
  // }

  function handleFiles(files) {
    // capture current number of rows before we start adding this batch
    const startIndex = $(".sortable-table-body tr").length;
    const now = new Date();
    const formattedDate = now.toLocaleDateString("en-GB", {
      day: "2-digit",
      month: "short",
      year: "numeric",
    });

    Array.from(files).forEach((file, batchIndex) => {
      if (!file.type.startsWith("image/")) return;

      // Push into filesList (if you rely on filesList for uploads)
      filesList.push(file);

      // Calculate size in KB
      const sizeKB = (file.size / 1024).toFixed(2);

      // Compute a stable index for this file in the current batch
      // startIndex is how many rows existed before this batch;
      // batchIndex (0-based) gives the offset inside this batch.
      const currentIndex = startIndex + batchIndex + 1;

      const reader = new FileReader();
      reader.onload = (e) => {
        const li = $(`
        <li class="image-preview" data-temp="true">
          <div class="image-info-holder">
            <div class="image-holder">
              <img src="${e.target.result}" alt="${file.name}">
            </div>
            <div class="image-title">
              <span class="title">${file.name}</span>
              <span class="image-size">${sizeKB} KB</span>
            </div>
          </div>
          <div class="progress-bar"></div>
          <button class="remove-image">&times;</button>
        </li>
      `);

        const tablelist = $(`
        <tr id="row-${currentIndex}">
          <td class="handle-cell">
            <img class="drag-handle" draggable="false" src="${fintech_ajax.site_url}/public/img/double-elipse.png" alt="drag" />
          </td>
          <td>${currentIndex}</td>
          <td>${file.name}</td>
          <td>${formattedDate}</td>
          <td>${sizeKB} KB</td>
          <td>
            <a href="#"><img src="${fintech_ajax.site_url}/public/img/download-01.png" alt="download"></a>
            <span style="padding:10px;"></span>
            <a href="delete"><img src="${fintech_ajax.site_url}/public/img/trash-04.png" alt="delete"></a>
          </td>
        </tr>
      `);

        previewContainer.append(li);
        $(".sortable-table-body").append(tablelist);
      };

      reader.readAsDataURL(file);
    });
  }

  // Upload files
  $("#upload-btn").on("click", function () {
    if (filesList.length === 0) {
      alert("Please select at least one image!");
      return;
    }

    const postID = $("#current_post_id").val();
    filesList.forEach((file, index) => {
      const formData = new FormData();
      formData.append("action", "upload_documents");
      formData.append("post_id", postID);
      formData.append("attach_media[]", file);

      const previewItem = previewContainer
        .find(".image-preview[data-temp='true']")
        .eq(index);
      const progressBar = previewItem.find(".progress-bar");

      $.ajax({
        xhr: function () {
          const xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress", function (e) {
            if (e.lengthComputable) {
              const percent = (e.loaded / e.total) * 100;
              progressBar.css("width", percent + "%");
            }
          });
          return xhr;
        },
        url: fp_media.ajaxurl,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          if (response.success) {
            const url = response.data.files[0];
            previewItem.attr("data-url", url).attr("data-temp", "false");
            progressBar.css("width", "100%");
            setTimeout(() => progressBar.fadeOut(300), 400);
          }
          console.log(response);
        },
      });
    });

    filesList = [];
  });

  // Remove uploaded image
  $(document).on("click", ".remove-image", function (e) {
    e.preventDefault();
    const imageDiv = $(this).closest(".image-preview");
    const imageURL = imageDiv.data("url");
    const postID = $("#current_post_id").val();

    // Just remove preview if not uploaded yet
    if (imageDiv.attr("data-temp") === "true") {
      imageDiv.remove();
      return;
    }

    $.ajax({
      url: fp_media.ajaxurl,
      type: "POST",
      data: {
        action: "remove_uploaded_image",
        image_url: imageURL,
        post_id: postID,
      },
      success: function (response) {
        if (response.success) {
          imageDiv.fadeOut(300, function () {
            $(this).remove();
            saveOrderToMeta();
          });
        }
      },
    });
  });

  // Save image order in post meta
  function saveOrderToMeta() {
    const postID = $("#current_post_id").val();
    const orderedURLs = [];
    previewContainer.find(".image-preview").each(function () {
      const url = $(this).data("url");
      if (url) orderedURLs.push(url);
    });

    $.ajax({
      url: fp_media.ajaxurl,
      type: "POST",
      data: {
        action: "update_image_order",
        post_id: postID,
        order: orderedURLs,
      },
    });
  }
});

jQuery(document).ready(function ($) {
  $(".btn-submit-claim").on("submit", function (e) {
    // Collect all image URLs
    let imageUrls = [];
    $("#preview-container .image-preview").each(function () {
      let url = $(this).data("url");
      if (url) imageUrls.push(url);
    });

    // Store in hidden field as JSON or comma-separated list
    $("#attached_images").val(imageUrls.join(","));
  });

  $(".btn-save").on("submit", function (e) {
    // Collect all image URLs
    let imageUrls = [];
    $("#preview-container .image-preview").each(function () {
      let url = $(this).data("url");
      if (url) imageUrls.push(url);
    });

    console.log(url);

    // Store in hidden field as JSON or comma-separated list
    $("#attached_images").val(imageUrls.join(","));
  });
});

jQuery(document).ready(function ($) {
  $("#btn-multiple-upload").on("click", function (e) {
    e.preventDefault();
    $("#upload-modal").fadeIn();
  });

  $("#browse-files").on("click", function () {
    $("#file-input").trigger("click");
  });

  // File input change
  $("#file-input").on("change", function (e) {
    handleFiles(e.target.files);
  });

  // Drag & drop area
  $("#drop-zone")
    .on("dragover", function (e) {
      e.preventDefault();
      $(this).addClass("dragover");
    })
    .on("dragleave", function () {
      $(this).removeClass("dragover");
    })
    .on("drop", function (e) {
      e.preventDefault();
      $(this).removeClass("dragover");
      handleFiles(e.originalEvent.dataTransfer.files);
    });

  function handleFiles(files) {
    $.each(files, function (i, file) {
      uploadFile(file);
    });
  }

  function uploadFile(file) {
    let formData = new FormData();
    formData.append("action", "fintech_upload_media");
    formData.append("file", file);

    // $.ajax({
    //   url: fp_media.ajaxUrl,
    //   type: "POST",
    //   data: formData,
    //   processData: false,
    //   contentType: false,
    //   success: function (response) {
    //     // if (response.success) {
    //     //   let url = response.data.url;
    //     //   $("#upload-preview").append(
    //     //     '<img src="' + url + '" style="width:100px;margin:5px;">'
    //     //   );
    //     //   // Optionally, append to CMB2 group via hidden field
    //     //   $(
    //     //     '<input type="hidden" name="fintech_profiler_slides[][slide_image]" value="' +
    //     //       url +
    //     //       '">'
    //     //   ).appendTo("#upload-preview");
    //     // } else {
    //     //   alert("Upload failed: " + response.data.message);
    //     // }
    //   },
    //   error: function () {
    //     alert("Upload error");
    //   },
    // });
  }
});

jQuery(document).ready(function ($) {
  var $uploader = $("#upload-section"); // original element

  $("#btn-close").on("click", function () {
    $(".fp-modal").hide();
  });

  $("#btn-multiple-upload").on("click", function () {
    $(".fp-modal").show();
  });

  $(document).on("click", ".fp-modal", function (e) {
    // If clicked directly on the modal (not its children)
    if ($(e.target).closest(".fp-modal-content").length === 0) {
      $(".fp-modal").hide();
    }
  });
});

jQuery(document).ready(function ($) {
  // Make tbody sortable, only via .drag-handle
  $("#sortable-body")
    .sortable({
      items: "> tr", // only rows
      handle: ".drag-handle", // drag only by this selector
      placeholder: "ui-sortable-placeholder",
      helper: function (e, tr) {
        // clone helper and keep column widths
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.addClass("ui-sortable-helper");
        $helper.children().each(function (index) {
          // set helper td widths same as original to prevent column jump
          $(this).width($originals.eq(index).width());
        });
        return $helper;
      },
      start: function (e, ui) {
        // optional: ensure placeholder has same height as current row
        ui.placeholder.height(ui.item.outerHeight());
      },
      update: function (e, ui) {
        // new order by row ids
        var order = $(this).sortable("toArray");
        console.log("New order:", order);
        // Example: send AJAX to save order on server
        // $.post(ajaxurl, { action: 'save_order', order: order }, function(resp){ console.log(resp); });
      },
    })
    .disableSelection();
});
