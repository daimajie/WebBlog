<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\EditormdAsset;

EditormdAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\notes\Notes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notes-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>


        <div class="form-group field-article-content">
            <label class="control-label" for="article-content">文章内容</label>
            <?= $form->field($model, 'content',['options'=>['id'=>'editormd']])->textarea() ?>
            <div class="help-block"></div>
        </div>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('提交保存', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
$js = <<<SCRIPT
    var editor = editormd("editormd", {
        path : "/static/libs/editormd/lib/",
        width   : "100%",
        height  : 640,
        syncScrolling : "single"
        
    });

SCRIPT;

$this->registerJs($js);
?>

