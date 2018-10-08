<?php
/**
 * Created by PhpStorm.
 * User: daimajie
 * Date: 2018/9/26
 * Time: 13:13
 */
namespace app\controllers;

use app\models\blog\BlogArticle;
use app\models\blog\Category;
use app\models\setting\Friend;
use yii\helpers\StringHelper;
use yii\web\Controller;
use app\models\setting\Setups;
use yii\caching\DbDependency;
use yii\helpers\VarDumper;
use Yii;

class BaseController extends Controller
{
    const SEO_CACHE = 'seo';
    const SIDEBAR_CACHE = 'sidebar';
    const BLOG_ARTICLE_CACHE = 'article';
    const SPECIAL_ARTICLE_CACHE = 'article';

    public function beforeAction($action)
    {

        if(parent::beforeAction($action)){

            //判断是否是前台页面
            $modelRoute = $this->action->controller->module->uniqueId;
            if( !StringHelper::startsWith($modelRoute, 'admin') ){
                //获取前台公共数据
                $cache = Yii::$app->cache;

                //缓存seo信息
                $seo = $cache->get(static::SEO_CACHE);
                if ($seo === false) {
                    $seo = Setups::find()
                        ->where(['id'=>1])
                        ->select(['name','sign','keywords','description','image','email','about'])
                        ->asArray()
                        ->one();
                    $dependency = new DbDependency([
                        'sql' => "SELECT updated_at FROM {{%setups}} WHERE id = 1",
                    ]);
                    $cache->set(static::SEO_CACHE, $seo, 60*60*2, $dependency);
                }
                $this->view->params[static::SEO_CACHE] = $seo;


                //获取侧边栏数据
                $sidebar = $cache->get(static::SIDEBAR_CACHE);
                if($sidebar !== false){
                    $sidebar = [];
                    //分类
                    $sidebar['category'] = Category::find()->select(['id','name','updated_at'])->asArray()->all();

                    //热门
                    $sidebar['hot'] = BlogArticle::find()->select(['id','title','image','brief'])->orderBy(['visited'=>SORT_DESC])->limit(5)->asArray()->all();

                    //友链
                    $sidebar['friend'] = Friend::find()->select(['id','site','url'])->orderBy(['sort'=>SORT_ASC])->limit(20)->asArray()->all();

                    $cache->set(static::SIDEBAR_CACHE, $sidebar, 60*60*2);
                }

                $this->view->params[static::SIDEBAR_CACHE] = $sidebar;

            }

            return true;
        }

        return false;
    }
}