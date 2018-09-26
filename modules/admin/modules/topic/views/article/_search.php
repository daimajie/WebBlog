<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\Select2Asset;
use yii\helpers\Url;

Select2Asset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\topic\SearchSpecialArticle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="special-article-search">

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

    <?= $form->field($model, 'special_id')->dropDownList($selectedSpecial, [
        'class' => 'form-control',
        'id' => 'select_special',
        'style' => 'width: 100%;',
        'prompt' => '选择所属专题',
        'style' => 'width:220px;'
    ]) ?>

    <?= $form->field($model, 'chapter_id')->dropDownList($selectedChapter, [
        'prompt' => '选择所属章节',
        'id' => 'select_chapter',
        'style' => 'width:220px;'
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary  btn-flat']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default  btn-flat']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
//根据专题获取章节列表
$getChapterBySpecialUrl = Url::to(['chapter/get-chapter-by-special']);

//下拉搜索
$jsStr = <<<STR
    initSelect2();
    $(window).resize(function() {
      initSelect2();
    });
    
    //展示章节
    $('#select_special').on('select2:select', function(){
        var special_id = $(this).val();
		
		if( !parseInt( special_id ) > 0 ) return;
		
		$.ajax({
		    url : "$getChapterBySpecialUrl",
		    type : 'POST',
		    data : {special_id : special_id},
		    success : function(d){
		        var inner = '<option value="">选择所属章节</option>';
		        if( !d.errno ){
		            //获取数据成功
		            $.each(d.data, function(index, value){
		                inner += '<option value="'+ index +'">'+ value +'</option>';
		            });
		        }else{
		            inner = '<option value="">该专题下没有章节，请先创建章节。</option>';
		        }
		        
		        $('#select_chapter').html(inner);
		    }
		});
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