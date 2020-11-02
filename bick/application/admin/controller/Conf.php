<?php

namespace app\admin\controller;

//配置管理
class Conf extends Common
{
    public function conf()
    {
        if ($this->request->isGet()) {
            $con = new \app\admin\model\Conf();
            $confres = $con->sel();
            $this->assign("confres", $confres);
        } else if ($this->request->isPost()) {
            $sorts = input('post.');
            //dump($sorts);
            $conf = new \app\admin\model\Conf();
            $conf->setUpdate($sorts);

            $this->success('改好了!', url('lst'));
        }
        return view();
    }

    public function lst()
    {
        if ($this->request->isGet()) {
            $con = new \app\admin\model\Conf();
            $confres = $con->sel();
            $this->assign("confres", $confres);
        }
        return view();
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $arr = input("post.");
            //dump($arr);
            $con = new \app\admin\model\Conf();
            $con->add($arr);
            //dump($a);
            $this->success("添加好了", "lst");
        }
        return view();
    }

    public function edit()
    {
        if ($this->request->isGet()) {
            $id = input("id");
            $con = new \app\admin\model\Conf();
            $confres = $con->getEdit($id);
            //dump($confres);
            $this->assign("confs", $confres[0]);
        } else if ($this->request->isPost()) {
            $id = input("id");
            $arr = input("post.");
            $con = new \app\admin\model\Conf();
            $con->edit($id, $arr);
            $this->success("修改好了!", "lst");
        }
        return view();
    }

    public function del()
    {
        $id = input("id");
        $con = new \app\admin\model\Conf();
        $con->del($id);
        $this->success("删除完了", "lst");
    }
}