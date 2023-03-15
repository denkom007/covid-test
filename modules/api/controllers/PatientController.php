<?php

namespace app\modules\api\controllers;

use Yii;
use yii\web\Response;
use yii\base\InvalidConfigException;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\ContentNegotiator;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use app\modules\api\forms\PatientFilterForm;

class PatientController extends ActiveController
{
    public $modelClass = 'app\modules\api\models\Patient';
    
    public $serializer = [
        'class'              => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
    
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        
        $behaviors['authenticator'] = [
            'class'       => CompositeAuth::class,
            'authMethods' => [
                HttpBearerAuth::class,
                QueryParamAuth::class,
            ],
            'optional'    => ['list', 'create'],
        ];
        
        $behaviors['access'] = [
            'class'        => AccessControl::class,
            'rules'        => [
                [
                    'actions' => ['list'],
                    'allow'   => true,
                    'roles'   => ['@'],
                    'verbs'   => ['GET', 'POST'],
                ],
                [
                    'actions' => ['create'],
                    'allow'   => true,
                    'roles'   => ['@'],
                    'verbs'   => ['POST'],
                ],
            ],
            'denyCallback' => function () {
                throw new ForbiddenHttpException('Forbidden', 403);
            },
        ];
        
        $behaviors['contentNegotiator'] = [
            'class'   => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        
        return $behaviors;
    }
    
    public function actions(): array
    {
        return [];
    }
    
    /**
     * @throws InvalidConfigException
     */
    public function actionList()
    {
        $form = new PatientFilterForm();
        
        $request = Yii::$app->getRequest();
        $params = $request->isGet ? $request->get() : $request->getBodyParams();
        
        if ($form->load($params) && $form->validate()) {
            return $form->getDataProvider();
        }
        
        if (!empty($form->errors)) {
            Yii::$app->response->statusCode = 422;
            
            return $form->errors;
        }
        
        return null;
    }
    
    /**
     * @throws InvalidConfigException
     */
    public function actionCreate(): ?array
    {
        $model = new $this->modelClass;
        
        $request = Yii::$app->getRequest();
        $params = $request->getBodyParams();
        
        if ($model->load($params) && $model->save()) {
            return ['patient_id' => $model->id];
        }
        
        if (!empty($model->errors)) {
            Yii::$app->response->statusCode = 422;
            
            return $model->errors;
        }
        
        return null;
    }
}