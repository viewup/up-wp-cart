<?php

/**
 * Class WPCartAPI
 *
 * Classe para integrar com a API WordPress, a classe WPCart
 */
class WPCartAPI extends WP_REST_Controller {
	const ADD = WP_REST_Server::CREATABLE;
	const EDIT = WP_REST_Server::EDITABLE;
	const DELETE = WP_REST_Server::DELETABLE;
	const GET = WP_REST_Server::READABLE;
	const  ALL = WP_REST_Server::ALLMETHODS;

	const ID = "/(?P<id>\d+)";


	private $render_prefix = '/render';
	private $base = UPWPCART_API_BASE;
	private $route = '/' . UPWPCART_API_ROUTE;
	private $initialized = false;

	public $cart = null;

	/**
	 * WPCartAPI constructor.
	 *
	 * @param WPCart $cart
	 */
	function __construct( $cart ) {
		$this->cart = $cart;
	}

	/**
	 * Register the routes
	 */
	function register_routes() {
		if ( $this->initialized ) {
			return false;
		}

		$this->initialized = true;

		// base routes
		$this->register_rest_route( '', array(
			array(
				'methods'  => self::GET,
				'callback' => $this->getCallback( 'get' )
			),
			array(
				'methods'  => self::ADD,
				'callback' => $this->getCallback( 'add' ),
				'args'     => array(
					'id'     => array(
						'required'          => true,
						'validate_callback' => array( $this, 'validateNumeric' ),
					),
					'amount' => array(
						'default'           => 1,
						'validate_callback' => array( $this, 'validateNumeric' ),
					)
				),
			),
			array(
				'methods'  => self::DELETE,
				'callback' => $this->getCallback( 'clean' ),
			),
		) );

		// item routes
		$this->register_rest_route( self::ID, array(
			array(
				'methods'  => self::GET,
				'callback' => $this->getCallback( 'getItem' ),
			),
			array(
				'methods'  => self::EDIT,
				'callback' => $this->getCallback( 'update' ),
				'args'     => array(
					'amount' => array(
						'required'          => false,
						'validate_callback' => array( $this, 'validateNumeric' ),
					),
				),
			),
			array(
				'methods'  => WP_REST_Server::DELETABLE,
				'callback' => $this->getCallback( 'remove' ),
			),
		) );

		return true;
	}

	/**
	 * Custom Register Route
	 *
	 * ADDs render prefix
	 *
	 * @param $route
	 * @param array $args
	 */
	function register_rest_route( $route, $args = array() ) {

		// fix all routes
		foreach ( $args as $key => $arg ) {
			// set args if no set
			$arg['args'] = $arg['args'] ? $arg['args'] : array();

			// set render argument
			$arg['args']['render'] = array(
				'description'       => __( 'If true, a rendered cart will be returned.', UPWPCART_PLUGIN_DOMAIN ),
				'default'           => false,
				'sanitize_callback' => array( $this, 'sanitizeBoolean' )
			);

			// update args
			$args[ $key ] = $arg;
		}

		//set default route
		register_rest_route( $this->base, $this->route . $route, $args );

		// Starts changes for render
		foreach ( $args as $key => $arg ) {
			// set default render to true
			$arg['args']['render']['default'] = true;

			// Changed Description
			$arg['args']['render']['description'] .= ' ' . __( 'Default enabled on this route.', UPWPCART_PLUGIN_DOMAIN );

			// update args
			$args[ $key ] = $arg;
		}
		// register prefixed route
		register_rest_route( $this->base, $this->route . $this->render_prefix . $route, $args );
	}

	public function get( WP_REST_Request $request ) {
		return $this->cart->get( $request );
	}

	public function getItem( WP_REST_Request $request ) {
		$id = $request['id'];

		return $this->cart->getItem( intval( $id ) );
	}

	public function add( WP_REST_Request $request ) {
		$id     = $request['id'];
		$amount = $request['amount'];

		return $this->cart->add( intval( $id ), intval( $amount ) )->get( $request );
	}

	public function remove( WP_REST_Request $request ) {
		return $this->cart->remove( intval( $request['id'] ) )->get( $request );
	}

	public function update( WP_REST_Request $request ) {
		return $this->cart->update( intval( $request['id'] ), intval( $request['amount'] ) )->get( $request );
	}

	public function clean( WP_REST_Request $request ) {
		return $this->cart->clean()->get( $request );
	}

	// private methods

	private function getCallback( $name ) {
		return array( $this, $name );
	}

	// Validators

	public function validateNumeric( $value ) {
		return is_numeric( $value );
	}

	// sanitizers

	/**
	 * Sanitize Boolean Value
	 *
	 * @param string|boolean $value
	 *
	 * @return bool|string
	 */
	public function sanitizeBoolean( $value = false ) {
		// only query field passed: true
		if ( $value === '' ) {
			return true;
		}
		$filter = filter_var( $value, FILTER_VALIDATE_BOOLEAN );
		if ( $filter !== null ) {
			$value = $filter;
		}
		if ( $value === '' ) {
			$value = true;
		}

		return $value;
	}
}