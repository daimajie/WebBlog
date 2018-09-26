<?php
/**
 * Created by PhpStorm.
 * User: daimajie
 * Date: 2018/9/21
 * Time: 13:01
 */

namespace app\models\blog;

use yii\base\Exception;
use yii\helpers\VarDumper;
use Yii;

class Article extends BlogArticle {



    //标签
    public $tag_arr;
    public $tag_str;

    public $content_str;


    public function rules()
    {
        $rules = parent::rules();

        return array_merge($rules, [
            [['content_str'], 'required'],
            [['tag_str'], 'trim'],
            [['content_str'], 'string', 'min' => 5],
            [['tag_arr'], 'safe'],
            [['tag_str'], 'string'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'tag_arr' => '可选标签',
            'tag_str' => '新建标签',
            'content_str' => '文章内容'
        ]);
    }


    /**
     * 文章创建
     */
    public function store(){
        if(!$this->validate())
            return false;

        $transaction = static::getDb()->beginTransaction();
        try{

            //新建标签
            $tag_arr = $this->saveNewTags();

            //保存文章
            $this->saveArticle();

            //保存标签
            $this->saveTagRelate($tag_arr);

            //保存内容
            $this->saveContent();

            //分类收录数累加
            $this->categoryIncr();

            $transaction->commit();
        }catch(\Exception $e){
            $transaction->rollBack();
            throw $e;
        }catch (\Throwable $e){
            $transaction->rollBack();
            throw $e;
        }

        return true;

    }

    /**
     * 文章修改
     */
    public function renew(){
        if(!$this->validate())
            return false;

        $transaction = static::getDb()->beginTransaction();
        try{
            //如果修改了分类
            $old_category_id = $this->getOldAttribute('category_id');
            if( ($old_category_id !== $this->category_id) ){
                Category::updateAllCounters(['count'=> -1], ['id'=> $old_category_id]);
                Category::updateAllCounters(['count'=> 1], ['id'=> $this->category_id]);
            }

            //如果是回收站编辑的文章
            if( $this->recycle === 1 ){
                Category::updateAllCounters(['count'=>1], ['id'=>$this->category_id]);
            }

            //新建标签
            $tag_arr = $this->saveNewTags();

            //保存文章
            $this->saveArticle();

            //保存标签
            $this->renewTagRelate($tag_arr);

            //保存内容
            $this->renewContent();

            $transaction->commit();
        }catch(\Exception $e){
            $transaction->rollBack();
            throw $e;
        }catch (\Throwable $e){
            $transaction->rollBack();
            throw $e;
        }

        return true;

    }

    public function categoryIncr(){
        $affected = Category::updateAllCounters(['count' => 1], ['id' => $this->category_id]);
        if($affected !== 1)
            throw new Exception('分类计数失败，请重试。');
    }

    /**
     * 保存新建标签
     * @throws Exception
     */
    private function saveNewTags(){
        if(empty($this->tag_str))
            return false;

        $str = htmlentities($this->tag_str);
        $tmp_arr = array_filter(explode(',', str_replace('，', ',', $str)));

        if(count($tmp_arr) <= 0)
            return false;
        $tag_arr = [];
        foreach ($tmp_arr as $k => $v){
            $tagModel = new Tag();
            $tagModel->name = $v;
            $tagModel->category_id = $this->category_id;

            if(!$tagModel->save())
                throw new Exception($tagModel->getFirstError('name'));

            $tag_arr[] = $tagModel->id;
        }

        return $tag_arr;
    }

    /**
     * 保存文章
     * @throws Exception
     */
    private function saveArticle(){
        if($this->draft){
            $this->draft = 1;
        }

        //能编辑的文章绝对不是回收站文章
        $this->recycle = 0;

        if(!$this->save(false))
            throw new Exception('保存文章失败，请重试。');
    }


    /**
     * 保存标签即文章的关联数据
     * @param $tags
     * @throws Exception
     */
    private function saveTagRelate($tags){
        $tmp_arr = [];

        if(!empty($this->tag_arr) && is_array($this->tag_arr)){
            $tmp_arr = array_merge($tmp_arr, $this->tag_arr);
        }

        if(is_array($tags)){
            $tmp_arr = array_merge($tags, $tmp_arr);
        }

        $tmp_arr = array_filter(array_unique($tmp_arr), 'is_numeric');


        foreach($tmp_arr as $k => $v){
            $tagArticle = new TagArticle();
            $tagArticle->tag_id = $v;
            $tagArticle->blog_article_id = $this->id;

            if(!$tagArticle->save(false))
                throw new Exception('保存标签文章关联数据失败，请重试。');

        }

    }

    /**
     * 保存标签即文章的关联数据
     * @param $tags
     * @throws Exception
     */
    private function renewTagRelate($tags){

        //先删除原有标签关联
        TagArticle::deleteAll(['blog_article_id' => $this->id]);

        //保存新选择的 和新建的标签
        $this->saveTagRelate($tags);

    }

    /**
     * 保存文章内容
     * @throws Exception
     */
    private function saveContent(){
        $contentModel = new Content();
        $contentModel->article_id = $this->id;
        $contentModel->type = static::ARTICLE_TYPE;
        $contentModel->words = mb_strlen($this->content_str, 'utf-8');
        $contentModel->content = $this->content_str;

        if(!$contentModel->save(false))
            throw new Exception('保存文章内容失败，请重试。');
    }

    /**
     * 保存文章内容
     * @throws Exception
     */
    private function renewContent(){

        $contentModel = Content::find()->where(['article_id'=>$this->id, 'type'=>static::ARTICLE_TYPE])->one();

        $contentModel->words = mb_strlen($this->content_str, 'utf-8');
        $contentModel->content = $this->content_str;

        if(!$contentModel->save(false))
            throw new Exception('保存文章内容失败，请重试。');
    }


}