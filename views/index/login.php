<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = Yii::$app->name . ' - 用户登录';
?>

<!-- /.login-logo -->
<div class="login-box-body">
    <p class="login-box-msg">登录即可开始当前会话</p>

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
            'placeholder' => '用户名/邮箱',
            ])->label(false);
        ?>

        <?=
        $form->field($model, 'password', ['options'=>[
            'tag'=>'div',
            'class' => 'form-group has-feedback',
        ],
            'template' => "{label}\n{input}<span class=\"glyphicon glyphicon-lock form-control-feedback\"></span>\n{error}",
        ])->passwordInput([
            'placeholder' => '密码',
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
                <div class="checkbox icheck">
                    <?= $form->field($model, 'rememberMe', ['options'=>['tag'=>false]])->checkbox([
                        'template' => "<label>{input}{label}{error}</label>",
                    ]) ?>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>
    <?php ActiveForm::end(); ?>

    <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#"><i class="fa fa-qq"></i></a>
        <a href="#"><i class="fa fa-wechat"></i></a>
    </div>
    <!-- /.social-auth-links -->
    <div style="padding-bottom: 15px;">
        <a href="<?= Url::to(['forget'])?>" class="pull-left">忘记密码.</a>
        <a href="<?= Url::to(['register'])?>" class="pull-right">注册新账户.</a>
    </div>

</div>
<!-- /.login-box-body -->