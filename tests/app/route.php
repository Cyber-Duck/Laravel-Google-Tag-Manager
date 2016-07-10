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
        return view('test::test');
    });
    Route::get('mix', function () {
        \CyberDuck\LaravelGoogleTagManager\Facades\GTM::data('testKey', 'testValue');
        \CyberDuck\LaravelGoogleTagManager\Facades\GTM::event('testEvent');
        \CyberDuck\LaravelGoogleTagManager\Facades\GTM::transactionCurrency('EUR');
        return view('test::test');
    });