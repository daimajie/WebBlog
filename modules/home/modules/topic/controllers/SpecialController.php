<?php
namespace app\modules\home\modules\topic\controllers;
use app\models\topic\Special;
use app\models\topic\SpecialArticle;
use app\modules\home\controllers\BaseController;
use yii\base\Exception;
use yii\helpers\VarDumper;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SpecialController extends BaseController
{
    //专题列表
    public function actionIndex(){
        $data = Special::getSpecials();

        return $this->render('index',[
            'specials' => $data['specials'],
            'pagination' =>$data['pagination']
        ]);
    }

    //专题详情
    public function actionView($special_id){
        $special = Special::getSpecial($special_id);

        $special_id = (int) Yii::$app->request->get('special_id', 0);
        $article_id = (int) Yii::$app->request->get('article_id', 0);
        if($special_id <= 0) throw new BadRequestHttpException('请求错误。');

        $content = SpecialArticle::getArticle($special_id, $article_id);

        return $this->render('view',[
            'special' => $special,
            'content' => $content
        ]);
    }




}