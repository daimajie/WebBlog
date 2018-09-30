<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;

AppAsset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="keywords" content="HTML5,CSS3,HTML,Template,Themeton" >
    <meta name="description" content="Cloudy Town - Simple Blog HTML Template">
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
<!--    data-bg-image="/static/img/bg-header.jpg"-->
    <div class="logo">
        <h1>
            <a href="index.html">Cloudy town</a>
        </h1>
        <p> A problem is a chance for you to do your best.</p>
    </div>
    <div class="menu-container">
        <div class="container">
            <div class="row">
                <div  class="col-md-7">
                    <nav class="main-nav">
                        <ul>
                            <li class=" current-menu-item menu-item-has-children">
                                <a href="index.html">首页</a>
                            </li>
                            <li><a href="<?= Url::to(['/home/topic/special/index'])?>">『专题』</a></li>
                            <li><a href="note.html">笔记</a></li>
                            <li>|</li>
                            <li><a href="about.html">关于我</a></li>
                            <li><a href="contacts.html">联系我</a></li>
                            <li>|</li>
                            <li><a href="content.html">文章详情</a></li>
                        </ul>
                        <a href="javascript:;" id="close-menu"> <i class="fa fa-close"></i></a>
                    </nav>
                </div>
                <div class=" col-md-5 h-search">
                    <form class="search_form">
                        <input type="text" name="2" placeholder="Search and hit enter...">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                    <div class="head-social">
                        <a class="socials" href="#"><i class="fa fa-facebook"></i></a>
                        <a class="socials" href="#"><i class="fa fa-twitter"></i></a>
                        <a class="socials" href="#"><i class="fa fa-pinterest"></i></a>
                        <a class="socials" href="#"><i class="fa fa-instagram"></i></a>
                        <a class="socials" href="#"><i class="fa fa-rss"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!--content-->
<?= $content?>

<footer id="footer">
    <div class="footer-slide">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide fslide col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <a href="#" class="thumbnails"><img src="/static/img/footer/photos2.jpg" alt="Image"></a>
                </div>
                <div class="swiper-slide fslide col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <a href="#" class="thumbnails"><img src="/static/img/footer/photos1.jpg" alt="Image"></a>
                </div>
                <div class="swiper-slide fslide col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <a href="#" class="thumbnails"><img src="/static/img/footer/01-footer.jpg" alt="Image"></a>
                </div>
                <div class="swiper-slide fslide col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <a href="#" class="thumbnails"><img src="/static/img/footer/02-footert.jpg" alt="Image"></a>
                </div>
                <div class="swiper-slide fslide col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <a href="#" class="thumbnails"><img src="/static/img/footer/photos4.jpg" alt="Image"></a>
                </div>

                <div class="swiper-slide fslide col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <a href="#" class="thumbnails"><img src="/static/img/footer/photos5.jpg" alt="Image"></a>
                </div>
                <div class="swiper-slide fslide col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <a href="#" class="thumbnails"><img src="/static/img/footer/photos7.jpg" alt="Image"></a>
                </div>
                <div class="swiper-slide fslide col-xs-6 col-sm-4 col-md-3 col-lg-2">
                    <a href="#" class="thumbnails"><img src="/static/img/footer/photos6.jpg" alt="Image"></a>
                </div>
            </div>
            <div class="swiper-button-prev circle-arrow"><i class="fa fa-chevron-left"></i></div>
            <div class="swiper-button-next circle-arrow"><i class="fa fa-chevron-right"></i></div>
            <div class="swiper-center"><a href="javascript:;"><i class="fa fa-instagram"></i>Cloudy town</a></div>
        </div>
    </div>        <div class="sub-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="widget">
                    </div>
                    <div class="widget footer-cp-text">
                        <p>
                            &copy; 2016. All rights reserved. Cloudytown made with love by Designs.
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


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>