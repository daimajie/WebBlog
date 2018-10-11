<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\member\User;

class ManagerController extends Controller
{
    public function actionIndex($message = 'hello world')
    {
        try{
            if(!$user = $this->addMember())
                throw new \Exception('create manger fail.');

            echo "create manager success!\n";
            return ExitCode::OK;
        }catch (\Exception $e){
            echo $e->getMessage()."\n";
            return ExitCode::TEMPFAIL;
        }
    }


    /**
     * 获取输入信息
     */
    private function addMember(){
        $username = $this->prompt('username: ', ['require' => true, 'validator' => function($input, &$error) {
            if (strlen($input) < 5) {
                $error = 'The Pin must be Greater than or equal to 5 chars!';
                return false;
            }
            return true;
        }]);

        $password = $this->prompt('password: ', ['require' => true,'validator' => function($input, &$error) {
            if (strlen($input) < 6) {
                $error = 'The Pin must be Greater than or equal to 6 chars!';
                return false;
            }
            return true;
        }]);

        $email = $this->prompt('email: ', ['require' => true, 'validator' => function($input, &$error) {
            if (!filter_var($input, FILTER_VALIDATE_EMAIL))
            {
                $error = 'The Pin must be email!';
                return false;
            }
            return true;
        }]);

        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->generatePasswordHash($password);
        $user->generateAuthKey();
        //保存数据
        if(!$user->save(false)){
            //throw new \Exception('create manger fail。');
            return false;
        }
        return $user;
    }
}
