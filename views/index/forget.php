<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '忘记密码 - ' . Html::encode($this->params['seo']['name']);
$this->params['keywords'] = '';
$this->params['description'] = '';
?>

<!-- /.login-logo -->
<div class="login-box-body">
    <p class="login-box-msg">填写信息找回密码</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
    ]); ?>
        <?=
            $form->field($model, 'username', ['options'=>[
                'tag'=>'div',
                'class' => 'form-group has-feedback',
            ],
            'template' => "{label}\n{input}<span class=\"glyphicon glyphicon-envelope form-control-feedback\"></span>\n{error}",
            ])->textInput([
            'autofocus' => true,
            'placeholder' => '用户名',
            ])->label(false);
        ?>

        <?=
        $form->field($model, 'email', ['options'=>[
            'tag'=>'div',
            'class' => 'form-group has-feedback',
        ],
            'template' => "{label}\n{input}<span class=\"glyphicon glyphicon-envelope form-control-feedback\"></span>\n{error}",
        ])->textInput([
            'autofocus' => true,
            'placeholder' => '邮箱',
        ])->label(false);
        ?>

        <?= $form->field($model,'captcha',[
            'options' => [
                'tag'=>'div',
                'class' => 'form-group has-feedback',
            ],
            'template' => "{label}\n{input}<span class=\"glyphicon glyphicon-picture  form-control-feedback\"></span>\n{error}",
        ])->widget(yii\captcha\Captcha::className(),[
            'captchaAction'=>'index/captcha',
            'options' => ['placeholder'=>'验证码','class'=>'form-control'],
            'imageOptions'=>[
                'alt'=>'点击换图',
                'title'=>'点击换图',
                'style'=>'cursor:pointer',

            ],
            'template' => '{input} {image}',
        ])->label(false);?>

        <div class="row">
            <div class="col-xs-8">
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('发送邮件', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>
    <?php ActiveForm::end(); ?>

    <div class="social-auth-links text-center">
    </div>
    <!-- /.social-auth-links -->
    <div style="padding-bottom: 15px;">
        <a href="<?= Url::to(['login'])?>" class="pull-left">返回登录页.</a>
        <a href="<?= Url::to(['register'])?>" class="pull-right">注册新账户.</a>
    </div>

</div>
<!-- /.login-box-body -->