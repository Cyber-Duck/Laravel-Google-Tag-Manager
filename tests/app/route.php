<?php
    Route::get('/', function () {
        return view('test::test');
    });
    Route::get('datalayer', function () {
        \CyberDuck\LaravelGoogleTagManager\Facades\GTM::data(
            $this->dummyData['datalayer']['key'],
            $this->dummyData['datalayer']['value']
        );
        return view('test::test');
    });
    Route::get('flash', function () {
        \CyberDuck\LaravelGoogleTagManager\Facades\GTM::data(
            $this->dummyData['datalayer']['key'],
            $this->dummyData['datalayer']['value']
        );
        \CyberDuck\LaravelGoogleTagManager\Facades\GTM::flash();
        return redirect('/');
    });
    Route::get('event', function () {
        \CyberDuck\LaravelGoogleTagManager\Facades\GTM::event($this->dummyData['event']);
        return view('test::test');
    });
    Route::get('currency', function () {
        \CyberDuck\LaravelGoogleTagManager\Facades\GTM::transactionCurrency('EUR');
        return view('test::test');
    });
    Route::get('currency2', function () {
        \CyberDuck\LaravelGoogleTagManager\Facades\GTM::transactionCurrency('USD');
        return view('test::test');
    });
    Route::get('impression', function () {
        $list = $this->dummyData['list'];
        $productAsArray = [
            'id' => $this->dummyData['purchase']['products'][0]['id'],
            'name' => $this->dummyData['purchase']['products'][0]['name']
        ];
        $product = new CyberDuck\LaravelGoogleTagManager\Tests\Models\Product();
        $product->shoppableid = $this->dummyData['purchase']['products'][1]['id'];
        $product->name = $this->dummyData['purchase']['products'][1]['name'];
        \CyberDuck\LaravelGoogleTagManager\Facades\GTM::productImpression($productAsArray, $list, 0);
        \CyberDuck\LaravelGoogleTagManager\Facades\GTM::productImpression($product, $list, 1);
        return view('test::test');
    });
    Route::get('impression2', function () {
        $list = $this->dummyData['list'];
        $product1 = new CyberDuck\LaravelGoogleTagManager\Tests\Models\Product();
        $product1->shoppableid = $this->dummyData['purchase']['products'][0]['id'];
        $product1->name = $this->dummyData['purchase']['products'][0]['name'];
        $product2 = new CyberDuck\LaravelGoogleTagManager\Tests\Models\Product();
        $product2->shoppableid = $this->dummyData['purchase']['products'][1]['id'];
        $product2->name = $this->dummyData['purchase']['products'][1]['name'];
        $products = collect($product1, $product2);
        \CyberDuck\LaravelGoogleTagManager\Facades\GTM::productImpressions($products, $list);
        return view('test::test');
    });
    Route::get('detail', function () {
        $list = $this->dummyData['list'];
        $product = new CyberDuck\LaravelGoogleTagManager\Tests\Models\Product();
        $product->shoppableid = $this->dummyData['purchase']['products'][0]['id'];
        $product->name = $this->dummyData['purchase']['products'][0]['name'];
        \CyberDuck\LaravelGoogleTagManager\Facades\GTM::productDetail($product, $list);
        return view('test::test');
    });
    Route::get('add', function () {
        $product = new CyberDuck\LaravelGoogleTagManager\Tests\Models\Product();
        $product->shoppableid = $this->dummyData['purchase']['products'][2]['id'];
        $product->name = $this->dummyData['purchase']['products'][2]['name'];
        \CyberDuck\LaravelGoogleTagManager\Facades\GTM::addToCart(
            $product,
            $this->dummyData['purchase']['products'][2]['quantity']
        );
        return view('test::test');
    });
    Route::get('remove', function () {
        $product = new CyberDuck\LaravelGoogleTagManager\Tests\Models\Product();
        $product->shoppableid = $this->dummyData['purchase']['products'][2]['id'];
        $product->name = $this->dummyData['purchase']['products'][2]['name'];
        \CyberDuck\LaravelGoogleTagManager\Facades\GTM::removeFromCart(
            $product,
            $this->dummyData['purchase']['products'][2]['quantity']
        );
        return view('test::test');
    });
    Route::get('transaction', function () {
        $transaction = array(
            'id'          => $this->dummyData['purchase']['id'],
            'affiliation' => $this->dummyData['purchase']['affiliation'],
            'revenue'     => $this->dummyData['purchase']['revenue'],
            'tax'         => $this->dummyData['purchase']['tax'],
            'shipping'    => $this->dummyData['purchase']['shipping'],
            'coupon'      => $this->dummyData['purchase']['coupon'],
        );
        \CyberDuck\LaravelGoogleTagManager\Facades\GTM::purchase($transaction);
        \CyberDuck\LaravelGoogleTagManager\Facades\GTM::purchaseItem(
            [
                'id' => $this->dummyData['purchase']['products'][0]['id'],
                'name' => $this->dummyData['purchase']['products'][0]['name']
            ]
        );
        \CyberDuck\LaravelGoogleTagManager\Facades\GTM::purchaseItem(
            [
                'id' => $this->dummyData['purchase']['products'][1]['id'],
                'name' => $this->dummyData['purchase']['products'][1]['name']
            ],
            $this->dummyData['purchase']['products'][1]['quantity']
        );
        $product = new CyberDuck\LaravelGoogleTagManager\Tests\Models\Product();
        $product->shoppableid = $this->dummyData['purchase']['products'][2]['id'];
        $product->name = $this->dummyData['purchase']['products'][2]['name'];
        \CyberDuck\LaravelGoogleTagManager\Facades\GTM::purchaseItem(
            $product,
            $this->dummyData['purchase']['products'][2]['quantity']
        );
        return view('test::test');
    });