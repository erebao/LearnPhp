<?php

/**
 * 观察者模式
 */
class Man
{
    //用来存放观察者
    protected $observers = [];

    //添加观察者方法
    function addObserver($observer)
    {
        $this->observers[] = $observer;
    }

    //花钱方法
    function buy(){
        //当被观察者做出这个行为的时候，让观察者得到通知，并且做出一定反应
        foreach($this->observers as $girl){
            $girl->dongjie();
        }
    }

    //删除观察者方法
    function delObserver($observer)
    {
        //查找对应值在数组中的键
        $key = array_search($observer, $this->observers);
        //根据键删除值，并且数组重新索引
        array_splice($this->observers, $key, 1);
    }
}

class GirlFriend
{
    function dongjie()
    {
        echo '你得男朋友正在花钱，马上冻结他的银行卡<br/>';
    }
}

#测试
//创建对象
$xiaoming = new Man();
$xiaohua = new GirlFriend();
$xiaoli = new GirlFriend();

//添加观察者
$xiaoming->addObserver($xiaohua);
$xiaoming->addObserver($xiaoli);

//删除观察者
$xiaoming->delObserver($xiaohua);

$xiaoming->buy();