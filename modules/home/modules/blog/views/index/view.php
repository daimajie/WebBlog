<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\components\helper\Helper;
use app\components\widgets\comment\Comment;
use app\components\widgets\sidebar\About;
use app\components\widgets\sidebar\Category;
use app\components\widgets\sidebar\Hot;
use app\components\widgets\sidebar\Tags;
use app\components\widgets\sidebar\Friend;
use yii\helpers\HtmlPurifier;
use app\controllers\BaseController;

$this->title = '文章列表 - ' . Html::encode($this->params['seo']['name']);
$this->params['keywords'] = '';
$this->params['description'] = '';

//默认封面
$cover = Yii::$app->params['article']['cover'];

//文章片段缓存依赖
$dependency = [
    'class' => 'yii\caching\DbDependency',
    'sql' => 'select updated_at from {{%blog_article}} where id=' . $article['id'],
];
?>
<section class="section-content"  id="anchor">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-md-8">
                <article class="content-item">
                    <div class="entry-media">
                        <div class="post-title">
                            <h2><a href="javascript:;"><?= Html::encode($article['title'])?></a></h2>
                            <div class="entry-date">
                                <ul>
                                    <li>
                                        分类 -
                                        <a href='#'><?= Html::encode($article['categoryName']['name'])?></a>
                                    </li>
                                    <li>发布 - <?= Helper::formatDate($article['created_at'])?></li>
                                    <li>评论 - <?= $article['comment']?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="bubble-line"></div>
                        <div class="post-content">
                            <?php
                            if ($this->beginCache(BaseController::BLOG_ARTICLE_CACHE, [
                                'dependency' => $dependency,
                                'variations' => [
                                        Yii::$app->request->get('article_id'),
                                        $this->context->module->id
                                    ],
                                'duration' => 3600,
                            ])){

                                echo HtmlPurifier::process($article['content']['content']);

                                $this->endCache();
                            }
                            ?>
                        </div>
                        <div id="prev_next" class="post-navigation">
                            <ul>
                                <li><a href="<?= empty($prevNext['prev']) ? 'javascript:void(0);' : Url::current(['article_id'=>$prevNext['prev']['id'],'#' => 'anchor']);?>"> <i class="fa fa-chevron-left"></i> </a></li>
                                <li><a href="<?= empty($prevNext['next']) ? 'javascript:void(0);' : Url::current(['article_id'=>$prevNext['next']['id'],'#' => 'anchor']);?>"> <i class="fa fa-chevron-right"></i> </a></li>
                            </ul>
                        </div>
                        <div class="bubble-line"></div>
                        <div class="post-footer">
                            <div class="row">
                                <div class="col-sm-5 s-tags">
                                    <?php foreach($article['tags'] as $tag):?>
                                    <a href="javascript:;"><?= $tag['name']?></a>
                                    <?php endforeach;?>
                                </div>
                                <div class="col-sm-7 text-right">
                                    <div
                                            class="content-social grid bdsharebuttonbox text-right"
                                            data-tag="share_1"
                                    >
                                        <a data-cmd="tqq">QQ</a>
                                        <a data-cmd="weixin">微信</a>
                                        <a data-cmd="weibo">微博</a>
                                        <a>分享: </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <?php if( !empty($related) ):?>
                <article class="content-item">
                    <div class="entry-media">
                        <div class="post-content related">
                            <div class="row">
                                <?php
                                foreach ($related as $item):
                                ?>
                                <div class="col-sm-6 col-md-4">
                                    <div class="related-post">
                                        <img src="<?= !empty($item['image']) ? $item['image'] : $cover;?>" alt="related post">
                                        <h4><a href="<?= Url::current(['article_id'=>$item['id']])?>"><?= Html::encode($item['title'])?></a></h4>
                                        <p><i class="fa fa-clock-o"></i> <?= Helper::formatDate($item['created_at'])?></p>
                                    </div>
                                </div>
                                <?php endforeach;?>

                            </div>
                        </div>
                    </div>
                </article>
                <?php endif;?>
                <article class="content-item">
                    <div class="entry-media">
                        <?= Comment::widget([
                                'article' => $article

                        ])?>
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
<!-- Baidu Button BEGIN -->
<?php
$shareUrl = Yii::$app->urlManager->createAbsoluteUrl(['home/blog/index/view', 'article_id' => $article['id']]);
$shareJs = <<<SHAR
window._bd_share_config = {
        common : {
            bdText : "{$article['title']}",
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
