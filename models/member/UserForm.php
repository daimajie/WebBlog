<?php
namespace app\models\member;

use yii\behaviors\TimestampBehavior;
use yii\helpers\VarDumper;

class UserForm extends User
{

    const SCENARIO_ADD = 'add';
    const SCENARIO_PUT = 'put';

    public $password;
    public $re_password;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return array_merge(parent::rules(),[
            [['password'], 'required', 'on' => [static::SCENARIO_ADD]],
            [['password'], 'string', 'min'=>6, 'max'=>18],
            [['re_password'], 'compare', 'skipOnEmpty'=>false,'compareAttribute' => 'password'],
        ]);
    }

    public function scenarios()
    {
        return [
            static::SCENARIO_ADD => ['username', 'email', 're_password', 'password'],
            static::SCENARIO_PUT => ['username', 'email', 're_password', 'password'],
        ];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),[
            'password' => '密码',
            're_password' => '重复密码',
        ]);
    }

    /**
     * 添加用户
     */
    public function store(){

        if(!$this->validate())
            return false;

        $this->generatePasswordHash($this->password);
        $this->generateAuthKey();

        return $this->save(false);

    }

    /**
     * 更新用户
     */
    public function renew(){


        if( !$this->validate() )
            return false;

        if( !empty($this->password) ){
            $this->generatePasswordHash($this->password);
        }

        return $this->save(false);
    }

}