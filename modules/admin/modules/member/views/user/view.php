<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\member\UserForm */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '用户列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-form-view box box-primary">
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
            'model' => $model,
            'attributes' => [
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
                            $avatar = Yii::getAlias('@web/' . $model->image);
                        }


                        return Html::img($avatar, ['width'=>50,'height'=>50,'class'=>'img-circle']);
                    }
                ],
                'status',
                'auth_key',
                'password_hash',
                'password_reset_token',
                'created_at:datetime',
                'updated_at:datetime',
                'lasttime',
                'signip',
            ],
        ]) ?>
    </div>
</div>
