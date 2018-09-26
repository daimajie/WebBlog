<?php
/**
 * Created by PhpStorm.
 * User: daimajie
 * Date: 2018/9/20
 * Time: 21:34
 */
namespace app\modules\admin\controllers;

class IndexController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    //后台首页
    public function actionIndex(){
        return $this->render('index');
    }


}