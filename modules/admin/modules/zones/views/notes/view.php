<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\notes\Notes */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '日记列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notes-view box box-primary">
    <div class="box-header">
        <?= Html::a('编辑', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => '您确定要删除该项吗?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'template' => '<tr><th width="120">{label}</th><td{contentOptions}>{value}</td></tr>',
            'model' => $model,
            'attributes' => [
                'id',
                'title',
                'content:ntext',
                'created_at:datetime',
                'updated_at:datetime',
                'user_id',
            ],
            'template' => '<tr><th width="120">{label}</th><td{contentOptions}>{value}</td></tr>',
        ]) ?>
    </div>
</div>
