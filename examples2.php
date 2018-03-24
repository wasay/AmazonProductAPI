<?php

require('vendor/autoload.php');

use MarcL\AmazonAPI;
use MarcL\AmazonUrlBuilder;

// Should load these from environment variables
//include_once('./secretKeys.php');

// get amazon product api valid attributes
$config_locale = config('amazonproductapi.config');
$api_locale = $config_locale['locale'];
$configAmazonProductAPI = config('amazonproductapi.'.$api_locale.'.config');

// Keep these safe
$keyId = $configAmazonProductAPI['credentials']['api_key'];

$secretKey = $configAmazonProductAPI['credentials']['api_secret'];

$associateId = $configAmazonProductAPI['credentials']['associate_tag'];


// get amazon product api valid attributes
$config_response_groups = config('amazonproductapi.'.$api_locale.'.response.groups');
$response_groups = $config_response_groups['Featured'];

$config_search_names = config('amazonproductapi.'.$api_locale.'.search.names');
$search_names = array($config_search_names['Apparel']);

$config_references = config('amazonproductapi.'.$api_locale.'.references');
$sort_values = $config_references['data']['Fashion']['SortValues'][0];

// Setup a new instance of the AmazonUrlBuilder with your keys
$urlBuilder = new AmazonUrlBuilder(
    $keyId,
    $secretKey,
    $associateId,
    $api_locale['locale']
);

// Setup a new instance of the AmazonAPI with your keys
$amazonAPI = new AmazonAPI($urlBuilder, 'simple',
	$params = array(
		'searchNames' => $search_names,
		'responseGroups' => $response_groups,
		'sortValues' => $sort_values,
	)
);

// Need to avoid triggering Amazon API throttling
$sleepTime = 1.5;

// Item Search:
// Harry Potter in Books, sort by featured
$items = $amazonAPI->ItemSearch('harry potter', 'Books');
print('>> Harry Potter in Books, sort by featured');
var_dump($items);

sleep($sleepTime);

// Harry Potter in Books, sort by price low to high
$items = $amazonAPI->ItemSearch('harry potter', 'Books', 'price');
print('>> Harry Potter in Books, sort by price low to high');
var_dump($items);

sleep($sleepTime);

// Harry Potter in Books, sort by price high to low
$items = $amazonAPI->ItemSearch('harry potter', 'Books', '-price');
print('>> Harry Potter in Books, sort by price high to low');
var_dump($items);

sleep($sleepTime);

// Amazon echo, lookup only with Amazon as a seller
$items = $amazonAPI->ItemLookUp('B01GAGVIE4', true);
print('>> Look up specific ASIN\n');
var_dump($items);

sleep($sleepTime);

// Amazon echo, lookup with incorrect ASIN array
$asinIds = array('INVALID', 'INVALIDASIN', 'NOTANASIN');
$items = $amazonAPI->ItemLookUp($asinIds, true);
print('>> Look up specific ASIN\n');
var_dump($items);
var_dump($amazonAPI->GetErrors());
?>
