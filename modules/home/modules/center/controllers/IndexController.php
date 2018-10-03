<?php
namespace app\modules\home\modules\center\controllers;
use app\components\services\UploadService;
use app\models\center\UserForm;
use app\models\member\User;
use app\modules\home\controllers\BaseController;
use Yii;
use yii\base\Exception;
use yii\web\BadRequestHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;

class IndexController extends BaseController
{
    public $layout = 'main';

    public function actionIndex(){
        $user = User::find(Yii::$app->user->id);


        return $this->render('index',[
            'user' => $user
        ]);
    }

    /**
     * 修改密码
     * @return string
     */
    public function actionResetPassword(){
        $model = UserForm::findOne(Yii::$app->user->id);
        $model->scenario = UserForm::RESET_PASSWORD;

        if( Yii::$app->request->isPost){
            if($model->load(Yii::$app->request->post()) &&  $model->resetPassword()){
                //修改密码成功
                Yii::$app->session->setFlash('info', '修改密码成功。');
                return $this->refresh();
            }
        }

        return $this->render('reset-password',[
            'model' => $model,
        ]);
    }

    /**
     * 修改邮箱
     * @return string
     */
    public function actionResetEmail(){
        $model = UserForm::findOne(Yii::$app->user->id);
        $model->scenario = UserForm::RESET_EMAIL;

        if( Yii::$app->request->isPost){
            if($model->load(Yii::$app->request->post()) &&  $model->resetEmail()){
                //修改密码成功
                Yii::$app->session->setFlash('info', '修改密码成功。');
                return $this->refresh();
            }
        }

        return $this->render('reset-email',[
            'model' => $model
        ]);
    }

    /**
     * 修改头像
     */
    public function actionResetAvatar(){
        return $this->render('reset-avatar');
    }

    /**
     * 上传头像
     */
    public function actionUpload(){
        Yii::$app->response->format = Response::FORMAT_JSON;

        try{
            if( !Yii::$app->request->isAjax ) throw new MethodNotAllowedHttpException('请求方式不被允许.');

            $base64_string = trim(Yii::$app->request->post('img'));
            if( empty($base64_string) ) throw new BadRequestHttpException('请求错误.');

            //获取图片数据
            $string= explode(',', $base64_string);

            //解码
            $binary= base64_decode($string[1]);

            //生成文件
            list($mime, $type) = explode(';', ltrim($string[0], 'data:'));
            list($tmp, $ext) = explode('/', $mime);

            //判断是否允许的后缀
            $allowMime = Yii::$app->params['upload']['allowMime'];
            if( !in_array($ext, $allowMime) ) throw new Exception('图片格式不被允许.');

            $ret = UploadService::generateImage('avatar', $ext);


            //保存图片
            if(file_put_contents($ret['fullPath'], $binary) === false){
                throw new Exception('上传文件失败，请重试。');
            }

            //删除原有头像
            if(!empty(Yii::$app->user->identity->image)){
                UploadService::deleteImage(Yii::$app->user->identity->image);
            }

            //写入数据库
            if(User::updateAll(['image'=>$ret['savePath']], ['id'=>Yii::$app->user->id]) === 0){
                throw new Exception('保存文件失败，请重试。');
            }
            return [
                'errno' => 0,
                'image' => $ret['savePath']
            ];


        }catch (MethodNotAllowedHttpException $e){
            return $this->redirect(['index']);

        }catch (Exception $e){
            return [
               'errno' => 1,
               'errmsg' => $e->getMessage()
            ];
        }
    }


}