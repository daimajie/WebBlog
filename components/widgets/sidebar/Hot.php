<?php
namespace app\components\widgets\sidebar;

use yii\base\Widget;
use app\controllers\BaseController;
use app\components\helper\Helper;
use yii\helpers\Html;
use yii\helpers\Url;
/**
 * 编辑器
 */
class Hot  extends Widget
{

    public function run ()
    {
        return $this->printHtml();
    }

    public function printHtml(){

        $view = $this->getView();
        $sidebar = $view->params[BaseController::SIDEBAR_CACHE];
        $hot = $sidebar['hot'];

        $str = '';
        foreach ($hot as $item) {
            $str .= '<div class="widget-recent">';
                if( !empty($item['image']) )
                    $str .= '<img src="'. Helper::showImage($item['image']) .'" alt="not image">';
                $str .= '<h4><a href="'. Url::to(['/home/blog/index/view', 'article_id'=>$item['id']]) .'">'. Html::encode($item['title']) .'</a> </h4>';
                $str .= '<p>'. Helper::truncate_utf8_string(Html::encode($item['brief']),75) .'</p>';
            $str .= '</div>';
        }

        $html = <<<HTML
                <!-- 热门文章 -->
                <div class="widget">
                    <h3 class="widget-title"> 热门文章</h3>
                    <div class="bubble-line"></div>
                    <div class="widget-content">
                        {$str}
                    </div>
                </div>
HTML;
        return $html;

    }


}