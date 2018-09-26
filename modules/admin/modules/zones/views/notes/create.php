<?php



/* @var $this yii\web\View */
/* @var $model app\models\notes\Notes */

$this->title = '创建日记';
$this->params['breadcrumbs'][] = ['label' => '日记列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notes-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
