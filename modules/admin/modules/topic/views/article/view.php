<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\topic\SpecialArticle */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="special-article-view box box-primary">
    <div class="box-header">
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?php
        if($model->recycle === 1){
            echo Html::a('丢弃', ['discard', 'id' => $model->id], [
                'class' => 'btn btn-info btn-flat',
                'data' => [
                    'confirm' => '您确定要彻底删除该项吗?',
                    'method' => 'post',
                ],
            ]);
        }else{
            echo Html::a('删除', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-flat',
                'data' => [
                    'confirm' => '您确定要删除该项吗?',
                    'method' => 'post',
                ],
            ]);
        }
        ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'title',
                [
                    'attribute' => 'draft',
                    'value' => function($model){
                        return $model->draft ? '草稿箱文章' : ' - ';
                    }
                ],
                [
                    'attribute' => 'recycle',
                    'value' => function($model){
                        return $model->recycle ? '回收站文章' : ' - ';
                    }
                ],
                'visited',
                'comment',
                'special.name',
                'chapter.title',
                'created_at:datetime',
                'updated_at:datetime',
                'user_id',
                'content.words',
                [
                    'attribute' => 'content',
                    'label' => '文章内容',
                    'value' => function($model){
                        return $model->content->content;
                    }
                ]
            ],
        ]) ?>
    </div>
</div>
