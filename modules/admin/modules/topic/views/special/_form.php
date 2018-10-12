<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\widgets\imageInput\ImageInput;
use yii\helpers\Url;
use app\components\helper\Helper;

/* @var $this yii\web\View */
/* @var $model app\models\topic\Special */
/* @var $form yii\widgets\ActiveForm */

//选择图片组件的默认图片
$cover = Yii::$app->params['article']['cover'];
?>

<div class="special-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'image')->widget(ImageInput::class,[
            'defaultImage' => !empty($model->image) ? Helper::showImage($model->image) : $cover,
            'uploadUrl' => Url::to(['upload']),
        ]) ?>

        <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
