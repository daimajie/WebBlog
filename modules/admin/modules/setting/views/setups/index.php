<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\components\helper\Helper;
/* @var $this yii\web\View */
/* @var $model app\models\setting\Setups */
$this->title = '站点信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setups-view box box-primary">
    <div class="box-header">
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'template' => '<tr><th width="120">{label}</th><td{contentOptions}>{value}</td></tr>',
            'model' => $model,
            'attributes' => [
                'name',
                'sign',
                'keywords',
                'description',
                [
                    'attribute' => 'image',
                    'format' => 'html',
                    'value' => function($model){
                        return Html::img( Helper::showImage($model->image), ['width'=>150]);
                    }
                ],
                'email:email',
                'about',
                'history',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>
    </div>
</div>
