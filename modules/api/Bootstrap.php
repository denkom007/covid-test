<?php
namespace app\modules\api;

use yii\base\BootstrapInterface;

/**
 * Class Bootstrap
 *
 * @package app\modules\api
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules(require __DIR__ . '/urls.php');
    }
}