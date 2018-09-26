<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\topic\SearchSpecialArticle */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="special-article-index box box-primary">
    <div class="box-header with-border">
        <div class="pull-left">
            <?= Html::a('新建博文', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
            <?= Html::a('草稿箱', ['', 'draft'=>1], ['class' => 'btn btn-info btn-flat']) ?>
            <?= Html::a('回收站', ['', 'recycle'=>1], ['class' => 'btn btn-danger btn-flat']) ?>
            <?= Html::a('全部', [''], ['class' => 'btn btn-warning btn-flat']) ?>
        </div>
        <div class="pull-right">
            <?php echo $this->render('_search', [
                    'model' => $searchModel,
                    'selectedSpecial' => $selectedSpecial,
                    'selectedChapter' => $selectedChapter
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
                'title',
                [
                    'attribute' => 'special_id',
                    'value' => function($model){
                        return $model->special->name;
                    }
                ],
                [
                    'attribute' => 'chapter_id',
                    'value' => function($model){
                        return $model->chapter->title;
                    }
                ],
                'visited',
                'comment',
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:Y-m-d']
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => ['date', 'php:Y-m-d']
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete} {refresh} {discard}',
                    'buttons' => [
                        'discard' => function ($url, $model, $key) {
                            $options = [
                                'title'=>'彻底删除',
                                'data-confirm' => '您要彻底删除该项吗？',
                                'data-method' => 'post',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-scissors" aria-hidden="true"></span>', $url, $options);
                        },
                        'refresh' => function ($url, $model, $key) {
                            $options = ['title'=>'恢复'];
                            return Html::a('<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>', $url,$options);
                        }
                    ],
                    'visibleButtons' => [
                        //回收站不展示修改
                        'update' => function($model, $key, $index){
                            if(!empty($_GET['recycle'])){
                                return false;
                            }
                            return true;
                        },
                        //回收站不展示删除
                        'delete' => function($model, $key, $index){
                            if(!empty($_GET['recycle'])){
                                return false;
                            }
                            return true;
                        },
                        //回收站展示丢弃
                        'discard' => function($model, $key, $index){
                            if(!empty($_GET['recycle'])){
                                return true;
                            }
                            return false;
                        },
                        //回收站展示恢复文章
                        'refresh' => function($model, $key, $index){
                            if(!empty($_GET['recycle'])){
                                return true;
                            }
                            return false;
                        }
                    ]
                ],
            ],
        ]); ?>
    </div>
</div>
