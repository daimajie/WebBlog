<?php
namespace app\components\widgets;

use app\assets\UEditorAsset;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\InputWidget;
use yii\base\InvalidConfigException;
/**
 * 编辑器
 */
class UEditor extends InputWidget
{
    public $clientOptions = [];

    public $selector; //UEditor选择器


    public function run ()
    {
        // 注册客户端所需要的资源
        $this->registerClientScript();

        // 构建html结构
        if ($this->hasModel()) {

            //输出html
            echo Html::activeTextarea($this->model, $this->attribute, [
                'id' => $this->selector
            ]);
        } else {
            throw new InvalidConfigException("'model' must be specified.");
        }
    }

    public function registerClientScript(){
        $view = $this->getView();
        UEditorAsset::register($view);

        $clintOptions = json_encode($this->clientOptions);

        //初始化编辑器
        $jsStr = <<<JS
            var ue = UE.getEditor("{$this->selector}",{$clintOptions});

            //给文本框添加id
            $(ue.textarea).attr('id', "{$this->options['id']}");
JS;

        $view->registerJs($jsStr);
    }


}