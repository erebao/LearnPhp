<?php

namespace app\admin\model;

use think\Model;

class Link extends Model
{
    /**
     * 链接列表查询
     */
    public function getSel()
    {
        $arr = db("bk_link")
            ->paginate(3);
        return $arr;
    }

    /**
     * 添加
     */
    public function getAdd($title, $url, $desc)
    {
        $id = db("bk_link")
            ->insertGetId(["title" => $title, "url" => $url, "desc" => $desc]);
        return $id;
    }

    /**
     * 提交查询数据
     */
    public function getEdit($id)
    {
        $arr = db("bk_link")
            ->where("id", $id)
            ->find();
        return $arr;
    }

    /**
     * 修改数据
     */
    public function getUpdate($title, $url, $desc, $id)
    {
        db("bk_link")
            ->where("id = $id")
            ->update(["title" => $title, "url" => $url, "desc" => $desc]);
    }

    public function getDel($id)
    {
        db("bk_link")
            ->where("id = $id")
            ->delete();
    }
}