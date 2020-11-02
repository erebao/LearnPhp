<?php

namespace app\admin\controller;

use app\admin\model\Auth_group;
use app\admin\model\Auth_rule;

//组
class Authgroup extends Common
{
    /**
     * 列表
     */
    public function lst()
    {
        $group = new Auth_group();
        $arr = $group->lst();
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
            $status = 0;
            if(!empty(input("post.status"))){
                $status = 1;
            }
            $rules = input('post.rules/a');
            if(!empty($rules)){
                $rules = join(',', $rules);
            }
            $group = new Auth_group();
            $id = $group->add($title, $status, $rules);
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
            $rule = new Auth_rule();
            $arr = $rule->getRuleTree();
            $this->assign("arr", $arr);
            $id = input("id");
            $group = new Auth_group();
            $edit = $group->getEdit($id);
            $this->assign("edit", $edit);
        }else if($this->request->isPost()){
            $id = input("id");
            $title = input("post.title");
            $status = 0;
            if(!empty(input("post.status"))){
                $status = 1;
            }
            $rules = input('post.rules/a');
            if(!empty($rules)){
                $rules = join(',', $rules);
            }
            $group = new Auth_group();
            $group->edit($id, $title, $status, $rules);
            $this->success("修改成功!", "lst");
        }
        return view();
    }

    /**
     * 删除
     */
    public function del(){
        $id = input("id");
        $group = new Auth_group();
        $group->getDel($id);
        $this->success("删除成功!", "lst");
    }
}