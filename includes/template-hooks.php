<?php

// add_action('fintech_profiler_before_main_content', 'fintech_profiler_output_content_wrapper', 10);
// add_action('fintech_profiler_after_main_content', 'fintech_profiler_output_content_wrapper_end', 10);
// add_action('fintech_profiler_archive_description', 'fintech_profiler_archive_description', 10);

add_action('fintech_profiler_archive_content', 'fintech_profiler_archive_content_cb', 10);

function fintech_profiler_archive_content_cb()
{
  global $post;
?>
  <div class="col-4">
    <article class="post">
      <a href="<?php the_permalink(); ?>" class="post-thumbnail">
        <?php
        if (has_post_thumbnail()) {
          the_post_thumbnail('fintech-profiler-three-col');
        } else {
          echo '<img src="' . esc_url(get_template_directory_uri() . '/images/fallback/default-thumb-3col.jpg') . '"  alt="' . esc_attr(get_the_title()) . '" />';
        }
        ?>
      </a>
      <header class="entry-header">
        <div class="icon-holder">
          <div class="cat-icon">
            <img src="<?php echo FINTECH_PROFILER_BASE_URL; ?>/public/img/img8.png">
          </div>
          <div>
            <a href="<?php the_permalink(); ?>"><img src="<?php echo FINTECH_PROFILER_BASE_URL; ?>/public/img/arrow-right.png"></a>
          </div>
        </div>
        <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
      </header>
      <div class="similar-content">
        <?php echo get_excerpt_or_trimmed_content($post->ID, 80); ?>
      </div>
      <div class="similar-tags">
        <?php
        $terms = get_the_terms($post->ID, 'fintech-category');

        if (! empty($terms) && ! is_wp_error($terms)) {
          foreach ($terms as $term) {
            echo '<a href="' . get_term_link((int) $term->term_id,  'fintech-category') . '" class="list-category">' . esc_html($term->name) . '</a>';
          }
        }
        ?>
      </div>
    </article>
  </div>
<?php }
