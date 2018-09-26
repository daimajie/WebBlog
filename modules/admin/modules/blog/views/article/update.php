<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\blog\Article */

$this->title = '修改文章: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '博文列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="article-update">

    <?= $this->render('_form', [
        'model' => $model,
        'tags' => $tags,
        'category' => $category,
    ]) ?>

</div>
