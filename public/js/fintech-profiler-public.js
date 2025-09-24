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

  document.addEventListener("DOMContentLoaded", function () {
    const btn = document.querySelector(".toggle-more");
    const after = document.querySelector(".content-after");

    if (btn && after) {
      btn.addEventListener("click", function () {
        if (after.style.display === "none") {
          after.style.display = "block";
          btn.textContent = "Show Less";
        } else {
          after.style.display = "none";
          btn.textContent = "Show More";
          window.scrollTo({
            top: document.querySelector(".content-before").offsetTop,
            behavior: "smooth",
          });
        }
      });
    }
  });

  $(function () {
    $("#tabs").tabs();
  });

  $(document).ready(function () {
    // Initialize select2 if not already
    $("#services").select2({
      placeholder: "Select Categories",
    });

    $(".parent-list").hide();

    // Function to sync and merge values
    function syncValues() {
      let select2Values = $("#services").val() || [];
      let checkboxValues = $('input[name="category[]"]:checked')
        .map(function () {
          return $(this).val();
        })
        .get();

      // Merge and remove duplicates
      let mergedValues = [...new Set([...select2Values, ...checkboxValues])];

      // Update Select2
      $("#services").val(mergedValues).trigger("change.select2");

      console.log("mergedValues:", mergedValues);
    }

    // Whenever select2 changes → sync
    $("#services").on("change", function () {
      syncValues();
      let selectedValues = $(this).val() || [];
      $(".parent-list").hide();
      selectedValues.forEach(function (val) {
        $(".category-" + val).show();
      });
    });

    // Whenever checkboxes change → sync
    $('input[name="category[]"]').on("change", function () {
      syncValues();
    });

    // On form submit → make sure values are synced
    $("form").on("submit", function () {
      syncValues();
    });
  });

  $(function () {
    var icons = {
      header: "ui-icon-circle-arrow-e",
      activeHeader: "ui-icon-circle-arrow-s",
    };
    $("#accordion").accordion({});
  });
})(jQuery);

jQuery(document).ready(function ($) {
  $(".fintech-carousel").owlCarousel({
    loop: true,
    margin: 16,
    nav: true,
    dots: false,
    // autoHeight: true,
    // autoplay: true,
    navText: [
      '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.6667 19L4 12M4 12L10.6667 5M4 12L20 12" stroke="black" stroke-opacity="0.4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
      '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.3333 5L20 12M20 12L13.3333 19M20 12L4 12" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
      // '<i class="fa fa-angle-left"></i>',
      // '<i class="fa fa-angle-right"></i>'
    ],
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 1,
      },
      1000: {
        items: 2,
      },
    },
  });

  $("#slider-range").slider({
    range: true,
    min: 0,
    max: 500,
    values: [75, 300],
    slide: function (event, ui) {
      //   $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
      $("#min_price").val("$" + ui.values[0]);
      $("#max_price").val("$" + ui.values[1]);
    },
  });

  //   $("#applyFilters").on("click", function (e) {
  //     e.preventDefault();
  //     $("#fintech-filter").submit();
  //   });

  //   jQuery("#postLink").on("click", function (e) {
  //     e.preventDefault();
  //     $("<form>", {
  //       method: "POST",
  //       action: "/submit.php",
  //     })
  //       .append(
  //         $("<input>", {
  //           type: "hidden",
  //           name: "id",
  //           value: "123",
  //         })
  //       )
  //       .appendTo("body")
  //       .submit();
  //   });

  //   jQuery(document).ready(function ($) {
  //     $("#fintech-filter").on("change", "input, select", function () {
  //       let formData = $("#fintech-filter").serialize();
  //       console.log(formData);

  //       $.ajax({
  //         url: fintech_ajax.ajax_url,
  //         type: "POST",
  //         data: {
  //           action: "fintech_filter",
  //           security: fintech_ajax.nonce,
  //           form: formData,
  //         },
  //         beforeSend: function () {
  //           $(".inner-row").html("<p>Loading...</p>");
  //         },
  //         success: function (response) {
  //           if (response.success) {
  //             $(".inner-row").html(response.data.html);
  //           } else {
  //             $(".inner-row").html("<p>No results found.</p>");
  //           }
  //         },
  //       });
  //     });
  //   });

  jQuery(document).ready(function ($) {
    $("#fintech-filter").on("click", function (e) {
      e.preventDefault();

      let formData = $("#fintech-filter-form").serialize();

      let searchVal = $("#archive-search").val();
      formData += "&search=" + encodeURIComponent(searchVal);

      $.ajax({
        url: fintech_ajax.ajax_url,
        type: "POST",
        data: {
          action: "fintech_filter",
          security: fintech_ajax.nonce,
          form: formData,
        },
        beforeSend: function () {
          $(".inner-row").html("<p>Loading...</p>");
        },
        success: function (response) {
          if (response.success) {
            $(".inner-row").html(response.data.html);
          } else {
            $(".inner-row").html("<p>No results found.</p>");
          }
        },
      });
    });
  });

  jQuery(document).ready(function ($) {
    $(".btn-getting-started").on("click", function () {
      $(".fp-hidden-field").toggleClass("show");
      // $(".fp-hidden-field.show").removeClass("show").addClass("hide");
    });

    // Toggle children on icon click
    $(document).on("click", ".toggle-icon", function () {
      var $icon = $(this);
      var $children = $icon.closest("li").children(".children");

      $children.slideToggle(200);

      $(this).closest("li").toggleClass("open");

      // Toggle icon direction
      // $icon.text($icon.text() === "▶" ? "▼" : "▶");
    });
  });

  jQuery(document).ready(function ($) {
    var countries = [];

    // Load JSON file
    $.getJSON(
      fintech_ajax.site_url + "public/img/countries.json",
      function (data) {
        countries = data;

        // Populate country dropdown
        $.each(countries, function (index, country) {
          $("#country").append(
            $("<option>", { value: country.code, text: country.name })
          );
        });
      }
    );

    // On country change → populate states
    $("#country").on("change", function () {
      var selectedCode = $(this).val();
      var country = countries.find((c) => c.code === selectedCode);

      $("#state").empty().append('<option value="">Select State</option>');
      if (country && country.states) {
        $.each(country.states, function (i, state) {
          $("#state").append(
            $("<option>", { value: state.name, text: state.name })
          );
        });
      }
    });
    // Example: countries.json data
    // var countries = [
    //   {
    //     name: "United States",
    //     phonecode: "+1",
    //     code: "US",
    //     states: [
    //       { name: "Alabama", cities: ["Abbeville", "Adamsville", "Alabaster"] },
    //       { name: "Alaska", cities: ["Anchorage", "Juneau", "Fairbanks"] },
    //     ],
    //   },
    //   {
    //     name: "Canada",
    //     phonecode: "+1",
    //     code: "CA",
    //     states: [
    //       { name: "Alberta", cities: ["Calgary", "Edmonton"] },
    //       { name: "Ontario", cities: ["Toronto", "Ottawa"] },
    //     ],
    //   },
    // ];
    // // Populate country dropdown
    // $.each(countries, function (index, country) {
    //   $("#country").append(
    //     '<option value="' + index + '">' + country.name + "</option>"
    //   );
    // });
    // // On country change, populate states
    // $("#country").on("change", function () {
    //   var countryIndex = $(this).val();
    //   var $state = $("#state");
    //   $state.empty();
    //   $state.append('<option value="">Select State</option>');
    //   if (countryIndex !== "") {
    //     var states = countries[countryIndex].states;
    //     $.each(states, function (i, state) {
    //       $state.append(
    //         '<option value="' + state.name + '">' + state.name + "</option>"
    //       );
    //     });
    //   }
    // });
  });
});

jQuery(document).ready(function ($) {
  let totalPages = $(".fp-page").length;
  console.log("Total Pages:", totalPages);
  let currentPage = 1;
  console.log("currentPage Pages:", currentPage);
  $("#prevBtn").hide();

  $("#nextBtn").on("click", function () {
    console.log("currentPage Pages inc:", currentPage);
    if (currentPage < totalPages) {
      currentPage = currentPage + 1;
      $("#currentPage").val(currentPage);

      $(".fp-page").hide();
      $("#fp-page-" + currentPage).show();
      if (currentPage === totalPages) {
        $("#nextBtn").hide();
        $("#fp-submit-btn").show();
      } else {
        $("#nextBtn").show();
        $("#fp-submit-btn").hide();
      }
      if (currentPage > 1) {
        $("#prevBtn").show();
        $("#prevBtn").prop("disabled", false);
      }
      if (currentPage === 1) {
        $("#prevBtn").hide();
        $("#prevBtn").prop("disabled", true);
      } else {
        $("#prevBtn").show();
        $("#prevBtn").prop("disabled", false);
      }
      // scrollToPage(currentPage + 1);
    }
  });

  $("#prevBtn").on("click", function () {
    $(".fp-page").removeClass("active");
    console.log("currentPage Pages dec:", currentPage);
    if (currentPage > 1) {
      currentPage = currentPage - 1;
      $("#currentPage").val(currentPage);
      // scrollToPage(currentPage - 1);

      $(".fp-page").hide();
      $("#fp-page-" + currentPage).show();
      if (currentPage === totalPages) {
        $("#nextBtn").hide();
        $("#fp-submit-btn").show();
      } else {
        $("#nextBtn").show();
        $("#fp-submit-btn").hide();
      }
      if (currentPage > 1) {
        $("#prevBtn").show();
        $("#prevBtn").prop("disabled", false);
      }
      if (currentPage === 1) {
        $("#prevBtn").hide();
        $("#prevBtn").prop("disabled", true);
      } else {
        $("#prevBtn").show();
        $("#prevBtn").prop("disabled", false);
      }
    }
  });
});

jQuery(document).ready(function ($) {
  // Add Pricing Plan
  $("#add-pricing-plan").on("click", function () {
    let clone = $("#pricing-plans-wrapper .pricing-plan-item:first").clone();
    clone.find("input").val(""); // clear values
    $("#pricing-plans-wrapper").append(clone);
  });

  // Remove Pricing Plan
  $(document).on("click", ".remove-plan", function () {
    if ($("#pricing-plans-wrapper .pricing-plan-item").length > 1) {
      $(this).closest(".pricing-plan-item").remove();
    } else {
      alert("At least one plan is required.");
    }
  });

  // Add Case Study
  $("#add-case-study").on("click", function () {
    let clone = $("#case-studies-wrapper .case-study-item:first").clone();
    clone.find("input").val(""); // clear values
    $("#case-studies-wrapper").append(clone);
  });

  // Remove Case Study
  $(document).on("click", ".remove-case", function () {
    if ($("#case-studies-wrapper .case-study-item").length > 1) {
      $(this).closest(".case-study-item").remove();
    } else {
      alert("At least one case study is required.");
    }
  });
});
