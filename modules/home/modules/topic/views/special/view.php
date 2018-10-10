<?php
use app\assets\AppAsset;
use app\components\helper\Helper;
use yii\helpers\Url;
use yii\helpers\Html;
use app\components\widgets\comment\Comment;
use yii\helpers\HtmlPurifier;
use app\controllers\BaseController;

AppAsset::addCss($this, '/static/css/nav_style.css');

$this->title = Html::encode($special['name']) . ' - ' . $this->params['seo']['name'];
$this->params['keywords'] = Html::encode($special['name']);
$this->params['description'] = Html::encode($special['description']);

//文章片段缓存依赖
$dependency = [
    'class' => 'yii\caching\DbDependency',
    'sql' => 'select updated_at from {{%special_article}} where id=' . $content['article']['id'],
];

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
                                            <a class="btn btn-default btn-sm" href="javascript:void(0);">
                                                <span id="sidebar_btn" class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
                                            </a>
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
                                    <hr class="hidden-md hidden-lg">
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
                                                <?php
                                                if ($this->beginCache(BaseController::SPECIAL_ARTICLE_CACHE, [
                                                    'dependency' => $dependency,
                                                    'variations' => [
                                                        Yii::$app->request->get('article_id'),
                                                        $this->context->module->id
                                                    ],
                                                    'duration' => 3600,
                                                ])){

                                                    echo HtmlPurifier::process($content['article']['content']['content']);

                                                    $this->endCache();
                                                }
                                                ?>
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

                                        <div
                                                class="content-social grid bdsharebuttonbox"
                                                data-tag="share_1"
                                        >
                                            <a class="pull-left">分享: </a>
                                            <a class="pull-left" data-cmd="tqq">QQ</a>
                                            <a class="pull-left" data-cmd="weixin">微信</a>
                                            <a class="pull-left" data-cmd="weibo">微博</a>
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

<!-- Baidu Button BEGIN -->
<?php
$shareUrl = Yii::$app->urlManager->createAbsoluteUrl(['home/topic/special/view', 'special_id' => $content['article']['id']]);
$shareJs = <<<SHAR
window._bd_share_config = {
        common : {
            bdText : "{$content['article']['title']}",
            bdUrl : "{$shareUrl}",
        },
        share : [{
            "bdSize" : 16
        }],
    }
    with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
SHAR;
$this->registerJs($shareJs);

?>

<!-- Baidu Button END -->

