<?php

namespace app\models\comment;

use app\models\member\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property string $id 主键
 * @property string $comment 评论内容
 * @property string $content_id 文章内容
 * @property string $comment_id 评论ID
 * @property string $user_id 评论用户
 * @property string $created_at 评论时间
 */
class Comment extends \yii\db\ActiveRecord
{
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
                'updatedByAttribute' => false
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content_id', 'comment_id', 'user_id', 'created_at'], 'integer'],
            [['comment'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'comment' => '评论内容',
            'content_id' => '文章内容',
            'comment_id' => '评论ID',
            'user_id' => '评论用户',
            'created_at' => '评论时间',
        ];
    }

    //关联用户
    public function getUser(){
        return $this->hasOne(User::class, ['id' => 'user_id'])->select(['id','username', 'image']);
    }

    //关联回复
    public function getReplys(){
        return $this->hasMany(static::class, ['comment_id'=>'id'])
            ->select(['id', 'content_id', 'comment_id', 'user_id', 'comment','created_at']);
    }
}
