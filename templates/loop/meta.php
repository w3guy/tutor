<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

global $post, $authordata;

$profile_url = tutor_utils()->profile_url($authordata->ID);
?>



<div class="list-item-meta text-medium-caption color-text-primary tutor-bs-d-flex tutor-mt-10">
    <?php
    $course_duration = get_tutor_course_duration_context();
    $course_students = tutor_utils()->count_enrolled_users_by_course();
    $disable_total_enrolled = (int) tutor_utils()->get_option( 'disable_course_total_enrolled' );
    ?>
    <?php
    if(!empty($course_duration)) { ?>
        <div class="tutor-bs-d-flex tutor-bs-align-items-center">
        <span class="meta-icon ttr-clock-filled color-text-hints"></span><span><?php echo $course_duration; ?></span>
        </div>
    <?php } ?>
    <?php if ( ! $disable_total_enrolled ) : ?>
        <div class="tutor-bs-d-flex tutor-bs-align-items-center">
        <span class="meta-icon ttr-user-filled color-text-hints"></span><span><?php echo $course_students; ?></span>
        </div>
    <?php endif; ?>
</div>

<div class="list-item-author tutor-bs-d-flex tutor-bs-align-items-center tutor-mt-30">
	<div class="tutor-avatar">
		<a href="<?php echo $profile_url; ?>"> <?php echo tutor_utils()->get_tutor_avatar($post->post_author); ?></a>
	</div>
	<div class="text-regular-caption color-text-subsued">
		<?php esc_html_e('By', 'tutor') ?>
		<span class="text-medium-caption color-text-primary">
		<?php echo get_the_author(); ?>
		</span>
		<?php
        $course_categories = get_tutor_course_categories();
        if(!empty($course_categories) && is_array($course_categories ) && count($course_categories)){
            ?>
            <?php esc_html_e('In', 'tutor') ?>
		<span class="text-medium-caption course-category color-text-primary">
        <?php
            foreach ($course_categories as $course_category){
                $category_name = $course_category->name;
                $category_link = get_term_link($course_category->term_id);
                echo "<a href='$category_link'>$category_name </a>";
            }
        }
        ?>
		</span>
	</div>
</div>