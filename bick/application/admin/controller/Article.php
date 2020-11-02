<?php

namespace app\admin\controller;

//文章管理
class Article extends Common
{
    public function lst()
    {
        $a = new \app\admin\model\Article();
        $arr = $a->getSel();
        $this->assign("arr", $arr);
        return view();
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $title = input("post.title");
            $url = input("post.url");
            $desc = input("post.desc");
            $a = new \app\admin\model\Article();
            $a->getAdd($title, $url, $desc);
            $this->success("加好了,滚吧!", "lst");
        } else if ($this->request->isGet()) {
            return view();
        }
    }

    //修改
    public function edit()
    {
        if($this->request->isPost()){

        }else if($this->request->isGet()){
            $id = input("id");
            $a = new \app\admin\model\Article();
            $edit = $a->getEdit($id);
            //dump($edit);
            $this->assign("edit", $edit);
        }
        return view();
    }

    //刪除
    public function del()
    {
        $id = input("id");
        $del = new \app\admin\model\Article();
        $del->getDel($id);
        $this->success("刪除成功!", "lst");
    }
}