<?php
namespace app\modules\home\modules\center\controllers;
use app\models\center\UserForm;
use app\models\member\User;
use app\modules\home\controllers\BaseController;
use Yii;

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
}