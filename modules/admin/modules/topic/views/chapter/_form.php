<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\Select2Asset;
use yii\helpers\Url;

Select2Asset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\topic\Chapter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chapter-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'special_id')->dropDownList(!empty($belongTo) ? $belongTo : [], [
                'class' => 'form-control',
                'id' => 'select_special',
                'style' => 'width: 100%;',
                'prompt' => '选择所属专题',
        ]) ?>


    </div>
    <div class="box-footer">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
//下拉搜索
$jsStr = <<<STR
    initSelect2();
    $(window).resize(function() {
      initSelect2();
    });
STR;
$this->registerJs($jsStr);
?>
<script>
function initSelect2(){
    $('#select_special').select2({
        ajax: {
            url: "<?= Url::to(['special/get-special-list'])?>",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                var query = {
                    search: params.term,
                    page: params.page || 1
                }
                return query;
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.results,
                    pagination: {
                        more: (params.page * 15) < data.count_filtered
                    }
                };
            }

        }
    });
}
</script>