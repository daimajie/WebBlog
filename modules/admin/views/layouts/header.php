<?php
use yii\helpers\Html;
use app\components\helper\Helper;
use yii\helpers\Url;

$user = Yii::$app->user->identity;
$unread = $this->params['unread'];

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-danger"><?= count($unread)?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">当前有<?= count($unread)?>条未读评论</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <?php foreach( $unread as $item ):?>
                                <li><!-- start message -->
                                    <a href="<?= Url::to(['/admin/member/contact/view', 'id'=>$item['id']])?>">
                                        <div class="pull-left">
                                            <?php if(!empty($item['userImage']['image'])):?>
                                            <img src="<?= Helper::showImage($item['userImage']['image'])?>" class="img-circle"
                                                 alt="User Image"/>
                                            <?php endif;?>
                                        </div>
                                        <h4>
                                            <?= $item['userImage']['username']?>
                                            <small><i class="fa fa-clock-o"></i><?= Helper::formatDate($item['created_at'])?></small>
                                        </h4>
                                        <p><?= $item['subject']?></p>
                                    </a>
                                </li>
                                <?php endforeach;?>
                            </ul>
                        </li>
                        <li class="footer"><a href="<?= Url::to(['member/contact'])?>">查看所有留言</a></li>
                    </ul>
                </li>

                <li class="user user-menu">
                    <a href="#" class="" data-toggle="">
                        <img src="<?= Helper::showImage($user['image'])?>" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?= $user['username']?></span>
                    </a>

                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <a href="<?= Url::to(['/index/logout'])?>"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
