<?php


/* @var $this yii\web\View */
/* @var $model app\models\notes\Notes */

$this->title = '修改日记: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '日记列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改日记';
?>
<div class="notes-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
