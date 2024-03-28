<?php

return [
    [
        'key' => 'sales.payment_methods.iyzico',
        'name' => 'Iyzico',
		'info' => 'iyzico::app.admin.system.info',
        'sort' => 5,
        'fields' => [
            [
                'name' => 'title',
                'title' => 'iyzico::app.admin.system.title',
                'type' => 'text',
                'validation' => 'required',
                'channel_based' => false,
                'locale_based' => true
            ], [
                'name' => 'description',
                'title' => 'iyzico::app.admin.system.description',
                'type' => 'textarea',
                'validation' => 'required',
                'channel_based' => false,
                'locale_based' => true
            ], [
                'name' => 'public_key',
                'title' => 'iyzico::app.admin.system.public-key',
                'type' => 'text',
                'validation' => 'required',
                'channel_based' => false,
                'locale_based' => true
            ], [
                'name'          => 'secret_key',
                'title'         => 'iyzico::app.admin.system.secret-key',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ],/* [
                'name'          => 'allowed_installments',
                'title'         => 'iyzico::app.admin.system.allowed-installments',
                'type'			=> 'text',
                'validation'	=> 'numeric',
				'default_value' => '0',
                'channel_based' => false,
                'locale_based'  => true,
				'default_value' => '1',
            ], */[
                'name' => 'sandbox',
                'title' => 'iyzico::app.admin.system.sandbox',
                'type' => 'boolean',
                'channel_based' => false,
                'locale_based'  => true
            ], [
                'name' => 'status',
                'title' => 'iyzico::app.admin.system.status',
                'type' => 'boolean',                
                'validation' => 'required',
                'channel_based' => false,
                'locale_based'  => true
            ], [
                'name' => 'sort',
                'title' => 'iyzico::app.admin.system.sort',
                'type' => 'select',
                'channel_based' => false,
                'locale_based'  => true,
				'options' => [
                    [
                        'title' => '1',
                        'value' => '1',
                    ], [
                        'title' => '2',
                        'value' => '2',
                    ], [
                        'title' => '3',
                        'value' => '3',
                    ], [
                        'title' => '4',
                        'value' => '4',
                    ], [
                        'title' => '5',
                        'value' => '5',
                    ],
                ],
            ],			
        ],
    ],
   
];