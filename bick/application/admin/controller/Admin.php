<?php

namespace app\admin\controller;

//管理员控制器
class Admin extends Common
{
    //查询
    public function lst()
    {
        $getadmin = new \app\admin\model\Admin();
        $getadmin = $getadmin->lst();
        $this->assign("admin", $getadmin);
        return view("list");
    }

    //添加
    public function add()
    {
        if ($this->request->isPost()) {
            $name = input("post.username");
            $pwd = md5(input("post.password"));

            $tian = new \app\admin\model\Admin();
            $tian2 = $tian->insertGroup($name, $pwd);
            $group_id = input("post.group_id");

            db("bk_auth_group_access")
                ->insert(["uid" => $tian2, "group_id" => $group_id]);

            $this->success("添加成功!", "admin/lst");
        } else if ($this->request->isGet()) {
            $add = new \app\admin\model\Admin();
            $add = $add->addGroup();
            $this->assign("add", $add);
        }
        return view();
    }

    //修改
    public function edit()
    {
        if ($this->request->isPost()) {
            $name = input("post.username");
            $pwd = md5(input("post.password"));
            $group_id = input("post.group_id");
            $id = input("id");

            $xiu = new \app\admin\model\Admin();
            $xiu->getUpdate($name, $pwd, $id);

            db("bk_auth_group_access")
                ->where("uid=$id")
                ->update(["group_id" => $group_id]);

            $this->success("修改成功!", "lst");
        } else if ($this->request->isGet()) {
            $id = input("id");
            $edit = new \app\admin\model\Admin();
            $edit = $edit->getedit($id);
            //dump($edit);
            $cha = new \app\admin\model\Admin();
            $cha = $cha->editcha();
            $this->assign("edit", $edit);
            $this->assign("cha", $cha);
        }
        return view("add2");
    }

    //删除
    public function del()
    {
        $cid = input("id");
        $del = new \app\admin\model\Admin();
        $del->getDel($cid);
        db("bk_auth_group_access")
            ->where("uid = $cid")
            ->delete();

        $this->success("删除成功!", "lst");
    }
}