<?php

namespace app\models\topic;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%chapter}}".
 *
 * @property string $id 主键
 * @property string $title 章节标题
 * @property string $special_id 所属专题
 * @property string $count 文章计数
 * @property string $created_at 创建时间
 * @property string $updated_at 修改时间
 *
 * @property SpecialArticle[] $specialArticles
 */
class Chapter extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%chapter}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'special_id'], 'required'],
            [['special_id'], 'integer'],
            [['special_id'], 'exist', 'targetClass' => Special::class, 'targetAttribute' => ['special_id' => 'id']],
            [['title'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'title' => '章节标题',
            'special_id' => '所属专题',
            'count' => '文章计数',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialArticles()
    {
        return $this->hasMany(SpecialArticle::className(), ['chapter_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecial()
    {
        return $this->hasOne(Special::class, ['id' => 'special_id']);
    }


    /**
     * 根据专题获取章节列表
     * @param $special_id
     * @return array
     */
    public static function getChapterListBySpecial($special_id){
        return static::find()->select(['title'])->indexBy('id')->where(['special_id'=>$special_id])->asArray()->column();
    }
}
