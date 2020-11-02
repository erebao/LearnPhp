<?php

namespace app\index\model;

use think\Model;

class Cate extends Model
{
    protected $table = 'bk_cate';

    //查询全部菜单
    public function getAllCate()
    {
        $cate = db('bk_cate')
            ->field('id, catename, type, pid')
            ->select();
        return $cate;
    }
    public function getTjrec()
    {
        $rec = db('bk_cate')
            ->field('id, catename, type')
            ->where('rec_index = 1')
            ->select();
        return $rec;
    }
    public function getFoot()
    {
        $rec = db('bk_cate')
            ->field('id, catename, type')
            ->where('rec_bottom = 1')
            ->select();
        return $rec;
    }
}