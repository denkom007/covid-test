<?php

use yii\web\JsonResponseFormatter;
use yii\web\Request;
use yii\web\Response;

return [
    'request'  => [
        'class'   => Request::class,
        'parsers' => [
            'application/json' => 'yii\web\JsonParser',
        ],
        'enableCookieValidation' => false,
    ],
    'response' => [
        'class'         => Response::class,
        'format'        => Response::FORMAT_JSON,
        'formatters'    => [
            Response::FORMAT_JSON => [
                'class'         => JsonResponseFormatter::class,
                'prettyPrint'   => YII_DEBUG,
                'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
            ],
        ],
        'on beforeSend' => function ($event) {
            /** @var Response $response */
            $response = $event->sender;
            $exception = Yii::$app->errorHandler->exception;
            if ($response->data !== null) {
                $response->data = [
                    'success' => $response->isSuccessful,
                    'data'    => ($exception && YII_DEBUG) ? [
                        'message' => $exception->getMessage(),
                        'statusCode' => $exception->getCode(),
                        'trace'   => explode("\n", $exception->getTraceAsString()),
                    ] : $response->data,
                ];
            }
        },
    ],
];