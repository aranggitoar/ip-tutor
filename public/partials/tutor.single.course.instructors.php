<?php
/**
 * Template for displaying course instructors/ instructor
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */



do_action('tutor_course/single/enrolled/before/instructors');

require_once ('../class-ip-tutor-public.php');

$instructor = IP_Tutor_Public::get_ip_tutor_instructor_data ( get_the_ID() );
	?>
	<h4 class="tutor-segment-title"><?php _e('About the instructor', 'tutor'); ?></h4>

	<div class="tutor-course-instructors-wrap tutor-single-course-segment" id="single-course-ratings">
			<div class="single-instructor-wrap">
				<div class="single-instructor-top">
                    <div class="tutor-instructor-left">
                        <div class="instructor-avatar">
                            <a href="<?php echo $instructor['profile_url']; ?>">
                                <img src="<?php echo $instructor['profile_picture_url']; ?>">
                            </a>
                        </div>

                        <div class="instructor-name">
                            <h3><a href="<?php echo $instructor['profile_url']; ?>"><?php echo $instructor['name']; ?></a></h3>
                            <?php
                            if ( ! empty($instructor['job_title'])){
                                echo "<h4>{$instructor['job_title']}</h4>";
                            }
                            ?>
                        </div>
                    </div>
					<div class="instructor-bio">
						<?php echo $instructor['bio']?>
					</div>
				</div>

				<div class="single-instructor-bottom">
					<div class="ratings">
						<span class="rating-generated">
							<?php tutor_utils()->star_rating_generator($instructor_rating->rating_avg); ?>
						</span>

						<?php
						echo " <span class='rating-digits'>{$instructor_rating->rating_avg}</span> ";
						echo " <span class='rating-total-meta'>({$instructor_rating->rating_count} ".__('ratings', 'tutor').")</span> ";
						?>
					</div>

					<div class="courses">
						<p>
							<i class='tutor-icon-mortarboard'></i>
							<?php echo $instructor['course_count']; ?> <span class="tutor-text-mute"> <?php _e('Courses', 'tutor'); ?></span>
						</p>
					</div>

					<div class="students">
						<?php
						$total_students = $instructor['total_students'];
						?>

						<p>
							<i class='tutor-icon-user'></i>
							<?php echo $total_students; ?>
							<span class="tutor-text-mute">  <?php _e('students', 'tutor'); ?></span>
						</p>
					</div>
				</div>
			</div>
	</div>
	<?php

do_action('tutor_course/single/enrolled/after/instructors');

