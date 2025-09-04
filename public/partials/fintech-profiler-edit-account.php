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
<div class="edit-profile-form">
  <h3>Account</h3>

  <form id="company-account-form" method="post" enctype="multipart/form-data">
    <h4>Password setting</h4>
    <p>Choose a strong password to keep your profile secure.</p>
    <div>
      <label for="current_password">Current password </label>
      <input type="password" id="current_password" name="current_password" required>
    </div>

    <a href="#" class="btn-change-pw">Change Password</a>
    <div class="change-pw-section">
      <div>
        <label for="new_password">New password </label>
        <input type="password" id="new_password" name="new_password" required>
        <ul>
          <li>Min. 8 characters</li>
          <li>Atleast 1 number (0-9)</li>
          <li>Atleast 1 symbol (!@#$%^&*)</li>
          <li>Atleast 1 upper and lower case</li>
        </ul>
      </div>
      <div>
        <label for="retype_password">Retype password </label>
        <input type="password" id="retype_password" name="retype_password" required>
      </div>
      <div> <Button onclick="cancel()">Cancel</Button><Button onclick="update_profile()">Update Password</Button></div>
      <div>
        <label for="remove_account">Remove account </label>
        <p>Permanently deletes your companies account from FinExplore 360</p>
        <Button class="danger">Remove account</Button>
      </div>

      <button type="submit">Upload Profile</button>

      <div class="modal-delete">
        <h2> Confirm Permanent Account Deletion?</h2>
        <p>You are about to delete this account permanently. This action is irreversible once the process is initiated; you wont be able to retrieve any of the content or information you might have added to this profile.</p>
        <div>
          <label for="delete_password">Remove account </label>
          <input type="password" id="delete_password" name="delete_password" required>
          <Button>Cancel</button><Button class="danger">Confirm Deletion</Button>
        </div>
      </div>
  </form>

</div>