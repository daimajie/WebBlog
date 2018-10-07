<?php
namespace app\modules\home\modules\blog\controllers;
use app\models\blog\BlogArticle;
use app\modules\home\controllers\BaseController;
use Yii;
use app\components\widgets\comment\actions\CommentAction;
use app\components\widgets\comment\actions\GetCommentsAction;
use app\components\widgets\comment\actions\DeleteCommentAction;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class IndexController extends  BaseController
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
                'type' => 'blog'
            ],
            'get-comments' => [
                'class' => GetCommentsAction::class,
            ],
            'delete-comment' => [
                'class' => DeleteCommentAction::class,
                'type' => 'blog'
            ]
        ];
    }

    public function actionIndex()
    {
        //获取文章列表
        $category_id = (int) Yii::$app->request->get('category_id', 0);
        $tag_id = (int) Yii::$app->request->get('tag_id', 0);
        $data = BlogArticle::getArticleList($category_id, $tag_id);
        return $this->render('index',[
            'articles' => $data['articles'],
            'pagination' => $data['pagination'],
        ]);
    }

    public function actionSearch( $keywords )
    {
        $words = htmlentities(trim($keywords));

        //获取文章列表
        $category_id = (int) Yii::$app->request->get('category_id', 0);
        $tag_id = (int) Yii::$app->request->get('tag_id', 0);
        $data = BlogArticle::getArticleList($category_id, $tag_id, $words);

        return $this->render('index',[
            'articles' => $data['articles'],
            'pagination' => $data['pagination'],
        ]);
    }

    public function actionView(){
        $article_id = (int) Yii::$app->request->get('article_id', 0);
        $article = BlogArticle::getArticle($article_id);
        $prevNext = BlogArticle::getPrevNext($article_id);
        $related = BlogArticle::getRelated($article['category_id'], $article['id']);

        //查阅累加
        BlogArticle::updateAllCounters(['visited'=>1], ['id'=>$article_id]);

        return $this->render('view',[
            'article' => $article,
            'prevNext' => $prevNext,
            'related' => $related
        ]);
    }
}
