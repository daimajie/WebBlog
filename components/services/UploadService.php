<?php
namespace app\components\services;
use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper;

class UploadService
{

    /**
     * 生成上传图片
     * @param $dir string
     * @param $ext string
     * @return array
     * @throws
     */
    public static function generateImage($dir, $ext){
        $upRoot = Yii::getAlias(Yii::$app->params['upload']['upRoot']);

        $path = $dir. '/' .date('Y') .'/'. date('m') .'/'. date('d');
        $file = uniqid() . time() . '.' . ltrim($ext, '.');

        //创建目录
        if( !is_dir($upRoot .'/'. $path) ){
            FileHelper::createDirectory($upRoot .'/'. $path);
        }

        return [
            'savePath' => $path . '/' .$file,
            'fullPath' => $upRoot .'/'. $path .'/'.$file,
        ];
    }

    /**
     * 删除图片
     * @param $image string
     * @return bool
     */
    public static function deleteImage($image){
        if(empty($image)) return false;

        $upRoot = Yii::getAlias(Yii::$app->params['upload']['upRoot']);

        return @unlink($upRoot .'/'. $image);

    }



}