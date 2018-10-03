<?php
/**
 * Created by PhpStorm.
 * User: daimajie
 * Date: 2018/9/26
 * Time: 13:13
 */
namespace app\controllers;

use yii\web\Controller;
use app\models\setting\Setups;
use yii\caching\DbDependency;
use Yii;

class BaseController extends Controller
{
    const SEO_CACHE = 'seo';

    public function beforeAction($action)
    {
        if(parent::beforeAction($action)){

            $cache = Yii::$app->cache;

            //缓存seo信息
            $seo = $cache->get(static::SEO_CACHE);
            if ($seo === false) {
                $seo = Setups::find()->where(['id'=>1])->select(['name','sign','keywords','description'])->asArray()->one();
                $dependency = new DbDependency([
                    'sql' => "SELECT updated_at FROM {{%setups}} WHERE id = 1",
                ]);
                $cache->set(static::SEO_CACHE, $seo, 60*60*2, $dependency);
            }
            $this->view->params['seo'] = $seo;



            return true;
        }

        return false;
    }
}