<?php
namespace app\components\helper;
use Yii;

class Helper {
    
    //显示图片
    public static function showImage($image){
        if(empty($image)) return false;
        $upUrl = Yii::getAlias(Yii::$app->params['upload']['upUrl']);
        return $upUrl .'/'. $image;
    }

    //显示头像
    public static function showAvatar($image){
        if(empty($image)){
            return '/static/img/avatar.png';
        }
        $upUrl = Yii::getAlias(Yii::$app->params['upload']['upUrl']);
        return $upUrl .'/'. $image;
    }
    
    //格式化时间
    public static function formatDate($date){
        return Yii::$app->formatter->asRelativeTime($date);
    }

    //判断时间格式
    public static function checkTime($time){
        if(date('Y-m-d', strtotime($time)) == $time){
            return true;
        }
        return false;
    }

    /**
     * 截取指定长度字符串
     * @param $string string #要截取的字符串
     * @param $length int #截取长度
     * @param string $etc #追加符号
     * @return string #截取后的字符串
     */
    public static function truncate_utf8_string($string, $length, $etc = '...')
    {
        $result = '';
        $string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
        $strlen = strlen($string);
        for ($i = 0; (($i < $strlen) && ($length > 0)); $i++)
        {
            if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0'))
            {
                if ($length < 1.0)
                {
                    break;
                }
                $result .= substr($string, $i, $number);
                $length -= 1.0;
                $i += $number - 1;
            }
            else
            {
                $result .= substr($string, $i, 1);
                $length -= 0.5;
            }
        }
        $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
        if ($i < $strlen)
        {
            $result .= $etc;
        }
        return $result;
    }
}