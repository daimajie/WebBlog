<?php
namespace app\components\widgets;

use Yii;
use app\assets\LayerAsset;

class LayerAlert extends \yii\bootstrap\Widget
{
    public $type = 'info'; //session key

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        //注册资源
        $this->register();

        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();

        foreach ($flashes as $type => $flash) {

            if($type === $this->type){
                foreach ((array) $flash as $i => $message) {
                    $this->alert($message);
                }

                $session->removeFlash($type);
            }
        }
    }

    //消息提示
    private function alert($msg){
        $js = <<<STR
        layer.msg("$msg");
STR;
        $this->view->registerJs($js);
    }

    //注册资源
    private function register(){
        LayerAsset::register($this->view);
    }
}
