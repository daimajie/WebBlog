<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\setting\Friend */

$this->title = '修改友链: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '友链列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改友链';
?>
<div class="friend-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
