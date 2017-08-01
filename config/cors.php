<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Laravel CORS
     |--------------------------------------------------------------------------
     |
     | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
     | to accept any value.
     |
     */
    'supportsCredentials' => false,
    'allowedOrigins' => ['*'],
		
    'allowedHeaders' => ['*'],
    'allowedMethods' => ['*'],
    /*
	'allowedHeaders' => ['Origin', 'X-Requested-With', 'Content-Type', 'Accept', 'Authorization'],
	'allowedMethods' => ['GET', 'POST', 'OPTIONS', 'PUT', 'PATCH', 'DELETE'],
	*/
    'exposedHeaders' => [],
    'maxAge' => 0,
];

