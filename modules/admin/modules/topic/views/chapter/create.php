<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\topic\Chapter */

$this->title = '创建章节';
$this->params['breadcrumbs'][] = ['label' => '章节列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chapter-create">

    <?= $this->render('_form', [
        'model' => $model,
        'belongTo' => [],
    ]) ?>

</div>
