<?php
use yii\helpers\Url;
use app\components\helper\Helper;

$user = Yii::$app->user->identity;
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php if(!empty($user['image'])):?>
                <img src="<?= Helper::showImage($user['image'])?>" class="img-circle" alt="User Image"/>
                <?php endif;?>
            </div>
            <div class="pull-left info">
                <p><?= $user['username']?></p>

                <a href="<?= Url::to(['/index/logout'])?>">退出 <i class="fa fa-sign-out" aria-hidden="true"></i></a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="搜索..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'MAIN NAVIGATION', 'options' => ['class' => 'header']],
                    [
                        'label' => '控制台',
                        'icon' => 'dashboard',
                        'url' => ['/admin'],
                    ],
                    [
                        'label' => '博客管理',
                        'icon' => 'edit',
                        'url' => '#',
                        'items' => [
                            ['label' => '分类管理', 'icon' => 'circle-o', 'url' => ['/admin/blog/category'],],
                            ['label' => '标签管理', 'icon' => 'circle-o', 'url' => ['/admin/blog/tag'],],
                            ['label' => '文章管理', 'icon' => 'circle-o', 'url' => ['/admin/blog/article'],],
                        ],
                    ],
                    [
                        'label' => '话题管理',
                        'icon' => 'book',
                        'url' => '#',
                        'items' => [
                            ['label' => '专题管理', 'icon' => 'circle-o', 'url' => ['/admin/topic/special'],],
                            ['label' => '章节管理', 'icon' => 'circle-o', 'url' => ['/admin/topic/chapter'],],
                            ['label' => '文章管理', 'icon' => 'circle-o', 'url' => ['/admin/topic/article'],],
                        ],
                    ],
                    [
                        'label' => '专属空间',
                        'icon' => 'calendar',
                        'url' => '#',
                        'items' => [
                            ['label' => '日记管理', 'icon' => 'circle-o', 'url' => ['/admin/zones/notes'],],
                            //['label' => '相册管理', 'icon' => 'circle-o', 'url' => ['#'],],
                        ],
                    ],
                    [
                        'label' => '成员管理',
                        'icon' => 'user',
                        'url' => '#',
                        'items' => [
                            ['label' => '用户管理', 'icon' => 'circle-o', 'url' => ['/admin/member/user'],],
                            ['label' => '留言管理', 'icon' => 'circle-o', 'url' => ['/admin/member/contact'],],
                            //['label' => '用户信息', 'icon' => 'circle-o', 'url' => ['/admin/member/info'],],
                        ],
                    ],
                    [
                        'label' => '站点管理',
                        'icon' => 'pie-chart',
                        'url' => '#',
                        'items' => [
                            ['label' => '友情链接', 'icon' => 'circle-o', 'url' => ['/admin/setting/friend'],],
                            ['label' => '基本设置', 'icon' => 'circle-o', 'url' => ['/admin/setting/setups'],],
                            //['label' => '广告设置', 'icon' => 'circle-o', 'url' => ['#'],],
                        ],
                    ],
                    [
                        'label' => '站点维护',
                        'icon' => 'laptop',
                        'url' => '#',
                        'items' => [
                            ['label' => '系统日志', 'icon' => 'circle-o', 'url' => ['/admin/operate/log'],],
                            ['label' => '缓存管理', 'icon' => 'circle-o', 'url' => ['/admin/operate/cache'],],
                            ['label' => '备份还原', 'icon' => 'circle-o', 'url' => ['/admin/operate/backups'],],
                        ],
                    ],


                ],
            ]
        ) ?>

    </section>

</aside>
