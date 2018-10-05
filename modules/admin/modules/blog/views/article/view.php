<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\components\helper\Helper;

/* @var $this yii\web\View */
/* @var $model app\models\blog\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '博文列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view box box-primary">
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
            'template' => '<tr><th width="120">{label}</th><td{contentOptions}>{value}</td></tr>',
            'model' => $model,
            'attributes' => [
                'id',
                'title',
                'brief',
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
                [
                    'attribute' => 'type',
                    'value' => function($model){
                        $tmp = ['原创','转载','翻译'];
                        return $tmp[$model->type];
                    }
                ],
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
                'praise',
                'collect',

                'category.name',
                [
                        'label' => '已选标签',
                    'value' => function($model){
                        $tags = '';
                        foreach($model->tags as $k => $v){
                            $tags .= $v->name . ' , ';
                        }
                        return trim($tags, ' , ');
                    }
                ],

                'user_id',
                [
                    'label' => '文章字数',
                    'value' => function($model){
                        return $model->content->words;
                    }
                ],
                [
                    'label' => '文章内容',
                    'value' => function($model){
                        return $model->content->content;
                    }
                ],

                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>
    </div>
</div>
