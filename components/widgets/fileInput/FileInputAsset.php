<?php
namespace app\components\widgets\fileInput;

use yii\web\AssetBundle;

class FileInputAsset extends AssetBundle
{
    public $css = [
        'static/css/bootstrap-fileinput.css',
    ];
    public $js = [
        'static/js/bootstrap-fileinput.js',

    ];
    
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
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
