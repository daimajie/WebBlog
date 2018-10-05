<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\helper\Helper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\topic\SearchSpecial */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '专题列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="special-index box box-primary">
    <div class="box-header with-border">
        <?= Html::a('创建专题', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
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
                'count',
                 [
                         'attribute'=>'created_at',
                     'format' => ['date', 'php:Y-m-d']
                 ],
                [
                    'attribute'=>'updated_at',
                    'format' => ['date', 'php:Y-m-d']
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
