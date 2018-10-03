<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


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
                <div class="widget">
                    <h3 class="widget-title">Story about me</h3>
                    <div class="bubble-line"></div>

                    <div class="widget-content">
                        <img src="/static/img/widget/about.jpg" alt="not image">
                        <p>Hello I’m Jenny Kurto author of Letter town blog. This is my personal space which is like to share
                            others. And i’m living New York city working and blogging.</p>
                        <div class="widget-more">
                            <a href="javascript:;" class="button">More story</a>
                        </div>
                    </div>
                </div>
                <div class="widget">
                    <h3 class="widget-title"> Category</h3>
                    <div class="bubble-line"></div>
                    <div class="widget-content">
                        <ul>
                            <li>
                                <a href="javascript:;">Video & music</a>
                            </li>
                            <li>
                                <a href="javascript:;">Fashion</a>
                            </li>
                            <li>
                                <a href="javascript:;">Travel & hiking</a>
                            </li>
                            <li>
                                <a href="javascript:;">Photography</a>
                            </li>
                            <li>
                                <a href="javascript:;">food recipe</a>
                            </li>
                            <li>
                                <a href="javascript:;">do it yourself</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="widget">
                    <h3 class="widget-title"> Resent posts</h3>
                    <div class="bubble-line"></div>
                    <div class="widget-content">
                        <div class="widget-recent">
                            <img src="/static/img/widget/resent.jpg" alt="not image">
                            <h4><a href="javascript:;">Meet my workspace</a> </h4>
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                                industry.
                            </p>
                        </div>
                        <div class="widget-recent">
                            <img src="/static/img/widget/resent1.jpg" alt="not image">
                            <h4><a href="javascript:;">This is how to unique idea born</a> </h4>
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                                industry.
                            </p>
                        </div>
                        <div class="widget-recent last">
                            <img src="/static/img/content/photos4.jpg" alt="not image">
                            <h4><a href="javascript:;">Only you will choose your life.</a></h4>
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                                industry.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="widget widget-sub">
                    <h5> Subscribe</h5>
                    <p>Sign up to receive updates and latest new things from us everyday. And i will not spam promise. :)</p>
                    <div class="widget-sub-s">
                        <form class="sign_up_form">
                            <input type="text" name="2" placeholder="Enter your email">
                            <a href="javascript:;" class="button color-y">sign up</a>
                        </form>
                    </div>


                </div>
                <div class="widget">
                    <h3 class="widget-title"> <a href="javascript:;">  Cloudy tags</a></h3>
                    <div class="bubble-line"></div>
                    <div class="widget-content">
                        <div class="widget-tags">
                            <a href="javascript:;">clean</a>
                            <a href="javascript:;">minimal</a>
                            <a href="javascript:;">cloudy</a>
                            <a href="javascript:;">video</a>
                            <a href="javascript:;">template</a>
                            <a href="javascript:;">fashion</a>
                            <a href="javascript:;">bloggers</a>
                            <a href="javascript:;">carefully</a>
                            <a href="javascript:;">handcrafted</a>
                            <a href="javascript:;">print</a>
                            <a href="javascript:;">psd</a>
                            <a href="javascript:;">music</a>
                            <a href="javascript:;">food recipe</a>

                        </div>
                    </div>
                </div>
                <div class="widget-sub social">
                    <ul>
                        <li>
                            <a class="social-widget" href="javascript:;"> <i class="fa fa-facebook"> </i><span> share</span></a>
                            <div> 211</div>

                        </li>
                        <li>
                            <a class="social-widget" href="javascript:;"> <i class="fa fa-twitter"></i> <span>follow</span></a>
                            <div> 121</div>
                        </li>
                        <li>
                            <a class="social-widget" href="javascript:;"> <i class="fa fa-google-plus"></i> <span> share </span></a>
                            <div> 11</div>
                        </li>
                        <li>
                            <a class="social-widget" href="javascript:;"> <i class="fa fa-instagram"></i> <span> follow  </span></a>
                            <div>65</div>
                        </li>

                    </ul>

                </div>
                <div class="widget">
                    <h3 class="widget-title"> <a href="javascript:;"> Buy this Theme </a></h3>
                    <div class="bubble-line"></div>
                    <div class="widget-content sm ">
                        <p>
                            Vivamus interdum felis posuere justo
                            condimentum, in consequat libero lacinia. Vestibulum eget viverra nulla. Curabitur
                            feugiat vulputate consectetur.
                        </p>
                        <div class="widget-more">
                            <a href="javascript:;" class="button">purchase</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
