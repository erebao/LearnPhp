<?php

namespace app\admin\model;

use think\Model;

class Auth_group_access extends Model
{
    public function groupId($uid)
    {
        $groupid = db('bk_auth_group_access')
            ->where("uid", $uid)
            ->value("group_id");    //取某一列的单个值
        return $groupid;
    }
}