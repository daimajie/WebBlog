<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\widgets\UEditor;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\notes\Notes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notes-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'content')->widget(UEditor::class,[
                'selector' => 'ueditor',
        ]) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('提交保存', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

