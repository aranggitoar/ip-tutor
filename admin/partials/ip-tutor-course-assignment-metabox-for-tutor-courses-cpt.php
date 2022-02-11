<?php
include_once IP_TUTOR_LOCATION . 'includes/ip-tutor-general-functions.php';

// TODO: Add capability to create the page right from here.
//       Add capability to assign more than one instructors.

$ip_id = get_the_ID();

// Get the currently assigned instructors page name and page id.
$assigned_instructors = get_post_meta( $ip_id, '_assigned_instructors' );
$currently_assigned_instructors; 

if ( count( $assigned_instructors ) === 0 ) {
	$currently_assigned_instructors = '';
} else if ( substr_count( $assigned_instructors[0], ',' ) === 0 ) {
	$currently_assigned_instructors = $assigned_instructors[0];
} else {
  // Useless for now, as there would only be one instructor.
  $currently_assigned_instructors = explode( ',', $currently_assigned_instructors[0], 50 );
  foreach ( $currently_assigned_instructors as $id ) {
    $currently_assigned_instructors[$id] = get_the_title( $id );
  }
}

// Get the available instructor page name and page id.
$available_instructors_ids = get_posts(array(
	'fields'					=> 'ids',
	'post_per_page'		=> -1,
	'post_type'				=> 'ip-tutor'
));

$available_instructor_ids = array_reverse( $available_instructors_ids );
$available_instructors = array();

foreach ( $available_instructor_ids as $id ) {
	$available_instructors[$id] = get_the_title( $id );
}

?>

<div class="tutor-option-field-row">
	<div class="tutor-option-field-label">
		<label for="assign_instructors">
		<?php _e('Assigned Instructors', 'tutor'); ?> <br />
		</label>
	</div>
	<div class="tutor-option-field tutor-option-tooltip">
    <select id="assign_instructors" name="assign_instructors">
      <option value="-1" <?php echo selected( $currently_assigned_instructors, '' ); ?> disabled><?php _e('Choose instructors for this course'); ?></option>
      <?php
      foreach ( $available_instructors as $id => $title ) {
        settype( $id, "string" );
      ?>
      <option value="<?php echo $id; ?>" <?php echo selected( $currently_assigned_instructors, $id ); ?>><?php echo $title; ?></option>
      <?php
      }
      ?>
    </select>
		<p class="desc">
			<?php _e('Assign a created instructor page here.', 'tutor'); ?><br>
			<?php _e('This metabox is from Instructor Page for Tutor LMS plugin.', 'tutor'); ?>
		</p>
    <?php wp_nonce_field('save_assign_instructors_in_metadata', 'assign_instructors_nonce'); ?>
	</div>
</div>
