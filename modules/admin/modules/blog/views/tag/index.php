<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\blog\SearchTag */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '标签列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-index box box-primary">
    <div class="box-header with-border">
        <div class="pull-left">
            <?= Html::a('新建标签', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
        </div>
        <div class="pull-right">
            <?php echo $this->render('_search', [
                'model' => $searchModel,
                'category' => $category
            ]); ?>
        </div>

    </div>
    <div class="box-body table-responsive no-padding">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

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

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
