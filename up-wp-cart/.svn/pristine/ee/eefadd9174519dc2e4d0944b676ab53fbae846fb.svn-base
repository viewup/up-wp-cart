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
		$base              = $this->base;
		$route             = $this->route;

		// base routes
		register_rest_route( $base, $route, array(
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
		register_rest_route( $base, $route . self::ID, array(
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
					)
				),
			),
			array(
				'methods'  => WP_REST_Server::DELETABLE,
				'callback' => array( $this, 'remove' ),
			),
		) );

		return true;
	}

	public function get() {
		return $this->cart->get();
	}

	public function getItem( WP_REST_Request $request ) {
		$id = $request['id'];

		return $this->cart->getItem( intval( $id ) );
	}

	public function add( WP_REST_Request $request ) {
		$id     = $request['id'];
		$amount = $request['amount'];

		return $this->cart->add( intval( $id ), intval( $amount ) )->get();
	}

	public function remove( WP_REST_Request $request ) {
		return $this->cart->remove( intval( $request['id'] ) )->get();
	}

	public function update( WP_REST_Request $request ) {
		return $this->cart->update( intval( $request['id'] ), intval( $request['amount'] ) )->get();
	}

	public function clean() {
		return $this->cart->clean()->get();
	}

	// private methods

	private function getCallback( $name ) {
		return array( $this, $name );
	}

	// Validators

	public function validateNumeric( $value ) {
		return is_numeric( $value );
	}
}