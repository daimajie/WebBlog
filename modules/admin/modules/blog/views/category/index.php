<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '分类列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('新建分类', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'name',
                'desc',
                'count',
                //'created_at',
                // 'updated_at',
                [
                    'attribute'=>'created_at',
                    'format' => ['date', 'php:Y-m-d']
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
            'emptyText' => '暂无数据'
        ]); ?>
    </div>
</div>
