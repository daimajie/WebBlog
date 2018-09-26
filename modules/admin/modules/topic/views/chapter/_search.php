<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\Select2Asset;
use yii\helpers\Url;

Select2Asset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\topic\SearchSpecial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="special-search pull-right">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'form-inline',

        ],
        'fieldConfig'=>[
            'template' =>'{input}'
        ],
    ]); ?>



    <?= $form->field($model, 'special_id')->dropDownList($selected, [
        'class' => 'form-control',
        'id' => 'select_special',
        'style' => 'width: 100%;',
        'prompt' => '选择所属专题',
        'style' => 'width:220px;'
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default btn-flat']) ?>
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
