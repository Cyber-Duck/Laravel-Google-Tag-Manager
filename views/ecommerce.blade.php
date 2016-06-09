@inject('gtm', 'GTM')

@if (!empty($transaction))

    {{ $gtm->purchase(array(
    	'id'          => $transaction['id'],
    	'affiliation' => $transaction['affiliation'],
    	'revenue'     => $transaction['revenue'],
    	'shipping'    => $transaction['shipping'],
    	'tax'         => $transaction['tax'],
    )) }}

    @foreach ($items as &$item)

    	{{ $gtm->purchaseItem(array(
    		'id'       => $transaction['id'],
    		'name'     => $item['name'],
    		'sku'      => $item['sku'],
    		'category' => $item['category'],
    		'price'    => $item['price'],
    		'quantity' => $item['quantity']
    	)) }}

    @endforeach
    
@endif