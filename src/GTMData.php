<?php

/**
 * Persistenet data storage class which deals with the values of the Tag Manager container and dataLayer
 *
 * @package cyber-duck/laravel-google-tag-manager
 * @license MIT License https://github.com/cyber-duck/laravel-google-tag-manager/blob/master/LICENSE
 * @author  <andrewm@cyber-duck.co.uk>
 **/
namespace CyberDuck\LaravelGoogleTagManager;

class GTMData
{
    /**
     * The Tag Manager container ID
     *
     * @var string
     */
    private $id;

    /**
     * The Tag Manager dataLayer array of values
     *
     * @var array
     */
    private $data = array();

    /**
     * The datalayer JSON string
     *
     * @var string
     */
    private $json;

    /**
     * Constructor
     */
    public function __construct($id = null)
    {
        if ($id) {
            $this->setID($id);
        }
    }

    /**
     * Set the container ID to a static class property
     *
     * @param string $id The container ID
     * @return void
     */
    public function setID($id)
    {
        $this->id = $id;
    }

    /**
     * Get the container ID
     *
     * @return string
     */
    public function getID()
    {
        return $this->id;
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
        $this->data[$name] = $value;
    }

    /**
     * Push an event to the data array
     *
     * @param string $name  The event name
     * @return void
     */
    public function pushEvent($name)
    {
        $this->data['event'] = $name;
    }

    /**
     * Push a transaction currency the data array
     *
     * @param string $code ISO 4217 format currency code e.g. EUR
     * @return void
     */
    public function pushTransactionCurrency($code)
    {
        $this->data['ecommerce']['currencyCode'] = $code;
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
            'currencyCode' => config('gtm.ecommerce.currency'),
            'affiliation'  => '',
            'revenue'      => '0.00',
            'tax'          => '0.00',
            'shipping'     => '0.00'
        );
        $this->data['ecommerce']['purchase']['actionField'] = $this->getDefaults($fields, $defaults);
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
            'name' => ''
        );
        $this->data['ecommerce']['purchase']['products'][] = $this->getDefaults($fields, $defaults);
    }

    /**
     * Push a details actionField
     *
     * @param string $list The list field
     * @return void
     */
    public function pushDetailsList($list)
    {
        $this->data['ecommerce']['detail']['actionField']['list'] = $list;
    }

    /**
     * Push a details item fields to the data array
     *
     * @param array $fields An array of a purchase item fields
     * @return void
     */
    public function pushDetailsItem($fields)
    {
        $defaults = array(
            'id'   => '',
            'name' => ''
        );
        $this->data['ecommerce']['detail']['products'][] = $this->getDefaults($fields, $defaults);
    }

    /**
     * Push a product impression to the data array
     *
     * @param array $fields An array of item fields
     * @return void
     */
    public function pushProductImpression($fields)
    {
        $defaults = array(
            'id'   => '',
            'name' => ''
        );
        $this->data['ecommerce']['impressions'][] = $this->getDefaults($fields, $defaults);
    }

    /**
     * Push a product promotional impression to the data array
     *
     * @param array $fields An array of item fields
     * @return void
     */
    public function pushProductPromoImpression($fields)
    {
        $defaults = array(
            'id'   => '',
            'name' => ''
        );
        $this->data['ecommerce']['promoView']['promotions'][] = $this->getDefaults($fields, $defaults);
    }

    /**
     * Push a refund to the data array
     *
     * @param string $id The id of the transaction to refund
     * @return void
     */
    public function pushRefundTransaction($id)
    {
        $this->data['ecommerce']['refund']['actionField'] = array('id' => $id);
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

        $this->data['ecommerce']['refund']['products'][] = array('id' => $productId, 'quantity' => $quantity);
    }

    /**
     * Push a cart add action to the data array
     *
     * @param array $fields An array of item fields
     * @return void
     */
    public function pushAddToCart($fields)
    {
        $this->pushCartAction('add', 'addToCart', $fields);
    }

    /**
     * Push a cart remove action to the data array
     *
     * @param array $fields An array of item fields
     * @return void
     */
    public function pushRemoveFromCart($fields)
    {
        $this->pushCartAction('remove', 'removeFromCart', $fields);
    }

    /**
     * Push a cart action to the data array
     *
     * @param array $action The cart action
     * @param array $event  The event name of the action
     * @param array $fields An array of item fields
     * @return void
     */
    public function pushCartAction($action, $event, $fields)
    {
        $this->pushCurrent();

        $defaults = array(
            'id'   => '',
            'name' => ''
        );
        $this->data['ecommerce'][$action]['products'][] = $this->getDefaults($fields, $defaults);

        // add to cart actions require their own event action and push
        $this->pushEvent($event);
        $this->pushCurrent();
    }

    /**
     * @param array $data
     * @return void
     */
    public function pushDataLayer($data)
    {
        $this->data = array_merge_recursive($this->data, $data);
    }


    /**
     * Get the complete formatted dataLayer
     *
     * @return string | null
     */
    public function getDataLayer()
    {
        $this->pushCurrent();

        return $this->json;
    }

    /**
     * Create a dataLayer push from the current data array
     *
     * @return void
     */
    private function pushCurrent()
    {
        if (!empty($this->data)) {
            $this->json .= 'dataLayer.push('.json_encode($this->data).');';
            $this->data = array();
        }
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
        foreach ($defaults as $key => $value) {
            if (!isset($fields[$key])) {
                $fields[$key] = $value;
            }
        }
        return $fields;
    }
}
