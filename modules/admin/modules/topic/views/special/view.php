<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\components\helper\Helper;

/* @var $this yii\web\View */
/* @var $model app\models\topic\Special */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '专题列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="special-view box box-primary">
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
            'template' => '<tr><th width="120">{label}</th><td{contentOptions}>{value}</td></tr>',
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                [
                    'attribute' => 'image',
                    'format' => 'html',
                    'value' => function($model){
                        if(empty($model->image)){
                            return ' - ';
                        }else{
                            return Html::img(Helper::showImage($model->image), ['width'=>150]);
                        }
                    }
                ],
                'description',
                'count',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>
    </div>
</div>
