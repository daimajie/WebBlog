<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\member\Contact */

$this->title = $model->subject;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-view box box-primary">
    <div class="box-header">
        <?= Html::a('返回', ['index'], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => '您确定要删除该留言吗?',
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
                'created_at:datetime',
            ],
        ]) ?>
    </div>
</div>
