<?php

/**
 * GTM sore class for Google Tag Manager functionality
 *
 * @package cyber-duck/laravel-google-tag-manager
 * @license MIT License https://github.com/cyber-duck/laravel-google-tag-manager/blob/master/LICENSE
 * @author  <andrewm@cyber-duck.co.uk>
 **/
namespace CyberDuck\LaravelGoogleTagManager;

class GTM {

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
        $this->data = GTMData::init();
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
     * @param array $fields An array of a purchase item fields
     * @return void
     */
    public function purchaseItem($fields)
    {
        $this->data->pushPurchaseItem($fields);
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
     * Record a product impression
     *
     * @param array $fields An array of item fields
     * @return void
     */
    public function productImpression($fields)
    {
        $this->data->pushProductImpression($fields);
    }

    /**
     * Record a product being added to the cart
     *
     * @param array $fields An array of item fields
     * @return void
     */
    public function addToCart($fields)
    {
        $this->data->pushAddToCart($fields);
    }

    /**
     * Record a product being removed from the cart
     *
     * @param array $fields An array of item fields
     * @return void
     */
    public function removeFromCart($fields)
    {
        $this->data->pushRemoveFromCart($fields);
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
}