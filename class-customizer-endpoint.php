<?php
/**
 * File Contains Logic to expose theme customizer data publically via the
 * WP Rest API.
 *
 * @package Customizer_Endpoint\API;
 */

namespace Customizer_Endpoint\API;

/**
 * Create Customizer Endpoint.
 */
class Customizer_Endpoint extends \WP_REST_Controller {
	/**
	 * Function initializes the Customizer_Endpoint  Class.
	 *
	 * @param [string] $namespace Endpoint Namespace.
	 */
	public function __construct( $namespace ) {
		$this->namespace = $namespace;
	}

	public function register_routes() {
		register_rest_route(
			$this->namespace, '/theme_setting/', [
				[
					'methods'  => \WP_REST_Server::READABLE,
					'callback' => array( $this, 'get_customizer_settings' ),
				],
			]
		);
		register_rest_route(
			$this->namespace, '/theme_setting/(?P<setting>[\w+\-?]+)', [
				[
					'methods'  => \WP_REST_Server::READABLE,
					'callback' => array( $this, 'get_customizer_setting' ),
				],
			]
		);
	}

	/**
	 * Function fetchs all theme settings.
	 *
	 * @return array
	 */
	public function get_customizer_settings() {
		return rest_ensure_response( get_theme_mods() );
	}

	/**
	 * Function fetches the values for a customizer theme optoin.
	 *
	 * @param [WP Rest Reuest] $request The REST APi Request.
	 * @return mixed
	 */
	public function get_customizer_setting( $request ) {
		$parameters = $request->get_params();
		$setting    = get_theme_mod( $parameters['setting'] );

		return rest_ensure_response( $setting );
	}
}