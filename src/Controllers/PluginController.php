<?php
namespace Tutor\Controllers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class PluginController
 * 
 * @author: themeum
 * @link: https://themeum.com
 * @package tutor
 */
class PluginController {

	public function __construct() {
		// Admin Footer Text
		add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ), 1 );

		add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );
		add_filter( 'plugin_action_links_' . plugin_basename( TUTOR_PLUGIN_FILE ), array( $this, 'plugin_action_links' ) );
		add_action( 'admin_action_uninstall_tutor_and_erase', array( $this, 'erase_tutor_data' ) );
	}

	/**
	 * Add footer text only on tutor pages
	 *
	 * @param $footer_text
	 * @return string
	 */
	public function admin_footer_text( $footer_text ) {
		$current_screen = get_current_screen();

		/**
		 * We are making sure that this message will be only on Tutor Admin page
		 */
		if ( apply_filters( 'tutor_display_admin_footer_text', ( tutor_utils()->array_get( 'parent_base', $current_screen ) === 'tutor' ) ) ) {
			$footer_text = sprintf(
				__( 'If you like %1$s please leave us a %2$s rating. A huge thanks in advance!', 'tutor' ),
				sprintf( '<strong>%s</strong>', esc_html__( 'Tutor LMS', 'tutor' ) ),
				'<a href="https://wordpress.org/support/plugin/tutor/reviews?rate=5#new-post" target="_blank" class="tutor-rating-link">&#9733;&#9733;&#9733;&#9733;&#9733;</a>'
			);
		}

		return $footer_text;
	}

	/**
	 * Add meta data to plugin descriptions
	 *
	 * @param array  $plugin_meta
	 * @param string $plugin_file
	 * @return array
	 */
	public function plugin_row_meta( $plugin_meta, $plugin_file ) {
		if ( $plugin_file === tutor()->basename ) {
			$plugin_meta[] = sprintf(
				'<a href="%s">%s</a>',
				esc_url( 'https://docs.themeum.com/tutor-lms/?utm_source=tutor&utm_medium=plugins_installation_list&utm_campaign=plugin_docs_link' ),
				__( '<strong style="color: #03bd24">Documentation</strong>', 'tutor' )
			);
			$plugin_meta[] = sprintf(
				'<a href="%s">%s</a>',
				esc_url( 'https://www.themeum.com/contact-us/?utm_source=tutor&utm_medium=plugins_installation_list&utm_campaign=plugin_support_link' ),
				__( '<strong style="color: #03bd24">Get Support</strong>', 'tutor' )
			);
		}

		return $plugin_meta;
	}

	/**
	 * Add action link to plugin
	 *
	 * @param array $actions
	 * @return array
	 */
	public function plugin_action_links( $actions ) {
		$hasPro = tutor()->has_pro;

		if ( ! $hasPro ) {
			$actions['tutor_pro_link'] =
				'<a href="https://www.themeum.com/product/tutor-lms/#pricing?utm_source=tutor_plugin_action_link&utm_medium=wordpress_dashboard&utm_campaign=go_premium" target="_blank">
					<span style="color: #ff7742; font-weight: bold;">' .
						__( 'Upgrade to Pro', 'wp-megamenu' ) .
					'</span>
				</a>';
		}

		$actions['settings'] = '<a href="admin.php?page=tutor_settings">' . __( 'Settings', 'tutor' ) . '</a>';

		return $actions;
	}

	public function erase_tutor_data() {
		global $wpdb;

		$is_erase_data = tutor_utils()->get_option( 'delete_on_uninstall' );
		// => Deleting Data

		$plugin_file = tutor()->basename;
		if ( $is_erase_data && current_user_can( 'deactivate_plugin', $plugin_file ) ) {
			/**
			 * Deleting Post Type, Meta Data, taxonomy
			 */
			$course_post_type = tutor()->course_post_type;
			$lesson_post_type = tutor()->lesson_post_type;

			$post_types = array(
				$course_post_type,
				$lesson_post_type,
				'tutor_quiz',
				'tutor_enrolled',
				'topics',
				'tutor_enrolled',
				'tutor_announcements',
			);

			$post_type_strings = "'" . implode( "','", $post_types ) . "'";
			$tutor_posts       = $wpdb->get_col( "SELECT ID from {$wpdb->posts} WHERE post_type in({$post_type_strings}) ;" );

			if ( is_array( $tutor_posts ) && count( $tutor_posts ) ) {
				foreach ( $tutor_posts as $post_id ) {
					// Delete categories
					$terms = wp_get_object_terms( $post_id, 'course-category' );
					foreach ( $terms as $term ) {
						wp_remove_object_terms( $post_id, array( $term->term_id ), 'course-category' );
					}

					// Delete tags if available
					$terms = wp_get_object_terms( $post_id, 'course-tag' );
					foreach ( $terms as $term ) {
						wp_remove_object_terms( $post_id, array( $term->term_id ), 'course-tag' );
					}

					// Delete All Meta
					$wpdb->delete( $wpdb->postmeta, array( 'post_id' => $post_id ) );
					$wpdb->delete( $wpdb->posts, array( 'ID' => $post_id ) );
				}
			}

			/**
			 * Deleting Comments (reviews, questions, quiz_answers, etc)
			 */
			$tutor_comments       = $wpdb->get_col( "SELECT comment_ID from {$wpdb->comments} WHERE comment_agent = 'comment_agent' ;" );
			$comments_ids_strings = "'" . implode( "','", $tutor_comments ) . "'";
			if ( is_array( $tutor_comments ) && count( $tutor_comments ) ) {
				$wpdb->query( "DELETE from {$wpdb->commentmeta} WHERE comment_ID in({$comments_ids_strings}) " );
			}
			$wpdb->delete( $wpdb->comments, array( 'comment_agent' => 'comment_agent' ) );

			/**
			 * Delete Options
			 */

			delete_option( 'tutor_option' );
			$wpdb->delete( $wpdb->usermeta, array( 'meta_key' => '_is_tutor_student' ) );
			$wpdb->delete( $wpdb->usermeta, array( 'meta_key' => '_tutor_instructor_approved' ) );
			$wpdb->delete( $wpdb->usermeta, array( 'meta_key' => '_tutor_instructor_status' ) );
			$wpdb->delete( $wpdb->usermeta, array( 'meta_key' => '_is_tutor_instructor' ) );
			$wpdb->query( "DELETE FROM {$wpdb->usermeta} WHERE meta_key LIKE  '%_tutor_completed_lesson_id_%' " );

			// Deleting Table
			$prefix = $wpdb->prefix;
			$wpdb->query( "DROP TABLE IF EXISTS {$prefix}tutor_quiz_attempts, {$prefix}tutor_quiz_attempt_answers, {$prefix}tutor_quiz_questions, {$prefix}tutor_quiz_question_answers, {$prefix}tutor_earnings, {$prefix}tutor_withdraws " );

			deactivate_plugins( $plugin_file );
		}

		wp_redirect( 'plugins.php' );
		die();
	}
}
