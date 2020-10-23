<?php
/**
 * 依赖注入模式
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

$luntai = new LunTai();
$bmw = new BMW($luntai);
$bmw->run();