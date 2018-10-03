<?php
use app\assets\CropboxAsset;
use yii\helpers\Url;
use app\components\helper\Helper;

CropboxAsset::register($this);
$user = Yii::$app->user->identity;
?>

<div class="container">
    <div class="imageBox">
        <div class="thumbBox"></div>
        <div class="spinner" style="display: none">Loading...</div>
    </div>
    <div class="action">
        <!-- <input type="file" id="file" style=" width: 200px">-->
        <div class="new-contentarea tc"> <a href="javascript:void(0)" class="upload-img">
                <label for="upload-file">上传图像</label>
            </a>
            <input type="file" class="" name="upload-file" id="upload-file" />
        </div>
        <input type="button" id="btnSubmit" class="Btnsty_peyton" value="提交保存" >
        <input type="button" id="btnCrop"  class="Btnsty_peyton" value="裁切">
        <input type="button" id="btnZoomIn" class="Btnsty_peyton" value="+"  >
        <input type="button" id="btnZoomOut" class="Btnsty_peyton" value="-" >
    </div>
    <div class="cropped"></div>
</div>
<?php
$uploadUrl = Url::to(['upload']);
$avatar = Helper::showImage($user['image']);
$str = <<<STR
var options =
	{
		thumbBox: '.thumbBox',
		spinner: '.spinner',
		imgSrc: "$avatar"
	}
	var cropper = $('.imageBox').cropbox(options);
	$('#upload-file').on('change', function(){
		var reader = new FileReader();
		reader.onload = function(e) {
			options.imgSrc = e.target.result;
			cropper = $('.imageBox').cropbox(options);
		}
		reader.readAsDataURL(this.files[0]);
		this.files = [];
	})
	$('#btnCrop').on('click', function(){
		var img = cropper.getDataURL();
		$('.cropped').html('');
		$('.cropped').append('<img src="'+img+'" align="absmiddle" style="width:64px;margin-top:4px;border-radius:64px;box-shadow:0px 0px 12px #7E7E7E;" ><p>64px*64px</p>');
		$('.cropped').append('<img src="'+img+'" align="absmiddle" style="width:128px;margin-top:4px;border-radius:128px;box-shadow:0px 0px 12px #7E7E7E;"><p>128px*128px</p>');
		$('.cropped').append('<img src="'+img+'" align="absmiddle" style="width:180px;margin-top:4px;border-radius:180px;box-shadow:0px 0px 12px #7E7E7E;"><p>180px*180px</p>');
	})
	$('#btnZoomIn').on('click', function(){
		cropper.zoomIn();
	})
	$('#btnZoomOut').on('click', function(){
		cropper.zoomOut();
	})
    $('#btnSubmit').on('click', function(){
        var img = cropper.getDataURL();
        
        if( img.length <= 0 ) return;
        $.ajax({
            url : "$uploadUrl",
            type : 'POST',
            data : {img : img},
            success : function( d ){
                if( d.errno === 0 ){
                    layer.msg('修改头像成功。');
                }else{
                    layer.msg(d.errmsg);
                }
                //刷新页面
                
            }
        });
    });
STR;
$this->registerJs($str);
?>