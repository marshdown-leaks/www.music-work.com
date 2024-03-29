<?php
/**
 * @var Opt_In_Admin $this
 */
?>

<?php if ( ! count( $modules ) ) : ?>

	<?php $this->render( 'admin/settings/welcome', array( 'user_name' => $user_name ) ); ?>

<?php else : ?>

	<main id="wpmudev-hustle" class="wpmudev-ui wpmudev-hustle-popup-wizard-view">

		<header id="wpmudev-hustle-title">

			<h1><?php esc_attr_e( 'Settings', Opt_In::TEXT_DOMAIN ); ?></h1>

		</header>

		<section id="wpmudev-hustle-content" class="wpmudev-container">

			<div class="wpmudev-row">

				<div id="wpmudev-settings-unsubscribe" class="wpmudev-col col-12 col-sm-6">

					<?php
					$this->render( 'admin/settings/widget-unsubscribe', array(
						'messages' => $unsubscription_messages,
						'email'	=> $unsubscription_email,
					) );
					?>

				</div><?php // #wpmudev-settings-unsubscribe ?>

				<div id="wpmudev-settings-mail" class="wpmudev-col col-12 col-sm-6">

					<?php
					$this->render( "admin/settings/widget-mail", array(
						'name' => $email_name,
						'email' => $email_address
					) );
					?>

				</div><?php // #wpmudev-settings-mail ?>

			</div><?php // .wpmudev-row ?>

			<div class="wpmudev-row">

				<div id="wpmudev-settings-activity" class="wpmudev-col col-12 col-sm-6">

					<?php
					$this->render( 'admin/settings/widget-modules', array(
						'modules'                    => $modules,
						'modules_state_toggle_nonce' => $modules_state_toggle_nonce,
					) );
					?>

				</div><?php // #wpmudev-settings-activity ?>

			</div><?php // .wpmudev-row ?>

		</section>

		<?php $this->render( 'admin/commons/footer', array() ); ?>

	</main>

<?php endif; ?>
