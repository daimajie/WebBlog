<?php
namespace app\components\helper;

class Helper {

    //判断时间格式
    public static function checkTime($time){
        if(date('Y-m-d', strtotime($time)) == $time){
            return true;
        }
        return false;
    }
}