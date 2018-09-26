<?php

namespace app\modules\admin;
use Yii;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // 设置模块错误页
        Yii::$app->errorHandler->errorAction = 'admin/index/error';

        // 自定义模块配置
        Yii::configure($this, require __DIR__ . '/config.php');
    }
}
