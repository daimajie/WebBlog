<?php
namespace app\components\widgets\imageInput\actions;
use yii\base\Action;
use app\components\widgets\imageInput\models\ImageModel;
use Yii;
use yii\base\Exception;
use yii\web\Response;

class UploadAction extends Action
{
    public $field;
    public $subDir;

    public function run()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        try{
            //判断是否为表单提交
            if( !Yii::$app->request->isPost )
                throw new Exception('请求方式不被允许。');

            //获取文件实例
            $model = new ImageModel(['field' => $this->field]);
            $ret = $model->upImage($this->subDir);
            if ( !$ret || !is_array($ret) ){
                //上传失败
                throw new Exception( $model->getErrors('image')[0] );
            }

            //上传成功
            return [
                'code' => 0,
                'url' => Yii::getAlias(Yii::$app->params['upload']['upUrl']) .'/'. $ret['savePath'],
                'attachment' => $ret['savePath']
            ];


        }catch (Exception $e){
            return [
                'code' => 1,
                'msg' => $e->getMessage()
            ];
        }






    }
}