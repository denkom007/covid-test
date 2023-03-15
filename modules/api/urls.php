<?php

use yii\rest\UrlRule;

return [
    [
        'class'         => UrlRule::class,
        'controller'    => 'api/patient',
        'pluralize'     => false,
        'only'          => ['list', 'create'],
        'extraPatterns' => [
            'GET list'    => 'list',
            'POST list'   => 'list',
            'POST create' => 'create',
        ],
    ],
    '/api'                       => 'api/error/not-found',
    '/api/<controller>'          => 'api/error/not-found',
    '/api/<controller>/<action>' => 'api/error/not-found',
];