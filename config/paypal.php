<?php
/*	return [
		'client_id'=>env('PAYPAL_CLIENT_ID',''),
		'secret'=>env('PAYPAL_SECRET',''),
		'settings'=>array(
			'mode'=>env('PAYPAL_MODE',''),
			'http.ConnectionTimeOut'=>30,
			'log.LogEnabled'=>true,
			'log.FileName'=>storage_path().'/logs/paypal.log',
			'log.LogLevel'=>'ERROR',
		),
	];*/



return array(

    /**
     * Set our Sandbox and Live credentials
     */
    'sandbox_client_id' => env('PAYPAL_CLIENT_ID', ''),
    'sandbox_secret' => env('PAYPAL_SECRET', ''),
    'live_client_id' => env('PAYPAL_LIVE_CLIENT_ID', ''),
    'live_secret' => env('PAYPAL_LIVE_SECRET', ''),

    
    /**
     * SDK configuration settings
     */
    'settings' => array(

        /** 
         * Payment Mode
         *
         * Available options are 'sandbox' or 'live'
         */
        'mode' => env('PAYPAL_MODE', 'sandbox'),
        
        'http.ConnectionTimeOut' => 3000,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'DEBUG'
    ),
);
