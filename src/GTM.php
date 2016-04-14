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
     * View object
     *
     * @var GTMView
     */
    private $view;

    /**
     * Set up the required objects for this class
     *
     * @return void
     */
    public function __construct()
    {
        $this->data = new GTMData();
        $this->view = new GTMView();
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
     * Refund an ecommerce transaction item quantity
     *
     * @param string $id        The id of the transaction
     * @param string $productId The id of the item
     * @param int    $quantity  The quantity to refund
     *
     * @return void
     */
    public function refundItem($id, $productId, $quantity)
    {
        $this->data->pushRefundTransactionItem($id, $productId, $quantity);
    }

    /**
     * Return the formatted dataLayer code
     *
     * @return string
     */
    public function code()
    {
        return $this->view->make(
            $this->data->getID(),
            $this->data->getDataLayer()
        );
    }
}