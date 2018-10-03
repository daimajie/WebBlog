<?php
namespace app\modules\home\modules\blog\controllers;
use app\models\blog\BlogArticle;
use app\modules\home\controllers\BaseController;
use Yii;
use yii\helpers\VarDumper;

class IndexController extends  BaseController
{
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

    public function actionView(){
        $article_id = (int) Yii::$app->request->get('article_id', 0);
        $article = BlogArticle::getArticle($article_id);
        $prevNext = BlogArticle::getPrevNext($article_id);
        $related = BlogArticle::getRelated($article['category_id'], $article['id']);

        //VarDumper::dump($related, 10, 1);die;

        return $this->render('view',[
            'article' => $article,
            'prevNext' => $prevNext,
            'related' => $related
        ]);
    }
}
