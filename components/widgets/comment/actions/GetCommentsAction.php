<?php
namespace app\components\widgets\comment\actions;
use app\components\widgets\comment\models\Comment;
use yii\base\Action;
use Yii;
use yii\base\Exception;
use yii\helpers\VarDumper;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;
use yii\widgets\LinkPager;

class GetCommentsAction extends Action
{
    public function run(){
        Yii::$app->response->format = Response::FORMAT_JSON;

        try{
            if (!Yii::$app->request->isAjax)
                throw new MethodNotAllowedHttpException('请求方式不被允许。');

            //接收参数
            $content_id = (int) Yii::$app->request->post('content_id');
            if( $content_id <= 0 ){
                throw new Exception('请求参数错误。');
            }

            //页码参数
            $page = (int) Yii::$app->request->get('page');
            $limit = (int) Yii::$app->request->get('limit');
            if($page <= 0) $page = 1;
            if($limit < 5 || $limit > 15) $limit = 5;

            //获取评论列表
            $data = Comment::getComments($content_id, $page, $limit);

            //VarDumper::dump($data,10,1);die;

            //生成数据
            return [
                'comments' => $data['comments'],
                'pagination' => LinkPager::widget([
                    'pagination' => $data['pagination'],
                    'nextPageLabel' => '<i class="fa fa-chevron-right"></i>',
                    'prevPageLabel' => '<i class="fa fa-chevron-left"></i>',
                    'options' => ['id' => 'pagination'],
                    'disableCurrentPageButton' => true
                ])
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