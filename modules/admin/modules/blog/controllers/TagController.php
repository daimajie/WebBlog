<?php

namespace app\modules\admin\modules\blog\controllers;

use app\models\blog\Category;
use app\models\blog\TagArticle;
use Yii;
use app\models\blog\Tag;
use app\models\blog\SearchTag;
use app\modules\admin\controllers\BaseController;
use yii\base\Exception;
use yii\helpers\VarDumper;
use yii\web\BadRequestHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * TagController implements the CRUD actions for Tag model.
 */
class TagController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Tag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchTag();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'category' => Category::getAllCategorys()
        ]);
    }

    /**
     * Displays a single Tag model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tag model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tag();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            return $this->render('create', [
                'model' => $model,
                'category' => Category::getAllCategorys()
            ]);
        }
    }

    /**
     * Updates an existing Tag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'category' => Category::getAllCategorys()
            ]);
        }
    }

    /**
     * Deletes an existing Tag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->discard();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Tag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tag::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * 获取指定分类下的所有标签数据
     */
    public function actionGetTagsByCategory()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        try {
            if (!Yii::$app->request->isAjax) {
                throw new MethodNotAllowedHttpException('请求方式不被允许。');
            }

            $category_id = (int)Yii::$app->request->post('category_id');
            $article_id = (int)Yii::$app->request->post('article_id');
            if ($category_id <= 0) {
                throw new BadRequestHttpException('请求错误，请重试。');
            }

            $tags = Tag::getTagsByCategory($category_id);
            if (count($tags) <= 0) {
                throw new Exception('没有可用标签。');
            }

            $hasTags = [];
            if ($article_id > 0) {
                $hasTags = TagArticle::getHasTags($article_id);
            }

            return [
                'errno' => 0,
                'data' => $tags,
                'hasTags' => array_intersect($hasTags, array_keys($tags))
            ];

        }catch (MethodNotAllowedHttpException $e){

            return $this->redirect(['tag/index']);
        }catch (Exception $e){
            return [
                'errno' => 1,
                'errmsg' => $e->getMessage()
            ];
        }

    }
}
