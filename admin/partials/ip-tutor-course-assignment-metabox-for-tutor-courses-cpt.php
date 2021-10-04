<?php
include_once IP_TUTOR_LOCATION . 'includes/ip-tutor-general-functions.php';

$ip_id = get_the_ID();

$assigned_instructors = get_post_meta( $ip_id, 'assigned_instructors' );

$currently_assigned_instructors; 

if ( count( $assigned_instructors ) === 0 ) {
	$currently_assigned_instructors = '';
} else if ( substr_count( $assigned_instructors[0], ',' ) === 0 ) {
	$currently_assigned_instructors = $assigned_instructors[0];
} else {
	$currently_assigned_instructors = explode( ',', $currently_assigned_instructors[0], 50 );
}

$available_instructors_ids = get_posts(array(
	'fields'					=> 'ids',
	'post_per_page'		=> -1,
	'post_type'				=> 'ip-tutor'
));

$available_instructors_ids = array_reverse($available_instructors_ids);

$available_instructor_titles = array();

foreach ($available_instructors_ids as $id) {
	array_push( $available_instructor_titles, get_the_title( $id ) );
}

?>

<div class="tutor-option-field-row">
	<div class="tutor-option-field-label">
	  <label for="available_instructors">
			<?php _e('Instructors available:', 'ip-tutor'); ?> <br />
	  </label>
	</div>
	<div class="tutor-option-field tutor-option-tooltip">
		<ul>
			<?php
			foreach ( $available_instructors_ids as $id ) {
				echo '<li><b>('.$id.')</b> <i>'.get_the_title( $id ).'</i></li>';
			}
			?>
		</ul>
	</div>
</div>

<div class="tutor-option-field-row">
	<div class="tutor-option-field-label">
	  <label for="assigned_instructors">
			<?php _e('Instructors assigned:', 'ip-tutor'); ?> <br />
	  </label>
	</div>
	<div class="tutor-option-field tutor-option-tooltip">
		<ul>
			<?php
			if ( count( $assigned_instructors ) === 0 ) {
				_e('None.', 'ip-tutor');
			} else {
				foreach ( $assigned_instructors as $id ) {
					echo '<li><b>('.$id.')</b>  <i>'.get_the_title( $id ).'</i></li>';
				}
			}
			?>
		</ul>
	</div>
</div>
<div class="tutor-option-field-row">
	<div class="tutor-option-field-label">
		<label for="assign_instructors">
		<?php _e('Instructors', 'tutor'); ?> <br />
		</label>
	</div>
	<div class="tutor-option-field tutor-option-tooltip">
		<input type="text" name="assign_instructors" value="<?php echo $currently_assigned_instructors ?>"></input>
		<p class="desc">
			<?php _e('Create a new instructor page or choose from an existing one.', 'tutor'); ?><br>
			<?php _e('This metabox is from Instructor Page for Tutor LMS plugin.', 'tutor'); ?>
			<?php echo get_stylesheet_directory() ?>
			<?php r($currently_assigned_instructors); ?>
		</p>
	</div>
</div>
