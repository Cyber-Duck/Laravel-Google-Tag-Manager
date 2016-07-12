<?php

namespace CyberDuck\LaravelGoogleTagManager\Tests;

use CyberDuck\LaravelGoogleTagManager\Tests\Models\Product;

class TagManagerTest extends \Illuminate\Foundation\Testing\TestCase
{
    const GTMID = '123456';

    protected $baseUrl = 'http://localhost';

    protected $dummyData;

    public function createApplication()
    {
        $faker = \Faker\Factory::create();
        $this->dummyData = [
            'datalayer' => [
                'key' => $faker->word,
                'value' => $faker->word
            ],
            'event' => $faker->word,
            "list" => $faker->word,
            "purchase" => [
                "id" => $faker->word,
                "affiliation" => $faker->word,
                "revenue" => ''.$faker->randomFloat(2),
                "tax" => ''.$faker->randomFloat(2),
                "shipping" => ''.$faker->randomFloat(2),
                "coupon" => $faker->word,
                "products" => [
                    [
                        "id" => $faker->word,
                        "name" => $faker->word,
                        "quantity" => 1
                    ],
                    [
                        "id" => $faker->word,
                        "name" => $faker->word,
                        "quantity" => $faker->randomDigitNotNull,
                    ],
                    [
                        "id" => $faker->word,
                        "name" => $faker->word,
                        "quantity" => $faker->randomDigitNotNull,
                    ],
                ]
            ]
        ];

        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';
        $app->register(\CyberDuck\LaravelGoogleTagManager\GTMServiceProvider::class);
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        // Set a valid key
        $app["config"]["app"] = array_merge(
            $app["config"]["app"],
            ["key" =>"SomeRandomStringSomeRandomString"]
        );

        // Include package config file
        $config = require __DIR__.'/../config/config.php';
        $config["id"] = self::GTMID;
        $app["config"]["gtm"] = $config;

        require(__DIR__.'/app/route.php');

        $app['view']->addNamespace('test', __DIR__.'/app/views');

        return $app;
    }

    public function testIntegration()
    {
        $this->assertTrue($this->app->bound('cyberduck.gtm'));
    }

    public function testGtmId()
    {
        $this->visit('/')
            ->see('(window,document,\'script\',\'dataLayer\',\'GTM-'.(self::GTMID).'\')')
            ->dontSee('dataLayer.push');
    }

    public function testDataLayerPush()
    {
        $key = $this->dummyData['datalayer']['key'];
        $value = $this->dummyData['datalayer']['value'];
        $this->visit('/datalayer')
            ->see('dataLayer.push({"'.$key.'":"'.$value.'"});')
            ->dontSee('"event"')
            ->dontSee('"refund"')
            ->dontSee('"impression"')
            ->dontSee('"ecommerce"');
    }

    public function testFlashData()
    {
        $key = $this->dummyData['datalayer']['key'];
        $value = $this->dummyData['datalayer']['value'];
        $this->visit('/flash')
            ->seePageIs('/')
            ->see('dataLayer.push({"'.$key.'":"'.$value.'"});');
    }


    public function testEvent()
    {
        $eventName = $this->dummyData['event'];
        $this->visit('/event')
            ->see('dataLayer.push({"event":"'.$eventName.'"});')
            ->dontSee('"refund"')
            ->dontSee('"ecommerce"');
    }

    public function testCurrency()
    {
        $this->visit('/currency')
            ->see('dataLayer.push({"ecommerce":{"currencyCode":"EUR"}});')
            ->dontSee('"refund"')
            ->dontSee('"detail"')
            ->dontSee('"impression"')
            ->dontSee('"event"');
    }

    public function testCurrency2()
    {
        $this->visit('/currency2')
            ->see('dataLayer.push({"ecommerce":{"currencyCode":"USD"}});')
            ->dontSee('dataLayer.push({"ecommerce":{"currencyCode":"EUR"}});')
            ->dontSee('"refund"')
            ->dontSee('"detail"')
            ->dontSee('"impression"')
            ->dontSee('"event"');
    }

    public function testImpression()
    {
        $p1Id = $this->dummyData['purchase']['products'][0]['id'];
        $p1Name = $this->dummyData['purchase']['products'][0]['name'];
        $p2Id = $this->dummyData['purchase']['products'][1]['id'];
        $p2Name = $this->dummyData['purchase']['products'][1]['name'];
        $list = $this->dummyData['list'];
        $this->visit('/impression')
            ->see('dataLayer.push({"ecommerce":{"impressions":[{"id":"'.$p1Id.'","name":"'.
                $p1Name.'","list":"'.$list.'","position":0},{"id":"'.$p2Id.'","name":"'.
                $p2Name.'","list":"'.$list.'","position":1}]}});')
            ->dontSee('"refund"')
            ->dontSee('"detail"')
            ->dontSee('"purchase"')
            ->dontSee('"event"');
    }

    public function testImpressionCollection()
    {
        $p1Id = $this->dummyData['purchase']['products'][0]['id'];
        $p1Name = $this->dummyData['purchase']['products'][0]['name'];
        $p2Id = $this->dummyData['purchase']['products'][1]['id'];
        $p2Name = $this->dummyData['purchase']['products'][1]['name'];
        $list = $this->dummyData['list'];
        $this->visit('/impression')
            ->see('dataLayer.push({"ecommerce":{"impressions":[{"id":"'.$p1Id.'","name":"'.
                $p1Name.'","list":"'.$list.'","position":0},{"id":"'.$p2Id.'","name":"'.
                $p2Name.'","list":"'.$list.'","position":1}]}});')
            ->dontSee('"refund"')
            ->dontSee('"detail"')
            ->dontSee('"purchase"')
            ->dontSee('"event"');
    }

    public function testDetail()
    {
        $p1Id = $this->dummyData['purchase']['products'][0]['id'];
        $p1Name = $this->dummyData['purchase']['products'][0]['name'];
        $list = $this->dummyData['list'];
        $this->visit('/detail')
            ->see('dataLayer.push({"ecommerce":{"detail":{"actionField":{"list":"'.$list.
                '"},"products":[{"id":"'.$p1Id.'","name":"'.
                $p1Name.'"}]}}});')
            ->dontSee('"refund"')
            ->dontSee('"purchase"')
            ->dontSee('"event"');
    }

    public function testAddToCart()
    {
        $pId = $this->dummyData['purchase']['products'][2]['id'];
        $pName = $this->dummyData['purchase']['products'][2]['name'];
        $pQty = $this->dummyData['purchase']['products'][2]['quantity'];
        $this->visit('/add')
            ->see('dataLayer.push({"ecommerce":{"add":{"products":[{"id":"'.
                $pId.'","name":"'.$pName.'","quantity":'.$pQty.'}]}},"event":"addToCart"});')
            ->dontSee('"refund"')
            ->dontSee('"purchase"');
    }

    public function testRemoveToCart()
    {
        $pId = $this->dummyData['purchase']['products'][2]['id'];
        $pName = $this->dummyData['purchase']['products'][2]['name'];
        $pQty = $this->dummyData['purchase']['products'][2]['quantity'];
        $this->visit('/remove')
            ->see('dataLayer.push({"ecommerce":{"remove":{"products":[{"id":"'.
                $pId.'","name":"'.$pName.'","quantity":'.$pQty.'}]}},"event":"removeFromCart"});')
            ->dontSee('"refund"')
            ->dontSee('"purchase"');
    }

    public function testTransaction()
    {
        $id = $this->dummyData['purchase']['id'];
        $affiliation = $this->dummyData['purchase']['affiliation'];
        $revenue = $this->dummyData['purchase']['revenue'];
        $tax = $this->dummyData['purchase']['tax'];
        $shipping = $this->dummyData['purchase']['shipping'];
        $coupon = $this->dummyData['purchase']['coupon'];
        $p1Id = $this->dummyData['purchase']['products'][0]['id'];
        $p1Name = $this->dummyData['purchase']['products'][0]['name'];
        $p1Qty = $this->dummyData['purchase']['products'][0]['quantity'];
        $p2Id = $this->dummyData['purchase']['products'][1]['id'];
        $p2Name = $this->dummyData['purchase']['products'][1]['name'];
        $p2Qty = $this->dummyData['purchase']['products'][1]['quantity'];
        $p3Id = $this->dummyData['purchase']['products'][2]['id'];
        $p3Name = $this->dummyData['purchase']['products'][2]['name'];
        $p3Qty = $this->dummyData['purchase']['products'][2]['quantity'];
        $this->visit('/transaction')
            ->see('dataLayer.push({"ecommerce":{"purchase":{"actionField":{"id":"'.$id.
                '","affiliation":"'.$affiliation.'","revenue":"'.$revenue.'","tax":"'.
                $tax.'","shipping":"'.$shipping.'","coupon":"'.$coupon.
                '","currencyCode":"GBP"},"products":[{"id":"'.$p1Id.'","name":"'.
                $p1Name.'","quantity":'.$p1Qty.'},{"id":"'.$p2Id.'","name":"'.$p2Name.
                '","quantity":'.$p2Qty.'},{"id":"'.$p3Id.'","name":"'.$p3Name.'","quantity":'.
                $p3Qty.'}]}}});')
            ->dontSee('"refund"')
            ->dontSee('"impression"')
            ->dontSee('"event"');
    }

/*
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
    }*/
}
