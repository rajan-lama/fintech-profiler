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
    formData.append("_wpnonce", wpVars.nonce); // pass nonce for security

    $.ajax({
      url: wpVars.ajaxurl, // localized admin-ajax.php
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
