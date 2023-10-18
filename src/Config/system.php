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
                'channel_based' => true,
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
                'title' => 'iyzico::app.admin.system.public_key',
                'type' => 'text',
                'validation' => 'required',
                'channel_based' => true,
                'locale_based' => true
            ],[
                'name'          => 'secret_key',
                'title'         => 'iyzico::app.admin.system.secret_key',
                'type'          => 'text',
                'validation'    => 'required',
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
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'Active',
                        'value' => true
                    ], [
                        'title' => 'Inacitve',
                        'value' => false
                    ]
                ],
                'validation' => 'required'
            ],[
                'name' => 'sort',
                'title' => 'iyzico::app.admin.system.sort',
                'type' => 'select',
                'options' => [
                    [
                        'title' => '1',
                        'value' => 1
                    ], [
                        'title' => '2',
                        'value' => 2
                    ], [
                        'title' => '3',
                        'value' => 3
                    ], [
                        'title' => '4',
                        'value' => 4
                    ]
                ],
            ]      
        ],
    ],
   
];