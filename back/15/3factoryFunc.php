<?php
/**
 * 抽象工厂模式
 */
interface Tell
{
    function call();
    function receive();
}

class XiaoMi implements Tell
{
    function call()
    {
        echo '我在使用小米手机打电话';
    }
    function receive()
    {
        echo '我在使用小米手机接电话';
    }
}

class HuaWei implements Tell
{
    function call()
    {
        echo '我在使用华为手机打电话';
    }
    function receive()
    {
        echo '我在使用华为手机接电话';
    }
}

//工厂类只负责规定接口，具体的实现交给子类
interface Factory
{
    static function createPhone();
}

class XiaoMiFactory implements Factory
{
    static function createPhone()
    {
        return new XiaoMi();
    }
}

class HuaWeiFactory implements Factory
{
    static function createPhone()
    {
        return new HuaWei();
    }
}

$xiaoMi = XiaoMiFactory::createHero();
$huaWei = HuaWeiFactory::createHero();