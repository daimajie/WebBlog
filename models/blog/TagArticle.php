<?php

namespace app\models\blog;

use Yii;

/**
 * This is the model class for table "{{%tag_article}}".
 *
 * @property string $tag_id 标签ID
 * @property string $blog_article_id 文章ID
 *
 * @property BlogArticle $blogArticle
 * @property Tag $tag
 */
class TagArticle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tag_article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_id','blog_article_id'], 'required'],
            [['tag_id', 'blog_article_id'], 'integer'],
            [['blog_article_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogArticle::className(), 'targetAttribute' => ['blog_article_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tag_id' => '标签ID',
            'blog_article_id' => '文章ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogArticle()
    {
        return $this->hasOne(BlogArticle::className(), ['id' => 'blog_article_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }

    /**
     * 根据文章获取已选标签
     */
    public static function getHasTags($article_id){
        return static::find()->select(['tag_id'])->where(['blog_article_id'=>$article_id])->asArray()->column();
    }
}
