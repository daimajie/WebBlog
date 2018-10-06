<?php
namespace app\components\widgets\comment\actions;
use yii\base\Action;
use Yii;
use yii\web\MethodNotAllowedHttpException;
use yii\base\Exception;
use app\components\widgets\comment\models\Comment;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DeleteCommentAction extends Action{

    public function run(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        try{
            if (!Yii::$app->request->isAjax)
                throw new MethodNotAllowedHttpException('请求方式不被允许。');

            if(Yii::$app->user->isGuest)
                throw new Exception('请先登录再进行操作。');

            //接收参数
            $content_id = (int) Yii::$app->request->post('content_id');
            $id = (int) Yii::$app->request->post('id');

            if( $content_id <= 0  || $id <= 0){
                throw new Exception('请求参数错误。');
            }

            //获取评论
            $model = Comment::find()->where(['and', ['id' => $id], ['user_id' => Yii::$app->user->id]])->one();
            if( !$model ) throw new NotFoundHttpException('没有相关参数。');

            //删除操作
            if( !$model->deleteComment() ){
                throw new Exception('删除评论失败，请重试');
            }

            return [
                'errno' => 0,
                'errmsg' => '删除评论成功。',
            ];


        }catch (MethodNotAllowedHttpException $e){

            return $this->controller->redirect(['index']);
        }catch (Exception $e){
            return [
                'errno' => 1,
                'errmsg' => $e->getMessage(),
            ];

        }
    }
}