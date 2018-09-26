<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\LaydateTAsset;

LaydateTAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\notes\SearchNotes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'form-inline',

        ],
        'fieldConfig'=>[
            'template' =>'{input}'
        ],
    ]); ?>

    <?= $form->field($model, 'start_time')->textInput(['placeholder'=>'开始时间','class'=>'form-control date-picker']) ?>

    <?= $form->field($model, 'end_time')->textInput(['placeholder'=>'结束时间', 'class'=>'form-control date-picker']) ?>

    <?= $form->field($model, 'user_id')->textInput(['placeholder'=>'用户','disabled'=>'disabled']) ?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$js = <<<JS
 $('input.date-picker').on('click', function(){
     var that = $(this);
     laydate.apply(that);
 });
JS;
$this->registerJs($js);
?>


