<?php

use CyberDuck\LaravelGoogleTagManager\GTM;

class TagManagerTest extends TestCase
{
    public $gtm;

    public function __construct()
    {
        $this->gtm = new GTM();
    }

    public function testContainerID()
    {
        $this->gtm->id('123456');

        $this->assertContains('GTM-123456', $this->gtm->code());
    }

    public function testDataLayerPush()
    {
        $this->gtm->data('testKey', 'testValue');

        $this->assertContains('"testKey": "testValue"', $this->gtm->code());
    }

    public function testEventPush()
    {
        $this->gtm->event('testEvent');

        $this->assertContains('"event": "testEvent"', $this->gtm->code());
    }

    public function testTransactionCurrency()
    {
        $this->gtm->transactionCurrency('EUR');
        
        $this->assertContains('"currencyCode": "EUR"', $this->gtm->code());
    }

    public function testTransaction()
    {
        $transaction = array(   
            'id'          => 'T_ID',
            'affiliation' => 'T_AFFILIATION',
            'revenue'     => '99.99',
            'tax'         => '4.55',
            'shipping'    => '1.22',
            'coupon'      => 'T_COUPON'
        );
        $this->gtm->purchase($transaction);

        $this->assertContains('"ecommerce": {', $this->gtm->code());

        $this->assertContains('"purchase": {', $this->gtm->code());
        $this->assertContains('"id": "T_ID"', $this->gtm->code());
        $this->assertContains('"tax": "4.55"', $this->gtm->code());
        $this->assertContains('"revenue": "99.99"', $this->gtm->code());
        $this->assertContains('"shipping": "1.22"', $this->gtm->code());
        $this->assertContains('"coupon": "T_COUPON"', $this->gtm->code());
        $this->assertContains('"currencyCode": "GBP"', $this->gtm->code());
        $this->assertContains('"affiliation": "T_AFFILIATION"', $this->gtm->code());

        $items = array(
            array(
                'id'   => '1',
                'name' => 'T_PRODUCT_1'
            ),
            array(
                'id'   => '2',
                'name' => 'T_PRODUCT_2'
            )
        );
        foreach($items as $item){
            $this->gtm->purchaseItem($item);
        }

        $this->assertContains('"products": [', $this->gtm->code());
        $this->assertContains('"name": "T_PRODUCT_1"', $this->gtm->code());
        $this->assertContains('"name": "T_PRODUCT_2"', $this->gtm->code());
    }

    public function testRefunds()
    {
        $this->gtm->refundTransaction('REFUND_ID');

        $this->assertContains('"refund": {', $this->gtm->code());
        $this->assertContains('"id": "REFUND_ID"', $this->gtm->code());

        $this->gtm->refundItem('REFUND_ID', 'REFUND_ITEM_1', 3);
        
        $this->assertContains('"id": "REFUND_ITEM_1"', $this->gtm->code());
        $this->assertContains('"quantity": 3',         $this->gtm->code());
    }

    public function testProductImpressions()
    {
        $items = array(
            array(
                'id'   => '1',
                'name' => 'I_PRODUCT_1'
            ),
            array(
                'id'   => '2',
                'name' => 'I_PRODUCT_2'
            )
        );
        foreach($items as $item){
            $this->gtm->productImpression($item);
        }
        
        $this->assertContains('"impressions": [', $this->gtm->code());
        $this->assertContains('"name": "I_PRODUCT_1"', $this->gtm->code());
        $this->assertContains('"name": "I_PRODUCT_2"', $this->gtm->code());
    }

    public function testAddAndRemoveFromCart()
    {
        $items = array(
            array(
                'id'   => '1',
                'name' => 'A_PRODUCT_1'
            ),
            array(
                'id'   => '2',
                'name' => 'A_PRODUCT_2'
            )
        );
        foreach($items as $item){
            $this->gtm->addToCart($item);
        }
        
        $this->assertContains('"add": {', $this->gtm->code());
        $this->assertContains('"name": "A_PRODUCT_1"', $this->gtm->code());
        $this->assertContains('"name": "A_PRODUCT_2"', $this->gtm->code());

        $items = array(
            array(
                'id'   => '1',
                'name' => 'R_PRODUCT_1'
            ),
            array(
                'id'   => '2',
                'name' => 'R_PRODUCT_2'
            )
        );
        foreach($items as $item){
            $this->gtm->removeFromCart($item);
        }
        
        $this->assertContains('"remove": {', $this->gtm->code());
        $this->assertContains('"name": "R_PRODUCT_1"', $this->gtm->code());
        $this->assertContains('"name": "R_PRODUCT_2"', $this->gtm->code());
    }
}
