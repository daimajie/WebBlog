<?php


$user = Yii::$app->user->identity;
?>

    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-user"></i> (<?= $user['username']?>)
                    <small class="pull-right">Now: <?= date('Y/m/d', time())?></small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <address>
                    用户名：<br>
                    邮箱：<br>
                    注册时间：<br>
                    最后登录时间：
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <address>
                    <?= $user['username']?><br>
                    <?= $user['email']?><br>
                    <?= date('Y-m-d', $user['created_at'])?><br>
                    <?= date('Y-m-d H:s:i', $user['lasttime'])?>
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
    <div class="clearfix"></div>