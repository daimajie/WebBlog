<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = Yii::$app->name . ' - 设置新密码';
?>

<!-- /.login-logo -->
<div class="login-box-body">
    <p class="login-box-msg">设置新密码</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
    ]); ?>
        <?=
        $form->field($model, 'new_password', ['options'=>[
            'tag'=>'div',
            'class' => 'form-group has-feedback',
        ],
            'template' => "{label}\n{input}<span class=\"glyphicon glyphicon-lock form-control-feedback\"></span>\n{error}",
        ])->passwordInput([
            'autofocus' => true,
            'placeholder' => '新密码',
        ])->label(false);
        ?>

        <?=
        $form->field($model, 're_password', ['options'=>[
            'tag'=>'div',
            'class' => 'form-group has-feedback',
        ],
            'template' => "{label}\n{input}<span class=\"glyphicon glyphicon-lock form-control-feedback\"></span>\n{error}",
        ])->passwordInput([
            'autofocus' => true,
            'placeholder' => '重复密码',
        ])->label(false);
        ?>



        <div class="row">
            <div class="col-xs-8">
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('重置密码', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>
    <?php ActiveForm::end(); ?>

    <div class="social-auth-links text-center">
    </div>

</div>
<!-- /.login-box-body -->