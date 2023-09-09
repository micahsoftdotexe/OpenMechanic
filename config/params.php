<?php

return [
    'companyName'        => 'Company Name',
    'companyLogo'        => 'Path to Company Logo', //Not implemented into anywhere yet
    'companyAddress'     => 'Company Address',
    'companyPhoneNumber' => 'Company Phone Number',
    'senderEmail'        => 'noreply@example.com',
    'sales_tax'          => 0.07,
    'timezone'           => 'America/New_York',
    'adminEmail'         => 'admin@email.com',
    'senderName'         => 'Admin',
    'corsSettings'       => [
        'Origin'         => ['http://localhost:5173'],
        'Access-Control-Allow-Credentials' => true,

        'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],

        'Access-Control-Request-Headers' => ['Origin', 'X-Requested-With', 'Content-Type', 'accept', 'Authorization'],
    ],
];
