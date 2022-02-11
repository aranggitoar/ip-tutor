<?php

/**
 * TODO: Add course count and student count feature.
 *
 * Template for displaying IP Tutor for Tutor LMS' instructor Public Profile.
 *
 * @since           0.4.0
 * @package					IP_Tutor
 * @author					Aranggi Toar <aranggi.josef@gmail.com>
 */

$instructor = IP_Tutor_Public::get_ip_tutor_instructor_data ( get_the_ID() );
$user_name = $instructor['name'];
$user_id = $instructor['ID'];
$user_bio = $instructor['bio'];
$user_pp_url = $instructor['profile_picture_url'];

$profile_layout = tutor_utils()->get_option('instructor_public_profile_layout', 'pp-circle');

get_header();
?>

    <div <?php tutor_post_class('tutor-full-width-student-profile tutor-page-wrap tutor-user-public-profile tutor-user-public-profile-'.$profile_layout); ?>>
        <div class="tutor-container photo-area">
            <div class="pp-area">
                <div class="profile-pic">
                    <img src="<?php echo $user_pp_url; ?>">
                </div>
                
                <div class="profile-name">
                    <h3><?php echo $user_name; ?></h3>
                </div>
            </div>
        </div>

        
        <div class="tutor-container" style="overflow:auto">
            <div class="tutor-user-profile-content">
            
                <h3><?php _e('Biography', 'tutor'); ?></h3>
                <?php echo wpautop($user_bio); ?>
                
            </div>
        </div>
    </div>

<?php
get_footer();
