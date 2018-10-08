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


$this->title = '文章列表 - ' . Html::encode($this->params['seo']['name']);
$this->params['keywords'] = $this->params['seo']['keywords'];
$this->params['description'] = $this->params['seo']['description'];

//搜索地址
$this->params['searchUrl'] = Url::to(['search']);
?>

<!--content-->
<section class="section-content">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-md-8">
                <?php
                foreach($articles as $article):
                ?>
                    <article class="content-item">
                        <div class="entry-media">
                            <div class="post-title">
                                <h2>
                                    <a href="<?= Url::to(['view', 'article_id'=>$article['id']])?>">
                                        <?= Html::encode($article['title'])?>
                                    </a>
                                </h2>
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
                                if( !empty($article['image']) ):
                                ?>
                                <img src="<?= Helper::showImage($article['image'])?>" alt=" image">
                                <?php endif;?>
                                <p><?= Html::encode($article['brief'])?></p>
                            </div>
                            <div class="bubble-line"></div>
                            <div class="post-footer">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <a href="<?= Url::to(['view', 'article_id'=>$article['id']])?>" class="button">查看详情</a>
                                    </div>
                                    <div class="col-sm-7 text-right">
                                        <div
                                                class="content-social grid bdsharebuttonbox text-right"
                                                data-tag="share_<?= $article['id']?>"
                                                data-url = "<?= Yii::$app->urlManager->createAbsoluteUrl(['home/blog/index/view', 'article_id' => $article['id']])?>"
                                                data-title = "<?= Html::encode($article['title'])?>",
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
                <?php
                endforeach;
                ?>
                <div class="post-navigation">
                    <?= LinkPager::widget([
                        'pagination' => $pagination,
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
<!--/content-->
<?php
$shareJs = <<<SHAR
var shareUrl = "",title='';
$(function(){
    $('.bdsharebuttonbox > a').mouseover(function(){
        shareUrl = $(this).closest('.bdsharebuttonbox').data('url');
        title = $(this).closest('.bdsharebuttonbox').data('title');
    });
});
window._bd_share_config = {
        common : {
            bdText : '',
            bdUrl : '',
            onBeforeClick : function(cmd,config){
                if (shareUrl && title) {
                    config.bdUrl = shareUrl;
                    config.bdText = title;
                }
                return config;
            }
        },
        share : [{
            "bdSize" : 16
        }],
    }
    with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
SHAR;
$this->registerJs($shareJs);

?>

