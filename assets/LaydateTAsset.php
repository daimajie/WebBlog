<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class LaydateTAsset extends AssetBundle
{
    public $basePath = '@webroot/static/libs';
    public $baseUrl = '@web/static/libs';
    public $css = [
    ];
    public $js = [
        'laydate/laydate.js',
    ];
    public $depends = [
        'dmstr\web\AdminLteAsset',
    ];
}