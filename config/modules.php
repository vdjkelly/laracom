<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Module Namespace
    |--------------------------------------------------------------------------
    |
    | Default module namespace.
    |
    */

    'namespace' => 'Modules',

    'stubs' => [
        'enabled' => false,
        'path' => app_path() . '/Console/Commands/stubModules',
        'files' => [
            'start' => 'start.php',
            'routes' => 'Http/routes.php',
            'json' => 'module.json',
            'views/index' => 'Resources/views/index.blade.php',
            'views/master' => 'Resources/views/layouts/master.blade.php',
            'scaffold/config' => 'Config/config.php',
            'composer' => 'composer.json',
        ],
        'replacements' => [
            'start' => ['LOWER_NAME'],
            'routes' => ['LOWER_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE'],
            'json' => ['LOWER_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE'],
            'views/index' => ['LOWER_NAME'],
            'views/master' => ['STUDLY_NAME'],
            'scaffold/config' => ['STUDLY_NAME'],
            'composer' => [
                'LOWER_NAME',
                'STUDLY_NAME',
                'VENDOR',
                'AUTHOR_NAME',
                'AUTHOR_EMAIL',
                'MODULE_NAMESPACE',
            ],
        ],
    ],

    'paths' => [
        'modules' => base_path('modules'),

        'assets' => public_path('modules'),

        'migration' => base_path('database/migrations'),
        'generator' => [
            'assets' => 'Assets',
            'config' => 'Config',
            'command' => 'Console',
            'migration' => 'Database/Migrations',
            'model' => 'Entities',
            'services' => 'Services',
            'seeder' => 'Database/Seeders',
            'controller' => 'Http/Controllers',
            'filter' => 'Http/Middleware',
            'request' => 'Http/Requests',
            'provider' => 'Providers',
            'lang' => 'Resources/lang',
            'views' => 'Resources/views',
            'test' => 'Tests'
        ],
    ],
    'composer' => [
        'vendor' => 'vdjkelly',
        'author' => [
            'name' => 'Kelly Salazar',
            'email' => 'vdjkelly@gmail.com',
        ],
    ],
    'register' => [
        'translations' => true,
    ],
];
