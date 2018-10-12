<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;
use yii\bootstrap\Nav;
use app\controllers\BaseController;
use app\components\helper\Helper;

AppAsset::register($this);
$this->params['name'] = Html::encode($this->params['seo']['name']);
$this->params['sign'] = Html::encode($this->params['seo']['sign']);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="keywords" content="<?= $this->params['keywords']?>" >
    <meta name="description" content="<?= $this->params['description']?>">
    <meta name="author" content="Themeton">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/static/img/favicon.png"/>

</head>
<body>
<?php $this->beginBody() ?>
<header id="header">
    <div class="container-fluid">
        <div class="topbar">
            <div class="container">
                <div class="row">
                    <?php
                    $isGuest = Yii::$app->user->isGuest;
                    $username = '游客';
                    if(!$isGuest)$username = Yii::$app->user->identity->username;
                    echo Nav::widget([
                        'options' => ['id' => 'operate'],
                        'items' => [
                            ['label' => '登录', 'url' => ['/index/login'],'visible'=>$isGuest],
                            ['label' => '注册', 'url' => ['/index/register'],'visible'=>$isGuest],
                            ['label' => '个人中心', 'url' => ['/home/center/index'],'visible'=>!$isGuest],
                            ['label' => '退出(' . $username . ')', 'url' => ['/index/logout'],'visible'=>!$isGuest],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
<!--    data-bg-image="/static/img/bg-header.jpg"-->
    <div class="logo">
        <h1>
            <a href="/"><?= $this->params['name']?></a>
        </h1>
        <p> <?= $this->params['sign']?></p>
    </div>
    <div class="menu-container">
        <div class="container">
            <div class="row">
                <div  class="col-md-7">
                    <nav class="main-nav">
                        <ul>
                            <li><a href="<?= Url::to(['/home/blog/index/index'])?>">首页</a></li>
                            <li><a href="<?= Url::to(['/home/topic/special/index'])?>">专题</a></li>
                            <li><a href="<?= Url::to(['/home/zones/notes/index'])?>">日记</a></li>
                            <li><a href="<?= Url::to(['/index/about'])?>">我的故事</a></li>
                            <li><a href="<?= Url::to(['/index/contact'])?>">联系我</a></li>
                        </ul>
                        <a href="javascript:;" id="close-menu"> <i class="fa fa-close"></i></a>
                    </nav>
                </div>
                <div class=" col-md-5 h-search">
                    <?php if( !empty($this->params['searchUrl']) ):?>
                    <form class="search_form" action="<?= $this->params['searchUrl']?>">
                        <input type="text" name="keywords" placeholder="<?= !empty($_GET['keywords']) ? $_GET['keywords'] : '搜索...';?>">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</header>

<!--content-->
<?= $content?>
<section class="instagram-follow">
    <a href="https://github.com/daimajie/WebBlog"><h2> SOURCE ON GITHUB </h2></a>
</section>
<footer id="footer">
    <div class="footer-slide">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php
                $slide = $this->params[BaseController::SLIDE_CACHE];
                if( !empty($slide) ):
                    foreach ( $slide as $v):
                ?>
                <div class="swiper-slide fslide col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <a href="<?= Url::to(['/home/blog/index/view', 'article_id'=>$v['id']])?>" class="thumbnails">
                        <img src="<?= Helper::showImage($v['image'])?>" alt="<?= $v['title']?>">
                    </a>
                </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
            <div class="swiper-button-prev circle-arrow"><i class="fa fa-chevron-left"></i></div>
            <div class="swiper-button-next circle-arrow"><i class="fa fa-chevron-right"></i></div>
            <div class="swiper-center"><a href="javascript:;"><i class="fa fa-instagram"></i>DAIMAJIE.COM</a></div>
        </div>
    </div>
    <div class="sub-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="widget">
                    </div>
                    <div class="widget footer-cp-text">
                        <p>
                            &copy; 2016. All rights reserved. DAIMAJIE.COM
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script type="text/template" id="tpl-bubble-left">
    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 15 30" enable-background="new 0 0 15 30" xml:space="preserve">
            <path fill-rule="evenodd" clip-rule="evenodd" fill="none" stroke="#000000" stroke-miterlimit="10" d="M0,29.4c0,0,7.5,0,7.5-7c0,0,7,0,7-7c0-0.1,0-0.1,0-0.2c0-0.1,0-0.1,0-0.2c0-7-7-7-7-7c0-7-7.5-7-7.5-7"/>
        </svg>
</script>

<script type="text/template" id="tpl-bubble-right">
    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 15 30" enable-background="new 0 0 15 30" xml:space="preserve">
            <path fill-rule="evenodd" clip-rule="evenodd" fill="none" stroke="#000000" stroke-miterlimit="10" d="M15,29.4c0,0-7.5,0-7.5-7c0,0-7,0-7-7c0-0.1,0-0.1,0-0.2c0-0.1,0-0.1,0-0.2c0-7,7-7,7-7c0-7,7.5-7,7.5-7"/>
        </svg>
</script>

<?php
try{
    \app\components\widgets\LayerAlert::widget();
}catch (Exception $e){

}
$this->endBody();
?>
</body>
</html>
<?php $this->endPage() ?>