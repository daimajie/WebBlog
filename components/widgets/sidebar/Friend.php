<?php
namespace app\components\widgets\sidebar;

use app\controllers\BaseController;
use yii\base\Widget;
use yii\helpers\Html;
/**
 * 编辑器
 */
class Friend  extends Widget
{

    public function run ()
    {
        return $this->printHtml();
    }

    public function printHtml(){

        $view = $this->getView();
        $sidebar = $view->params[BaseController::SIDEBAR_CACHE];
        $friend = $sidebar['friend'];

        $tmp = '';
        foreach ($friend as $item) {
            $tmp .= '<a target="_blank" href="'. $item['url'] .'">'. Html::encode($item['site']) .'</a>&nbsp;&nbsp;';
        }
        
        $html = <<<HTML
                <!-- 友链 -->
                <div class="widget">
                    <h3 class="widget-title"> <a href="javascript:;"> 友链 </a></h3>
                    <div class="bubble-line"></div>
                    <div class="widget-content sm ">
                        {$tmp} 
                    </div>
                </div>
HTML;
        return $html;

    }


}