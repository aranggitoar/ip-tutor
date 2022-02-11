<?php
include_once IP_TUTOR_LOCATION . 'includes/ip-tutor-general-functions.php';

$ip_id = get_the_ID();

$assigned_courses = get_post_meta( $ip_id, 'assigned_courses' );
if ( count( $assigned_courses ) !== 0 ) {
	if ( substr_count( $assigned_courses[0],',' !== 0 ) ) {
		$assigned_courses = explode( ',', $assigned_courses[0], 50 );
	}
}

$available_course_ids = get_posts(array(
	'fields'					=> 'ids',
	'post_per_page'		=> -1,
	'post_type'				=> 'courses'
));

$available_course_ids = array_reverse($available_course_ids);

$available_course_titles = array();

foreach ($available_course_ids as $id) {
	array_push( $available_course_titles, get_the_title( $id ) );
}

$currently_assigned_courses;

if ( count( $assigned_courses ) === 0 ) {
	return;
} else if ( count( $assigned_courses ) === 1 ) {
	$currently_assigned_courses = $assigned_courses[0];
} else {
	$currently_assigned_courses = implode( ',', $assigned_courses );
}

?>

<div class="tutor-option-field-row">
	<div class="tutor-option-field-label">
	  <label for="available_courses">
			<?php _e('Courses available:', 'ip-tutor'); ?> <br />
	  </label>
	</div>
	<div class="tutor-option-field tutor-option-tooltip">
		<ul>
			<?php
			foreach ( $available_course_ids as $id ) {
				echo '<li><b>('.$id.')</b> <i>'.get_the_title( $id ).'</i></li>';
			}
			?>
		</ul>
	</div>
</div>

<div class="tutor-option-field-row">
	<div class="tutor-option-field-label">
	  <label for="assigned_courses">
			<?php _e('Courses assigned:', 'ip-tutor'); ?> <br />
	  </label>
	</div>
	<div class="tutor-option-field tutor-option-tooltip">
		<ul>
			<?php
			if ( count( $assigned_courses ) === 0 ) {
				_e('None.', 'ip-tutor');
			} else {
				foreach ( $assigned_courses as $id ) {
					echo '<li><b>('.$id.')</b>  <i>'.get_the_title( $id ).'</i></li>';
				}
			}
			?>
		</ul>
	</div>
</div>

<div class="tutor-option-field-row">
	<div class="tutor-option-field-label">
	  <label for="assign_courses">
			<?php _e('Assign which course(s) to this instructor?', 'ip-tutor'); ?> <br />
	  </label>
	</div>
	<div class="tutor-option-field tutor-option-tooltip">
		<input type="text" name="assign_courses" value="<?php echo $currently_assigned_courses ?>"></input>
    <p class="desc">
			<?php _e('Assign the courses by its unique number.', 'ip-tutor'); ?>
			<?php _e('You can assign several courses for each instructor.', 'ip-tutor'); ?>
			<?php _e('To assign more than one, follow this example: 65,127,788.', 'ip-tutor'); ?>
    </p>
		<p>
			<?php r( $assigned_courses ); ?>
			<?php
			foreach ( $assigned_courses as $id ) {
				r( $id );
				$neue_ip_id = get_post_meta( $id, 'assigned_instructors' )[0] ;
				r( $neue_ip_id );
				r( get_post( $neue_ip_id ) );
				r( get_the_title( $neue_ip_id ) );
			}
			?>
		</p>
    <?php wp_nonce_field( 'save_assign_courses_in_metadata', 'assign_courses_nonce' ); ?>
  </div>
</div>


<div class="tutor-option-field-row">
	<div class="tutor-option-field-label">
	  <label for="deassign_courses">
			<?php _e('Deassign which course(s) to this instructor?', 'ip-tutor'); ?> <br />
	  </label>
	</div>
	<div class="tutor-option-field tutor-option-tooltip">
		<input type="text" name="deassign_courses"></input>
    <p class="desc">
			<?php _e('Deassign the courses by its unique number.', 'ip-tutor'); ?>
			<?php _e('You can deassign several courses for each instructor.', 'ip-tutor'); ?>
			<?php _e('To deassign more than one, follow this example: 65,127,788.', 'ip-tutor'); ?>
    </p>
    <?php wp_nonce_field( 'save_deassign_courses_in_metadata', 'deassign_courses_nonce' ); ?>
  </div>
</div>
