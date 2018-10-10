<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name .' - '. Html::encode($this->params['seo']['name']);
$this->params['keywords'] = '';
$this->params['description'] = '';
?>

<section class="section-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <article class="content-item">
                    <div class="entry-media">
                        <div class="about-title">
                            <h3> <?= Html::encode($this->title) ?></h3>
                        </div>
                        <div class="bubble-line"></div>
                        <div class="post-content about">
                            <p class="text-danger"><?= nl2br(Html::encode($message)) ?></p>
                            <hr class="post-horizontal-rule">
                            <p>
                                服务器正在处理您的请求时发生上述错误。
                            </p>
                            <p>
                                如果您认为这是服务器错误，请与我们联系 (daimajie.com) 。谢谢您。
                            </p>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
