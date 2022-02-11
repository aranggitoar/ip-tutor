<?php
$ip_id = get_the_ID();
if ( isset( get_post_meta( $ip_id, 'profile_picture' )[0] ) ) {
  $current_profile_picture_url = get_post_meta( $ip_id, 'profile_picture' )[0]['url'];
}
/* print_r( get_post_meta( $ip_id, 'profile_picture' )); */
/* print_r( get_post_meta( $ip_id ) ); */
/* print_r( get_permalink( $ip_id ) ); */
?>

<div class="tutor-option-field-row">
		<div class="tutor-option-field-label">
      <label for=""><?php _e('Current Profile Picture', 'tutor'); ?></label>
		</div>
		<div class="tutor-option-field">
      <?php echo isset( $current_profile_picture_url ) ? "<img
src='" . $current_profile_picture_url . "'>" : "<p>None</p>";?>
		</div>
</div>

<div class="tutor-option-field-row">
  <form method="POST">
		<div class="tutor-option-field-label">
      <label for=""><?php _e('Upload New Profile Picture', 'tutor'); ?></label>
		</div>
		<div class="tutor-option-field">
      <input type="file" id="profile_picture" name="profile_picture" value="" size=25></input>
      <p class="desc">
<?php _e('Profile picture of the instructor.', 'tutor'); ?>
      </p>
      <?php wp_nonce_field( 'save_profile_picture_in_metadata', 'profile_picture_nonce' ); ?>
		</div>
  </form>
</div>

