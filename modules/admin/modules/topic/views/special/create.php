<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\topic\Special */

$this->title = '创建专题';
$this->params['breadcrumbs'][] = ['label' => '专题列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="special-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
