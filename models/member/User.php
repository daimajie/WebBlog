<?php

namespace app\models\member;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $id 主键
 * @property string $username 用户名
 * @property string $email 邮箱
 * @property string $image 头像
 * @property int $status 状态
 * @property string $auth_key Auth_Key
 * @property string $password_hash 密码
 * @property string $password_reset_token 密码重置key
 * @property string $created_at 注册时间
 * @property string $updated_at 修改时间
 * @property string $lasttime 最后登录时间
 * @property string $signip 最后登录ip
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            [['username'], 'string', 'max' => 18],
            [['email'], 'string', 'max' => 64],
            [['username'], 'unique'],
            [['email'], 'unique'],

            [['status'], 'default', 'value' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'username' => '用户名',
            'email' => '邮箱',
            'image' => '头像',
            'status' => '状态',
            'auth_key' => 'Auth_Key',
            'password_hash' => '密码',
            'password_reset_token' => '密码重置key',
            'created_at' => '注册时间',
            'updated_at' => '修改时间',
            'lasttime' => '最后登录时间',
            'signip' => '最后登录ip',
        ];
    }

    //生成密码
    public function generatePasswordHash($password){
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    //生成auth_key
    public function generateAuthKey(){
        $this->auth_key = Yii::$app->security->generateRandomString();
    }


}
