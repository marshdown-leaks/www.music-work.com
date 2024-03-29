<?php
if( !class_exists("Hustle_Aweber_Form_Settings") ):

/**
 * Class Hustle_Aweber_Form_Settings
 * Form Settings Aweber Process
 *
 */
class Hustle_Aweber_Form_Settings extends Hustle_Provider_Form_Settings_Abstract {

	/**
	 * For settings Wizard steps
	 *
	 * @since 3.0.5
	 * @return array
	 */
	public function form_settings_wizards() {
		// already filtered on Abstract
		// numerical array steps
		return array(
			// 0
			array(
				'callback'     => array( $this, 'first_step_callback' ),
				'is_completed' => array( $this, 'first_step_is_completed' ),
			),
		);
	}
		
	/**
	 * Check if step is completed
	 *
	 * @since 3.0.5 
	 * @return bool
	 */
	public function first_step_is_completed( $submitted_data ) {
		// Do validation here
		return true;
	}
	
	/**
	 * Returns all settings and conditions for 1st step of Provider settings
	 *
	 * @since 3.0.5
	 *
	 * @param array $submitted_data
	 * @param boolean $validate
	 * @return array
	 */
	public function first_step_callback( $submitted_data, $validate ) {
		$error_message = '';

		if( ! $this->provider->is_activable() ) {
			wp_send_json_error( 'Aweber requires a higher version of PHP or Hustle, or the extension is not configured correctly.' );
		}
		
		$options = $this->first_step_options( $submitted_data );

		$html = '';
		foreach( $options as $key =>  $option ) {
			$html .= Hustle_Api_Utils::static_render("general/option", array_merge( $option, array( "key" => $key ) ), true);
		}

		if( empty( $error_message ) ) {
			$step_html = $html;
			$has_errors = false;
		} else {
			$step_html = '<label class="wpmudev-label--notice"><span>' . $error_message . '</span></label>';
			$step_html .= $html;
			$has_errors = true;
		}
		$step_html .= $this->get_current_list_name_markup();
		
		$buttons = array(
			'cancel' => array(
				'markup' => $this->get_cancel_button_markup(),
			), 
			'save' => array(
				'markup' => $this->get_next_button_markup(),
			), 
		);
		
		$response = array(
			'html'       => $step_html,
			'buttons'    => $buttons,
			'has_errors' => $has_errors,
		);

		if( $validate ){
			$response['data_to_save'] = $this->before_save_first_step( $submitted_data );
		}
		return $response;
	}
	
	/**
	 * Returns array with options to be converted into HTML by Opt_In->render()
	 *
	 * @since 3.0.5
	 *
	 * @param string $submitted_data
	 * @return array
	 */
	private function first_step_options( $submitted_data ) {

		if ( isset( $submitted_data['api_key'] ) ) {
			$api_key =  $submitted_data['api_key'];
		} elseif ( isset( $submitted_data['module_id'] ) ) {
			$module_id = $submitted_data['module_id'];
			$module = Hustle_Module_Model::instance()->get( $module_id );
			$api_key = Hustle_Aweber::_get_api_key( $module );
		} else {
			$api_key = '';
		}

		return array(
			'auth_code_label' => array(
				"id"    => "auth_code_label",
				"for"   => "aweber_authorization_url",
				"value" => sprintf(
					__('Please <a href="%s" target="_blank">click here</a> to connect to Aweber service then paste the authorization code below', Opt_In::TEXT_DOMAIN),
					"https://auth.aweber.com/1.0/oauth/authorize_app/" . Hustle_Aweber::APP_ID
				),
				"type"  => "label",
			),
			"wrapper" => array(
				"id"    => "wpoi-get-lists",
				"class" => "wpmudev-provider-group",
				"type"  => "wrapper",
				"elements" => array(
					"consumer_key" => array(
						"id"            => "api_key",
						"name"          => "api_key",
						"label"         => __("Customer key", Opt_In::TEXT_DOMAIN),
						"type"          => "text",
						"default"       => "",
						"value"         => $api_key,
						"class"         => "wpmudev-input_text",
						"placeholder"   => __("Please enter authorization code", Opt_In::TEXT_DOMAIN)
					),
					'refresh' => array(
						"id"    => "refresh-lists",
						"type"  => "ajax_button",
						"value" => __("Fetch Lists", Opt_In::TEXT_DOMAIN),
						"class" => "wpmudev-button wpmudev-button-sm hustle_provider_on_click_ajax",
						"attributes" => array(
							"data-action" => "hustle_aweber_refresh_lists",
							"data-nonce"  => wp_create_nonce("hustle_aweber_refresh_lists"),
							"data-dom_wrapper"  => "#optin-provider-account-options"
						)
					),
				)
			)
		);
	}

	/**
	 * Returns array with $html to be inserted into the $wrapper DOM object
	 *
	 * @since 3.0.5
	 *
	 * @return array
	 */
	public function ajax_refresh_lists() {
		Hustle_Api_Utils::validate_ajax_call( 'hustle_aweber_refresh_lists' );
		
		$submitted_data = Hustle_Api_Utils::validate_and_sanitize_fields( $_REQUEST );
		$response = array(
			'html' => $this->refresh_lists_html( $submitted_data ),
			'wrapper' => $submitted_data['dom_wrapper'],
		);
		wp_send_json_success( $response );
	}

	/**
	 * Returns HTML for when refreshing lists
	 *
	 * @since 3.0.5
	 *
	 * @param string $submitted_data
	 * @return string
	 */
	private function refresh_lists_html( $submitted_data ){

		$api_key = $submitted_data['api_key'];

		if ( $this->provider->get_provider_option( Hustle_Aweber::AUTH_CODE, '' ) !== $api_key ) {
			
			// Check if API key is valid
			try {
				$aweber_data = AWeberAPI::getDataFromAweberID( $api_key );
			} catch ( AWeberException $e ) {
				Hustle_Api_Utils::maybe_log( $e->message );
				return '<label class="wpmudev-label--notice"><span>' . __( 'There was an error connecting to Aweber. Please make sure your authorization code is okay.' , Opt_In::TEXT_DOMAIN ) . '</span></label>';
			}
			
			list($consumer_key, $consumer_secret, $access_token, $access_secret) = $aweber_data; //AWeberAPI::getDataFromAweberID( $api_key );

			$this->provider->update_provider_option( Hustle_Aweber::CONSUMER_KEY, $consumer_key );
			$this->provider->update_provider_option( Hustle_Aweber::CONSUMER_SECRET, $consumer_secret );
			$this->provider->update_provider_option( Hustle_Aweber::ACCESS_TOKEN, $access_token );
			$this->provider->update_provider_option( Hustle_Aweber::ACCESS_SECRET, $access_secret );

			$this->provider->update_provider_option( Hustle_Aweber::AUTH_CODE, $api_key );

		} else {
			$consumer_key = $this->provider->get_provider_option( Hustle_Aweber::CONSUMER_KEY, '' );
			$consumer_secret = $this->provider->get_provider_option( Hustle_Aweber::CONSUMER_SECRET, '' );
			$access_token = $this->provider->get_provider_option( Hustle_Aweber::ACCESS_TOKEN, '' );
			$access_secret = $this->provider->get_provider_option( Hustle_Aweber::ACCESS_SECRET, '' );
		}

		// Check if account is valid
		try {
			$account = $this->provider->api( $consumer_key, $consumer_secret )->getAccount( $access_token, $access_secret );
		} catch ( AWeberException $e ) {
			Hustle_Api_Utils::maybe_log( $e->message );
			return '<label class="wpmudev-label--notice"><span>' . __( 'There was an error connecting to Aweber. Please make sure your authorization code is okay.' , Opt_In::TEXT_DOMAIN ) . '</span></label>';
		}

		$_lists = (array) $account->lists->data;

		if( ! is_wp_error( $_lists ) && ! empty( $_lists ) ) {
			$options = $this->refresh_lists_options( $_lists );
	
			if ( !is_wp_error( $options ) ) {
				$html = '';
				if ( !empty( $options ) ) {
					foreach( $options as $key =>  $option ){
						$html .= Hustle_Api_Utils::static_render("general/option", array_merge( $option, array( "key" => $key ) ), true);
					}
				}
				return $html;
				
			} else {
				Hustle_Api_Utils::maybe_log( implode( "; ", $options->get_error_messages() ) );
				
				return '<label class="wpmudev-label--notice"><span>' . __( 'There was an error retrieving the options.' , Opt_In::TEXT_DOMAIN ) . '</span></label>';
			}
			
		} else {
			if( is_wp_error( $_lists ) )
				Hustle_Api_Utils::maybe_log( implode( "; ", $_lists->get_error_messages() ) );

			return '<label class="wpmudev-label--notice"><span>' . __( 'No lists were found for this account.' , Opt_In::TEXT_DOMAIN ) . '</span></label>';
	
		}
	}

	/**
	 * Retrieves options of the ActiveCampaign account with the given api_key
	 *
	 * @param string $submitted_data
	 * @return array
	 */
	private function refresh_lists_options( $data ) {

		$lists = array();
		foreach( (array) $data['entries'] as $list ){
			$list = (array) $list;
			$lists[ $list['id'] ]['value'] = $list['id'];
			$lists[ $list['id'] ]['label'] = $list['name'];
		}


		$first = count( $lists ) > 0 ? reset( $lists ) : "";
		if( !empty( $first ) )
			$first = $first['value'];

		return array(
			"label" => array(
				"id"    => "list_id_label",
				"for"   => "list_id",
				"value" => __("Choose Email List:", Opt_In::TEXT_DOMAIN),
				"type"  => "label",
			),
			"choose_email_list" => array(
				"label"         => __("Choose Email List:", Opt_In::TEXT_DOMAIN),
				"type"          => 'select',
				'name'          => "list_id",
				'id'            => "wph-email-provider-lists",
				"default"       => "",
				'options'       => $lists,
				'value'         => $first,
				'selected'      => $first,
				"attributes"    => array(
					'class'         => "wpmudev-select"
				)
			)
		);
	}

	/**
	 * Registers AJAX endpoints for provider's custom actions
	 *
	 */
	public function register_ajax_endpoints(){
		add_action( "wp_ajax_hustle_aweber_refresh_lists", array( $this , "ajax_refresh_lists" ) );
	}
}
if ( is_admin() ) {
	Hustle_Api_Utils::register_ajax_endpoints( 'Hustle_Aweber' );
}

endif;
