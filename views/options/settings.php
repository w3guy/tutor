<?php
/**
 * Template for editing email template
 *
 * @since v.2.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Certificate
 * @version 2.0
 */

?>
<!-- .tutor-backend-wrap -->
<section class="tutor-backend-settings-page" style="margin-left: -20px;">
	<header class="tutor-option-header tutor-pl-30 tutor-pr-25">
		<div class="title"><?php esc_html_e( 'Settings', 'tutor' ); ?></div>
		<div class="search-field">
			<div class="tutor-input-group tutor-form-control-has-icon tutor-form-control-sm">
				<span class="ttr-search-filled tutor-input-group-icon color-black-50"></span>
				<input type="search" accesskey="s" autofocus autocomplete="off" id="search_settings" class="tutor-form-control" placeholder="<?php esc_html_e( 'Search ...⌃⌥ + S or Alt+S for shortcut', 'tutor' ); ?>" />
				<div class="search-popup-opener search_result"></div>
			</div>
		</div>
		<div class="save-button">
			<button id="save_tutor_option" class="tutor-btn tutor-text-nowrap" disabled>
				<?php _e( 'Save Changes', 'tutor' ); ?>
			</button>
		</div>
	</header>
	<div class="tutor-option-body">
		<form class="tutor-option-form tutor-bs-py-4 tutor-bs-px-3" id="tutor-option-form">
			<input type="hidden" name="action" value="tutor_option_save">
			<div class="tutor-option-tabs">
				<ul class="tutor-option-nav tutor-bs-mt-0">
					<?php
					foreach ( $option_fields as $key => $section ) {
						// $icon         = tutor()->icon_dir . $key . '.svg';
						$active_class = $active_tab == $key ? esc_attr( ' active' ) : '';
						?>
						<li class="tutor-option-nav-item">
							<a data-page="<?php esc_attr_e( $_GET['page'] ); ?>" data-tab="<?php echo esc_attr( $key ); ?>" class="<?php echo esc_attr( $active_class ); ?>">
								<span class="<?php echo esc_attr( $section['icon'] ); ?> tutor-icon-30 color-black-40"></span>
								<span class="nav-label"><?php echo esc_html( $section['label'] ); ?></span>
							</a>
						</li>
						<?php
					}
					?>
				</ul>
			</div>
			<!-- end /.tutor-option-tabs -->

			<div class="tutor-option-tab-pages">
				<?php
				foreach ( $option_fields as $key => $section ) {
					$active_class = $active_tab == $key ? esc_attr( ' active' ) : '';
					?>
						<div id="<?php echo esc_attr( $key ); ?>" class="tutor-option-nav-page<?php echo esc_attr( $active_class ); ?>">
						<?php
						if ( is_array( $section ) ) {
							echo $this->template( $section );
						}
						?>
						</div>
					<?php
				}
				?>
			</div>
			<!-- end /.tutor-option-tab-pages -->
		</form>
	</div>
</section>
<?php echo $this->view_template( 'common/modal-confirm.php', array() ); ?>
<style>
	.color-picker-input input[type=color]:focus,.color-picker-input input[type=color]:active {box-shadow: none;}
	.color-preset-input [type="radio"]{position: absolute;opacity: 0;visibility: hidden;z-index: -1;}
	#wpbody-content {
		margin-top: 70px;
	}
	#wpcontent {
		padding-left: 30px;
		padding-right: 25px;
	}
	.notice, div.error, div.updated {
		margin-right: 0;
		margin-left: 0;
	}
	.notice.is-dismissible {
		margin-bottom: 10px;
	}
	#wpfooter {
		background: #f0f0f1;
		z-index: 10;
		box-shadow: 0 -1px 0px 0 rgb(220 219 220);
	}
	#wpwrap {
		overflow-y: hidden;
	}
</style>
