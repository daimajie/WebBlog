<?php
namespace app\components\widgets\imageInput;

use yii\widgets\InputWidget;
use yii\base\InvalidConfigException;
/**
 * 编辑器
 */
class ImageInput extends InputWidget
{
    public $defaultImage;
    public $uploadUrl;
    public $clientOptions = [];

    public function run ()
    {
        // 注册客户端所需要的资源
        $this->registerClientScript();

        // 构建html结构
        if ($this->hasModel()) {

            //输出html
            return $this->render('image-input',[
                'defaultImage' => $this->defaultImage,
                'uploadUrl' => $this->uploadUrl,
                'model' => $this->model,
                'attribute' => $this->attribute,
                'clientOptions' => json_encode($this->clientOptions),
                'id' => $this->options['id']
            ]);

        } else {
            throw new InvalidConfigException("'model' must be specified.");
        }
    }

    public function registerClientScript(){
        $view = $this->getView();
        ImageInputAsset::register($view);


    }


}