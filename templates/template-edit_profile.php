<?php

/**
 * Template: Edit Profile
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="container">
  <div class="row">
    <div id="sidebar" class="left-sidebar col-md-3">
      <?php get_sidebar(); ?>
    </div>
    <div class="col-md-9">
      <h2>Edit Your Profile</h2>
      <?php echo do_shortcode('[fintech_profile_edit]'); ?>
    </div>
  </div>
</div>