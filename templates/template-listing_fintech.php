<?php

/**
 * Fintech Archive Page
 * 
 * @package fintech_profiler
 */

get_header();
?>
<main id="main" class="site-main">
  <div class="container">
    <header class="page-header">
      <?php
      echo '<h1 class="page-title">Explore Fintechs </h1>';
      // the_archive_title( '<h1 class="page-title">', '</h1>' );
      // the_archive_description( '<div class="archive-description">', '</div>' );
      ?>
    </header><!-- .page-header -->
    <div class="row">
      <div class="archive-filter">
        <div class="archive-page-filter">
          <h5>
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M2 4L10 4M2 10H10M10 10V12M10 10V8M2 16H6M10 16L18 16M14 10H18M14 4L18 4M14 4V6M14 4V2M6.5 18V14" stroke="black" stroke-opacity="0.8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Filters
          </h5><button class="btn-filter" id="fintech-filter">Apply</button>
        </div>
        <div class="archive-search-box">
          <input type="search" id="archive-search" placeholder="Search ..." />
        </div>
      </div>
    </div>
    <div class="row">

      <?php

      $fintech_qry = new WP_Query(array('post_type' => 'fintech_profiles', 'post_status' => 'publish', 'posts_per_page' => 12)); ?>


      <div id="primary" class="content-area fintech-archive">
        <!-- <div class="inner-contents"> -->
        <div class="inner-row">
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
        <!-- </div> -->
      </div><!-- #primary -->

      <aside id="sidebar">
        <form method="post" id="fintech-filter-form">

          <div class="sidebar-section category-filter">

            <!-- Fintech Category -->
            <h4 class="sidebar-title">Categories</h4>
            <?php
            $selected_cats = !empty($_GET['category']) ? (array) $_GET['category'] : [];

            $post_type = 'fintech-profiles';

            $taxonomies = get_object_taxonomies($post_type);

            $taxonomy = 'fintech-category';

            $categories = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false]);

            $selected_cats = !empty($_GET['category']) ? (array) $_GET['category'] : [];
            echo '<ul>';
            render_taxonomy_tree($taxonomy, 0, $selected_cats);
            echo '</ul>';
            ?>

          </div>

          <!-- Cost Price Model -->
          <div class="sidebar-section pricing-category">
            <h4 class="sidebar-title">Cost Price Model</h4>
            <?php
            $models = get_terms(['taxonomy' => 'fintech-pricing', 'hide_empty' => false]);
            echo '<ul>';
            render_taxonomy_tree('fintech-pricing', 0, $models);
            echo '</ul>';
            ?>

            <!-- Price Range -->
            <h5 class="sidebar-title title-pricing">Pricing Range</h5>

            <div id="slider-range"></div>
            <div class="slider-value">
              <div>
                <label>Minimum</label> <input type="text" id="min_price" name="min_price" value="<?php echo esc_attr($_GET['min_price'] ?? ''); ?>">
              </div>
              <div>
                <label>Maximum</label> <input type="text" id="max_price" name="max_price" value="<?php echo esc_attr($_GET['max_price'] ?? ''); ?>">
              </div>
            </div>
          </div>

          <!-- Size -->
          <div class="sidebar-section size-filter">
            <h4>Size</h4>
            <?php
            $sizes = get_terms(['taxonomy' => 'fintech-size', 'hide_empty' => false]);
            echo '<ul>';
            render_taxonomy_tree('fintech-size', 0, $sizes);
            echo '</ul>';
            ?>

          </div>
          <!-- Location -->
          <div class="sidebar-section location-filter">
            <h4>Location</h4>
            <div class="filter-location">
              <select id="country" name="country">
                <option value="">Select Country</option>
              </select>
              <select id="state" name="state">
                <option value="">Select State</option>
              </select>
            </div>
            <input type="text" name="city" placeholder="City" value="<?php echo esc_attr($_GET['city'] ?? ''); ?>">
          </div>

          <button type="submit" style="display: none;">Filter</button>
        </form>

      </aside>

    </div>
  </div>
</main><!-- #main -->
<?php
get_sidebar();
get_footer();
