<?php
namespace app\components\widgets\sidebar;

use yii\base\Widget;
use app\controllers\BaseController;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\blog\Tag;
use Yii;
/**
 * 编辑器
 */
class Tags  extends Widget
{

    public function run ()
    {

        //获取分类参数
        $category_id = Yii::$app->request->get('category_id', 0);

        if( !$category_id ) return '';

        $tags = Tag::find()->where(['category_id'=>$category_id])->select(['id', 'name'])->orderBy(['created_at'=>SORT_DESC])->all();

        return $this->printHtml($tags);
    }

    public function printHtml($tags){

        $tmp = '';
        if(empty($tags)){

            $tmp = '暂无标签.';
        }else{

            foreach ($tags as $tag) {
                $tmp .= '<a href="'. Url::current(['tag_id'=>$tag['id']]) .'">'.Html::encode($tag['name']) .'</a>';
            }
        }





        $html = <<<HTML
                <!-- 标签 -->
                <div class="widget">
                    <h3 class="widget-title"> <a href="javascript:;">云标签</a></h3>
                    <div class="bubble-line"></div>
                    <div class="widget-content">
                        <div class="widget-tags">
                            {$tmp}
                        </div>
                    </div>
                </div>
HTML;
        return $html;

    }


}