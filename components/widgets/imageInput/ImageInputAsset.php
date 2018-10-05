<?php
namespace app\components\widgets\imageInput;

use yii\web\AssetBundle;

class ImageInputAsset extends AssetBundle
{
    public $css = [
        ['webuploader/Uploader.swf','id'=>'swf']

    ];
    public $js = [
        'webuploader/webuploader.min.js',

    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'app\assets\LayerAsset',
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
