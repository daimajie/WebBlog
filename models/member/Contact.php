<?php

namespace app\models\member;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%contact}}".
 *
 * @property string $id 主键
 * @property string $email 联系邮箱
 * @property string $subject 信息主题
 * @property string $body 信息主体
 * @property string $user_id 用户
 * @property string $created_at 创建时间
 */
class Contact extends \yii\db\ActiveRecord
{
    public $verifyCode;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contact}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'subject','body', 'verifyCode'], 'required'],
            [['email'], 'string', 'max' => 64],
            [['subject'], 'string', 'max' => 125],
            [['body'], 'string', 'max' => 512],
            ['email', 'email'],
            ['verifyCode', 'captcha', 'captchaAction' => 'index/captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'email' => '联系邮箱',
            'subject' => '信息主题',
            'body' => '信息主体',
            'user_id' => '用户',
            'created_at' => '创建时间',
            'visited' => '状态',
            'verifyCode' => '验证码'
        ];
    }

    public function getUser(){
        return $this->hasOne(User::class, ['id'=>'user_id']);
    }

}
