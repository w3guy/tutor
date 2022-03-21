<?php

/**
 * Template for displaying course content
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

global $post;

do_action('tutor_course/single/before/content');

if (tutor_utils()->get_option('enable_course_about', true, true)) {
    $string             = apply_filters( 'tutor_course_about_content', get_the_content() );
    $post_size_in_words = sizeof( explode(" ", $string) );
	$word_limit         = 100;
	$has_readmore       = false;

	if ( $post_size_in_words > $word_limit ) {
		$has_readmore = true;
		// truncate string
		$first_part =  force_balance_tags( html_entity_decode( wp_trim_words( htmlentities( wpautop( $string ) ), $word_limit ) ) );
	}
?>
	<div class='tab-item-content <?php echo $has_readmore ? 'tutor-has-showmore' : '' ?>'>
		<div class='tutor-showmore-content'>
			<div class="text-medium-h6 tutor-color-black">
				<?php echo apply_filters( 'tutor_course_about_title', __( 'About Course', 'tutor' ) ); ?>
			</div>
			<div class="text-regular-body tutor-color-black-60 tutor-mt-12">
				<?php
                    if ($has_readmore) {
                        ?>
                        <div class='showmore-short-text'>
                            <?php echo wp_kses_post( $first_part ); ?>
                        </div>
                        <div class='showmore-text'>
                            <?php echo wp_kses_post( $string ); ?>
                        </div>
                        <?php
                    } else {
                        echo wp_kses_post( $string );
                    }
				?>
			</div>
		</div>
        <?php if ( $has_readmore ) : ?>
            <div class="tutor-showmore-btn tutor-mt-24" data-showmore="true">
                <button class="tutor-btn tutor-btn-icon tutor-btn-disable-outline tutor-btn-ghost tutor-no-hover tutor-btn-md btn-showmore">
                    <span class="btn-icon tutor-icon-plus-filled tutor-color-design-brand"></span>
                    <span class="tutor-color-black-60">
                        <?php esc_html_e( 'Show More', 'tutor' ); ?>
                    </span>
                </button>
                <button class="tutor-btn tutor-btn-icon tutor-btn-disable-outline tutor-btn-ghost tutor-no-hover tutor-btn-md btn-showless">
                    <span class="btn-icon tutor-icon-minus-filled tutor-color-design-brand"></span>
                    <span class="tutor-color-black-60">
                        <?php esc_html_e( 'Show Less', 'tutor' ); ?>
                    </span>
                </button>
            </div>
        <?php endif; ?>
	</div>
<?php
}

do_action('tutor_course/single/after/content'); ?>