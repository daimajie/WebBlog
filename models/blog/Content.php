<?php

namespace app\models\blog;

use Yii;

/**
 * This is the model class for table "{{%content}}".
 *
 * @property string $id 主键
 * @property int $type 内容类型: 1为博客文章、2为话题文章
 * @property string $article_id 文章ID
 * @property string $words 文章字数
 * @property string $content
 */
class Content extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%content}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'words'], 'integer'],
            [['content'], 'string'],
            [['type'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'type' => '内容类型: 1为博客文章、2为话题文章',
            'article_id' => '文章ID',
            'words' => '文章字数',
            'content' => 'Content',
        ];
    }
}
