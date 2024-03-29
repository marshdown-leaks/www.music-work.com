<?php if ( count( $sshares ) === 0 ){ ?>

	<?php
	$this->render("admin/sshare/welcome", array(
        'new_url' => $add_new_url,
        'user_name' => $user_name
    ));
	?>

<?php } else { ?>

	<main id="wpmudev-hustle" class="wpmudev-ui wpmudev-hustle-listings-view">

        <header id="wpmudev-hustle-title" class="wpmudev-has-button">

			<h1><?php esc_attr_e( "Social Sharing Dashboard", Opt_In::TEXT_DOMAIN ); ?></h1>

			<a class="wpmudev-button wpmudev-button-sm wpmudev-button-ghost" <?php if ( $is_free && count( $sshares ) >= 3 ) echo 'id="hustle-free-version-create"'; ?> href="<?php echo esc_url( $add_new_url ); ?>"><?php esc_attr_e('New Sharing Module', Opt_In::TEXT_DOMAIN); ?></a>

        </header>

        <section id="wpmudev-hustle-content">

            <?php
			foreach( $sshares as $sshare ) :

                $keep_open = ( count( $sshares ) === 1 ) ? true : false;

                if ( !$keep_open && $new_module && $sshare->id === $new_module )
                    $keep_open = true;

                if ( !$keep_open && $updated_module && $sshare->id === $updated_module )
                    $keep_open = true;
				?>

                <div class="wpmudev-row">

                    <div class="wpmudev-col col-12">

                        <div class="wpmudev-box-listing">

							<div class="wpmudev-box-head">

                                <div class="wpmudev-box-group">

									<div class="wpmudev-box-group--inner">

										<div class="wpmudev-group-switch">

											<div class="wpmudev-switch">

												<input id="social-sharing-active-toggle-<?php echo esc_attr( $sshare->id ); ?>" class="social-sharing-toggle-activity" type="checkbox" data-id="<?php echo esc_attr( $sshare->id ); ?>" <?php checked( $sshare->active, 1 ); ?> data-nonce="<?php echo esc_attr( wp_create_nonce('sshare_module_toggle_state') ); ?>">

												<label class="wpmudev-switch-design" for="social-sharing-active-toggle-<?php echo esc_attr( $sshare->id ); ?>" aria-hidden="true"></label>

											</div><?php // .wpmudev-switch ?>

										</div>

										<div class="wpmudev-group-title">

											<h5><?php echo esc_html( $sshare->module_name ); ?></h5>

										</div>

										<div class="wpmudev-group-buttons">

											<a class="wpmudev-button wpmudev-button-sm hustle-edit-module" href="<?php echo esc_attr( $sshare->decorated->get_edit_url( Hustle_Module_Admin::SOCIAL_SHARING_WIZARD_PAGE, '' ) ); ?>">
												<span class="wpmudev-button-icon"><?php $this->render("general/icons/admin-icons/icon-edit" ); ?></span>
												<span class="wpmudev-button-text"><?php esc_attr_e('Edit', Opt_In::TEXT_DOMAIN); ?></span>
											</a>

										</div>

									</div>

								</div>

<div class="wpmudev-element--settings">

<div class="wpmudev-element--content">

	<div class="wpmudev-dots-dropdown">

		<button class="wpmudev-dots-button"><svg height="4" width="16">
			<circle cx="2" cy="2" r="2" fill="#B5BBBB" />
			<circle cx="8" cy="2" r="2" fill="#B5BBBB" />
			<circle cx="14" cy="2" r="2" fill="#B5BBBB" />
		</svg></button>

		<ul class="wpmudev-dots-nav wpmudev-hide">

			<li><a href="#" class="module-duplicate" data-id="<?php echo esc_attr( $sshare->id ); ?>" data-type="<?php echo esc_attr( $sshare->module_type ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce('duplicate_social_share') ); ?>" ><?php esc_attr_e( "Duplicate", Opt_In::TEXT_DOMAIN ); ?></a></li>
				<?php
					/**
					 * single optin export
					 */
					$action = Opt_In::EXPORT_MODULE_ACTION;
					$nonce = wp_create_nonce( $action );
					$url = add_query_arg(
						array(
							'page' => Hustle_Module_Admin::POPUP_LISTING_PAGE,
							'action' => $action,
							'id' => $sshare->id,
							'type' => $sshare->module_type,
							Opt_In::EXPORT_MODULE_ACTION => $nonce,
						),
						admin_url( 'admin.php' )
					);
					$url = wp_nonce_url( $url, $action, $nonce );
				?>
				<li><a href="<?php echo esc_url( $url ); ?>"><?php esc_attr_e( "Export module settings", Opt_In::TEXT_DOMAIN ); ?></a></li>
				<li><a href="#" class="import-module-settings" data-id="<?php echo esc_attr( $sshare->id ); ?>" data-name="<?php echo esc_attr( $sshare->module_name ); ?>" data-type="<?php echo esc_attr( $sshare->module_type ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce('import_settings' . $sshare->id ) ); ?>"><?php esc_attr_e( "Import module settings", Opt_In::TEXT_DOMAIN ); ?></a></li>
				<li><a href="#" class="hustle-delete-module" data-nonce="<?php echo esc_attr( wp_create_nonce('hustle_delete_module') ); ?>" data-id="<?php echo esc_attr( $sshare->id ); ?>" ><?php esc_attr_e( "Delete Social Share", Opt_In::TEXT_DOMAIN ); ?></a></li>
		</ul>

	</div>

</div>

</div>
								<div class="wpmudev-box-action"><?php $this->render("general/icons/icon-arrow" ); ?></div>

                            </div><?php // .wpmudev-box-head ?>

                            <div class="wpmudev-box-body <?php echo $keep_open ? '' : 'wpmudev-hidden'; ?>">

								<div class="wpmudev-box-<?php echo $sshare->active ? 'enabled' : 'disabled'; ?>">

									<label class="wpmudev-helper"><?php esc_attr_e("Please activate this social sharing to configure it's settings.", Opt_In::TEXT_DOMAIN); ?></label>

								</div>

								<div class="wpmudev-listing">

									<div class="wpmudev-listing-head" aria-hidden="true">

                                        <div class="wpmudev-listing-type"><?php esc_attr_e( "Module type", Opt_In::TEXT_DOMAIN ); ?></div>

										<div class="wpmudev-listing-conditions"><?php esc_attr_e( "Display conditions", Opt_In::TEXT_DOMAIN ); ?></div>

										<div class="wpmudev-listing-views"><?php esc_attr_e( "Views", Opt_In::TEXT_DOMAIN ); ?></div>

										<div class="wpmudev-listing-conversions"><?php esc_attr_e( "Conversions", Opt_In::TEXT_DOMAIN ); ?></div>

										<div class="wpmudev-listing-rates"><?php esc_attr_e( "Conv. rate", Opt_In::TEXT_DOMAIN ); ?></div>

                                        <div class="wpmudev-listing-status"><?php esc_attr_e( "Module status", Opt_In::TEXT_DOMAIN ); ?></div>

										<div class="wpmudev-listing-tracking"><?php esc_attr_e( "Tracking", Opt_In::TEXT_DOMAIN ); ?></div>

									</div><?php // .wpmudev-listing-head ?>

									<div class="wpmudev-listing-body">

                                        <?php foreach( $types as $type ) : ?>

                                            <div class="wpmudev-listing-row">

                                                <div class="wpmudev-listing-type">

                                                    <p class="wpmudev-listing-title"><?php esc_attr_e( "Module type", Opt_In::TEXT_DOMAIN ); ?></p>

                                                    <?php if ( "floating_social" === $type ) { ?>

                                                        <div class="wpmudev-listing-content">

                                                            <div class="wpmudev-listing-type-icon"><?php $this->render("general/icons/admin-icons/icon-floating" ); ?></div>

                                                            <span><?php esc_attr_e( "Floating Social", Opt_In::TEXT_DOMAIN ); ?></span>

                                                        </div>

                                                    <?php } else if ( "widget" === $type ) { ?>

                                                        <div class="wpmudev-listing-content">

                                                            <div class="wpmudev-listing-type-icon"><?php $this->render("general/icons/admin-icons/icon-widget" ); ?></div>

                                                            <span><?php esc_attr_e( "Widget", Opt_In::TEXT_DOMAIN ); ?></span>

                                                        </div>

                                                    <?php } else if ( "shortcode" === $type ) { ?>

                                                        <div class="wpmudev-listing-content">

                                                            <div class="wpmudev-listing-type-icon"><?php $this->render("general/icons/admin-icons/icon-shortcode" ); ?></div>

                                                            <span><?php esc_attr_e( "Shortcode", Opt_In::TEXT_DOMAIN ); ?></span>

                                                        </div>

                                                    <?php } ?>

                                                </div>

                                                <div class="wpmudev-listing-conditions">

                                                    <p class="wpmudev-listing-title"><?php esc_attr_e( "Display conditions", Opt_In::TEXT_DOMAIN ); ?></p>

                                                    <p class="wpmudev-listing-content">

														<?php
														if ( 'floating_social' === $type ) {
															echo $sshare->decorated->get_condition_labels(false); //phpcs:ignore
														} else if ( 'shortcode' === $type ) {
															$shortcode = '[wd_hustle id=&quot;'. $sshare->shortcode_id .'&quot; type=&quot;social_sharing&quot;]';
															echo '<input type="text" value="' . esc_attr( $shortcode ) . '" readonly class="highlight_input_text shortcode_input">';
														}
														?>

													</p>

                                                </div>

                                                <div class="wpmudev-listing-views">

                                                    <p class="wpmudev-listing-title"><?php esc_attr_e( "Views", Opt_In::TEXT_DOMAIN ); ?></p>

                                                    <p class="wpmudev-listing-content"><?php echo esc_html( $sshare->get_statistics($type)->views_count ); ?></p>

                                                </div>

                                                <div class="wpmudev-listing-conversions">

                                                    <p class="wpmudev-listing-title"><?php esc_attr_e( "Conversions", Opt_In::TEXT_DOMAIN ); ?></p>

                                                    <p class="wpmudev-listing-content"><?php echo esc_html( $sshare->get_statistics($type)->conversions_count ); ?></p>

                                                </div>

                                                <div class="wpmudev-listing-rates">

                                                    <p class="wpmudev-listing-title"><?php esc_attr_e( "Conversions rate", Opt_In::TEXT_DOMAIN ); ?></p>

                                                    <p class="wpmudev-listing-content"><?php echo esc_html( $sshare->get_statistics($type)->conversion_rate ); ?>%</p>

                                                </div>

                                                <div class="wpmudev-listing-status">

                                                    <p class="wpmudev-listing-title"><?php esc_attr_e( "Module status", Opt_In::TEXT_DOMAIN ); ?></p>

                                                    <div class="wpmudev-listing-content"><div class="wpmudev-tabs">

                                                        <ul class="wpmudev-tabs-menu wpmudev-tabs-menu_full">

															<li class="wpmudev-tabs-menu_item <?php echo ( !$sshare->is_sshare_type_active($type) && !$sshare->is_test_type_active( $type ) ) ? 'current' : ''; ?>">
                                                                <input id="<?php echo esc_attr('wph-module-' . $type ."-". $sshare->id . '-status--off' ); ?>" type="radio" value="off" name="wph-module-status" data-nonce="<?php echo esc_attr( wp_create_nonce('sshare_toggle_module_type_state') ); ?>" data-type="<?php echo esc_attr($type); ?>" data-id="<?php echo esc_attr($sshare->id); ?>" >
                                                                <label for="<?php echo esc_attr('wph-module-' . $type ."-". $sshare->id . '-status--off' ); ?>" class="wpmudev-status-off"><?php esc_attr_e( "Off", Opt_In::TEXT_DOMAIN ); ?></label>
                                                            </li>

                                                            <li class="wpmudev-tabs-menu_item <?php echo ( $sshare->is_test_type_active( $type ) ) ? 'current' : ''; ?>">
                                                                <input id="<?php echo esc_attr('wph-module-' . $type ."-". $sshare->id . '-status--test'); ?>" type="radio" value="test" name="wph-module-status" data-nonce="<?php echo esc_attr( wp_create_nonce('sshare_toggle_test_activity') ); ?>" data-type="<?php echo esc_attr($type); ?>" data-id="<?php echo esc_attr($sshare->id); ?>" >
                                                                <label for="<?php echo esc_attr('wph-module-' . $type ."-". $sshare->id . '-status--test'); ?>" class="wpmudev-status-test"><?php esc_attr_e( "Test", Opt_In::TEXT_DOMAIN ); ?></label>
                                                            </li>

                                                            <li class="wpmudev-tabs-menu_item <?php echo ( $sshare->is_sshare_type_active($type) && !$sshare->is_test_type_active( $type ) ) ? 'current' : ''; ?>">
                                                                <input id="<?php echo esc_attr('wph-module-' . $type ."-". $sshare->id . '-status--live'); ?>" type="radio" value="live" name="wph-module-status" data-nonce="<?php echo esc_attr( wp_create_nonce('sshare_toggle_module_type_state') ); ?>" data-type="<?php echo esc_attr($type); ?>" data-id="<?php echo esc_attr($sshare->id); ?>">
                                                                <label for="<?php echo esc_attr('wph-module-' . $type ."-". $sshare->id . '-status--live'); ?>" class="wpmudev-status-live"><?php esc_attr_e( "Live", Opt_In::TEXT_DOMAIN ); ?></label>
                                                            </li>

                                                        </ul>

                                                    </div></div>

                                                </div>

                                                <div class="wpmudev-listing-tracking">

                                                    <p class="wpmudev-listing-title"><?php esc_attr_e( "Tracking", Opt_In::TEXT_DOMAIN ); ?></p>

                                                    <div class="wpmudev-switch">

                                                        <input id="<?php echo esc_attr( 'social-sharing-toggle-tracking-' . $type . '-' . $sshare->id ); ?>"
															   class="social-sharing-toggle-tracking-activity" type="checkbox" data-id="<?php echo esc_attr( $sshare->id ); ?>"
															   data-type="<?php echo esc_attr( $type ); ?>" <?php checked( $sshare->is_track_type_active( $type ), true); ?>
															   data-nonce="<?php echo esc_attr( wp_create_nonce('sshare_toggle_tracking_activity') ); ?>" >

                                                        <label class="wpmudev-switch-design" for="<?php echo esc_attr( 'social-sharing-toggle-tracking-' . $type . '-' . $sshare->id ); ?>"
															   aria-hidden="true"></label>

                                                    </div>

                                                </div>

                                            </div><?php // .wpmudev-listing-row ?>

                                        <?php endforeach; ?>

									</div><?php // .wpmudev-listing-body ?>

								</div><?php // .wpmudev-listing ?>

							</div><?php // .wpmudev-box-body ?>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </section>

        <?php $this->render( "admin/commons/footer", array() ); ?>

        <?php $this->render("admin/commons/listing/delete-confirmation"); ?>
		
		<?php $this->render("admin/commons/listing/modal-import"); ?>

		<?php if ( $is_free && count( $sshares ) >= 3 ) $this->render("admin/commons/listing/modal-upgrade"); ?>
	</main>

<?php } ?>

<!--<script>
(function($) {

	var item       = $('.wpmudev-list .wpmudev-list--element'),
		totalItems = item.length,
		itemCount  = totalItems;

	item.each(function() {

		$(this).css('z-index', itemCount);
		itemCount--;

		var dropdown	= $(this).find('.wpmudev-dots-dropdown'),
			button		= dropdown.find('.wpmudev-dots-button'),
			droplist	= dropdown.find('.wpmudev-dots-nav');

		droplist.addClass('wpmudev-hide');

		button.on('click', function(){
			$(this).toggleClass('wpmudev-active');
			droplist.toggleClass('wpmudev-hide');
		});

	});

}(jQuery));
</script> -->
