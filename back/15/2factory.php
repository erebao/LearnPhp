<?php

/**
 * 工厂模式
 */
interface Skill
{
    function family();
    function buy();
}

class Person implements Skill
{
    function family()
    {
        echo '人族在辛辛苦苦的伐木<br/>';
    }
    function buy()
    {
        echo '人族在使用人民币买房子<br/>';
    }
}

class JingLing implements Skill
{
    function family()
    {
        echo '精灵族在砍树<br/>';
    }
    function buy()
    {
        echo '精灵族在使用精灵币<br/>';
    }
}

class Factory
{
    static function createHero($type)
    {
        switch($type){
            case 'person':
                return new Person();
                break;
            case 'jingling':
                return new JingLing();
                break;
        }
    }
}

$person = Factory::createHero('person');
$jingling = Factory::createHero('jingling');