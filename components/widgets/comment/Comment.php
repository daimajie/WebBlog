<?php
namespace app\components\widgets\comment;

use yii\base\Widget;
//use app\components\widgets\comment\CommentAsset;
/**
 * 评论小部件
 */
class Comment extends Widget
{
    public $article;
    public $fullwidth = false;



    public function run ()
    {
        // 注册客户端所需要的资源
        $this->registerClientScript();



        return $this->render('index',[
            'article' => $this->article,
            'fullwidth' => $this->fullwidth
        ]);
    }

    public function registerClientScript(){
        $view = $this->view;

        CommentAsset::register($view);
    }


}