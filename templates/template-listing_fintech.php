<?php get_header(); ?>
<style>
  /* CONTAINER */
  .fintech-filters-container {
    display: flex;
    min-height: 100vh;
    overflow: visible;
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 20px;
    margin-bottom: 200px;
  }



  /* Responsive Design */
  @media (max-width: 1024px) {
    .fintech-filters-container {
      flex-direction: column;
      margin-bottom: 100px;
    }

    .fintech-sidebar {
      width: 100%;
      height: auto;
      max-height: none;
      position: relative;
      margin-bottom: 20px;
    }

    .fintech-content {
      padding: 15px;
      width: 100%;
      overflow: visible;
      height: auto;
    }

    .results {
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 15px;
    }
  }

  @media (max-width: 768px) {
    .fintech-filters-container {
      padding: 0 15px;
      margin-bottom: 80px;
      min-height: auto;
      height: auto;
    }

    .fintech-sidebar {
      padding: 15px;
      height: auto;
      max-height: 400px;
      overflow-y: auto;
    }

    .fintech-content {
      padding: 10px 0;
      height: auto;
      min-height: auto;
    }

    .results {
      grid-template-columns: 1fr;
      gap: 15px;
      height: auto;
      overflow: visible;
    }

    .selected-filters {
      margin-bottom: 15px;
    }

    .filter-tag {
      font-size: 12px;
      padding: 5px 8px;
    }
  }

  @media (max-width: 480px) {
    .fintech-filters-container {
      padding: 0 10px;
      margin-bottom: 60px;
    }

    .fintech-sidebar {
      padding: 12px;
      max-height: 350px;
    }

    .results {
      gap: 12px;
      display: flex;
      flex-direction: column;
    }

    .card {
      border-radius: 8px;
      height: auto;
      min-height: auto;
    }

    .card-body {
      padding: 12px;
    }

    .fintech-card {
      height: auto !important;
      min-height: auto !important;
      max-height: none !important;
    }
  }

  .fintech-content {
    flex: 1;
    padding: 25px;
    overflow: visible;
    min-height: auto;
    height: auto;
  }


  .fintech-card {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    position: relative;
    height: auto;
    display: flex;
    flex-direction: column;
  }

  input[type="checkbox"] {
    appearance: none;
    -webkit-appearance: none;
    width: 15px;
    height: 15px;
    border: 1px solid #00000066;
    border-radius: 2px;
    background-color: #fff;
    cursor: pointer;
    position: relative;
    transition: all 0.2s ease;
  }

  .filters-heading {
    display: flex;
    align-items: center;
    border-bottom: 1px solid #0000001A;
    padding-bottom: 1rem;
    margin-bottom: 10px;
  }

  .filters-heading h3 {
    margin: 0;
  }

  .filters-icon {
    width: 24px;
    height: 24px;
    margin-right: 8px;
  }

  /* SIDEBAR */
  .fintech-sidebar {
    width: 320px;
    background: #F4F6F5;
    padding: 18px;
    height: auto;
    min-height: 100vh;
    overflow-y: auto;
    position: sticky;
    top: 0;
    align-self: flex-start;
  }

  h3 {
    margin-bottom: 18px;
    font-size: 18px;
    color: #222;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .filter-group {
    margin-bottom: 18px;
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
  }

  .filter-header.main {
    font-weight: 600;
  }

  .filter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    font-size: 15px;
    color: #2a2a2a;
    padding: 6px 0;
    transition: color 0.2s ease;
  }

  .filter-header:hover {
    color: #FF7B2E;
  }

  .filter-header i {
    font-size: 13px;
    color: #777;
    transition: transform 0.25s ease;
  }

  /* Rotate icon when open */
  .filter-group.active>.filter-header i,
  .nested-group.active>.filter-header i,
  .sub-group.active>.filter-header i {
    transform: rotate(90deg);
  }

  .filter-content {
    display: none;
    margin-top: 10px;
    margin-left: 5px;
    padding-left: 10px;
    border-left: 2px solid #eee;
  }

  .filter-content label {
    display: block;
    font-size: 14px;
    color: #444;
    margin-bottom: 6px;
  }

  input[type="checkbox"] {
    margin-right: 6px;
  }

  /* NESTED GROUPS */
  .nested-group {
    margin-left: 15px;
    margin-top: 6px;
    padding-left: 10px;
    border-left: 1px dashed #ddd;
  }

  .nested-group .filter-header {
    font-size: 14px;
    color: #333;
  }

  .sub-group {
    margin-left: 15px;
    margin-top: 5px;
    padding-left: 10px;
    border-left: 1px dotted #ccc;
  }

  .sub-group .filter-header {
    font-weight: 400;
    font-size: 13.5px;
    color: #444;
  }

  select,
  input[type="text"],
  input[type="number"] {
    width: 100%;
    padding: 6px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 13.5px;
  }

  /* Price Range Slider Styles */
  .price-range-wrapper {
    width: 100%;
    padding: 0;
  }

  .price-range-header {
    margin-bottom: 5px;
  }

  .price-range-header h2 {
    font-size: 16px;
    font-weight: 600;
    margin: 0;
  }

  .price-range-header p {
    margin-top: 2px;
    font-size: 12px;
    color: #666;
  }

  .price-input {
    width: 100%;
    display: flex;
    margin: 15px 0;
    gap: 10px;
  }

  .price-input .field {
    display: flex;
    flex-direction: column;
    width: 100%;
  }

  .price-input .field span {
    font-size: 12px;
    color: #666;
    margin-bottom: 2px;
  }

  .field input {
    width: 100%;
    height: 32px;
    outline: none;
    font-size: 13px;
    border-radius: 4px;
    text-align: center;
    border: 1px solid #999;
    -moz-appearance: textfield;
  }

  input[type="number"]::-webkit-outer-spin-button,
  input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
  }

  .price-input .separator {
    width: 20px;
    display: flex;
    font-size: 15px;
    align-items: center;
    justify-content: center;
    margin-top: 18px;
  }

  .slider {
    height: 4px;
    position: relative;
    background: #ddd;
    border-radius: 4px;
    margin: 20px 0 30px;
  }

  .slider:before {
    display: none !important
  }

  .slider .progress {
    height: 100%;
    left: 25%;
    right: 25%;
    position: absolute;
    border-radius: 4px;
    background: #007bff;
  }

  .range-input {
    position: relative;
  }

  .range-input input {
    position: absolute;
    width: 100%;
    height: 4px;
    top: -35px;
    background: none;
    pointer-events: none;
    -webkit-appearance: none;
    -moz-appearance: none;
  }

  input[type="range"]::-webkit-slider-thumb {
    height: 14px;
    width: 14px;
    border-radius: 50%;
    background: #007bff;
    pointer-events: auto;
    -webkit-appearance: none;
    box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
    cursor: pointer;
  }

  input[type="range"]::-moz-range-thumb {
    height: 14px;
    width: 14px;
    border: none;
    border-radius: 50%;
    background: #007bff;
    pointer-events: auto;
    -moz-appearance: none;
    box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
    cursor: pointer;
  }

  .fintech-sidebar::-webkit-scrollbar {
    width: 8px;
  }

  .fintech-sidebar::-webkit-scrollbar-thumb {
    background-color: #ccc;
    border-radius: 4px;
  }

  /* Selected filter tags */
  .selected-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 25px;
  }

  .filter-tag {
    background: #fff;
    color: #333;
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: default;
  }

  .filter-tag i {
    font-size: 12px;
    color: #666;
    cursor: pointer;
  }

  /* Cards grid */
  .results {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    width: 100%;
  }

  .card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: all 0.3s ease;
  }

  .card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  .card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
  }

  .card-body {
    padding: 15px;
  }

  .card-title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 6px;
  }

  .card-text {
    font-size: 13px;
    color: #555;
    line-height: 1.4;
    margin-bottom: 10px;
  }

  .card-meta {
    font-size: 12px;
    color: #999;
  }

  .fintech-heading {
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    font-size: 40px;
    line-height: 100%;
    letter-spacing: -0.02em;
  }

  .unique-container {
    display: flex;
    overflow: hidden;
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .slider .progress {
    height: 100%;
    left: 25%;
    right: 25%;
    position: absolute;
    border-radius: 4px;
    background: #FF7B2E !important;
  }

  /* ---------- Heading and Search Bar---------- */

  .search-container {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    max-width: 1280px;
    margin: 0 auto;
    padding: 5px 20px 5px 20px;
    gap: 20px;
  }

  .search-left h2 {
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    font-size: 40px;
    line-height: 100%;
    letter-spacing: -0.02em;
    margin: 0;
  }

  .search-right {
    position: relative;
    flex: 1;
    max-width: 470px;
  }

  .search-right i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #888;
    font-size: 16px;
  }

  .search-right input {
    width: 96%;
    padding: 12px 16px 12px 40px;
    font-size: 15px;
    border: 1px solid #E0E0E0;
    border-radius: 10px;
    outline: none;
    transition: 0.3s ease;
    background-color: #fff;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  }

  .search-right input:focus {
    border-color: #FF7B2E;
    box-shadow: 0 0 0 3px rgba(255, 123, 46, 0.15);
  }

  /* Mobile layout adjustments */
  @media (max-width: 768px) {
    .search-container {
      flex-direction: column;
      align-items: flex-start;
      gap: 15px;
      padding: 5px 15px;
    }

    .search-right {
      width: 100%;
      max-width: 100%;
    }

    .search-left h2 {
      font-size: 32px;
    }

    .search-right input {
      width: 94%;
    }
  }

  @media (max-width: 480px) {
    .search-left h2 {
      font-size: 28px;
    }

    .search-container {
      padding: 5px 10px;
      gap: 12px;
    }
  }

  .fintech-card {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    position: relative;
    height: auto;
    display: flex;
    flex-direction: column;
  }

  .fintech-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
  }

  /* Image area */
  .card-image {
    position: relative;
    width: 100%;
    height: 300px;
    overflow: hidden;
  }

  .card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* Featured label */
  .featured-tag {
    position: absolute;
    bottom: 10px;
    left: 13px;
    background: #FF7B2E;
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    padding: 4px 10px 4px 8px;
    border-radius: 4px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }

  .featured-tag img {
    width: 14px;
    height: 14px;
    object-fit: contain;
  }

  /* Heart icon */
  .fav-btn {
    position: absolute;
    top: 244px;
    right: 10px;
    background: #fff;
    border: none;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
  }

  .fav-btn:hover {
    background: #FF7B2E;
    color: #fff;
  }

  /* Card body */
  .card-body {
    padding: 16px;
    flex: 1;
    display: flex;
    flex-direction: column;
  }

  .card-logo img {
    width: 36px;
    height: 36px;
    margin-bottom: 8px;
    border-radius: 6px;
  }

  .card-title {
    font-size: 17px;
    font-weight: 600;
    color: #111;
    margin-bottom: 6px;
  }

  .card-text {
    font-size: 15px;
    color: #555;
    line-height: 1.4;
    margin-bottom: 10px;
    flex: 1;
  }

  /* Tags */
  .card-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
  }

  .card-tags .tag {
    background: #fdfdfd;
    color: #FF7B2E;
    font-size: 12px;
    padding: 5px 10px;
    border-radius: 10px;
    font-weight: 500;
  }

  .card-logo {
    position: relative;
    display: inline-block;
  }

  .card-logo img {
    display: block;
    max-width: 100%;
    height: auto;
  }

  .card-logo .arrow-icon {
    position: absolute;
    top: 50%;
    left: 1000%;
    transform: translateY(-50%);
    color: #555;
    font-size: 16px;
    cursor: pointer;
    transition: color 0.3s ease, transform 0.3s ease;
  }

  .card-logo .arrow-icon:hover {
    color: #FF7B2E;
    transform: translateY(-50%) translateX(3px);
  }

  .clear-all-tag {
    background: #ffeded !important;
    color: #d33 !important;
    font-weight: 600 !important;
    cursor: pointer !important;
    order: -1;
  }

  .fav-btn {
    position: absolute;
    top: 244px;
    right: 10px;
    background: #fff;
    border: none;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
  }

  .cta-section {
    background: url('https://jamesw705.sg-host.com/wp-content/uploads/2025/10/Frame-1707480072.png') center/cover no-repeat;
    background-color: #FFD700;
    border-radius: 10px;
    padding: 50px 20px;
    text-align: center;
    color: white;
    position: relative;
    max-width: 1000px;
    margin: 60px auto -30px;
  }

  .cta-section h2 {
    font-size: 43px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #fff;
  }

  .cta-btn {
    background-color: white;
    color: #333;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .cta-btn:hover {
    background-color: #333;
    color: white;
  }

  input[type="checkbox"]:checked {
    background-color: #FF7B2E;
    border: #FF7B2E;
  }

  input[type="checkbox"]::before {
    content: "";
    position: absolute;
    width: 6px;
    height: 12px;
    border-right: 2px solid #fff;
    border-bottom: 2px solid #fff;
    top: -1px;
    left: 4px;
    transform: rotate(45deg);
    opacity: 0;
    transition: opacity 0.2s ease;
  }

  input[type="checkbox"]:checked::before {
    opacity: 1;
  }

  /* Mobile adjustments for cards */
  @media (max-width: 768px) {
    .card-image {
      height: 250px;
    }

    .fav-btn {
      top: 194px;
    }

    .featured-tag {
      font-size: 11px;
      padding: 3px 8px 3px 6px;
    }

    .card-body {
      padding: 12px;
    }

    .card-title {
      font-size: 16px;
    }

    .card-text {
      font-size: 14px;
    }
  }

  @media (max-width: 480px) {
    .card-image {
      height: 200px;
    }

    .fav-btn {
      top: 144px;
      width: 28px;
      height: 28px;
    }

    .card-logo img {
      width: 32px;
      height: 32px;
    }
  }
</style>

<div class="search-container">
  <div class="search-left">
    <h2>Explore Fintechs</h2>
  </div>
  <div class="search-right">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="text" id="fintechSearch" placeholder="Search fintechs...">
  </div>
</div>

<div class="fintech-filters-container">
  <!-- SIDEBAR -->
  <aside class="fintech-sidebar">
    <form method="post" id="fintech-filter-form">
      <div class="filters-heading">
        <img src="https://jamesw705.sg-host.com/wp-content/uploads/2025/10/audio-settings-01.png"
          alt="Audio Settings"
          class="filters-icon" />
        <!-- <div class="filters-icon">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M2 4L10 4M2 10H10M10 10V12M10 10V8M2 16H6M10 16L18 16M14 10H18M14 4L18 4M14 4V6M14 4V2M6.5 18V14" stroke="black" stroke-opacity="0.8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </div> -->
        <h3>Filters</h3>
        <button type="submit" style="display:none">Filter</button>
      </div>

      <!-- Your filter groups remain the same -->
      <div class="filter-group">
        <!-- Fintech Category -->
        <div class="filter-header main"> Categories <i class="fa-solid fa-chevron-right"></i></div>

        <?php
        $selected_cats = !empty($_GET['category']) ? (array) $_GET['category'] : [];

        $post_type = 'fintech-profiles';

        $taxonomies = get_object_taxonomies($post_type);

        $taxonomy = 'fintech-category';

        $categories = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]);

        $selected_cats = !empty($_GET['category']) ? (array) $_GET['category'] : [];
        echo '<div class="filter-content">';
        render_taxonomy_tree($taxonomy, 0, $selected_cats);
        echo '</div>';
        ?>
      </div>

      <!-- Other filter groups... -->
      <div class="filter-group">
        <div class="filter-header main">
          Cost & Pricing Model <i class="fa-solid fa-chevron-right"></i>
        </div>
        <div class="filter-content">
          <?php
          $models = get_terms(['taxonomy' => 'fintech-pricing', 'hide_empty' => false]);
          $selected_models = !empty($_GET['models']) ? (array) $_GET['models'] : [];
          render_taxonomy_tree('fintech-pricing', 0, $selected_models);
          ?>
        </div>
      </div>

      <div class="filter-group">
        <div class="filter-header main">
          Pricing Range <i class="fa-solid fa-chevron-right"></i>
        </div>

        <div class="filter-content">
          <div class="price-range-wrapper">
            <div class="price-range-header"></div>
            <div class="price-input">
              <div class="field">
                <span>Minimum</span>
                <input type="number" class="input-min" id="min_price" name="min_price" value="<?php echo esc_attr($_GET['min_price'] ?? '2500'); ?>">
              </div>
              <div class="separator">-</div>
              <div class="field">
                <span>Maximum</span>
                <input type="number" class="input-max" id="max_price" name="max_price" value="<?php echo esc_attr($_GET['min_price'] ?? '7500'); ?>">
              </div>
            </div>
            <div class="slider">
              <div class="progress"></div>
            </div>
            <div class="range-input">
              <input type="range" class="range-min" min="0" max="10000" value="2500" step="100">
              <input type="range" class="range-max" min="0" max="10000" value="7500" step="100">
            </div>
          </div>
        </div>
      </div>

      <div class="filter-group">
        <div class="filter-header main">
          Company Size <i class="fa-solid fa-chevron-right"></i>
        </div>

        <div class="filter-content">
          <?php
          $sizes = get_terms(['taxonomy' => 'fintech-size', 'hide_empty' => false]);

          $selected_sizes = !empty($_GET['sizes']) ? (array) $_GET['sizes'] : [];
          render_taxonomy_tree('fintech-size', 0, $selected_sizes);
          ?>
        </div>
      </div>

      <div class="filter-group">
        <div class="filter-header main">
          Location <i class="fa-solid fa-chevron-right"></i>
        </div>
        <div class="filter-content">
          <label>Country</label>
          <select name="country" id="country">
            <option value="">Select Country</option>
            <option value="USA">USA</option>
            <option value="UK">UK</option>
            <option value="Canada">Canada</option>
            <option value="Australia">Australia</option>
            <option value="Germany">Germany</option>
          </select>
          <label>State</label>
          <select name="state" id="state">
            <option value="">Select State</option>
            <option value="Alabama">Alabama</option>
            <option value="California">California</option>
            <option value="Texas">Texas</option>
            <option value="Florida">Florida</option>
            <option value="New York">New York</option>
          </select>
          <label>City</label>
          <input type="text" id="city" name="" placeholder="City name">
        </div>
      </div>
    </form>
  </aside>

  <!-- MAIN CONTENT -->
  <section class="fintech-content">
    <div class="selected-filters" id="selectedFilters">
      <!-- Dynamic filter tags will appear here -->
    </div>

    <?php
    $fintech_qry = new WP_Query(array('post_type' => 'fintech_profiles', 'post_status' => 'publish', 'posts_per_page' => 12)); ?>

    <div class="results">
      <!-- Add all your cards here - they will now display properly on mobile -->
      <?php
      if ($fintech_qry->have_posts()) :
        /* Start the Loop */
        while ($fintech_qry->have_posts()) :
          $fintech_qry->the_post();
          $post = $fintech_qry->post;
          // global $post;

          do_action('fintech_profiler_archive_content');
        endwhile;
      else :
        echo "<h2>No Item Found </h2>";

      endif;
      ?>

    </div>
  </section>
</div>

<script>
  const maxVisible = 2; // number of tags to show
  document.querySelectorAll('.card-tags').forEach(card => {
    const tags = Array.from(card.querySelectorAll('.tag'));
    if (tags.length > maxVisible) {
      // hide the remaining tags
      tags.slice(maxVisible).forEach(tag => tag.style.display = 'none');

      // add a "more" indicator
      const moreCount = tags.length - maxVisible;
      const moreTag = document.createElement('span');
      moreTag.className = 'tag more';
      moreTag.textContent = `+${moreCount} more`;
      card.appendChild(moreTag);
    }
  });
</script>

<script>
  // Toggle dropdowns
  document.querySelectorAll('.filter-header').forEach(header => {
    header.addEventListener('click', e => {
      e.stopPropagation();
      const parent = header.parentElement;
      parent.classList.toggle('active');
      const content = parent.querySelector('.filter-content');
      if (content) {
        content.style.display = content.style.display === 'block' ? 'none' : 'block';
      }
    });
  });

  // Price Range Slider Functionality
  const rangeInput = document.querySelectorAll(".range-input input"),
    priceInput = document.querySelectorAll(".price-input input"),
    range = document.querySelector(".slider .progress");
  let priceGap = 1000;

  // Set initial progress
  let minVal = parseInt(rangeInput[0].value),
    maxVal = parseInt(rangeInput[1].value);
  range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
  range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";

  priceInput.forEach((input) => {
    input.addEventListener("input", (e) => {
      let minPrice = parseInt(priceInput[0].value),
        maxPrice = parseInt(priceInput[1].value);

      if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
        if (e.target.className === "input-min") {
          rangeInput[0].value = minPrice;
          range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
        } else {
          rangeInput[1].value = maxPrice;
          range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
        }
      }
      updatePriceFilterTag();
    });
  });

  rangeInput.forEach((input) => {
    input.addEventListener("input", (e) => {
      let minVal = parseInt(rangeInput[0].value),
        maxVal = parseInt(rangeInput[1].value);

      if (maxVal - minVal < priceGap) {
        if (e.target.className === "range-min") {
          rangeInput[0].value = maxVal - priceGap;
        } else {
          rangeInput[1].value = minVal + priceGap;
        }
      } else {
        priceInput[0].value = minVal;
        priceInput[1].value = maxVal;
        range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
        range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
      }
      updatePriceFilterTag();
    });
  });

  // Selected filters management
  const selectedFiltersDiv = document.getElementById('selectedFilters');
  const checkboxes = document.querySelectorAll('input[type="checkbox"]');
  const countrySelect = document.getElementById('country');
  const stateSelect = document.getElementById('state');
  const cityInput = document.getElementById('city');

  // Create "Clear All" tag
  const clearAllTag = document.createElement('div');
  clearAllTag.className = 'filter-tag clear-all-tag';
  clearAllTag.innerHTML = 'Clear All <i class="fa-solid fa-xmark"></i>';
  clearAllTag.addEventListener('click', clearAllFilters);

  let clearAllAdded = false;

  // Function to clear all filters
  function clearAllFilters() {
    checkboxes.forEach(cb => cb.checked = false);
    priceInput[0].value = 2500;
    priceInput[1].value = 7500;
    rangeInput[0].value = 2500;
    rangeInput[1].value = 7500;
    range.style.left = '25%';
    range.style.right = '25%';
    countrySelect.value = '';
    stateSelect.value = '';
    cityInput.value = '';

    selectedFiltersDiv.querySelectorAll('.filter-tag:not(.clear-all-tag)').forEach(tag => {
      tag.remove();
    });

    updateClearAllState();
  }

  // Function to update price filter tag
  function updatePriceFilterTag() {
    const minPrice = priceInput[0].value;
    const maxPrice = priceInput[1].value;
    const priceTag = document.querySelector('.filter-tag[data-type="price-range"]');

    if (minPrice != 2500 || maxPrice != 7500) {
      if (!priceTag) {
        const tag = document.createElement('div');
        tag.className = 'filter-tag';
        tag.dataset.type = 'price-range';
        tag.innerHTML = `Price Range: $${minPrice} - $${maxPrice} <i class="fa-solid fa-xmark"></i>`;
        tag.querySelector('i').addEventListener('click', () => {
          priceInput[0].value = 2500;
          priceInput[1].value = 7500;
          rangeInput[0].value = 2500;
          rangeInput[1].value = 7500;
          range.style.left = '25%';
          range.style.right = '25%';
          tag.remove();
          updateClearAllState();
        });
        addFilterTagToContainer(tag);
      } else {
        priceTag.innerHTML = `Price Range: $${minPrice} - $${maxPrice} <i class="fa-solid fa-xmark"></i>`;
        priceTag.querySelector('i').addEventListener('click', () => {
          priceInput[0].value = 2500;
          priceInput[1].value = 7500;
          rangeInput[0].value = 2500;
          rangeInput[1].value = 7500;
          range.style.left = '25%';
          range.style.right = '25%';
          priceTag.remove();
          updateClearAllState();
        });
      }
      addClearAllIfNeeded();
    } else if (priceTag) {
      priceTag.remove();
      updateClearAllState();
    }
  }

  // Function to add filter tag to container (with Clear All first)
  function addFilterTagToContainer(tag) {
    if (clearAllAdded) {
      // Insert after Clear All tag
      selectedFiltersDiv.insertBefore(tag, clearAllTag.nextSibling);
    } else {
      selectedFiltersDiv.appendChild(tag);
    }
  }

  // Function to add filter tag
  function addFilterTag(value, hierarchy, isInput = false) {
    const existingTag = document.querySelector(`.filter-tag[data-value="${value}"]`);
    if (existingTag) return;

    const tag = document.createElement('div');
    tag.className = 'filter-tag';
    tag.dataset.value = value;

    if (isInput) {
      tag.innerHTML = `${hierarchy}: ${value} <i class="fa-solid fa-xmark"></i>`;
    } else {
      tag.innerHTML = `${hierarchy} → ${value} <i class="fa-solid fa-xmark"></i>`;
    }

    tag.querySelector('i').addEventListener('click', () => {
      // Find and clear the corresponding input/select
      if (value.includes('Country')) {
        countrySelect.value = '';
      } else if (value.includes('State')) {
        stateSelect.value = '';
      } else if (value.includes('City')) {
        cityInput.value = '';
      } else {
        // For checkboxes, find and uncheck
        const cb = document.querySelector(`input[value="${value}"]`);
        if (cb) cb.checked = false;
      }

      tag.remove();
      updateClearAllState();
    });

    addFilterTagToContainer(tag);
    addClearAllIfNeeded();
  }

  // Function to add clear all if needed
  function addClearAllIfNeeded() {
    if (!clearAllAdded) {
      selectedFiltersDiv.insertBefore(clearAllTag, selectedFiltersDiv.firstChild);
      clearAllAdded = true;
    }
  }

  // Function to update clear all state
  function updateClearAllState() {
    const filterTags = selectedFiltersDiv.querySelectorAll('.filter-tag:not(.clear-all-tag)');
    if (filterTags.length === 0 && clearAllAdded) {
      clearAllTag.remove();
      clearAllAdded = false;
    }
  }

  // Handle checkbox changes
  checkboxes.forEach(cb => {
    cb.addEventListener('change', () => {
      const value = cb.value;

      // Function to get hierarchy name
      function getHierarchy(cb) {
        let parts = [];
        let parent = cb.closest('.filter-content');
        while (parent && parent.classList.contains('filter-content')) {
          const header = parent.previousElementSibling;
          if (header && header.classList.contains('filter-header')) {
            const text = header.textContent.trim();
            if (!text.includes(value)) { // Avoid duplicate leaf value
              parts.unshift(text);
            }
          }
          parent = parent.parentElement.closest('.filter-content');
        }
        return parts.join(' → ');
      }

      if (cb.checked) {
        // Add tag
        const hierarchy = getHierarchy(cb);
        addFilterTag(value, hierarchy);
      } else {
        // Remove tag
        document.querySelector(`.filter-tag[data-value="${value}"]`)?.remove();
        updateClearAllState();
      }
    });
  });

  // Handle location inputs
  countrySelect.addEventListener('change', function() {
    if (this.value) {
      addFilterTag(`Country: ${this.value}`, 'Location', true);
    } else {
      document.querySelector(`.filter-tag[data-value="Country: ${this.value}"]`)?.remove();
      updateClearAllState();
    }
  });

  stateSelect.addEventListener('change', function() {
    if (this.value) {
      addFilterTag(`State: ${this.value}`, 'Location', true);
    } else {
      document.querySelector(`.filter-tag[data-value="State: ${this.value}"]`)?.remove();
      updateClearAllState();
    }
  });

  cityInput.addEventListener('change', function() {
    if (this.value) {
      addFilterTag(`City: ${this.value}`, 'Location', true);
    } else {
      document.querySelector(`.filter-tag[data-value="City: ${this.value}"]`)?.remove();
      updateClearAllState();
    }
  });

  // Initial price tag update
  updatePriceFilterTag();
</script>
<?php get_footer(); ?>