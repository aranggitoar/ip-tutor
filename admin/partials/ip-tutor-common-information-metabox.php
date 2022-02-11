<?php
$ip_id = get_the_ID();
if ( isset( get_post_meta( $ip_id, 'short_biography' )[0] ) ) {
  $current_short_biography = get_post_meta( $ip_id, 'short_biography' )[0];
}
if ( isset( get_post_meta( $ip_id, 'job_title' )[0] ) ) {
  $current_job_title = get_post_meta( $ip_id, 'job_title' )[0];
}
/* print_r( get_post_meta( $ip_id )); */
?>

<!-- TODO: Use wp_editor() to edit the text, check ./tutor/views/metabox/user-profile-fields.php -->
<div class="tutor-option-field-row">
		<div class="tutor-option-field-label">
				<label for=""><?php _e('Short Biography', 'tutor'); ?></label>
		</div>
		<div class="tutor-option-field">
        <textarea name="short_biography"><?php echo isset( $current_short_biography ) ? $current_short_biography : '';?></textarea>
				<p class="desc">
<?php _e('Short biography text.', 'tutor'); ?>
				</p>
        <?php wp_nonce_field('save_short_biography_in_metadata', 'short_biography_nonce'); ?>
		</div>
</div>

<div class="tutor-option-field-row">
		<div class="tutor-option-field-label">
				<label for=""><?php _e('Job Title', 'tutor'); ?></label>
		</div>
		<div class="tutor-option-field">
        <textarea name="job_title"><?php echo isset( $current_job_title ) ? $current_job_title : ''; ?></textarea>
				<p class="desc">
<?php _e('Job title text.', 'tutor'); ?>
				</p>
        <?php wp_nonce_field('save_job_title_in_metadata', 'job_title_nonce'); ?>
		</div>
</div>

