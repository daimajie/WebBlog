<?php

namespace app\modules\admin\modules\blog\controllers;

use app\models\blog\BlogArticle;
use app\models\blog\Category;
use app\models\blog\Tag;
use Yii;
use app\models\blog\Article;
use app\models\blog\SearchArticle;
use app\modules\admin\controllers\BaseController;
use yii\base\Exception;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\widgets\imageInput\actions\UploadAction;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'discard' => ['POST']
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'upload' => [
                'class' => UploadAction::class,
                'field' => 'file',
                'subDir' => 'cover'
            ]
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchArticle();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'category' => Category::getAllCategorys(),
        ]);
    }

    /**
     * Displays a single Article model.
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
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();
        $tags = [];

        if ($model->load(Yii::$app->request->post())) {
            try{
                if($model->store()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }catch (\Exception $e){
                Yii::$app->session->setFlash('error', $e->getMessage());
            }catch (\Throwable $e){
                Yii::$app->session->setFlash('error', $e->getMessage());
            }

            //获取以展示的标签
            if($model->category_id >= 0){
                $tags = Tag::getTagsByCategory($model->category_id);
            }

        }

        return $this->render('create', [
            'model' => $model,
            'category' => Category::getAllCategorys(),
            'tags' => $tags
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (($model = Article::findOne($id)) === null)
            throw new NotFoundHttpException('The requested page does not exist.');


        if ($model->load(Yii::$app->request->post()) && $model->renew()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->tag_arr = $model->getTagArticle()->select(['tag_id'])->asArray()->column();
            $model->content_str = $model->content->content;

            return $this->render('update', [
                'model' => $model,
                'category' => Category::getAllCategorys(),
                'tags' => Tag::getTagsByCategory($model->category_id),
            ]);
        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->recycle = 1;
        $model->draft = 0;
        $model->save(false);

        try{
            Category::updateAllCounters(['count'=>-1], ['id'=>$model->category_id]);
        }catch (Exception $e){
            Yii::$app->session->setFlash('error', '分类计数错误 : ' . $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    /**
     * 恢复文章
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionRefresh($id)
    {
        $model = $this->findModel($id);
        $model->recycle = 0;
        $model->save(false);


        Category::updateAllCounters(['count'=>1], ['id'=>$model->category_id]);
        return $this->redirect(['index']);
    }

    /**
     * 彻底删除文章
     */
    public function actionDiscard($id){
        $model = $this->findModel($id);

        try{
            $model->discard();

        }catch(\Exception $e){
            Yii::$app->session->setFlash('error', $e->getMessage());
        }catch (\Throwable $e){
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['article/index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BlogArticle::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
