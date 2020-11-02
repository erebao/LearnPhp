<?php

namespace app\admin\model;

use think\Model;

class Auth_group extends Model
{
    /**
     * 根据用户组ID查询权限ID
     */
    public function getRules($gid)
    {
        $rules = db("bk_auth_group")
            ->where("id", $gid)
            ->value("rules");
        return $rules;
    }

    /**
     * 列表
     */
    public function lst()
    {
        $arr = db("bk_auth_group")
            ->select();
        return $arr;
    }

    /**
     * 添加
     */
    public function add($title, $status, $rules)
    {
        $id = db("bk_auth_group")
            ->insertGetId(["title" => $title, "status" => $status, "rules" => $rules]);
        return $id;
    }

    /**
     * 获取需要修改的数据
     */
    public function getEdit($id)
    {
        $arr = db("bk_auth_group")
            ->where("id", $id)
            ->find();
        return $arr;
    }

    /**
     * 修改
     */
    public function edit($id, $title, $status, $rules)
    {
        db("bk_auth_group")
            ->where("id = $id")
            ->update(["title" => $title, "status" => $status, "rules" => $rules]);
    }

    /**
     * 删除
     */
    public function getDel($id)
    {
        db("bk_auth_group")
            ->where("id = $id")
            ->delete();
    }
}