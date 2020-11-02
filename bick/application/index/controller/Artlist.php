<?php

namespace app\index\controller;

class Artlist extends Common
{
    public function Index($cateid = 0)
    {
        $cate = new \app\index\model\Article();
        $cateid = $cate->getCteid($cateid);
        //var_dump($cateid);
        $this->assign('cateid', $cateid);

        $rec = new \app\index\model\Article();
        $right = $rec->getRight();
        $this->assign('right', $right);
        return $this->fetch('artlist');
    }
}