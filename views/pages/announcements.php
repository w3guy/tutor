<?php
/**
 * Since 1.7.9
 * configure query with get params
 *
 * @package tutor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="tutor-admin-wrap">
	<?php
		/**
		 * Load Templates with data.
		 */
		$filters_template = tutor()->path . 'views/elements/filters.php';
		$navbar_template  = tutor()->path . 'views/elements/navbar.php';
		tutor_load_template_from_custom_path( $navbar_template, $navbar_data );
	?>

	<div class="tutor-px-20 tutor-mb-24">
		<div class="tutor-card tutor-p-24">
			<div class="tutor-row tutor-align-lg-center">
				<div class="tutor-col-lg-auto tutor-mb-16 tutor-mb-lg-0">
					<div class="tutor-round-box">
						<i class="tutor-icon-bullhorn tutor-fs-3" area-hidden="true"></i>
					</div>
				</div>

				<div class="tutor-col tutor-mb-16 tutor-mb-lg-0">
					<div class="tutor-fs-6 tutor-color-muted tutor-mb-4">
						<?php esc_html_e( 'Create Announcement', 'tutor' ); ?>
					</div>
					<div class="tutor-fs-5 tutor-color-black">
						<?php esc_html_e( 'Notify all students of your course', 'tutor' ); ?>
					</div>
				</div>

				<div class="tutor-col-lg-auto">
					<button type="button" class="tutor-btn tutor-btn-primary tutor-btn-lg" data-tutor-modal-target="tutor_announcement_new">
						<?php esc_html_e( 'Add New Announcement', 'tutor' ); ?>
					</button>
				</div>
			</div>
		</div>
	</div>

	<?php
		tutor_load_template_from_custom_path( $filters_template, $filters );
	?>

	<div class="tutor-admin-body">
		<div class="tutor-admin-announcements-list tutor-mt-24">
		<?php
			$announcements         = $the_query->have_posts() ? $the_query->posts : array();
			$announcement_template = tutor()->path . '/views/fragments/announcement-list.php';
			tutor_load_template_from_custom_path(
				$announcement_template,
				array(
					'announcements' => is_array( $announcements ) ? $announcements : array(),
					'the_query'     => $the_query,
					'paged'         => $page_filter,
				)
			);
			?>
		</div>
	</div>
</div>
