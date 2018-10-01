<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\member\SearchContact */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '留言列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-index box box-primary">
    <div class="box-header with-border">
         <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <div class="box-body table-responsive no-padding">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'email:email',
                'subject',
                'body',
                [
                    'attribute' => 'visited',
                    'value' => function($model){
                        return $model->visited ? '已读' : '未读';
                    }
                ],
                [
                    'attribute' => 'user_id',
                    'value' => function($model){
                        return $model->user->username;
                    }
                ],
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:Y-m-d']
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {delete}',
                ],
            ],
        ]); ?>
    </div>
</div>
