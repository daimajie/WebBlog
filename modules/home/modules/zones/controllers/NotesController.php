<?php
namespace app\modules\home\modules\zones\controllers;
use app\models\zones\Notes;
use app\modules\home\controllers\BaseController;
use yii\helpers\VarDumper;

class NotesController extends BaseController
{
    //日记列表
    public function actionIndex(){

        $notes = Notes::getNotes();

        return $this->render('index',[
            'notes' => $notes
        ]);
    }

    //搜索
    public function actionSearch($keywords){
        $words = htmlentities(trim($keywords));

        $notes = Notes::getNotes($words);

        return $this->render('index',[
            'notes' => $notes
        ]);
    }
}