<?php

/**
 * 门面模式
 * 打开照相机为例：
 *  两步：
 *      打开闪光灯、打开照相机
 *      关闭闪光灯、关闭照相机
 */
class Light
{
    function turnOn()
    {
        echo '打开闪光灯<br/>';
    }
    function turnOff()
    {
        echo '关闭闪光灯<br/>';
    }
}

class Camera
{
    function active()
    {
        echo '打开照相机<br/>';
    }
    function deactive()
    {
        echo '关闭照相机<br/>';
    }
}

class Facade
{
    protected $light;
    protected $camera;

    function __construct()
    {
        $this->light = new Light();
        $this->camera = new Camera();
    }

    function start(){
        $this->light->turnOn();
        $this->camera->active();
    }

    function stop(){
        $this->light->turnOff();
        $this->camera->deactive();
    }
}

$f = new Facade();
$f->start();
$f->stop();