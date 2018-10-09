<?php
/**
 * Created by PhpStorm.
 * User: daimajie
 * Date: 2018/9/20
 * Time: 21:34
 */
namespace app\modules\admin\controllers;


use app\models\blog\BlogArticle;
use app\models\member\Contact;
use app\models\member\User;
use app\models\topic\SpecialArticle;

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

        //留言数
        $msgNum = Contact::find()->count();

        //会员数
        $userNum = User::find()->count();

        //博文数
        $bArtNum = BlogArticle::find()->count();

        //专题文章数
        $sArtNum = SpecialArticle::find()->count();

        return $this->render('index',[
            'msgNum' => $msgNum,
            'userNum' => $userNum,
            'bArtNum' => $bArtNum,
            'sArtNum' => $sArtNum
        ]);
    }



}