<?php

namespace app\index\controller;


class Article extends Common
{
    public function index($id)
    {
        //轮播跳转
        //echo $id;
        $art = new \app\index\model\Article();
        $article = $art->getArticle($id);
        //print_r($article);
        $this->assign("article", $article);

        $rec = new \app\index\model\Article();
        $right = $rec->getRight();
        $this->assign('right', $right);
        return $this->fetch('article');
    }

    //处理点赞
    public function zan()
    {
        $id = input("get.aid");
        $art = new \app\index\model\Article();
        $zan = $art->dianzan($id);
        return $zan;
        //注意：如果ajax请求返回多个数据，返回json数据   return json（）
    }
}