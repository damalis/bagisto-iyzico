<?php

return [
    [
        'key' => 'sales.paymentmethods.iyzico',
        'name' => 'Iyzico',
        'sort' => 5,
        'fields' => [
            [
                'name' => 'title',
                'title' => 'admin::app.admin.system.title',
                'type' => 'text',
                'validation' => 'required',
                'channel_based' => false,
                'locale_based' => true
            ],[
                'name' => 'description',
                'title' => 'admin::app.admin.system.description',
                'type' => 'textarea',
                'validation' => 'required',
                'channel_based' => false,
                'locale_based' => true
            ],[
                'name' => 'public_key',
                'title' => 'iyzico::app.admin.system.public-key',
                'type' => 'text',
                'validation' => 'required',
                'channel_based' => false,
                'locale_based' => true
            ],[
                'name'          => 'secret_key',
                'title'         => 'iyzico::app.admin.system.secret-key',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ],[
                'name'          => 'allowed_installments',
                'title'         => 'iyzico::app.admin.system.allowed-installments',
                'type'			=> 'text',
                'validation'	=> 'numeric',
				'default_value' => '0',
                'channel_based' => false,
                'locale_based'  => true,
            ],[
                'name' => 'sandbox',
                'title' => 'admin::app.admin.system.sandbox',
                'type' => 'boolean',
                'channel_based' => false,
                'locale_based'  => true
            ],[
                'name' => 'active',
                'title' => 'admin::app.admin.system.status',
                'type' => 'boolean',                
                'validation' => 'required',
                'channel_based' => false,
                'locale_based'  => true
            ]     
        ],
    ],
   
];