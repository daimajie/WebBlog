<?php

namespace app\modules\home\modules\center;
use Yii;

/**
 * center module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\home\modules\center\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function beforeAction($action)
    {
        if( parent::beforeAction($action) ){

            $isGuest = Yii::$app->getUser()->isGuest;
            if( $isGuest ){
                Yii::$app->getUser()->loginRequired();
                return false;
            }

            return true;
        }

        return false;
    }
}
