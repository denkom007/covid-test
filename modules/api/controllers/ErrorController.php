<?php
namespace app\modules\api\controllers;

use yii\filters\ContentNegotiator;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ErrorController extends Controller
{
    public function behaviors(): array
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }
    
    /**
     * @throws ForbiddenHttpException
     */
    public function actionForbidden()
    {
        throw new ForbiddenHttpException('Forbidden', 403);
    }
    
    /**
     * @throws NotFoundHttpException
     */
    public function actionNotFound()
    {
        throw new NotFoundHttpException('Not Found', 404);
    }
    
    /**
     * @throws MethodNotAllowedHttpException
     */
    public function actionNotAllowed()
    {
        throw new MethodNotAllowedHttpException('Not Allowed', 405);
    }
}