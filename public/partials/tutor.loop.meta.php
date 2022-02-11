<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

global $post, $authordata;

$instructor = IP_Tutor_Public::get_ip_tutor_instructor_data( get_the_ID() );
$instructor_id = $instructor['ID'];
$profile_url = $instructor['profile_url'];
$profile_picture_url = $instructor['profile_picture_url'];
$profile_name = $instructor['name'];
?>



<div class="tutor-course-loop-meta">
    <?php
    $course_duration = get_tutor_course_duration_context();
    $course_students = tutor_utils()->count_enrolled_users_by_course();
    ?>
    <?php
    if(!empty($course_duration)) { ?>
        <div class="tutor-single-loop-meta">
            <i class='tutor-icon-clock'></i> <span><?php echo $course_duration; ?></span>
        </div>
    <?php } ?>
</div>


<div class="tutor-loop-author">
  <div class="tutor-single-course-avatar">
    <a href="<?php echo $profile_url; ?>">
      <img src="<?php echo $profile_picture_url; ?>">
    </a>
  </div>
  <div class="tutor-single-course-author-name">
    <span><?php _e('by', 'tutor'); ?></span>
    <a href="<?php echo $profile_url; ?>"><?php echo $profile_name; ?></a>
  </div>

  <div class="tutor-course-lising-category">
    <?php
    $course_categories = get_tutor_course_categories();
    if(!empty($course_categories) && is_array($course_categories ) && count($course_categories)){
        ?>
        <span><?php esc_html_e('In', 'tutor') ?></span>
        <?php
        foreach ($course_categories as $course_category){
            $category_name = $course_category->name;
            $category_link = get_term_link($course_category->term_id);
            echo "<a href='$category_link'>$category_name </a>";
        }
    }
    ?>
  </div>
</div>
