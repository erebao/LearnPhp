<?php
/**
 * Created by PhpStorm.
 * User: tanwb
 * Date: 2020/10/29
 * Time: 16:16
 */

namespace app\admin\controller;

//空控制器
class Error
{
    //当请求的方法不存在时，直接请求empty方法
    public function _empty()
    {
        //header("location:www.baidu.com");
        echo "<h1>404</h1>";
    }
}