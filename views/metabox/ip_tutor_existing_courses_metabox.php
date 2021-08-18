<?php
$ip_id = get_the_ID();

$linked_courses = get_post_meta($ip_id, 'linked_courses');
/* if ( substr_count( $linked_courses[0],"," !== 0 )) { */
/* 	$linked_courses = explode( ",", $linked_courses[0], -1 ); */
/* } */

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
?>

<div class="tutor-option-field-row">
	<div class="tutor-option-field-label">
	  <label for="linked_courses">
			<?php _e('Courses available:', 'ip-tutor'); ?> <br />
	  </label>
	</div>
	<div class="tutor-option-field tutor-option-tooltip">
		<ul>
			<?php
			foreach ($available_course_ids as $id) {
				echo '<li><b>'.$id.'</b>.'.get_the_title( $id ).'.</li>';
			}
			?>
		</ul>
	</div>
</div>

<div class="tutor-option-field-row">
	<div class="tutor-option-field-label">
	  <label for="linked_courses">
			<?php _e('Courses assigned:', 'ip-tutor'); ?> <br />
	  </label>
	</div>
	<div class="tutor-option-field tutor-option-tooltip">
		<ul>
			<?php
			foreach ($linked_courses as $id) {
				echo '<li><b>'.$id.'</b>.'.get_the_title( $id ).'.</li>';
			}
			?>
		</ul>
	</div>
</div>

<div class="tutor-option-field-row">
	<div class="tutor-option-field-label">
	  <label for="linked_courses">
			<?php _e('Assign which course(s) to this instructor?', 'ip-tutor'); ?> <br />
	  </label>
	</div>
	<div class="tutor-option-field tutor-option-tooltip">
		<input type="text" name="linked_courses"></input>
    <p class="desc">
			<?php _e('Assign the courses by its unique number.', 'ip-tutor'); ?>
			<?php _e('You can assign several courses for each instructor.', 'ip-tutor'); ?>
			<?php _e('To assign more than one, follow this example: 65,127,788.', 'ip-tutor'); ?>
    </p>
		<p>
			<?php r($linked_courses); ?>
			<?php 
				/* array_push($linked_courses, 108); */
				/* $linked_courses[0] = $linked_courses[0].',108'; */
				/* r($linked_courses); */
			?>
		</p>
  </div>
</div>
