<?php

namespace app\modules\admin\modules\topic\controllers;

use app\models\topic\Chapter;
use app\models\topic\Special;
use Yii;
use app\models\topic\SpecialArticle;
use app\models\topic\Article;
use app\models\topic\SearchSpecialArticle;
use app\modules\admin\controllers\BaseController;
use yii\base\Exception;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SpecialArticleController implements the CRUD actions for SpecialArticle model.
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
                ],
            ],
        ];
    }

    /**
     * Lists all SpecialArticle models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchSpecialArticle();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //获取当前专题 及 章节
        $selectedSpecial = [];
        $selectedChapter = [];
        if($searchModel->special_id){
            $selectedSpecial = Special::getBelongTo($searchModel->special_id);
            $selectedChapter = Chapter::getChapterListBySpecial($searchModel->special_id);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'selectedSpecial' => $selectedSpecial,
            'selectedChapter' => $selectedChapter
        ]);
    }

    /**
     * Displays a single SpecialArticle model.
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
     * Creates a new SpecialArticle model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post()) && $model->store()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SpecialArticle model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = Article::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('没有找到相关数据');
        }

        if ($model->load(Yii::$app->request->post()) && $model->renew()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->content_str = $model->content->content;
            $selectedSpecial = Special::getBelongTo($model->special_id);
            $selectedChapter = Chapter::getChapterListBySpecial($model->special_id);


            return $this->render('update', [
                'model' => $model,
                'selectedSpecial' => $selectedSpecial,
                'selectedChapter' => $selectedChapter
            ]);
        }
    }

    /**
     * Deletes an existing SpecialArticle model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)/**/
    {
        $model = Article::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('没有找到相关数据');
        }
        $model->draft = 0;
        $model->recycle = 1;
        if(!$model->save(false)){
            throw new Exception('删除文章失败，请重试。');
        }

        //刷新计数
        try{
            $model->countIncr($model->special_id, $model->chapter_id, -1);
        }catch (Exception $e){
            Yii::$app->session->setFlash('error', '文章计数错误 : ' . $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    public function actionDiscard($id){
        //删除文章
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

    public function actionRefresh($id){
        //更新文章
        $model = Article::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('没有找到相关数据');
        }
        $model->recycle = 0;
        if(!$model->save(false)){
            throw new Exception('恢复文章失败，请重试。');
        }

        //刷新计数
        try{
            $model->countIncr($model->special_id, $model->chapter_id, 1);
        }catch (Exception $e){
            Yii::$app->session->setFlash('error', '文章计数错误 : ' . $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the SpecialArticle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SpecialArticle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SpecialArticle::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('没有找到相关数据');
        }
    }
}
