<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\notes\SearchNotes */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '日记列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notes-index box box-primary">
    <div class="box-header with-border">
        <div class="pull-left">
            <?= Html::a('创建日记', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
        </div>
        <div class="pull-right">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
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
                'title',
                [
                    'attribute'=>'created_at',
                    'format' => ['date', 'php:Y-m-d']
                ],
                [
                    'attribute'=>'created_at',
                    'format' => ['date', 'php:Y-m-d']
                ],
                'user_id',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
