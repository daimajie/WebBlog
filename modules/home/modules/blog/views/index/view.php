<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\components\helper\Helper;
use app\components\widgets\comment\Comment;

$this->title = '文章列表 - ' . Html::encode($this->params['seo']['name']);
$this->params['keywords'] = '';
$this->params['description'] = '';

//默认封面
$cover = Yii::$app->params['article']['cover'];
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
                            <?= Html::encode($article['content']['content'])?>

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
                <div class="widget-sub social">
                    <div class="s-slide">
                        <div class="swiper-container">
                            <div class="swiper-wrapper s-slide-wrapper">
                                <div class="swiper-slide"><img src="/static/img/content/photo1.jpg" alt="image"></div>
                                <div class="swiper-slide"><img src="/static/img/content/photo2.jpg" alt="image"></div>
                                <div class="swiper-slide"><img src="/static/img/content/photo3.jpg" alt="image"></div>
                                <div class="swiper-slide"><img src="/static/img/content/photo4.jpg" alt="image"></div>
                            </div>
                            <div class="swiper-button-prev circle-arrow"><i
                                        class="fa fa-chevron-left"></i>
                            </div>
                            <div class="swiper-button-next circle-arrow"><i
                                        class="fa fa-chevron-right"></i>
                            </div>
                        </div>
                    </div>
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
