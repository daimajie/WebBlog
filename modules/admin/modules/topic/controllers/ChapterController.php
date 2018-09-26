<?php

namespace app\modules\admin\modules\topic\controllers;

use app\models\topic\SearchChapter;
use app\models\topic\Special;
use Yii;
use app\models\topic\Chapter;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use app\modules\admin\controllers\BaseController;
use yii\helpers\VarDumper;
use yii\web\BadRequestHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ChapterController implements the CRUD actions for Chapter model.
 */
class ChapterController extends BaseController
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
     * Lists all Chapter models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new SearchChapter();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $selected = [];
        if($searchModel->special_id){
            $selected = Special::getBelongTo($searchModel->special_id);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'selected' => $selected
        ]);
    }

    /**
     * Displays a single Chapter model.
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
     * Creates a new Chapter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Chapter();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Chapter model.
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
            $belongTo = Special::getBelongTo($model->special_id);


            return $this->render('update', [
                'model' => $model,
                'belongTo' => $belongTo
            ]);
        }
    }

    /**
     * Deletes an existing Chapter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Chapter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Chapter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Chapter::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetChapterBySpecial(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        try{
            if(!Yii::$app->request->isAjax)
                throw new MethodNotAllowedHttpException('请求方式不被允许。');

            $special_id = (int) Yii::$app->request->post('special_id');
            if($special_id <= 0) throw new BadRequestHttpException('请求错误。');

            //获取章节列表
            $chapter_list = Chapter::getChapterListBySpecial($special_id);

            if(!$chapter_list){
                throw new NotFoundHttpException('没有相关数据。');
            }

            return [
                'errno' => 0,
                'data' => $chapter_list,
            ];

        }catch (MethodNotAllowedHttpException $e){

            return $this->redirect(['chapter/index']);
        }catch (Exception $e){
            return [
                'errno' => 1,
                'errmsg' => $e->getMessage(),
            ];
        }
    }
}
