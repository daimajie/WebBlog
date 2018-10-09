<?php
use app\assets\ChartjsAsset;

ChartjsAsset::register($this);

/* @var $this yii\web\View */



$this->title = '控制台';

$this->registerCss("canvas {
			-moz-user-select: none;
			-webkit-user-select: none;
			-ms-user-select: none;
		}");
?>

<div class="friend-index box box-primary">
    <div class="box-body table-responsive no-padding">
        <section class="content">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">用户留言</span>
                            <span class="info-box-number"><?= $msgNum?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">注册用户</span>
                            <span class="info-box-number"><?= $userNum?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-file-text"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">博客文章</span>
                            <span class="info-box-number"><?= $bArtNum?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-book"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">专题文章</span>
                            <span class="info-box-number"><?= $sArtNum?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">每日流量</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="areaChart" style="height: 270px; width: 541px;" width="541" height="270"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">浏览器</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <canvas id="pieChart" style="height: 270px; width: 541px;" width="541" height="270"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">主机信息</h3>
                        </div>
                        <div class="box-body">
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    <b>名称</b>
                                    <address>
                                        <strong>系统平台</strong><br>
                                        <strong>HTTP服务器</strong><br>
                                        <strong>服务器IP</strong><br>
                                        <strong>PHP版本</strong><br>
                                        <strong>服务器时间</strong><br>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>信息</b>
                                    <address>
                                        <?PHP echo PHP_OS; ?><br />
                                        <?PHP echo $_SERVER ['SERVER_SOFTWARE']; ?><br />
                                        <?= GetHostByName($_SERVER['SERVER_NAME'])?><br />
                                        <?PHP echo 'PHP ' . PHP_VERSION; ?><br />
                                        <?PHP echo date('Y-m-d H:i:s', time()); ?><br />
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




        </section>
    </div>
</div>
<?php
$jsStr = <<<JS

    /*browser*/
    var data = {
        labels: [
            "Chrome",
            "IE",
            "FireFox"
        ],
        datasets: [{
            data: [300, 50, 100],
            backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56"
            ],
            hoverBackgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56"
            ]
        }]
    };
    var ctx = document.getElementById("pieChart").getContext("2d");
    var myBarChart = new Chart(ctx, {
                type: 'pie',
                data: data,
                options : {
                }
        });
    
    
    
    /*visited*/
    var areaChartData = {
      labels  : ["星期一", "星期二", "星期三", "星期四", "星期五","星期六","星期日"], 
      datasets: [
        {
          label               : '每日流量',
          fillColor           : 'rgba(210, 214, 222, 1)',
          strokeColor         : 'rgba(210, 214, 222, 1)',
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [65, 59, 80, 81, 56, 55, 40]
        }
      ]
    };
    var areaChartOptions = {
                responsive: true,
				title: {
					display: false,
					text: 'Chart.js Line Chart - Stacked Area'
				},
				tooltips: {
					mode: 'index',
					display : false
				},
				hover: {
					mode: 'index'
				},
				scales: {
					xAxes: [{
						scaleLabel: {
							display: false,
							labelString: 'Month'
						}
					}],
					yAxes: [{
						stacked: true,
						scaleLabel: {
							display: false,
							labelString: 'Value'
						}
					}]
				}
    };
    
    
    var ctx = $('#areaChart').get(0).getContext('2d');
    var myLineChart = new Chart(ctx, {
            type: 'line',
            data: areaChartData,
            options: areaChartOptions
        });

JS;
$this->registerJs($jsStr);
?>