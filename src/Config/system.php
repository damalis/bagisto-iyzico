<?php

return [
    [
        'key' => 'sales.paymentmethods.iyzicoPayment',
        'name' => 'iyzico::app.admin.system.iyzicoPayment',
        'sort' => 5,
        'fields' => [
            [
                'name' => 'title',
                'title' => 'iyzico::app.admin.system.title',
                'type' => 'text',
                'validation' => 'required',
                'channel_based' => true,
                'locale_based' => true
            ],[
                'name' => 'description',
                'title' => 'iyzico::app.admin.system.description',
                'type' => 'textarea',
                'validation' => 'required',
                'channel_based' => false,
                'locale_based' => true
            ],[
                'name' => 'public_key',
                'title' => 'iyzico::app.admin.system.public-key',
                'type' => 'text',
                'validation' => 'required',
                'channel_based' => true,
                'locale_based' => true
            ],[
                'name'          => 'secret_key',
                'title'         => 'admin::app.admin.system.secret-key',
                'type'          => 'text',
                'validation'    => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ],[
                'name' => 'sandbox',
                'title' => 'iyzico::app.admin.system.sandbox',
                'type' => 'boolean',
                'channel_based' => false,
                'locale_based'  => true
            ],[
                'name' => 'active',
                'title' => 'iyzico::app.admin.system.status',
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
                'name' => 'paymentfromapplicablecountries',
                'title' => 'iyzico::app.admin.system.paymentFromApplicableCountries',
                'type' => 'select',
                'options' => [
                    [
                        'title' => 'All Allowed Countries',
                        'value' => false
                    ], [
                        'title' => 'Specific Countries',
                        'value' => true
                    ]
                ],
                'validation' => 'required'
            ],[
                'name' => 'paymentfromspecificcountries',
                'title' => 'iyzico::app.admin.system.paymentFromSpecificCountries',
                'info' => 'Applicable if specific countries are selected',
                'type' => 'multiselect',
                'channel_based' => true,
                'locale_based' => true,
                'repository'=>'Damalis\Iyzico\Repositories\IyzicoRepository@getCountry'
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