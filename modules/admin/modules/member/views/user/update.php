<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\member\UserForm */

$this->title = '修改用户: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '用户列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改用户';
?>
<div class="user-form-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
