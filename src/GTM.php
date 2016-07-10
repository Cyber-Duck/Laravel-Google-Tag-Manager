<?php

/**
 * GTM sore class for Google Tag Manager functionality
 *
 * @package cyber-duck/laravel-google-tag-manager
 * @license MIT License https://github.com/cyber-duck/laravel-google-tag-manager/blob/master/LICENSE
 * @author  <andrewm@cyber-duck.co.uk>
 **/
namespace CyberDuck\LaravelGoogleTagManager;

use Session;

class GTM
{
    /**
     * Data layer object
     *
     * @var GTMData
     */
    private $data;

    /**
     * Set up the required objects for this class
     *
     * @return void
     */
    public function __construct()
    {
        $this->data = new GTMData(config('gtm.id'));
        $sessionKey = config('gtm.sessionKey');
        if (Session::has($sessionKey)) {
            $this->data->pushDataLayer(Session::get($sessionKey));
        }
    }

    /**
     * Set the Tag Manager container ID
     *
     * @param string $id The container ID GTM-XXXXX
     * @return void
     */
    public function id($id)
    {
        $this->data->setID($id);
    }

    /**
     * Return the formatted dataLayer code
     *
     * @return string
     */
    public function code()
    {
        $view = new GTMView();

        return $view->make(
            $this->data->getID(),
            $this->data->getDataLayer()
        );
    }

    /**
     * Set a dataLayer key value pair
     *
     * @param string $name  DataLayer var name
     * @param mixed  $value DataLayer var value
     * @return void
     */
    public function data($name, $value)
    {
        $this->data->pushData($name, $value);
    }

    /**
     * Push an event to the dataLayer
     *
     * @param string $name  The event name
     * @return void
     */
    public function event($name)
    {
        $this->data->pushEvent($name);
    }

    /**
     * Add the ecommerce transaction currency code
     *
     * @param string $code ISO 4217 format currency code e.g. EUR
     * @return void
     */
    public function transactionCurrency($code)
    {
        $this->data->pushTransactionCurrency($code);
    }

    /**
     * Record a product impression
     *
     * @param mixed $product An array of item fields or a shoppable item
     * @param mixed $list (Optional) The list name
     * @param mixed $position (Optional) The position in the list
     * @return void
     */
    public function productImpression($product, $list = null, $position = null)
    {
        if ($product instanceof Product/IsShoppable) {
            $product = $product->getShoppableData();
        }
        if ($list) {
            $product['list'] = $list;
        }
        if ($position) {
            $product['position'] = $position;
        }
        $this->data->pushProductImpression($product);
    }

    /**
     * Record a product impression in a promotional space
     *
     * @param mixed $product An array of item fields or a shoppable item
     * @param mixed $creative The name of the promotional space
     * @param mixed $slot The position in the promotional space
     * @return void
     */
    public function productPromoImpression($product, $creative, $slot)
    {
        if ($product instanceof Product/IsShoppable) {
            $product = $product->getShoppableData();
        }
        $product['creative'] = $creative;
        $product['slot'] = $slot;
        $this->data->pushProductPromoImpression($product);
    }

    /**
     * Record a product being added to the cart
     *
     * @param mixed $product An array of item fields or a shoppable item
     * @param integer $quantity The quantity to add
     * @return void
     */
    public function addToCart($product, $quantity = 1)
    {
        if ($product instanceof Product/IsShoppable) {
            $product = $product->getShoppableData();
        }
        if(!array_key_exists('quantity', $product)) {
            $product['quantity'] = $quantity;
        }
        $this->data->pushAddToCart($product);
    }

    /**
     * Record a product being removed from the cart
     *
     * @param mixed $product An array of item fields or a shoppable item
     * @param integer $quantity The quantity to remove
     * @return void
     */
    public function removeFromCart($product, $quantity = 1)
    {
        if ($product instanceof Product/IsShoppable) {
            $product = $product->getShoppableData();
        }
        if(!array_key_exists('quantity', $product)) {
            $product['quantity'] = $quantity;
        }
        $this->data->pushRemoveFromCart($product);
    }

    /**
     * Add an ecommerce transaction
     *
     * @param array $fields An array of purchase fields
     * @return void
     */
    public function purchase($fields)
    {
        $this->data->pushPurchase($fields);
    }

    /**
     * Add an ecommerce transaction item
     * Used in conjunction with ->purchase()
     *
     * @param mixed $product An array of item fields or a shoppable item
     * @param integer $quantity The quantity to add
     * @return void
     */
    public function purchaseItem($product, $quantity = 1)
    {
        if ($product instanceof Product\IsShoppable) {
            $product = $product->getShoppableData();
        }
        if(!array_key_exists('quantity', $product)) {
            $product['quantity'] = $quantity;
        }
        $this->data->pushPurchaseItem($product);
    }

    /**
     * Refund an ecommerce transaction
     *
     * @param string $id The id of the transaction to refund
     * @return void
     */
    public function refundTransaction($id)
    {
        $this->data->pushRefundTransaction($id);
    }

    /**
     * Refund an ecommerce transaction item quantity
     *
     * @param string $id        The id of the transaction
     * @param string $productId The id of the item
     * @param int    $quantity  The quantity to refund
     * @return void
     */
    public function refundItem($id, $productId, $quantity)
    {
        $this->data->pushRefundTransactionItem($id, $productId, $quantity);
    }

    /**
     * Flash data for next request
     *
     * @return void
     */
    public function flash()
    {
        Session::flash(config('gtm.sessionKey'), $this->data->getDataLayer());
    }
}
