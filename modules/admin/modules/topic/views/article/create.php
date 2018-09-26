<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\topic\SpecialArticle */

$this->title = '创建文章';
$this->params['breadcrumbs'][] = ['label' => '文章列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="special-article-create">

    <?= $this->render('_form', [
        'model' => $model,
        'selectedSpecial' => [],
        'selectedChapter' => []
    ]) ?>

</div>
