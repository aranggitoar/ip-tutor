<?php
$ip_id = get_the_ID();
$current_short_biography = get_post_meta( $ip_id, 'short_biography' );
$current_job_title = get_post_meta( $ip_id, 'job_title' );
if ( ! $current_short_biography ) $current_short_biography = '';
if ( ! $current_job_title ) $current_job_title = '';
?>

/* TODO: Use wp_editor() to edit the text, check ./tutor/views/metabox/user-profile-fields.php */
<div class="tutor-option-field-row">
		<div class="tutor-option-field-label">
				<label for=""><?php _e('Short Biography', 'tutor'); ?></label>
		</div>
		<div class="tutor-option-field">
				<textarea name="short_biography"><?php echo $current_short_biography; ?></textarea>
				<p class="desc">
<?php _e('Short biography text.', 'tutor'); ?>
				</p>
		</div>
</div>

<div class="tutor-option-field-row">
		<div class="tutor-option-field-label">
				<label for=""><?php _e('Job Title', 'tutor'); ?></label>
		</div>
		<div class="tutor-option-field">
				<textarea name="job_title"><?php echo $current_job_title; ?></textarea>
				<p class="desc">
<?php _e('Job title text.', 'tutor'); ?>
				</p>
		</div>
</div>

