<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\topic\Chapter */

$this->title = '修改章节: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '章节列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改章节';
?>
<div class="chapter-update">

    <?= $this->render('_form', [
        'model' => $model,
        'belongTo' => $belongTo
    ]) ?>

</div>
