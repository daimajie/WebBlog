<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\blog\Article */

$this->title = '新建博文';
$this->params['breadcrumbs'][] = ['label' => '博文列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">

    <?= $this->render('_form', [
        'model' => $model,
        'category' => $category,
        'tags' => $tags
    ]) ?>

</div>
