<?php
use yii\helpers\Html;
use app\components\helper\Helper;
use yii\widgets\LinkPager;
use yii\helpers\Url;
use app\components\widgets\sidebar\About;
use app\components\widgets\sidebar\Category;
use app\components\widgets\sidebar\Hot;
use app\components\widgets\sidebar\Tags;
use app\components\widgets\sidebar\Friend;
use yii\helpers\HtmlPurifier;

$this->title = '日记列表 - ' . Html::encode($this->params['seo']['name']);
$this->params['keywords'] = '';
$this->params['description'] = '';

//搜索地址
$this->params['searchUrl'] = Url::to(['search']);
?>

<section class="section-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-md-8">
                <?php
                foreach ($notes['notes'] as $note):
                ?>
                <article class="content-item">
                    <div class="entry-media">
                        <div class="post-content">
                            <div class="post-icon">
                                <p></p>
                            </div>
                            <h2><?= Html::encode($note['title'])?></h2>
                            <p><?= HtmlPurifier::process($note['content'])?></p>
                            <hr class="post-horizontal-rule">
                            <br>
                            <p class="sub-title"><?= Helper::formatDate($note['created_at'])?></p>
                        </div>
                    </div>
                </article>
                <?php
                endforeach;
                ?>
                <div class="post-navigation">
                    <?= LinkPager::widget([
                        'pagination' => $notes['pagination'],
                        'nextPageLabel' => '<i class="fa fa-chevron-right"></i>',
                        'prevPageLabel' => '<i class="fa fa-chevron-left"></i>',
                        'options' => ['class'=>false],
                        'disableCurrentPageButton' => true
                    ])?>
                </div>
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