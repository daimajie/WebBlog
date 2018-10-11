<?php
use yii\helpers\Html;
use app\components\widgets\sidebar\About;
use app\components\widgets\sidebar\Category;
use app\components\widgets\sidebar\Hot;
use app\components\widgets\sidebar\Tags;
use app\components\widgets\sidebar\Friend;
use yii\helpers\HtmlPurifier;



$this->title = '关于我 - ' . Html::encode($this->params['seo']['name']);
$this->params['keywords'] = '';
$this->params['description'] = '';
?>

<section class="section-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-md-8">
                <article class="content-item">
                    <div class="entry-media">
                        <div class="about-title">
                            <h3> 我的故事</h3>
                        </div>
                        <div class="bubble-line"></div>
                        <div class="post-content about">
                            <p><?= HtmlPurifier::process($about['history'])?></p>
                            <hr class="post-horizontal-rule">
                            <p class="sub-title"><?= $about['email']?></p>
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