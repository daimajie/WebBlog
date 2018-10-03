<?php
namespace app\models\center;
use app\models\member\User;
use Yii;

class UserForm extends User
{
    const RESET_PASSWORD = 'password';
    const RESET_EMAIL = 'email';

    public $password;
    public $re_password;
    public $secure_email;
    public $email_captcha;

    public function rules()
    {
        return [
            [['username', 'secure_email', 'password', 're_password'], 'required', 'on'=>[self::RESET_PASSWORD]],
            [['re_password'], 'compare', 'compareAttribute' => 'password', 'on'=>[self::RESET_PASSWORD]],
            [['secure_email'], 'checkEmail', 'on'=>[self::RESET_PASSWORD]],

            [['username', 'password', 'email_captcha'], 'required', 'on'=>[self::RESET_EMAIL]],
            [['password'], 'checkPassword', 'on'=>[self::RESET_EMAIL]],
            [['secure_email'], 'unique', 'targetAttribute' => 'email', 'on'=>[self::RESET_EMAIL]],
            [['email_captcha'], 'checkEmailCaptcha', 'on'=>[self::RESET_EMAIL]],

            //[['secure_email'], 'email', 'on'=>[self::RESET_EMAIL,self::RESET_PASSWORD]],
            [['password'], 'string', 'min'=>6, 'on'=>[self::RESET_EMAIL,self::RESET_PASSWORD]],
        ];
    }

    public function checkPassword($attr){
        if( $this->hasErrors() ) return false;

        if( !$this->validatePassword($this->password) ){
            $this->addError($attr, '密码错误。');
            return false;
        }
        return true;
    }

    /**
     * 验证邮箱验证码
     */
    public function checkEmailCaptcha($attr){
        if( $this->hasErrors() ) return false;

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

    /**
     * 检测邮箱是否匹配
     */
    public function checkEmail( $attr ){
        if($this->hasErrors())
            return false;
        if($this->email !== $this->secure_email){
            $this->addError($attr, '用户名与邮箱不匹配。');
            return false;
        }

        return true;
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            're_password' => '重复密码',
            'password' => '密码',
            'secure_email' => '邮箱',
            'email_captcha' => '邮箱验证码'
        ];
    }

    /**
     * 重置密码
     */
    public function resetPassword(){
        if( !$this->validate() ) return false;

        $this->generatePasswordHash($this->password);
        return $this->save(false);
    }

    /**
     * 修改邮箱
     */
    public function resetEmail(){
        if( !$this->validate() ) return false;

        $this->email = $this->secure_email;
        return $this->save(false);
    }


}