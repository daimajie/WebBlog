<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = Yii::$app->name . ' - 注册新用户';
?>
<div class="register-box-body">
    <p class="login-box-msg">注册一个新账户</p>

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
        $form->field($model, 'password', ['options'=>[
            'tag'=>'div',
            'class' => 'form-group has-feedback',
        ],
            'template' => "{label}\n{input}<span class=\"glyphicon glyphicon-lock form-control-feedback\"></span>\n{error}",
        ])->passwordInput([
            'placeholder' => '密码',
        ])->label(false);
        ?>
        <?=
        $form->field($model, 're_password', ['options'=>[
            'tag'=>'div',
            'class' => 'form-group has-feedback',
        ],
            'template' => "{label}\n{input}<span class=\"glyphicon glyphicon-lock form-control-feedback\"></span>\n{error}",
        ])->passwordInput([
            'placeholder' => '重复密码',
        ])->label(false);
        ?>

        <?=
        $form->field($model, 'email', ['options'=>[
            'tag'=>'div',
            'class' => 'form-group has-feedback',
            'id' => 'email_val'
        ],
            'template' => "{label}\n{input}<span class=\"glyphicon glyphicon-envelope form-control-feedback\"></span>\n{error}",
        ])->textInput([
            'placeholder' => '邮箱',
            //'style' => 'width:70%;',
        ])->label(false);
        ?>
        <?=
        $form->field($model, 'email_captcha', ['options'=>[
            'tag'=>'div',
            'class' => 'form-group has-feedback',
        ],
            'template' => "{label}\n<div id='email_box'>{input}<span class='btn btn-info btn-flat  '>获取验证码</span></div>\n{error}",
        ])->textInput([
            'placeholder' => '邮箱验证码',
        ])->label(false);
        ?>


        <div class="row">
            <div class="col-xs-8">
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('注册', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>
    <?php ActiveForm::end(); ?>

    <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#"><i class="fa fa-qq"></i></a>
        <a href="#"><i class="fa fa-wechat"></i></a>
    </div>

    <a href="<?= Url::to(['index/login'])?>" class="text-center">已经拥有账户，现在去登录。</a>
</div>
<!-- /.form-box -->

<?php
$sendEmailUrl = Url::to(['index/send-email-captcha']);
$jsStr = <<<JS
    $('#email_box span').on('click', function(){
        var that = $(this), 
            val = $('#email_val input').val();
        
        if(val.length <= 0) return;
        
        if(that.hasClass('disabled')) return;
        
        $.ajax({
            url : "$sendEmailUrl",
            type : 'POST',
            data : {email : val},
            success : function(d){
                if(d.errno === 0){
                    //邮件发送成功
                    setTimer(that);
                }else{
                    layer.msg(d.errmsg); 
                }
                
            }
        });
        return false;
        
    });

    //定时器
    var timer = null;
    function setTimer(obj){
        clearInterval(timer);
        
        if( !obj.hasClass('disabled') ) obj.addClass('disabled');
        
        obj.text('已发送邮件');
        
        var scond = 60;
            timer = setInterval(function(){
            scond--;
            
            if(scond <= 0){
                obj.text('发送邮件').removeClass('disabled');
                clearInterval(timer);
            }else{
                obj.text('- ' + scond + ' -');
            }
        },1000);
    }
JS;

$this->registerJs($jsStr);
?>