<?php

return [
    'features' => [
        'quick_login' => env('QUICK_LOGIN_ENABLED', true),
    ],

    'company' => [
        'name' => 'Weberse Infotech Private Limited',
        'tagline' => 'Innovating Intelligence. Building the Future.',
        'primary_green' => '#73B655',
        'primary_blue' => '#0D2F50',
        'billing_url' => env('WHMCS_BASE_URL', 'https://billing.weberse.com'),
        'email' => 'info@weberse.com',
        'phone' => '+91 81769 91383',
        'whatsapp' => '+91 81769 91383',
        'skype' => 'live:.cid.f9a5dacb1a15fbc4',
        'location' => 'Jaipur, Rajasthan, India',
        'socials' => [
            'twitter' => 'https://twitter.com/weweberse',
            'facebook' => 'https://facebook.com/wewebere',
            'youtube' => 'https://youtube.com/weweberse',
            'linkedin' => 'https://linkedin.com/weweberse',
            'instagram' => 'https://instagram.com/weweberse',
        ],
    ],
];
