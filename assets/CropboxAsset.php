<?php
namespace app\assets;

use yii\web\AssetBundle;

class CropboxAsset extends AssetBundle
{
    public $basePath = '@webroot/static/libs';
    public $baseUrl = '@web/static/libs';
    public $css = [
        'cropbox/cropbox.css'
    ];
    public $js = [
        'cropbox/cropbox.js',
    ];
    public $depends = [
        'dmstr\web\AdminLteAsset',
    ];
}