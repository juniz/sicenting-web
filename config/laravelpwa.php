<?php

return [
    'name' => 'SICENTING',
    'manifest' => [
        'name' => env('APP_NAME', 'SICENTING'),
        'short_name' => 'SICENTING',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation' => 'any',
        'status_bar' => 'black',
        'icons' => [
            '72x72' => [
                'path' => '/assets/icons/icon.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/assets/icons/icon.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/assets/icons/icon.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/assets/icons/icon.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/assets/icons/icon.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/assets/icons/icon.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '/assets/icons/icon.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/assets/icons/icon.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/images/icons/mobile-splash.png',
            '750x1334' => '/images/icons/mobile-splash.png',
            '828x1792' => '/images/icons/mobile-splash.png',
            '1125x2436' => '/images/icons/landscape.png',
            '1242x2208' => '/images/icons/landscape.png',
            '1242x2688' => '/images/icons/landscape.png',
            '1536x2048' => '/images/icons/landscape.png',
            '1668x2224' => '/images/icons/landscape.png',
            '1668x2388' => '/images/icons/landscape.png',
            '2048x2732' => '/images/icons/landscape.png',
        ],
        // 'shortcuts' => [
        //     [
        //         'name' => 'Shortcut Link 1',
        //         'description' => 'Shortcut Link 1 Description',
        //         'url' => '/shortcutlink1',
        //         'icons' => [
        //             "src" => "/images/icons/icon-72x72.png",
        //             "purpose" => "any"
        //         ]
        //     ],
        //     [
        //         'name' => 'Shortcut Link 2',
        //         'description' => 'Shortcut Link 2 Description',
        //         'url' => '/shortcutlink2'
        //     ]
        // ],
        'custom' => []
    ]
];
