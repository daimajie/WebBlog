<?php
/**
 * Created by PhpStorm.
 * User: saimajie
 * Date: 2018/9/20
 * Time: 22:51
 */
namespace app\modules\admin\controllers;
use app\controllers\BaseController as Controller;
use app\models\member\Contact;
use Yii;
use yii\base\Exception;
use yii\helpers\VarDumper;
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
            
            //获取未读留言
            $unread = Contact::find()->with('userImage')
                ->where(['visited'=>0])
                ->select(['id','subject','user_id','created_at'])
                ->orderBy(['created_at'=>SORT_DESC])
                ->asArray()
                ->limit(8)
                ->all();
            $this->view->params['unread'] = $unread;
            return true;
        }
        return false;
    }
}