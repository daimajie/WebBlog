<?php
/**
 * Created by PhpStorm.
 * User: daimajie
 * Date: 2018/9/23
 * Time: 20:14
 */
namespace app\models\topic;

use app\models\blog\Content;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\VarDumper;


class Article extends SpecialArticle
{


    public $content_str;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false
            ],
        ];
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['content_str'],'required'],
            [['content_str'], 'string', 'min'=>5]
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),[
            'content_str' => '文章内容',
        ]);
    }

    /**
     * 保存文章
     */
    public function store(){
        if(!$this->validate())
            return false;

        //保存文章
        $transaction = static::getDb()->beginTransaction();
        try{
            //保存文章
            $this->saveArticle();

            //保存文章内容
            $this->saveContent();

            //累计计数
            $this->countIncr($this->special_id, $this->chapter_id);

            $transaction->commit();
            return true;
        }catch (\Exception $e){
            $transaction->rollBack();
            throw $e;
        }catch (\Throwable $e){
            $transaction->rollBack();
            throw $e;
        }

    }

    /**
     * 新建文章后累计计数
     * @param int $count 计数量
     * @param int $special_id
     * @param int $chapter_id
     * @throws Exception
     */
    public function countIncr($special_id, $chapter_id, $count = 1){

        if(Special::updateAllCounters(['count'=>$count], ['id' => $special_id]) !== 1)
            throw new Exception('专题计数失败，请重试。');

        if(Chapter::updateAllCounters(['count'=>$count], ['id' => $chapter_id]) !== 1)
            throw new Exception('章节计数失败，请重试。');
    }

    /**
     * 保存文章
     */
    public function renew(){

        if(!$this->validate())
            return false;

        //保存文章
        $transaction = static::getDb()->beginTransaction();
        try{
            //如果修改了专题和章节 就删除计数
            $old_special_id = $this->getOldAttribute('special_id');
            $old_chapter_id = $this->getOldAttribute('chapter_id');
            if( ($old_special_id !== $this->special_id) || ($old_chapter_id !== $this->chapter_id) ){
                $this->countIncr($old_special_id, $old_chapter_id, -1);
                $this->countIncr($this->special_id, $this->chapter_id, 1);
            }

            //保存文章
            $this->saveArticle();

            //保存文章内容
            $this->renewContent();

            $transaction->commit();
            return true;
        }catch (\Exception $e){
            $transaction->rollBack();
            throw $e;
        }catch (\Throwable $e){
            $transaction->rollBack();
            throw $e;
        }

    }



    /**
     * 保存文章
     */
    public function saveArticle(){
        //能编辑文章绝对不是回收站文章
        $this->recycle = 0;

        if(!$this->save(false))
            throw new Exception('保存文章失败，请重试。');
    }


    /**
     * 保存文章内容
     */
    public function saveContent(){
        $contentModel = new Content();
        $contentModel->type = static::ARTICLE_TYPE;
        $contentModel->article_id = $this->id;
        $contentModel->words = mb_strlen($this->content_str, 'utf-8');
        $contentModel->content = $this->content_str;


        if(!$contentModel->save(false))
            throw new Exception('保存文章内容失败，请重试。');
    }

    /**
     * 保存文章内容
     */
    public function renewContent(){
        $contentModel = Content::find()->where(['article_id'=>$this->id, 'type'=>static::ARTICLE_TYPE])->one();
        $contentModel->words = mb_strlen($this->content_str, 'utf-8');
        $contentModel->content = $this->content_str;


        if(!$contentModel->save(false))
            throw new Exception('保存文章内容失败，请重试。');
    }



}