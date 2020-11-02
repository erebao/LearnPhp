<?php

namespace app\index\model;

use think\Model;

class Link extends Model
{
    public function index()
    {
        $arr = db('bk_link')
            ->field('title, url, desc')
            ->select();
        return $arr;
    }
}