<?php
namespace app\components\widgets\comment\actions;
use app\components\widgets\comment\models\Comment;
use app\models\blog\Content;
use app\models\topic\Special;
use app\models\topic\SpecialArticle;
use yii\base\Exception;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;
use yii\base\Action;
use Yii;
use app\models\blog\BlogArticle;

class CommentAction extends Action
{
    public $type;

    public function run()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        try{
            if( !Yii::$app->request->isAjax )
                throw new MethodNotAllowedHttpException('请求方式不被允许。');

            if( Yii::$app->user->isGuest )
                throw new Exception('请先登录再评论文章。');

            $model = new Comment();
            $model->setAttributes(Yii::$app->request->post());

            if( !$model->save() ){
                throw new Exception($model->getErrors()[0]);
            }

            //获取文章id
            $content = Content::findOne(['id' => $model['content_id']]);

            if($this->type == 'blog')
                BlogArticle::updateAllCounters(['comment'=>1], ['id'=>$content['article_id']]);
            else{
                SpecialArticle::updateAllCounters(['comment'=>1], ['id'=>$content['article_id']]);

                $special_id = SpecialArticle::find()
                    ->where(['id'=>$content['article_id']])
                    ->select(['special_id'])
                    ->asArray()
                    ->scalar();
                Special::updateAllCounters(['comment'=>1], ['id'=>$special_id]);
            }

            return [
                'errno' => 1,
                'errmsg' => '提交成功',
            ];

        }catch (MethodNotAllowedHttpException $e){

            return $this->controller->redirect(['index']);
        }catch (Exception $e){
            return [
                'errno' => 0,
                'errmsg' => $e->getMessage(),
            ];
        }


    }
}