<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://rajanlama.com.np
 * @since      1.0.0
 *
 * @package    Fintech_Profiler
 * @subpackage Fintech_Profiler/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="container">
  <div class="login-form">
    <div class="fp-logo">
      <img src="<?php echo esc_url(FINTECH_PROFILER_BASE_URL . 'public/img/logo.png'); ?>" alt="Fintech Profiler" />
      <h3>Create An Account</h3>
      <p>Create for a Financial Company instead? <a href="#">Switch</a></p>
    </div>


    <form class="fp-form" method="post" action="">
      <?php if ($msg) :
      ?>
        <div class="fp-notice fp-info"><?php echo esc_html($msg);  ?></div>
      <?php endif;
      ?>

      <!-- <div class="fp-field">
        <label for="fp_reg_user">Username</label>
        <input type="text" name="fp_reg_user" id="fp_reg_user" required />
      </div> -->

      <div class="fp-hidden-field show">
        <div class="fp-field">
          <label for="fp_reg_email">Email</label>
          <input type="email" name="fp_reg_email" id="fp_reg_email" required />
        </div>

        <div class="fp-actions"><button type="button" class="btn btn-getting-started">Getting Started</button></div>

      </div>

      <div class="fp-hidden-field">

        <div class="fp-field">
          <label for="fp_reg_pass">Create A Password</label>
          <input type="password" name="fp_reg_pass" id="fp_reg_pass" required />
        </div>

        <ul>
          <li>Min. 8 characters</li>
          <li>Atleast 1 number (0-9)</li>
          <li>Atleast 1 symbol (!#$%^)</li>
          <li>Atleast 1 upper and lower case</li>
        </ul>

        <?php if (fp_RECAPTCHA_ENABLED) : ?>
          <div class="fp-field">
            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-reg" />
          </div>
        <?php endif; ?>

        <input type="hidden" name="fp_action" value="financial_register" />
        <input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect); ?>" />
        <?php wp_nonce_field('fp_register_nonce', 'fp_nonce');
        ?>

        <div class="fp-actions"><button type="submit" class="button">Create Account</button></div>

      </div>
    </form>

    <div class="fp-login-info">
      <p>Already have an account? <a href="#">Log in</a></p>
    </div>
  </div>
</div>