<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '章节列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chapter-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('创建章节', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
        <?php echo $this->render('_search', ['model' => $searchModel, 'selected'=>$selected]); ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                [
                    'attribute' => 'special_id',
                    'value' => function($model){
                        return $model->special->name;
                    }
                ],
                'title',
                'count',
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:Y-m-d']
                ],
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:Y-m-d']
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
