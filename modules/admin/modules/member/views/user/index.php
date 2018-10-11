<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\helper\Helper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\member\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-form-index box box-primary">
    <div class="box-header with-border">
        <div class="pull-left">
            <?= Html::a('创建用户', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
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
                'username',
                'email:email',
                [
                    'attribute' => 'image',
                    'format' => 'html',
                    'value' => function($model){
                        if(empty($model->image)){
                            //默认头像
                            $avatar = Yii::$app->params['member']['avatar'];
                        }else{
                            $avatar = Helper::showImage($model->image);
                        }


                        return Html::img($avatar, ['width'=>35,'height'=>35,'class'=>'img-circle']);
                    }
                ],
                'status',
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:Y-m-d']
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => ['date', 'php:Y-m-d']
                ],
                [
                    'attribute' => 'lasttime',
                    'value' => function($model){
                        return $model->lasttime == 0 ? ' - ' : date('Y-m-d', $model->lasttime);
                    }
                ],
                [
                    'attribute' => 'signip',
                    'value' => function($model){
                        return $model->signip == 0 ? ' - ' : long2ip($model->signip);
                    }
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
