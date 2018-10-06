<?php
use app\assets\AppAsset;
use app\components\helper\Helper;
use yii\helpers\Url;
use yii\helpers\Html;
use app\components\widgets\comment\Comment;

AppAsset::addCss($this, '/static/css/nav_style.css');

$this->title = Html::encode($special['name']) . ' - ' . $this->params['seo']['name'];
$this->params['keywords'] = Html::encode($special['name']);
$this->params['description'] = Html::encode($special['description']);
?>

<section class="section-content" id="anchor">
    <div class="container">
        <div class="row ">
            <div class="col-md-1 full-width-content">
                <article class="content-item">
                    <div class="entry-media">
                        <div class="post-title">
                            <h2><a href="javascript:;"><?= Html::encode($special['name'])?></a></h2>
                            <div class="entry-date">
                                <p class="description">描述：<?= Html::encode($special['description'])?></p>
                                <ul>
                                    <li>收录 - <?= $special['count']?></li>
                                    <li>评论 - <?= $special['comment']?></li>
                                    <li>创建 - <?= Helper::formatDate($special['created_at'])?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="bubble-line"></div>
                        <div class="post-content full-width">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 sidebar "><!-- hidden-xs hidden-sm -->
                                        <div class="hidden-md hidden-lg">
                                            <span id="sidebar_btn" class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
                                        </div>
                                        <nav id="sidebar_nav" class="toc hidden-xs hidden-sm">
                                            <ul>
                                                <?php
                                                foreach ($special['chapters'] as $chapter):
                                                    if ( empty($chapter['specialArticlesTitle']) )
                                                        continue;
                                                ?>
                                                    <li>
                                                        <a href="javascript:void(0);"><?= Html::encode($chapter['title'])?></a>
                                                        <ul>
                                                            <?php
                                                            foreach ($chapter['specialArticlesTitle'] as $article):
                                                            ?>
                                                            <li><a href="<?= Url::current(['article_id'=>$article['id'],'#' => 'anchor'])?>"><?= Html::encode($article['title'])?></a></li>
                                                            <?php
                                                            endforeach;
                                                            ?>
                                                        </ul>
                                                    </li>
                                                <?php
                                                endforeach;
                                                ?>
                                            </ul>
                                        </nav>
                                    </div>
                                    <div class="col-sm-12 col-md-8">
                                        <?php
                                        if( !empty($content['article']) ):
                                        ?>
                                        <article class="contents" id="article">
                                            <div class="s-post post-header">
                                                <h4 style="font-size:22px;"><?= Html::encode($content['article']['title'])?></h4>
                                                <div class="entry-date">
                                                    <ul>
                                                        <li>作者 - <?= $content['article']['user_id']?></li>
                                                        <li>评论 - <?= $content['article']['comment']?></li>
                                                        <li>发布 - <?= Helper::formatDate($special['created_at'])?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="post-body">
                                                <?= Html::encode($content['article']['content']['content'])?>
                                            </div>
                                            <div id="prev_next" class="post-navigation">
                                                <ul>
                                                    <li><a href="<?= empty($content['prevAndNext']['prev']) ? 'javascript:void(0);' : Url::current(['article_id'=>$content['prevAndNext']['prev']['id'],'#' => 'anchor']);?>"> <i class="fa fa-chevron-left"></i> </a></li>
                                                    <li><a href="<?= empty($content['prevAndNext']['next']) ? 'javascript:void(0);' : Url::current(['article_id'=>$content['prevAndNext']['next']['id'],'#' => 'anchor']);?>"> <i class="fa fa-chevron-right"></i> </a></li>
                                                </ul>
                                            </div>
                                        </article>
                                        <?php
                                        else:
                                            echo '暂无任何数据。';
                                        endif;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bubble-line"></div>
                        <div class="post-footer full-width">
                            <div class="container">
                                <div class="row">
                                    <div style="padding-top: 15px;" class="col-sm-4 text-left">
                                        <div class="content-social">
                                            <a href="javascript:;"><i class="fa fa-qq"></i> <span>QQ</span></a>
                                            <a href="javascript:;"><i class="fa fa-wechat"></i> <span>微信</span></a>
                                            <a href="javascript:;"><i class="fa fa-weibo"></i> <span>微博</span></a>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= Comment::widget([
                                            'article' => $content['article'],
                                            'fullwidth' => true,
                                        ])?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
<?php
$strJs = <<<STR
//文章导航
$('#sidebar_btn').on('click', function(){
    $('#sidebar_nav').toggleClass('hidden-xs hidden-sm');
});
STR;
$this->registerJs($strJs);
?>