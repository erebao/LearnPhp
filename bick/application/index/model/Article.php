<?php

namespace app\index\model;

use think\Model;

class Article extends Model
{
    public function getRec()
    {
        //查询轮播图的数据
        $rec = db("bk_article")
            ->field("id, title, thumb")
            ->where('rec = 1')
            ->limit('4')
            ->select();
        return $rec;
    }
    public function getArt()
    {
        $art = db('bk_article')
            ->field('a.*, b.catename')
            ->order('time', 'desc')
            ->alias('a')
            ->join('bk_cate b', 'a.cateid = b.id')
            ->limit(10)
            ->select();
        return $art;
    }
    //轮播跳转数据查询
    public function getArticle($id = 0)
    {
        db('bk_article')
            ->where("id = $id")
            ->setInc('click');
        $article = db('bk_article')
            ->field('a.*, b.catename')
            ->alias('a')
            ->join('bk_cate b', 'a.cateid = b.id')
            ->where("a.id", "=", $id)
            ->select();
        return $article;
    }

    //头部数据查询
    public function getCteid($cateid = 0)
    {
        $article = db('bk_article')
            ->field('a.*, b.catename')
            ->alias('a')
            ->join('bk_cate b', 'a.cateid = b.id')
            ->where("a.cateid", "=", $cateid)
            ->paginate(3);
        return $article;
    }

    //右边栏数据查询
    public function getRight()
    {
        $arr = db('bk_article')
            ->field('id, thumb, title, click')
            ->order('click', 'desc')
            ->limit(5)
            ->select();
        return $arr;
    }
    public function dianzan($id)
    {
        db("bk_article")
            ->where("id", $id)
            ->setInc('zan');
        $arr = db("bk_article")
            ->where("id", $id)
            ->find();
        return $arr["zan"];
    }
}