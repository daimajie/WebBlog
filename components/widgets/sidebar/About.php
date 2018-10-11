<?php
namespace app\components\widgets\sidebar;

use app\controllers\BaseController;
use yii\base\Widget;
use app\components\helper\Helper;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * 编辑器
 */
class About  extends Widget
{

    public function run ()
    {


        echo $this->printHtml();
    }

    public function printHtml(){

        $view = $this->getView();
        $about = $view->params[BaseController::SEO_CACHE];

        $image = !empty($about['image']) ? Helper::showImage($about['image']) : '/static/img/widget/about.jpg';
        $intro = Html::encode($about['about']);
        $aboutUrl = Url::to(['/index/about']);

        $html = <<<HTML
                <!-- 我的故事 -->
                <div class="widget">
                    <h3 class="widget-title">关于我</h3>
                    <div class="bubble-line"></div>

                    <div class="widget-content">
                        <img src="{$image}" alt="not image">
                        <p>
                            {$intro}
                        </p>
                        <div class="widget-more">
                            <a href="{$aboutUrl}" class="button">查看更多</a>
                        </div>
                    </div>
                </div>
HTML;
        return $html;

    }


}