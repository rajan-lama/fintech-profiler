<?php
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}

// Check if user can edit financial profiles
if (!current_user_can('edit_financial_profiles')) {
  wp_die(__('You do not have permission to access this page.', 'fintech-profiler'));
}

get_header();
?>
<main id="main" class="site-main full-width">
  <div class="container">
    <header class="page-header">
      <div class="dashboard-page-title">
        <?php
        // Get current user
        $current_user = wp_get_current_user();

        if ($current_user->exists()) {
          $profile_picture_id = get_user_meta($current_user->ID, '_profile_picture', true);
          $profile_picture_url = wp_get_attachment_image_url($profile_picture_id, 'thumbnail');

          if ($profile_picture_url) {
            echo '<div class="dashboard-profile-picture"><img src="' . esc_url($profile_picture_url) . '" alt="Profile Picture" style="max-width: 100px; border-radius: 10px;"></div>';
          } else {
            echo '<div class="dashboard-profile-picture"><img src="' . esc_url(FINTECH_PROFILER_BASE_URL . '/public/img/img8.png') . '" alt="Default Profile Picture" style="max-width: 100px; border-radius: 10px;"></div>';
          }
          echo '<h1 class="dashboard-profile-name">' . esc_html($current_user->display_name) . '</h1>';
        } else {
          echo '<p>You are not logged in.</p>';
        }
        ?>
        <div class="dashboard-button-holder">
          <a href="<?php echo esc_url(home_url('/edit-financial-profile')); ?>" class="btn btn-secondary btn-edit-profile">Edit Profile</a>
        </div>
      </div>

    </header><!-- .page-header -->
    <div class="row">
      <div class="archive-filter">
        <div class="archive-page-filter">
          <h3>Saved Fintechs</h3>
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
        <div class="inner-contents">
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
        </div>
      </div><!-- #primary -->
    </div>
  </div>
</main><!-- #main -->
<?php
get_sidebar();
get_footer();
