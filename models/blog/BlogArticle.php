<?php

namespace app\models\blog;

use Yii;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%blog_article}}".
 *
 * @property string $id 主键
 * @property string $title 文章标题
 * @property string $brief 文章简介
 * @property string $image 文章图片
 * @property int $type 文章类型
 * @property int $draft 草稿箱
 * @property int $recycle 回收站
 * @property string $visited 阅读数
 * @property string $comment 评论数
 * @property string $praise 赞赏数
 * @property string $collect 收藏数
 * @property string $created_at 创建时间
 * @property string $updated_at 修改时间
 * @property string $category_id 所属分类
 * @property string $user_id 作者
 *
 * @property Category $category
 * @property TagArticle[] $tagArticles
 */
class BlogArticle extends \yii\db\ActiveRecord
{
    const ARTICLE_TYPE = 1; //1为博客 2为话题

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
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
        return '{{%blog_article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'type', 'category_id','draft'], 'required'],
            [['title', 'image'], 'string', 'max' => 125],
            [['brief'], 'string', 'max' => 512],


            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['category_id'], 'integer'],
            [['type'], 'in', 'range' => [0, 1, 2]],

            [['draft'], 'in', 'range' => [0, 1]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'title' => '文章标题',
            'brief' => '文章简介',
            'image' => '文章图片',
            'type' => '文章类型',
            'draft' => '草稿箱',
            'recycle' => '回收站',
            'visited' => '阅读数',
            'comment' => '评论数',
            'praise' => '赞赏数',
            'collect' => '收藏数',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'category_id' => '所属分类',
            'user_id' => '作者',


        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagArticle()
    {
        return $this->hasMany(TagArticle::className(), ['blog_article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->via('tagArticle');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['article_id' => 'id']);
    }

    /**
     * 删除文章
     */
    public function discard(){

        $transaction = static::getDb()->beginTransaction();
        try{
            //删除标签关联数据
            $this->deleteTagRelate();

            //删除文章内容
            $this->deleteContent();

            //删除文章
            $this->deleteArticle();

            $transaction->commit();
        }catch(\Exception $e){
            $transaction->rollBack();
            throw $e;
        }catch (\Throwable $e){
            $transaction->rollBack();
            throw $e;
        }

    }

    //删除标签关联
    private function deleteTagRelate(){
        if(TagArticle::deleteAll(['blog_article_id'=>$this->id]) === false){
            throw new Exception('删除标签关联数据失败，请重试。');
        }
    }

    //删除文章内容
    private function deleteContent(){
        $affected = Content::deleteAll(['article_id'=>$this->id, 'type'=>static::ARTICLE_TYPE]);
        if($affected === false){
            throw new Exception('删除文章内容失败，请重试。');
        }
    }

    //删除文章
    private function deleteArticle(){
        if(!$this->delete()){
            throw new Exception('删除文章失败，请重试。');
        }
    }


}
