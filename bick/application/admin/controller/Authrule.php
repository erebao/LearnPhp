<?php

namespace app\admin\controller;

use app\admin\model\Auth_rule;

//权限
class Authrule extends Common
{
    /**
     * 列表
     */
    public function lst()
    {
        $rule = new Auth_rule();
        $arr = $rule->getRuleTree();
        $this->assign("arr", $arr);
        return view();
    }

    /**
     * 添加
     */
    public function add()
    {
        if($this->request->isGet()){
            $rule = new Auth_rule();
            $arr = $rule->getRuleTree();
            $this->assign("arr", $arr);
        }else if($this->request->isPost()){
            $title = input("post.title");
            $name = input("post.name");
            $pid = input("post.pid");
            $rule = new Auth_rule();
            $id = $rule->add($title, $name, $pid);
            $this->success("加好了,滚吧!", "lst");
        }
        return view();
    }

    /**
     * 修改
     */
    public function edit()
    {
        if($this->request->isGet()){
            $id = input("id");
            $rule = new Auth_rule();
            $arr = $rule->getRuleTree($id);
            $this->assign("arr", $arr);
            $edit = $rule->getEdit($id);
            $this->assign("edit", $edit);
        }else if($this->request->isPost()){
            $id = input("id");
            $title = input("post.title");
            $name = input("post.name");
            $pid = input("post.pid");
            $rule = new Auth_rule();
            $rule->edit($id, $name, $title, $pid);
            $this->success("修改成功!", "lst");
        }
        return view();
    }

    /**
     * 删除数据
     */
    public function del(){
        $id = input("id");
        $del = new Auth_rule();
        $del->getDel($id);
        $this->success("删除成功!", "lst");
    }
}