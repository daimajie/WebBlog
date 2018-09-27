<?php
/**
 * Created by PhpStorm.
 * User: daimajie
 * Date: 2018/9/26
 * Time: 13:11
 */
namespace app\controllers;

use app\components\services\EmailService;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\member\LoginForm;
use app\models\member\ContactForm;
use yii\helpers\VarDumper;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;

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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
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
                'minLength' => 4
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
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

    public function actionRegister(){
        $this->layout = 'layout-login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $model->scenario = LoginForm::SCENARIO_REGISTER;
        if ($model->load(Yii::$app->request->post()) && $model->register()) {

            return Yii::$app->getUser()->loginRequired()->send();
        }

        $model->password = '';
        return $this->render('register', [
            'model' => $model,
        ]);

    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

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
        return $this->render('about');
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
            EmailService::sendLimit(1, 300);

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
}