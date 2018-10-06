<?php
namespace app\components\widgets\comment;

use yii\web\AssetBundle;

class CommentAsset extends AssetBundle
{

    public $css = [

    ];
    public $js = [
        'static/template-web.js',
        'static/js/comment.js',
    ];
    public $depends = [
        'app\assets\appAsset',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = __DIR__;
        parent::init();
    }
}
