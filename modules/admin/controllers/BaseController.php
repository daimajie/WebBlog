<?php
/**
 * Created by PhpStorm.
 * User: saimajie
 * Date: 2018/9/20
 * Time: 22:51
 */
namespace app\modules\admin\controllers;
use app\controllers\BaseController as Controller;
use Yii;
use yii\base\Exception;
use yii\web\ForbiddenHttpException;

class BaseController extends Controller
{
    //验证权限
    public function beforeAction($action)
    {
        if( parent::beforeAction($action) ){
            if( Yii::$app->user->isGuest )
                return Yii::$app->user->loginRequired();

            $user_id = Yii::$app->user->id;

            $permiss = Yii::$app->params['RBAC']['RBAC_PERMISS'];

            $modelId = Yii::$app->controller->module->id;

            $key = 0;
            foreach ($permiss as $k => $v){
                if( in_array($user_id, $v) ){
                    $key = $k;
                }
            }
            if( !$key ) return $this->action->controller->redirect(['/']);

            //检测权限
            $auths = Yii::$app->params['RBAC']['RBAC_AUTHS'][$key];
            if(!in_array('*', $auths) && !in_array($modelId .'/*', $auths)){
                throw new ForbiddenHttpException('您没有权限访问。');
            }
            return true;
        }
        return false;
    }
}