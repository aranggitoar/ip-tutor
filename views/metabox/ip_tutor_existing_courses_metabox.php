<?php
$ip_id = get_the_ID();

$linked_courses = get_post_meta($ip_id, 'linked_courses');
if ( count( $linked_courses ) !== 0 ) {
	if ( substr_count( $linked_courses[0],"," !== 0 )) {
		$linked_courses = explode( ",", $linked_courses[0], 50 );
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
				echo '<li><b>('.$id.')</b> <i>'.get_the_title( $id ).'</i></li>';
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
			if ( count( $linked_courses ) === 0 ) {
				_e('None.', 'ip-tutor');
			} else {
				foreach ($linked_courses as $id) {
					echo '<li><b>('.$id.')</b>  <i>'.get_the_title( $id ).'</i></li>';
				}
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
				r($available_course_ids);
			?>
		</p>
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
  </div>
</div>
