<?php

namespace app\admin\controller;


class Link extends Common
{
    /**
     * 链接地址
     */
    public function lst()
    {
        $a = new \app\admin\model\Link();
        $arr = $a->getSel();
        $this->assign("arr", $arr);
        return view();
    }

    /**
     * 添加
     */
    public function add()
    {
        if($this->request->isPost()){
            $title = input("post.title");
            $url = input("post.url");
            $desc = input("post.desc");
            $a = new \app\admin\model\Link();
            $a->getAdd($title, $url, $desc);
            $this->success("加好了,滚吧!", "lst");
        }else if($this->request->isGet()){
            return view();
        }
    }

    public function edit()
    {
        if($this->request->isPost()){
            $id = input("id");
            $title = input("post.title");
            $url = input("post.url");
            $desc = input("post.desc");
            $a = new \app\admin\model\Link();
            $a->getUpdate($title, $url, $desc, $id);
            $this->success("修改成功!", "lst");
        }else if($this->request->isGet()){
            $id = input("id");
            $a = new \app\admin\model\Link();
            $edit = $a->getEdit($id);
            //dump($edit);
            $this->assign("edit", $edit);
        }
        return view();
    }

    /**
     * 删除
     */
    public function del()
    {
        $id = input("id");
        $del = new \app\admin\model\Link();
        $del->getDel($id);
        $this->success("删除成功!", "lst");
    }
}