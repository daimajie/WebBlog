<?php

namespace app\modules\home;
use Yii;

/**
 * home module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\home\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // 自定义模块配置
        Yii::configure($this, require __DIR__ . '/config.php');
    }
}
