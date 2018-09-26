<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\member\UserForm */

$this->title = '创建用户';
$this->params['breadcrumbs'][] = ['label' => '用户列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-form-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
