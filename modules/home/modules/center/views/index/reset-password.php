<?php
use yii\widgets\ActiveForm;
?>
<section class="content">
    <div class="row">
        <!-- right column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">修改密码</h3>
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

                        <?= $form->field($model, 'secure_email',[
                            'options'=>[
                                'class' => 'form-group',
                            ],
                        ])->textInput([
                            'class' => 'form-control',
                            'placeholder' => '邮箱'
                        ])->label('邮箱',['class' => 'col-sm-2 control-label']) ?>

                        <?= $form->field($model, 'password',[
                            'options'=>[
                                'class' => 'form-group',
                            ],
                        ])->passwordInput([
                            'class' => 'form-control',
                            'placeholder' => '新密码'
                        ])->label('新密码',['class' => 'col-sm-2 control-label']) ?>

                        <?= $form->field($model, 're_password',[
                            'options'=>[
                                'class' => 'form-group',
                            ],
                        ])->passwordInput([
                            'class' => 'form-control',
                            'placeholder' => '重复密码'
                        ])->label('重复密码',['class' => 'col-sm-2 control-label']) ?>
                    </div>

                    <!-- /.box-body -->
                    <div class="box-footer">
                        <input type="reset" class="btn btn-default"></input>
                        <input type="submit" class="btn btn-primary"></input>
                    </div>
                    <!-- /.box-footer -->
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <!--/.col (right) -->
    </div>
    <!-- /.row -->
</section>