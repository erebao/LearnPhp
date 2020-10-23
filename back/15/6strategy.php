<?php

/**
 * 策略模式
 */
interface Love
{
    function sajiao();
}

class KeAi implements Love
{
    function sajiao()
    {
        echo '讨厌，不理你了<br/>';
    }
}

class Tiger implements Love
{
    function sajiao()
    {
        echo '给老娘过来<br/>';
    }
}

class GirlFriend
{
    protected $xingge;

    function __construct($xingge)
    {
        $this->xingge = $xingge;
    }
    function sajiao()
    {
        $this->xingge->sajiao();
    }
}

$keai = new KeAi();
$yeman = new Tiger();
$li = new GirlFriend($yeman);
$li->sajiao();