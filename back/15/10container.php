<?php
/**
 * 容器模式
 */

//轮胎类
class LunTai
{
    function roll()
    {
        echo '轮胎在滚动<br/>';
    }
}

//汽车类
class BMW
{
    protected $luntai;

    public function __construct($luntai)
    {
        $this->luntai = $luntai;
    }

    function run()
    {
        $this->luntai->roll();
        echo '开着宝马吃烤串<br/>';
    }
}

class Container
{
    //存放所绑定的类
    static $register = [];
    //绑定函数
    static function bind($name, Closure $col)
    {
        self::$register[$name] = $col;
    }

    //创建对象函数
    static function make($name)
    {
        $col = self::$register[$name];
        return $col();
    }
}

Container::bind('luntai', function(){
    return new LunTai();
});
Container::bind('bmw', function(){
    return new BMW(Container::make('luntai'));
});

$bmw = Container::make('bmw');
$bmw->run();