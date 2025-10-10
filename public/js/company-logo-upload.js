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
  function handleFiles(files) {
    Array.from(files).forEach((file) => {
      if (!file.type.startsWith("image/")) return;
      filesList.push(file);

      const reader = new FileReader();
      reader.onload = (e) => {
        const li = $(`
          <li class="image-preview" data-temp="true">
            <img src="${e.target.result}" alt="${file.name}">
            <div class="progress-bar"></div>
            <button class="remove-image">&times;</button>
          </li>
        `);
        previewContainer.append(li);
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
      formData.append("action", "upload_company_logo");
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
        url: ajaxurl,
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
      url: ajaxurl,
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
      url: ajaxurl,
      type: "POST",
      data: {
        action: "update_image_order",
        post_id: postID,
        order: orderedURLs,
      },
    });
  }
});
