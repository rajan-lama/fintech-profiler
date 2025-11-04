<?php

// add_action('fintech_profiler_before_main_content', 'fintech_profiler_output_content_wrapper', 10);
// add_action('fintech_profiler_after_main_content', 'fintech_profiler_output_content_wrapper_end', 10);
// add_action('fintech_profiler_archive_description', 'fintech_profiler_archive_description', 10);

add_action('fintech_profiler_archive_content', 'fintech_profiler_archive_content_callback', 10);


function fintech_profiler_archive_content_callback()
{
  global $post;
?>

  <div class="card fintech-card">
    <div class="card-image">
      <a href="<?php the_permalink(); ?>">
        <?php

        $post_id = $post->ID;
        $attached_images = get_post_meta($post->ID, 'fintech_attached_images', true);

        $fintech_owner_id = get_post_meta($post->ID, 'fintech_owner', true);

        $fintech_owner = get_user_meta($fintech_owner_id, '_profile_picture_id', true);

        // $company_logo_url = wp_get_attachment_url($fintech_owner);

        if ($fintech_owner_id) {
          $company_logo_url = get_avatar($fintech_owner_id, 96); // 96px image
        } else {
          $company_logo_url = '';
        }

        if (has_post_thumbnail()) {
          the_post_thumbnail('fintech-profiler-three-col');
        } else if (!empty($attached_images) && is_array($attached_images)) {
          $first_image_id = $attached_images[0];
          $first_image_url = wp_get_attachment_image_url($first_image_id, 'fintech-profiler-three-col');
          if ($first_image_url) {
            echo '<img src="' . esc_url($first_image_url) . '" alt="' . esc_attr(get_the_title()) . '" />';
          } else {
            echo '<img src="' . esc_url(FINTECH_PROFILER_BASE_URL . '/public/img/fallback-image.png') . '"  alt="' . esc_attr(get_the_title()) . '" />';
          }
        } else {
          echo '<img src="' . esc_url(FINTECH_PROFILER_BASE_URL . '/public/img/fallback-image.png') . '"  alt="' . esc_attr(get_the_title()) . '" />';
        }
        ?>
      </a>

      <div class="featured-tag">

        <img src="https://jamesw705.sg-host.com/wp-content/uploads/2025/10/star-02.png" alt="Star Icon">
        FEATURED
      </div>
      <button class="fav-btn"><i class="fa-regular fa-heart"></i></button>
    </div>
    <div class="card-body">
      <div class="card-logo">

        <?php if ($company_logo_url) : ?>
          <?php echo  $company_logo_url; ?>
        <?php else : ?>
          <img src="https://jamesw705.sg-host.com/wp-content/uploads/2025/10/image-8-1.png" alt="Logo">
        <?php endif; ?>

        <i class="fa-solid fa-arrow-right arrow-icon"></i>
      </div>
      <h3 class="card-title"><?php the_title(); ?></h3>
      <p class="card-text"><?php echo get_excerpt_or_trimmed_content($post->ID, 80); ?></p>
      <div class="card-tags">
        <?php
        $terms = get_the_terms($post->ID, 'fintech-category');

        if (! empty($terms) && ! is_wp_error($terms)) {
          foreach ($terms as $term) {
            echo '<span class="tag">' . esc_html($term->name) . '</span>';
          }
        }
        ?>
      </div>
    </div>
  </div>
<?php
}
