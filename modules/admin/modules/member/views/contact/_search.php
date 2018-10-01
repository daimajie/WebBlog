<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\member\SearchContact */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pull-right">

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

    <?php echo $form->field($model, 'username')->textInput(['placeholder'=>'用户名']) ?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
