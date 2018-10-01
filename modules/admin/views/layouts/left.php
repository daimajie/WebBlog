<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
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
                        'label' => '博客管理',
                        'icon' => 'circle-o',
                        'url' => '#',
                        'items' => [
                            ['label' => '分类管理', 'icon' => 'circle-o', 'url' => ['/admin/blog/category'],],
                            ['label' => '标签管理', 'icon' => 'circle-o', 'url' => ['/admin/blog/tag'],],
                            ['label' => '文章管理', 'icon' => 'circle-o', 'url' => ['/admin/blog/article'],],
                        ],
                    ],
                    [
                        'label' => '话题管理',
                        'icon' => 'circle-o',
                        'url' => '#',
                        'items' => [
                            ['label' => '专题管理', 'icon' => 'circle-o', 'url' => ['/admin/topic/special'],],
                            ['label' => '章节管理', 'icon' => 'circle-o', 'url' => ['/admin/topic/chapter'],],
                            ['label' => '文章管理', 'icon' => 'circle-o', 'url' => ['/admin/topic/article'],],
                        ],
                    ],
                    [
                        'label' => '专属空间',
                        'icon' => 'circle-o',
                        'url' => '#',
                        'items' => [
                            ['label' => '日记管理', 'icon' => 'circle-o', 'url' => ['/admin/zones/notes'],],
                            //['label' => '相册管理', 'icon' => 'circle-o', 'url' => ['#'],],
                        ],
                    ],
                    [
                        'label' => '成员管理',
                        'icon' => 'circle-o',
                        'url' => '#',
                        'items' => [
                            ['label' => '用户管理', 'icon' => 'circle-o', 'url' => ['/admin/member/user'],],
                            ['label' => '留言管理', 'icon' => 'circle-o', 'url' => ['/admin/member/contact'],],
                            //['label' => '用户信息', 'icon' => 'circle-o', 'url' => ['/admin/member/info'],],
                        ],
                    ],
                    [
                        'label' => '站点管理',
                        'icon' => 'circle-o',
                        'url' => '#',
                        'items' => [
                            ['label' => '友情链接', 'icon' => 'circle-o', 'url' => ['/admin/setting/friend'],],
                            ['label' => '基本设置', 'icon' => 'circle-o', 'url' => ['/admin/setting/setups'],],
                            //['label' => '广告设置', 'icon' => 'circle-o', 'url' => ['#'],],
                        ],
                    ],
                    [
                        'label' => '站点维护',
                        'icon' => 'circle-o',
                        'url' => '#',
                        'items' => [
                            //['label' => '系统日志', 'icon' => 'circle-o', 'url' => ['#'],],
                            //['label' => '备份还原', 'icon' => 'circle-o', 'url' => ['#'],],
                            //['label' => '缓存管理', 'icon' => 'circle-o', 'url' => ['#'],],
                        ],
                    ],


                ],
            ]
        ) ?>

    </section>

</aside>
