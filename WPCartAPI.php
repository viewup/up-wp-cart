<?php

/**
 * Class WPCartAPI
 *
 * Classe para integrar com a API WordPress, a classe WPCart
 */
class WPCartAPI extends WP_REST_Controller
{
    const ADD = WP_REST_Server::CREATABLE;
    const EDIT = WP_REST_Server::EDITABLE;
    const DELETE = WP_REST_Server::DELETABLE;
    const GET = WP_REST_Server::READABLE;
    const  ALL = WP_REST_Server::ALLMETHODS;

    const ID = "/(?P<id>\d+)";

    private $base = UPWPCART_API_BASE;
    private $route = '/' . UPWPCART_API_ROUTE;
    public $cart = null;

    /**
     * WPCartAPI constructor.
     * @param WPCart $cart
     */
    function __construct($cart)
    {
        $this->cart = $cart;
    }

    /**
     * Register the routes
     */
    function register_routes()
    {
        $base = $this->base;
        $route = $this->route;

        // base routes
        register_rest_route($base, $route, array(
            array(
                'methods' => self::GET,
                'callback' => $this->getCallback('get')
            ),
            array(
                'methods' => self::ADD,
                'callback' => $this->getCallback('add'),
                'args' => array(
                    'id' => array(
                        'validate_callback' => 'is_numeric'
                    ),
                    'amount' => array(
                        'default' => 1,
                        'validate_callback' => 'is_numeric'
                    )
                ),
            ),
            array(
                'methods' => self::DELETE,
                'callback' => $this->getCallback('clean'),
            ),
        ));

        // item routes
        register_rest_route($base, $route . self::ID, array(
            array(
                'methods' => self::GET,
                'callback' => $this->getCallback('getItem'),
            ),
            array(
                'methods' => self::EDIT,
                'callback' => $this->getCallback('update'),
                'args' => array(
                    'amount' => array(
                        'required' => false,
                        'validate_callback' => 'is_numeric'
                    )
                ),
            ),
            array(
                'methods' => WP_REST_Server::DELETABLE,
                'callback' => array($this, 'remove'),
            ),
        ));
    }

    public function get()
    {
        return $this->cart;
    }

    public function getItem(WP_REST_Request $request)
    {
        $id = $request['id'];
        return $this->cart->getItem($id);
    }

    public function add(WP_REST_Request $request)
    {
        $id = $request['id'];
        $amount = $request['amount'];
        return $this->cart->add($id, $amount);
    }

    public function remove(WP_REST_Request $request)
    {
        return $this->cart->remove($request['id']);
    }

    public function update(WP_REST_Request $request)
    {
        return $this->cart->update($request['id'], $request['amount']);
    }

    public function clean()
    {
        return $this->cart->clean();
    }

    // private methods

    private function getCallback($name)
    {
        return array($this, $name);
    }
}