<?php
use app\components\helper\Helper;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;



$this->title = '专题列表 - ' . Html::encode($this->params['seo']['name']);
$this->params['keywords'] = Html::encode(implode(',',ArrayHelper::getColumn($specials, 'name')));
$this->params['description'] = Html::encode($this->params['seo']['description']);

//搜索地址
$this->params['searchUrl'] = Url::to(['search']);
?>

<section class="section-content">
    <div class="container">
        <div class="row">
            <?php
            $i = 0;
            foreach ($specials as $special):
            ?>
            <div class="col-sm-6">
                <div class="grid-wrapper">
                    <div class="grid-content">
                        <article class="content-item">
                            <div class="entry-media">
                                <div class="post-title">
                                    <h2> <a href="<?= Url::to(['special/view', 'special_id' => $special['id']])?>"><?= Html::encode($special['name'])?> </a> </h2>
                                    <div class="entry-date">
                                        <ul>
                                            <li>收录  - <?= $special['count']?></li>
                                            <li>发布 - <?= Helper::formatDate($special['created_at'])?></li>
                                            <li>评论 - <?= $special['comment']?></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="bubble-line"></div>
                                <div class="post-content">
                                    <?php
                                    if(!empty($special['image']))
                                        echo "<img src='" . Helper::showImage($special['image']) . "' alt='". $special['name'] ."'>";
                                    else
                                        echo '';
                                    ?>
                                    <p>
                                        <?= Html::encode($special['description'])?>
                                    </p>
                                </div>
                                <div class="bubble-line"></div>
                                <div class="post-footer">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <a href="<?= Url::to(['special/view', 'special_id' => $special['id']])?>" class="button">点击查看</a>
                                        </div>
                                        <div class="col-sm-6 text-right">
                                            <div
                                                    class="content-social grid bdsharebuttonbox text-right"
                                                    data-tag="share_<?= $special['id']?>"
                                                    data-url = "<?= Yii::$app->urlManager->createAbsoluteUrl(['home/topic/special/view', 'special_id' => $special['id']])?>"
                                                    data-title = "<?= Html::encode($special['name'])?>",
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
                    </div>
                </div>
            </div>
            <?php
            if( ++$i % 2 == 0 )echo '<div class="clearfix"></div>';
            endforeach;
            ?>
        </div>

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
</section>

<!-- Baidu Button BEGIN -->
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

<!-- Baidu Button END -->