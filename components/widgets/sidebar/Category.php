<?php
namespace app\components\widgets\sidebar;

use app\controllers\BaseController;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use app\components\helper\Helper;
/**
 * 编辑器
 */
class Category  extends Widget
{

    public function run ()
    {
        return $this->printHtml();
    }

    public function printHtml(){
        $view = $this->getView();
        $sidebar = $view->params[BaseController::SIDEBAR_CACHE];
        $category = $sidebar['category'];

        $tmp = '';
        if(!empty($category)){
            foreach ($category as $item) {
                $tmp .= '<li><a href="'. Url::to(['/home/blog/index/index', 'category_id'=>$item['id']]) .'">'. Html::encode($item['name']) .'</a><span class="pull-right"> 更新于 - '.Helper::formatDate($item['updated_at']).'</span></li>';
            }
        }else{
            $tmp = '暂无分类';
        }


        $html = <<<HTML
                <!-- 分类 -->
                <div class="widget">
                    <h3 class="widget-title"> 分类</h3>
                    <div class="bubble-line"></div>
                    <div class="widget-content">
                        <ul>
                            {$tmp}
                        </ul>
                    </div>
                </div>
HTML;
        return $html;

    }


}