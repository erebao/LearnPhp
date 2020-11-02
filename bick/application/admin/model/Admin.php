<?php

namespace app\admin\model;

use think\Model;

class Admin extends Model
{
    public function check()
    {
        $user = input("post.username");
        $pwd = md5(input("post.password"));
        $arr = db("bk_admin")
            ->where("name", $user)
            ->where("password", $pwd)
            ->find();
        return $arr;
    }

    public function lst()
    {
        $arr = db("bk_admin")
            ->join("bk_auth_group_access", "bk_admin.id = bk_auth_group_access.uid")
            ->join("bk_auth_group", "bk_auth_group_access.group_id = bk_auth_group.id")
            ->field('bk_admin.*, bk_auth_group.title')
            ->select();
        return $arr;
    }

    public function addGroup()
    {
        $arr = db("bk_auth_group")
            ->select();
        return $arr;
    }

    public function insertGroup($name, $pwd)
    {
        $id = db("bk_admin")
            ->insertGetId(["name" => $name, "password" => $pwd]);
        return $id;
    }

    public function editAdd($id)
    {
        $arr=db("bk_admin")
            ->join("bk_auth_group_access","bk_admin.id=bk_auth_group_access.uid")
            ->join("bk_auth_group","bk_auth_group_access.group_id=bk_auth_group.id")
            ->field('bk_admin.*,bk_auth_group.title')
            ->where('bk_admin.id',$id)
            ->find();
        return $arr;
    }

    public function getedit($aid)
    {
        $edit = db("bk_admin")
            ->join("bk_auth_group_access", "bk_auth_group_access.uid = bk_admin.id")
            ->join("bk_auth_group", "bk_auth_group_access.group_id = bk_auth_group.id")
            ->field("bk_admin.*, bk_auth_group.title, bk_auth_group_access.group_id")
            ->where("bk_admin.id = $aid")
            ->find();
        return $edit;
    }

    public function editcha()
    {
        $cha = db("bk_auth_group")
            ->select();
        return $cha;
    }

    /**
     * 修改数据
     */
    public function getUpdate($name, $pwd, $cid)
    {
        $data = array("name" => $name, "password" => $pwd);
        db("bk_admin")
            ->where("id = $cid")
            ->update($data);
    }

    /**
     * 删除数据
     */
    public function getDel($cid)
    {
        db("bk_admin")
            ->where("id = $cid")
            ->delete();
    }
}