<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\blog\Category */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '分类列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view box box-primary">
    <div class="box-header">
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => '您确定要删除该项目吗?',
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
                'name',
                'desc',
                'count',
                [
                    'attribute'=>'created_at',
                    'format' => ['date', 'php:Y-m-d']
                ],
                [
                    'attribute'=>'updated_at',
                    'format' => ['date', 'php:Y-m-d']
                ],
            ],
        ]) ?>
    </div>
</div>
