<?php

namespace app\admin\model;


use think\Model;

class Auth_rule extends Model
{
    public function getUrl($rule)
    {
        $urlArr = db("bk_auth_rule")
            ->where("id", "in", $rule)
            ->column("name");
        return $urlArr;
    }

    public function getEdit($id)
    {
        $arr = db("bk_auth_rule")
            ->where("id", $id)
            ->find();
        return $arr;
    }

    /**
     * 查询树状结构列表
     */
    public function getRuleTree($id = null)
    {
        $map = [];
        $id == null ? : $map['id'] = ['neq', $id];
        $all = db("bk_auth_rule")
            ->where($map)
            ->select();
        $arr = $this->getRule($all, 0);
        return $arr;
    }

    /**
     * 递归排序为树状结构
     */
    public function getRule($arr, $pid)
    {
        static $array = array();
        foreach($arr as $k => $v){
            if($v["pid"] == $pid){
                $array[] = $v;
                //递归调用
                $this->getRule($arr, $v["id"]);
            }
        }
        return $array;
    }

    /**
     * 添加
     */
    public function add($title, $name, $pid)
    {
        //获取级别
        $level = 1;
        if($pid != 0){
            $rule_level = db("bk_auth_rule")
                ->where("id", $pid)
                ->value("level");
            $level = $rule_level + 1;
        }
        //添加
        $id = db("bk_auth_rule")
            ->insertGetId(["title" => $title, "name" => $name, "pid" => $pid, "level" => $level]);
        return $id;
    }

    /**
     * 修改
     */
    public function edit($id, $name, $title, $pid)
    {
        //获取级别
        $level = 1;
        if($pid != 0){
            $rule_level = db("bk_auth_rule")
                ->where("id", $pid)
                ->value("level");
            $level = $rule_level + 1;
        }
        //修改
        db("bk_auth_rule")
            ->where("id = $id")
            ->update(["title" => $title, "name" => $name, "pid" => $pid, "level" => $level]);
    }

    public function getDel($id)
    {
        db("bk_auth_rule")
            ->where("id = $id")
            ->delete();
    }
}