<?php

/**
 * 单例模式
 */
class Dog
{
    private function __construct(){}

    //静态属性保存单例对象
    static private $instance;
    //通过静态方法创建单例对象
    static public function getInstance()
    {
        //判断$instance是否为空，如果为空则new一个对象，如果不为空则直接返回
        if(!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }
}

#测试单例模式
$dog1 = Dog::getInstance();
$dog2 = Dog::getInstance();
if ($dog1 === $dog2) {
    echo '这是同一个对象';
} else {
    echo '这是两个不同的对象';
}