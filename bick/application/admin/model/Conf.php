<?php

namespace app\admin\model;

use think\Model;

class Conf extends Model
{
    public function sel()
    {
        $arr = db("bk_conf")
            ->paginate(5);
        return $arr;
    }

    public function setUpdate($sort)
    {
        static $val = array();
        foreach ($sort as $k => $v) {
            db("bk_conf")->where(['enname' => $k])->update(["value" => $v]);
        }
    }

    public function add($sort)
    {
        $sort['value'] = $sort["values"];
        db("bk_conf")->insert($sort);
    }

    public function getEdit($id)
    {
        $arr = db("bk_conf")
            ->where("id", $id)
            ->select();
        return $arr;
    }

    public function edit($id, $arr)
    {
        db("bk_conf")
            ->where("id", $id)
            ->update($arr);
    }

    public function del($id)
    {
        db("bk_conf")
            ->where("id", $id)
            ->delete();
    }
}