<?php
use yii\helpers\Html;

$cssStr = <<<CSS
.pic_box > .pic_right{
	margin-left: 15px;
}
.pic_box .pic_top img{
	width:290px;
	height: 140px;
}
.pic_box .pic_bottom{
	margin-top:5px;
}
.upsuccess{
	box-shadow: 0 0 5px green;
}
.uperror{
	box-shadow: 0 0 5px red;
}
.webuploader-container {
	position: relative;
}
.webuploader-element-invisible {
	position: absolute !important;
	clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
	clip: rect(1px,1px,1px,1px);
}
CSS;
$this->registerCss($cssStr);

// $id 输入框的默认id
?>

<div class="pic_box form-inline" id="uploader">
    <div class="pic_left pull-left">
        <div class="pic_top"  id="fileList">
            <img src="<?= $defaultImage?>" alt="选择图片" class="img-thumbnail">
        </div>
        <div class="pic_bottom">
            <div class="form-group up_input">
                <?= Html::activeInput('text', $model, $attribute,[
                        'class' => "form-control disabled",
                        'id' => $id,
                        'readonly' => true
                ])?>
            </div>
            <span id="filePicker" class="btn btn-info">上传图片</span>
        </div>
    </div>
    <div class="pic_right pull-left">
        <dl>
            <dt>类型：</dt>
            <dd>允许上传 <mark>( jpg jpeg png gif )</mark> 格式图片</dd>
            <dt>尺寸：</dt>
            <dd>应在<mark>500kb</mark>之内。</dd>
            <dt>大小：</dt>
            <dd>该图用于文章封面，<mark>290 * 140</mark>像素为佳。</dd>
        </dl>
    </div>
    <div class="clearfix"></div>
</div>
<?php
$token =  \Yii::$app->request->getCsrfToken();
$imageInput = <<<STR
    var imgBox = $('#fileList'),
        imgInput = $('#{$id}'),
        thumbnailWidth = 290,
        thumbnailHeight = 140;
        
    // 初始化Web Uploader
    var uploader = WebUploader.create({
        
        auto: true,
        multiple : false,
        //swf: $('#swf').attr('href'),
        
        server: "$uploadUrl",
        
        pick: {
            id : '#filePicker',
            name : 'image',
            multiple : false
        },
        formData: {  
            _csrf : "$token",  
        },

        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        },
        
        //限制尺寸
        whLimit:{width:[100,1000], height:[100, 1000]},
        
        //限制大小
        fileNumLimit : 1,
    });
    

    // 当有文件添加进来的时候
    uploader.on( 'fileQueued', function( file ) {
        //创建图片
        var img = $('<img src="" class="img-thumbnail">');

        // 添加到容器
        imgBox.html( img );

        // 创建缩略图
        uploader.makeThumb( file, function( error, src ) {
            if ( error ) {
                img.replaceWith('<img src=""/>');
                return;
            }
            img.attr( 'src', src );
        }, thumbnailWidth, thumbnailHeight );
    });
    
    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on( 'uploadSuccess', function( file, response ) {
        if(response.code === 0){
            //上传成功
            layer.msg('上传成功');
            $( '#fileList' ).addClass('upsuccess');
            
            //填充数据
            imgInput.val(response.attachment);
            
        }else{
            //上传失败
            layer.msg(response.msg);
        }
        
        
    });
    
    // 文件上传失败，显示上传出错。
    uploader.on( 'uploadError', function( file ) {
        layer.msg('上传失败，请重试。');
        console.log(file);
        $( '#fileList' ).addClass('uperror');
    });
STR;

$this->registerJs($imageInput);
?>