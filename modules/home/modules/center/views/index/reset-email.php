<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<section class="content">
    <div class="row">
        <!-- right column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">修改邮箱</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?php $form = ActiveForm::begin([
                    'options' => [
                        'class' => "form-horizontal",
                    ],
                    'fieldConfig' => [
                        'template' => '{label}<div class="col-sm-10">{input}{error}</div>'
                    ]
                ]); ?>
                    <div class="box-body">
                        <?= $form->field($model, 'username',[
                            'options'=>[
                                'class' => 'form-group',
                            ],
                        ])->textInput([
                            'class' => 'form-control disabled',
                            'disabled'=>"disabled",
                            'placeholder' => '用户名'
                        ])->label('用户名',['class' => 'col-sm-2 control-label']) ?>

                        <?= $form->field($model, 'password',[
                            'options'=>[
                                'class' => 'form-group',
                            ],
                        ])->passwordInput([
                            'class' => 'form-control',
                            'placeholder' => '密码'
                        ])->label('密码',['class' => 'col-sm-2 control-label']) ?>

                        <?= $form->field($model, 'secure_email',[
                            'options'=>[
                                'class' => 'form-group',
                            ],
                        ])->textInput([
                            'class' => 'form-control',
                            'placeholder' => '新邮箱',
                            'id'=> 'email_input'
                        ])->label('新邮箱',['class' => 'col-sm-2 control-label']) ?>

                        <?=
                        $form->field($model, 'email_captcha', ['options'=>[
                            'tag'=>'div',
                            'class' => 'form-group',
                            'id' => 'email_box'
                        ],
                            'template' => "{label}\n<div class='col-sm-5'>{input}\n{error}</div><div class='col-sm-2'><span class='btn btn-info'>获取验证码</span></div>",
                        ])->textInput([
                            'class' => 'form-control',
                            'placeholder' => '邮箱验证码',
                        ])->label('邮箱验证码',['class' => 'col-sm-2 control-label']);
                        ?>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <input type="reset" class="btn btn-default"></input>
                        <input type="submit" class="btn btn-primary"></input>
                    </div>
                    <!-- /.box-footer -->
                <?php ActiveForm::end(); ?>
                </form>
            </div>
        </div>
        <!--/.col (right) -->
    </div>
    <!-- /.row -->
</section>

<?php
$sendEmailUrl = Url::to(['/index/send-email-captcha']);
$jsStr = <<<JS
    $('#email_box span').on('click', function(){
        var that = $(this), 
            val = $('#email_input').val();
        
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