<?php
namespace app\components\widgets;

use app\assets\UEditorAsset;
use yii\widgets\InputWidget;
use yii\base\InvalidConfigException;
/**
 * 编辑器
 */
class UEditor extends InputWidget
{
    public $clientOptions = [];
    public $selector;


    public function run ()
    {
        // 注册客户端所需要的资源
        $this->registerClientScript();

        // 构建html结构
        if ($this->hasModel()) {
            //合并选项
            $this->options = array_merge($this->options, $this->clientOptions);

            //输出html
            echo '<script id="'. $this->selector .'" type="text/plain"></script>';
        } else {
            throw new InvalidConfigException("'model' must be specified.");
        }
    }

    public function registerClientScript(){
        $view = $this->getView();
        UEditorAsset::register($view);

        //初始化编辑器
        $jsStr = <<<JS
            var ue = UE.getEditor("$this->selector",{});
JS;

        $view->registerJs($jsStr);
    }


}