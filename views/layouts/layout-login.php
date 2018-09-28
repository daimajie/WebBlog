<?php
use yii\helpers\Html;
use app\assets\AdminLteICheckAsset;
use app\assets\LayerAsset;


AdminLteICheckAsset::register($this);
LayerAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        .btn-wechat {
            color: #fff;
            background-color: forestgreen;
            border-color: rgba(0,0,0,0.2);
        }
        .btn-qq {
            color: #fff;
            background-color: cornflowerblue;
            border-color: rgba(0,0,0,0.2);
        }
        #email_box{
            overflow: hidden;
        }
        #email_box input{
            width: 65%;
            float: left;
        }
        #email_box span{
            width: 35%;
            float: right;
        }
    </style>
</head>
<body class="hold-transition login-page">
<?php $this->beginBody() ?>
<div class="login-box">
    <div class="login-logo">
        <a href="/"><?= Yii::$app->name?></a>
    </div>
    <div class="content">
        <?= $content ?>
    </div>
</div>
<!-- /.login-box -->

<?php
$this->endBody();
$session = Yii::$app->session;
$info = $session->hasFlash('info') ? $session->getFlash('info') : '';

?>

<script>
$(function () {
    //alert
    var info = "<?= $info?>";
    if( info.length > 0 )
        layer.msg( info );


    //iCheck
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
    });
});

</script>
</body>
</html>
<?php $this->endPage() ?>

