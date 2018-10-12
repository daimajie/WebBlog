<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\components\helper\Helper;

dmstr\web\AdminLteAsset::register($this);

//站点名称
$name = $this->params['seo']['name'];
//user
$user = Yii::$app->user->identity;
//用户头像
$avatar = empty($user['image']) ? Yii::$app->params['member']['avatar'] : Helper::showImage($user['image']);

$backend_ids = Yii::$app->params['RBAC']['RBAC_PERMISS'];
$console = array_merge($backend_ids[1], $backend_ids[2]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="keywords" content="" >
    <meta name="description" content="">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" type="image/x-icon" href="/static/img/favicon.png"/>

</head>
<!-- ADD THE CLASS layout-boxed TO GET A BOXED LAYOUT -->
<body class="hold-transition skin-blue layout-boxed sidebar-mini">
<?php $this->beginBody() ?>
<!-- Site wrapper -->
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . $name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
        </nav>
    </header>

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?= $avatar?>" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?= $user['username']?></p>
                    <a href="<?= Url::to(['/index/logout'])?>">安全退出 <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span></a>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <?= dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                    'items' => [
                        ['label' => 'MAIN NAVIGATION', 'options' => ['class' => 'header']],
                        [
                            'label' => '个人信息',
                            'icon' => 'circle-o',
                            'url' => ['/home/center/index'],
                        ],
                        [
                            'label' => '设置头像',
                            'icon' => 'circle-o',
                            'url' => ['/home/center/index/reset-avatar'],
                        ],
                        [
                            'label' => '修改密码',
                            'icon' => 'circle-o',
                            'url' => ['/home/center/index/reset-password'],
                        ],
                        [
                            'label' => '修改邮箱',
                            'icon' => 'circle-o',
                            'url' => ['/home/center/index/reset-email'],
                        ],
                        [
                            'label' => '控制台',
                            'icon' => 'circle-o',
                            'url' => ['/admin'],
                            'visible' => in_array(Yii::$app->user->id, $console),
                        ],
                    ],
                ]
            ) ?>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <?= $content?>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

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
