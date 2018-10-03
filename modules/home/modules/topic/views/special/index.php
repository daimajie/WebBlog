<?php
use app\components\helper\Helper;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;



$this->title = '专题列表 - ' . Html::encode($this->params['seo']['name']);
$this->params['keywords'] = Html::encode(implode(',',ArrayHelper::getColumn($specials, 'name')));
$this->params['description'] = Html::encode($this->params['seo']['description']);
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
                                        echo "<img src='" . Helper::displyImage($special['image']) . "' alt='". $special['name'] ."'>";
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
                                            <div class="content-social grid">
                                                <a href="javascript:;"><i class="fa fa-qq"></i></a>
                                                <a href="javascript:;"><i class="fa fa-wechat"></i></a>
                                                <a href="javascript:;"><i class="fa fa-weibo"></i></a>
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