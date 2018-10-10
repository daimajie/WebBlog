<?php
namespace app\modules\admin\modules\operate\controllers;
use Yii;
use app\modules\admin\controllers\BaseController;
use app\controllers\BaseController as Base;
use yii\helpers\VarDumper;

class CacheController extends BaseController
{
    public $cache;

    public function init()
    {
        parent::init();
        $this->cache = Yii::$app->cache;
    }

    //缓存列表
    public function actionIndex(){
        $caches = [];

        //seo
        $caches[Base::SEO_CACHE]['exists'] = $this->cache->exists(Base::SEO_CACHE);
        $caches[Base::SEO_CACHE]['desc'] = 'SEO缓存("站点名称,关键字,站点描述,关于我,博主头像")';

        //轮播图
        $caches[Base::SLIDE_CACHE]['exists'] = $this->cache->exists(Base::SLIDE_CACHE);
        $caches[Base::SLIDE_CACHE]['desc'] = '页面底部轮播图缓存';

        //侧边栏
        $caches[Base::SIDEBAR_CACHE]['exists'] = $this->cache->exists(Base::SIDEBAR_CACHE);
        $caches[Base::SIDEBAR_CACHE]['desc'] = '侧边栏缓存';


        return $this->render('index',[
            'caches' => $caches,
        ]);
    }


    //清除所有缓存
    public function actionFlush(){
        $this->cache->flush();
        return $this->redirect(['index']);
    }

    //清空seo缓存
    public function actionSEO(){
        $this->cache->delete(Base::SEO_CACHE);
        return $this->redirect(['index']);
    }

    //清空侧边栏缓存
    public function actionSidebar(){
        $this->cache->delete(Base::SIDEBAR_CACHE);
        return $this->redirect(['index']);
    }

    //清空轮播图缓存
    public function actionSlide(){
        $this->cache->delete(Base::SLIDE_CACHE);
        return $this->redirect(['index']);
    }
}