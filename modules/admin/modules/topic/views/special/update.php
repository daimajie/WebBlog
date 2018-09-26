<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\topic\Special */

$this->title = '修改专题: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '专题列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="special-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
