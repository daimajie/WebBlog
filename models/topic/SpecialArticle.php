<?php

namespace app\models\topic;

use app\components\helper\Helper;
use app\models\blog\Content;
use Yii;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\VarDumper;


/**
 * This is the model class for table "{{%special_article}}".
 *
 * @property string $id 主键
 * @property string $title 文章标题
 * @property int $draft 草稿箱
 * @property int $recycle 回收站
 * @property string $visited 阅读数
 * @property string $comment 评论数
 * @property string $special_id 所属专题
 * @property string $chapter_id 所属章节
 * @property string $created_at 创建时间
 * @property string $updated_at 修改时间
 * @property string $user_id 作者
 *
 * @property Chapter $chapter
 * @property Special $special
 */
class SpecialArticle extends \yii\db\ActiveRecord
{
    const ARTICLE_TYPE = 2;//专题文章
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%special_article}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['special_id', 'chapter_id', 'title'], 'required'],
            [['special_id', 'chapter_id', 'draft'], 'integer'],
            [['draft'], 'in', 'range' => [0, 1]],
            [['title'], 'string', 'max' => 125],
            [['chapter_id'], 'exist', 'skipOnError' => true, 'targetClass' => Chapter::className(), 'targetAttribute' => ['chapter_id' => 'id']],
            [['special_id'], 'exist', 'skipOnError' => true, 'targetClass' => Special::className(), 'targetAttribute' => ['special_id' => 'id']],
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
            'draft' => '草稿箱',
            'recycle' => '回收站',
            'visited' => '阅读数',
            'comment' => '评论数',
            'special_id' => '所属专题',
            'chapter_id' => '所属章节',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'user_id' => '作者',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChapter()
    {
        return $this->hasOne(Chapter::className(), ['id' => 'chapter_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpecial()
    {
        return $this->hasOne(Special::className(), ['id' => 'special_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['article_id' => 'id'])
            ->andWhere(['type' => static::ARTICLE_TYPE]);
    }

    /**
     * 获取文章查询生成器
     * @return \yii\db\ActiveQuery
     */
    public static function getArticlesQuery(){
        return static::find()
            ->where([
                'draft' => 0,
                'recycle' => 0,
            ]);
    }

    /**
     * 删除文章
     */
    public function discard(){
        $transaction = static::getDb()->beginTransaction();
        try{
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


    /**
     * 获取专题文章 (文章详情)
     * @param $special_id
     * @param $article_id
     * @return array
     */
    public static function getArticle($special_id, $article_id){
        $query = static::getArticlesQuery()
            ->andWhere(['special_id'=>$special_id])
            ->with('content');

        if($article_id > 0){
            $query->andWhere(['id' => $article_id]);
        }
        else{
            $query->orderBy(['id' => SORT_ASC])
                ->limit(1);
        }

        $article = $query->asArray()->one();
        $article_id = $article_id > 0 ? $article_id : $article['id'];
        return [
            'article' => $article,
            'prevAndNext' => static::getPrevAndNext($special_id, $article_id)
        ];

    }

    /**
     * 获取上下一篇文章
     * @param int $special_id
     * @param int $article_id
     * @return array
     */
    private static function getPrevAndNext($special_id, $article_id){

        $prev = static::getArticlesQuery()
            ->select(['id', 'title'])
            ->where(['special_id'=>$special_id])
            ->andWhere(['<', 'id', $article_id])
            ->orderBy(['id'=>SORT_DESC])
            ->limit(1)
            ->asArray()
            ->one();

        $next = static::getArticlesQuery()
            ->select(['id', 'title'])
            ->where(['special_id'=>$special_id])
            ->andWhere(['>', 'id', $article_id])
            ->orderBy(['id'=>SORT_ASC])
            ->limit(1)
            ->asArray()
            ->one();
        return [
            'prev' => $prev,
            'next' => $next
        ];

    }
}
