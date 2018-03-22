<?php

return [

	'credentials'  => [
		'api_key'    => env('AWS_API_KEY', 'YOUR-AWS-KEY'),
		'api_secret' => env('AWS_API_SECRET_KEY', 'DO-NOT-ADD-YOUR-API-SECRET-IN-THIS-FILE'),

		'associate_tag' => env('AWS_ASSOCIATE_TAG', 'YOUR-AMAZON-ASSOCIATE-ID'),
	],

	// add your custom settings below //

];