<?php

namespace app\admin\model;

use think\Model;

class Article extends Model
{
    /**
     * 文章列表查询
     */
    public function getSel()
    {
        $arr = db("bk_article")
            ->field('a.*, b.catename')
            ->alias('a')
            ->join('bk_cate b', 'a.cateid = b.id')
            ->paginate(5);
        return $arr;
    }

    /**
     * 添加
     */
    public function getAdd($title, $url, $desc)
    {
        $id = db("bk_article")
            ->insertGetId(["title" => $title, "url" => $url, "desc" => $desc]);
        return $id;
    }

    /**
     * 提交查询数据
     */
    public function getEdit($id)
    {
        $arr = db("bk_article")
            ->where("id", $id)
            ->find();
        return $arr;
    }

    /**
     * 修改数据
     */
    public function getUpdate($title, $url, $desc, $id)
    {
        db("bk_article")
            ->where("id = $id")
            ->update(["title" => $title, "url" => $url, "desc" => $desc]);
    }

    /**
     * 删除数据
     */
    public function getDel($id)
    {
        db("bk_article")
            ->where("id = $id")
            ->delete();
    }
}