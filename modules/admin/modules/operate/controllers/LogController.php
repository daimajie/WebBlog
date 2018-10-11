<?php
namespace app\modules\admin\modules\operate\controllers;
use app\models\operate\Log;
use Yii;
use app\modules\admin\controllers\BaseController;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class LogController extends BaseController
{
    //列表
    public function actionIndex(){
        $dataProvider = new ActiveDataProvider([
            'query'=>Log::find()->orderBy(['log_time'=>SORT_DESC])
        ]);
        return $this->render('index',[
            'dataProvider' => $dataProvider,
        ]);
    }

    //查看
    public function actionView($id){
        $model = Log::findOne($id);
        if ($model === null)
            throw new NotFoundHttpException('没有相关数据。');

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    //删除
    public function actionDelete($id){
        $model = Log::findOne($id);
        if ($model === null)
            throw new NotFoundHttpException('没有相关数据。');

        $model->delete();

        return $this->redirect(['index']);
    }

    //删除全部
    public function actionFlush(){
        Log::deleteAll();
        return $this->redirect(['index']);
    }
}