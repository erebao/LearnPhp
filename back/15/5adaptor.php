<?php

/**
 * 适配器模式
 */
interface PerfectMan
{
    function cook();
    function writePhp();
}

class Wife
{
    function cook()
    {
        echo '我会做满汉全席<br/>';
    }
}

class Man implements PerfectMan
{
    protected $wife;

    //在创建对象的时候保存传递进来的对象
    public function __construct($wife)
    {
        $this->wife = $wife;
    }

    function cook()
    {
        $this->wife->cook();
    }

    function writePhp()
    {
        echo '我会写php代码<br/>';
    }
}

$wife = new Wife();
$ming = new Man($wife);
$ming->writePhp();
$ming->cook();