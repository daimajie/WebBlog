<?php
namespace app\modules\home\modules\topic\controllers;
use app\models\topic\Special;
use app\models\topic\SpecialArticle;
use app\modules\home\controllers\BaseController;
use Yii;
use yii\web\BadRequestHttpException;
use app\components\widgets\comment\actions\CommentAction;
use app\components\widgets\comment\actions\GetCommentsAction;
use app\components\widgets\comment\actions\DeleteCommentAction;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class SpecialController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['comment', 'delete-comment'],
                'rules' => [
                    [
                        'actions' => ['comment', 'delete-comment'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'comment' => ['post'],
                    'delete-comment' => ['post'],
                ],
            ],
        ];
    }
    //小部件提供方法
    public function actions()
    {
        return [
            'comment' => [
                'class' => CommentAction::class,
                'type' => 'special'
            ],
            'get-comments' => [
                'class' => GetCommentsAction::class,
            ],
            'delete-comment' => [
                'class' => DeleteCommentAction::class,
                'type' => 'special'
            ]
        ];
    }

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

        //查阅累加
        SpecialArticle::updateAllCounters(['visited'=>1], ['id'=>$article_id]);

        return $this->render('view',[
            'special' => $special,
            'content' => $content
        ]);
    }




}