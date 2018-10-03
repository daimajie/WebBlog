<?php
namespace app\assets;

use yii\web\AssetBundle;

class UEditorAsset extends AssetBundle
{
    public $basePath = '@webroot/static/libs';
    public $baseUrl = '@web/static/libs';
    public $css = [

    ];
    public $js = [
        'UEditor/ueditor.config.js',
        'UEditor/ueditor.all.min.js',
        'UEditor/lang/zh-cn/zh-cn.js',
    ];
}