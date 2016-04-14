<?php

/**
 * Persistenet data storage class which deals with the values of the Tag Manager container and dataLayer
 *
 * @package cyber-duck/laravel-google-tag-manager
 * @license MIT License https://github.com/cyber-duck/laravel-google-tag-manager/blob/master/LICENSE
 * @author  <andrewm@cyber-duck.co.uk>
 **/
namespace CyberDuck\LaravelGoogleTagManager;

class GTMData {

    /**
     * The Tag Manager container ID
     *
     * @var string
     */
    private static $id;

    /**
     * The Tag Manager dataLayer array of values
     *
     * @var array
     */
    private static $data = array();

    /**
     * Set the container ID to a static class property
     *
     * @param string $id The container ID
     * @return void
     */
    public function setID($id)
    {
        self::$id = $id;
    }

    /**
     * Push a key value pair to the data array
     *
     * @param string $name  DataLayer var name
     * @param mixed  $value DataLayer var value
     * @return void
     */
    public function pushData($name, $value)
    {
        self::$data[$name] = $value;
    }

    /**
     * Push an event to the data array
     *
     * @param string $name  The event name
     * @return void
     */
    public function pushEvent($name)
    {
        self::$data['event'] = $name;
    }

    /**
     * Push a purchase to the data array
     *
     * @param array $fields An array of purchase fields
     * @return void
     */
    public function pushPurchase($fields)
    {
        $defaults = array(
            'id'           => '',
            'currencyCode' => 'GBP',
            'affiliation'  => '',
            'revenue'      => '0.00',
            'tax'          => '0.00',
            'shipping'     => '0.00'
        );
        self::$data['ecommerce']['purchase']['actionField'] = $this->getDefaults($fields, $defaults);
    }

    /**
     * Push a purchase item fields to the data array
     *
     * @param array $fields An array of a purchase item fields
     * @return void
     */
    public function pushPurchaseItem($fields)
    {
        $defaults = array(
            'id'   => '',
            'name' => 'GBP'
        );
        self::$data['ecommerce']['purchase']['products'][] = $this->getDefaults($fields, $defaults);
    }

    /**
     * Push a refund to the data array
     *
     * @param string $id The id of the transaction to refund
     * @return void
     */
    public function pushRefundTransaction($id)
    {
        self::$data['ecommerce']['refund']['actionField'] = array('id' => $id);
    }

    /**
     * Push a refund item to the data array
     *
     * @param string $id        The id of the transaction
     * @param string $productId The id of the item
     * @param int    $quantity  The quantity to refund
     * @return void
     */
    public function pushRefundTransactionItem($id, $productId, $quantity)
    {
        $this->pushRefundTransaction($id);

        self::$data['ecommerce']['refund']['products'][] = array('id' => $productId, 'quantity' => $quantity);
    }

    /**
     * Get the container ID
     *
     * @return string
     */
    public function getID()
    {
        return self::$id;
    }

    /**
     * Get the complete formatted dataLayer
     *
     * @return string | null
     */
    public function getDataLayer()
    {
        $count = count(self::$data);

        if($count > 0) return 'dataLayer.push('.json_encode(self::$data, JSON_PRETTY_PRINT).');';
    }

    /**
     * Compare an array against an array of required fields for a dataLayer property
     *
     * @param array $fields   Fields to check
     * @param array $defaults Default fields for this array
     * @return array
     */
    private function getDefaults($fields, $defaults)
    {
        foreach($defaults as $key => $value) {
            if(!isset($fields[$key])) {
                $fields[$key] = $value;
            }
        } 
        return $fields;
    }
}