<?php

return [

	'credentials'  => [
		'api_key'    => env('AWS_API_KEY', 'YOUR-AWS-KEY'),
		'api_secret' => env('AWS_API_SECRET_KEY', 'DO-NOT-ADD-YOUR-API-SECRET-IN-THIS-FILE'),

		'associate_tag' => env('AWS_ASSOCIATE_TAG', 'YOUR-AMAZON-ASSOCIATE-ID'),
	],

	// Valid names that can be used for search
	'search_names' => [
		'All',
		'Apparel',
		'Appliances',
		'Automotive',
		'Baby',
		'Beauty',
		'Blended',
		'Books',
		'Classical',
		'DVD',
		'Electronics',
		'Grocery',
		'HealthPersonalCare',
		'HomeGarden',
		'HomeImprovement',
		'Jewelry',
		'KindleStore',
		'Kitchen',
		'Lighting',
		'Marketplace',
		'MP3Downloads',
		'Music',
		'MusicTracks',
		'MusicalInstruments',
		'OfficeProducts',
		'OutdoorLiving',
		'Outlet',
		'PetSupplies',
		'PCHardware',
		'Shoes',
		'Software',
		'SoftwareVideoGames',
		'SportingGoods',
		'Tools',
		'Toys',
		'VHS',
		'Video',
		'VideoGames',
		'Watches',
	],


	// Specifies the types of values to return.
	// Separate multiple response groups with commas.
	// Type = String
	// Default = Small
	// List Last Updated = 2018-03-10 (yyyy-mm-dd)

	'response_groups' => [
		'Accessories',
		'AlternateVersions',
		'BrowseNodeInfo',
		'BrowseNodes',
		'Cart',
		'CartNewReleases',
		'CartTopSellers',
		'CartSimilarities',
		'EditorialReview',
		'Images',
		'ItemAttributes',
		'ItemIds',
		'Large',
		'Medium',
		'MostGifted',
		'MostWishedFor',
		'NewReleases',
		'OfferFull',
		'OfferListings',
		'Offers',
		'OfferSummary',
		'PromotionSummary',
		'RelatedItems',
		'Request',
		'Reviews',
		'SalesRank',
		'SearchBins',
		'Similarities',
		'Small',
		'TopSellers',
		'Tracks',
		'Variations',
		'VariationImages',
		'VariationMatrix',
		'VariationOffers',
		'VariationSummary',
	],
	
	// add project custom settings below

];