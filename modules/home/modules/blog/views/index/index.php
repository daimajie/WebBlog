<?php
use yii\helpers\Html;
use app\components\helper\Helper;
use yii\widgets\LinkPager;
use yii\helpers\Url;


$this->title = '文章列表 - ' . Html::encode($this->params['seo']['name']);
$this->params['keywords'] = $this->params['seo']['keywords'];
$this->params['description'] = $this->params['seo']['description'];
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
                                        <div class="content-social">
                                            <a href="javascript:;"><i class="fa fa-qq"></i><span>QQ</span></a>
                                            <a href="javascript:;"><i class="fa fa-weibo"></i><span>微博</span></a>
                                            <a href="javascript:;"><i class="fa fa-wechat"></i><span>微信</span></a>
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
                <div class="widget">
                    <h3 class="widget-title">我的故事</h3>
                    <div class="bubble-line"></div>

                    <div class="widget-content">
                        <img src="/static/img/widget/about.jpg" alt="not image">
                        <p>你好，我是Jenny Kurto的信镇博客的作者。这是我的个人空间，喜欢分享别人。我住在纽约市工作和写博客。</p>
                        <div class="widget-more">
                            <a href="javascript:;" class="button">查看更多</a>
                        </div>
                    </div>
                </div>
                <div class="widget">
                    <h3 class="widget-title"> 分类</h3>
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
                    <h3 class="widget-title"> 热门文章</h3>
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
<!--/content-->