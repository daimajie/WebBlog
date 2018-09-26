<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\blog\Tag */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '标签列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-view box box-primary">
    <div class="box-header">
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
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
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                [
                    'attribute'=>'created_at',
                    'format' => ['date', 'php:Y-m-d']
                ],
                [
                    'attribute'=>'updated_at',
                    'format' => ['date', 'php:Y-m-d']
                ],
                [
                    'attribute' => 'category_id',
                    'label' =>'所属分类',
                    'value' => function($model){
                        return $model->category->name;
                    }
                ],
            ],
        ]) ?>
    </div>
</div>
