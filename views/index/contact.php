<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\components\widgets\sidebar\About;
use app\components\widgets\sidebar\Category;
use app\components\widgets\sidebar\Hot;
use app\components\widgets\sidebar\Tags;
use app\components\widgets\sidebar\Friend;


$this->title = '联系我 - ' . Html::encode($this->params['seo']['name']);
$this->params['keywords'] = '';
$this->params['description'] = '';
?>
<section class="section-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-md-8">
                <article class="contact-media">
                    <h3 class="contact-media-title">联系我 -- </h3>
                    <div class="bubble-line"></div>
                    <div class="contact-content">
                        <h3>
                            填写您的联系方式和建议，然后提交。我会尽快与您联系的。
                        </h3>
                        <p>
                            如果您有使用或其他问题，请填写以下表格与我们联系。 感谢您的来信。
                        </p>
                        <div class="contact-row">
                            <?php $form = ActiveForm::begin([
                                'id' => 'login-form',
                            ]); ?>
                                <div class="contact-form">
                                    <?= $form->field($model, 'email')?>
                                    <?= $form->field($model, 'subject')?>
                                    <?= $form->field($model, 'body')->textarea(['style'=>"resize:none;"])?>
                                    <?= $form->field($model,'verifyCode',[
                                    ])->widget(yii\captcha\Captcha::class,[
                                        'captchaAction'=>'index/captcha',
                                        'options' => [
                                            'placeholder'=>'验证码',
                                        ],
                                        'imageOptions' => [
                                            'style'=>'width:150px;',
                                        ],
                                        'template' => "<div>{image}</div>{input}"
                                    ])->label(false);?>

                                </div>

                                <div class="contact-submit">
                                    <?= Html::submitButton('提交', ['class' => 'button']) ?>
                                </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </article>
            </div>
            <div class="col-sm-4 sidebar">
                <!-- 我的故事 -->
                <?= About::widget([])?>
                <!-- 分类 -->
                <?= Category::widget([])?>
                <!-- 热门文章 -->
                <?= Hot::widget([])?>
                <!-- 标签 -->
                <?= Tags::widget([])?>
                <!-- 友链 -->
                <?= Friend::widget([])?>
            </div>
        </div>
    </div>
</section>
