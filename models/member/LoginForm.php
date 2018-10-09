<?php

namespace app\models\member;

use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'register';

    public $username;
    public $password;
    public $rememberMe = true;
    public $captcha;

    public $email;
    public $re_password;
    public $email_captcha;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password', 'captcha'], 'required', 'on'=>[static::SCENARIO_LOGIN]],
            [['rememberMe'], 'boolean', 'on'=>[static::SCENARIO_LOGIN]],
            ['captcha', 'captcha', 'captchaAction' => 'index/captcha', 'on'=>[static::SCENARIO_LOGIN]],
            ['password', 'validatePassword', 'on'=>[static::SCENARIO_LOGIN]],


            [['username', 'password', 're_password', 'email', 'email_captcha'], 'required', 'on'=>[static::SCENARIO_REGISTER]],
            [['re_password'], 'compare', 'compareAttribute' => 'password', 'on'=>[static::SCENARIO_REGISTER]],
            [['email_captcha'], 'checkEmail', 'on'=>[static::SCENARIO_REGISTER]]
        ];
    }



    public function checkEmail($attr){
        if($this->hasErrors())
            return false;

        //获取session验证码数据
        $session = Yii::$app->session;
        $data = $session->get('email-captcha','');
        if (empty($data)){
            $this->addError($attr, '数据验证失败，请重试。');
            return false;
        }

        //判断时间
        if((time() - $data['lifetime']) > $data['start_at']){
            $this->addError($attr, '验证码有效时间已过，请重新发送');
            return false;
        }
        //判断是否一致
        if($data['captcha'] !== $this->email_captcha){
            $this->addError($attr, '验证码填写不正确，请查证。');
            return false;
        }
        //清空captcha
        $session->remove('email-captcha');

        return true;

    }


    public function attributeLabels()
    {
        return [
            'username' => '账户',
            'password' => '密码',
            'rememberMe' => '记住我，(7日免登录)',
            'captcha' => '验证码',
            'email' => '邮箱',
            're_password' => '重复密码',
            'validEmail' => '邮箱验证'
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '用户名或密码无效.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            User::updateAll(['lasttime'=>time()],['id'=>$this->getUser()->id]);
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*7 : 0);
        }
        return false;
    }

    /**
     * 注册新账户
     * @return bool
     */
    public function register(){
        if(!$this->validate()){
            return false;
        }

        //创建用户
        return $model = $this->generateUser();
    }

    /**
     * 生成新用户
     * @return bool
     */
    private function generateUser(){
        $model = new User();
        $model->username = $this->username;
        $model->email = $this->email;
        $model->generateAuthKey();
        $model->generatePasswordHash($this->password);

        return $model->save(false);
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsernameOrEmail($this->username);
        }

        return $this->_user;
    }
}
