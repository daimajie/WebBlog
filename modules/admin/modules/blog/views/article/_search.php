<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\blog\SearchArticle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-search">

    <?php $form = ActiveForm::begin([
        'action' => Url::current(),
        'method' => 'get',
        'options' => [
            'class' => 'form-inline',

        ],
        'fieldConfig'=>[
            'template' =>'{input}'
        ],
    ]); ?>

    <?php echo $form->field($model, 'title')->textInput(['placeholder'=>'标题搜索']) ?>

    <?php echo $form->field($model, 'category_id')->dropDownList($category, ['prompt'=>'选择分类']); ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
