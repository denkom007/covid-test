<?php

namespace app\modules\api;

use Yii;
use yii\base\Module as BaseModule;

/**
 * Class Module
 *
 * @package app\modules\api
 */
class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public $defaultRoute = 'api/error/not-found';
    
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\api\controllers';
    
    /**
     * @inheritdoc
     */
    public $controllerMap = [
        'patient' => 'app\modules\api\controllers\PatientController',
        'error'   => 'app\modules\api\controllers\ErrorController',
    ];
    
    public function init()
    {
        parent::init();
        
        Yii::$app->user->enableSession = true;
        
        Yii::$app->setComponents(require __DIR__ . '/components.php');
    }
}
