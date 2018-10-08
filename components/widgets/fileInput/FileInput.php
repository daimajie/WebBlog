<?php
namespace app\components\widgets\fileInput;

use app\components\helper\Helper;
use yii\widgets\InputWidget;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

/**
 * 编辑器
 */
class FileInput extends InputWidget
{
    public $clientOptions = [];

    public function run ()
    {
        // 注册客户端所需要的资源
        $this->registerClientScript();

        // 构建html结构
        if ($this->hasModel()) {


            //输出html
            return $this->printHtml();
        } else {
            throw new InvalidConfigException("'model' must be specified.");
        }
    }

    public function registerClientScript(){
        $view = $this->getView();
        FileInputAsset::register($view);

    }

    public function printHtml(){
        $input = Html::fileInput($this->attribute, null, [
            'id' => 'picID',
            'accept' => "image/gif,image/jpeg,image/x-png"
        ]);

        $currentImg = !empty($this->model->image) ? Helper::showImage($this->model->image) : '/statis/img/noimage.png';
        $html = <<<HTML
            <div class="form-group" id="uploadForm">
                <div class="fileinput fileinput-new" data-provides="fileinput"  id="exampleInputUpload">
                    <div class="fileinput-new thumbnail" style="width: 200px;height: auto;max-height:150px;">
                        <img id='picImg' style="width: 100%;height: 140px;" src="{$currentImg}" alt="" />
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                    <div>
                        <span class="btn btn-primary btn-file">
                            <span class="fileinput-new">选择文件</span>
                            <span class="fileinput-exists">换一张</span>
                            {$input}
                        </span>
                        <a href="javascript:;" class="btn btn-warning fileinput-exists" data-dismiss="fileinput">移除</a>
                    </div>
                </div>
            </div>
HTML;
        return $html;
    }


}