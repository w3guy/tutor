<?php
/**
 * @package tutor
 * @since v.1.0.0
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
		$navbar_template  = tutor()->path . 'views/elements/navbar.php';
		$filters_template = tutor()->path . 'views/elements/filters.php';
		tutor_load_template_from_custom_path( $navbar_template, $navbar_data );
		tutor_load_template_from_custom_path( $filters_template, $filters );
	?>
	<div class="tutor-admin-body">
		<div class="tutor-mt-24">
			<?php
				tutor_load_template_from_custom_path(
					tutor()->path . '/views/qna/qna-table.php',
					array(
						'qna_list'       => $qna_list,
						'context'        => 'backend-dashboard-qna-table',
						'qna_pagination' => $qna_pagination,
					)
				);
				?>
		</div>
	</div>
</div>
