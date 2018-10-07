<?php

namespace app\models\zones;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%notes}}".
 *
 * @property string $id 主键
 * @property string $title 日记标题
 * @property string $content 日记内容
 * @property string $created_at 创建时间
 * @property string $updated_at 修改时间
 * @property string $user_id 作者
 */
class Notes extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
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
        return '{{%notes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','content'], 'required'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 125],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'title' => '日记标题',
            'content' => '日记内容',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'user_id' => '作者',
        ];
    }



    /*
     * front
     */

    /**
     * 获取日记列表
     */
    public static function getNotes( $words = '' ){
        $query = static::find();

        if( $words ) $query->andWhere(['like', 'title', $words]);

        $count = $query->count();

        $pagination = new Pagination(['totalCount' => $count]);

        $notes = $query->orderBy(['created_at' => SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();
        return [
            'notes' => $notes,
            'pagination' => $pagination
        ];
    }

}
