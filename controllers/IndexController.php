<?php
/**
 * Created by PhpStorm.
 * User: daimajie
 * Date: 2018/9/26
 * Time: 13:11
 */
namespace app\controllers;

use app\components\services\EmailService;
use app\models\setting\Setups;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use app\models\member\LoginForm;
use app\models\member\Contact;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;
use app\models\member\ForgetForm;

class IndexController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            /*'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],*/
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'maxLength' => 4,
                'minLength' => 4,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    /*public function actionIndex()
    {
        $this->layout = 'layout';
        return $this->render('index');
    }*/

    /**
     * Login action.
     */
    public function actionLogin()
    {
        $this->layout = 'layout-login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $model->scenario = LoginForm::SCENARIO_LOGIN;
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * register action.
     */
    public function actionRegister(){
        $this->layout = 'layout-login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $model->scenario = LoginForm::SCENARIO_REGISTER;
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            Yii::$app->session->setFlash('info', '注册成功，马上登录吧。');
            return Yii::$app->getUser()->loginRequired()->send();
        }

        $model->password = '';
        return $this->render('register', [
            'model' => $model,
        ]);

    }

    /**
     * Logout action.
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * forget action.
     */
    public function actionForget(){
        $this->layout = 'layout-login';

        $model = new ForgetForm();
        $model->scenario = ForgetForm::SCENARIO_FORGET;
        if(Yii::$app->request->isPost){
            if( $model->load(Yii::$app->request->post()) ){

                try{
                    if( $model->sendEmail() ){
                        Yii::$app->session->setFlash('info', '邮件发送成功，请查收。');
                        return $this->refresh();
                    }

                }catch (Exception $e){
                    Yii::$app->session->setFlash('info', $e->getMessage());
                }
            }
        }
        return $this->render('forget',[
            'model' => $model
        ]);
    }

    /**
     * 重置密码
     */
    public function actionResetPassword($token){
        $this->layout = 'layout-login';

        $model = new ForgetForm([
            'scenario' => ForgetForm::SCENARIO_RESET,
            'token' => trim($token)
        ]);

        if(Yii::$app->request->isPost){
            if($model->load(Yii::$app->request->post()) && $model->reset()){
                //重置成功
                Yii::$app->session->setFlash('info', '重置密码成功。');
                return $this->redirect(['index/login']);
            }
            //失败
            Yii::$app->session->setFlash('info', '链接已经失效，请重新申请。');
            $model->new_password = $model->re_password = '';
        }

        return $this->render('reset-password',[
            'model' => $model,
        ]);
    }


    /**
     * 发送邮箱验证码
     * @return array
     */
    public function actionSendEmailCaptcha(){
        Yii::$app->response->format = Response::FORMAT_JSON;

        try{
            //请求方式
            if(!Yii::$app->request->isAjax){
                throw new MethodNotAllowedHttpException('请求方式不被允许.');
            }

            //接收邮件地址信息
            $email = trim(Yii::$app->request->post('email'));
            if( !filter_var($email, FILTER_VALIDATE_EMAIL) )
                throw new Exception('邮箱地址错误.');

            //邮件限速 5分钟内只能发送1条
            if( !EmailService::sendLimit(3, 300) ){
                throw new Exception('发送邮件太多，休息一下吧。');
            }

            //生成邮箱验证码
            $captcha = EmailService::generateCaptcha(6, 5*60, 'email-captcha');
            if( empty($captcha) ) throw new Exception('创建验证码失败,请重试.');

            //发送邮件
            $fromEmail = Yii::$app->params['adminEmail'];
            $subject = Yii::$app->name . ' - 邮件验证码。';
            $viewFile = 'message/send-email';
            $var = [
                'name' => Yii::$app->name,
                'captcha' => $captcha
            ];
            $ret = EmailService::sendEmail($fromEmail, $email, $subject, $viewFile, $var);
            if( !$ret ){
                throw new Exception('邮件发送失败,请重试.');
            }

            return [
                'errno' => 0,
                'errmsg' => '已发送邮件'
            ];
        }catch (Exception $e){
            return [
                'errno' => 1,
                'errmsg' => $e->getMessage()
            ];
        }
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     * @throws
     */
    public function actionContact()
    {
        if(Yii::$app->user->isGuest)
            Yii::$app->user->loginRequired();

        $model = new Contact();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info', '留言成功,我们会尽快联系您的...');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about',[
            'about' => Setups::find()->select(['about', 'email'])->where(['id'=>1])->asArray()->one(),
        ]);
    }
}