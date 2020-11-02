<?php
namespace app\index\controller;

use app\index\model\Article;
use app\index\model\Cate;
use app\index\model\Conf;
use app\index\model\Link;

class Index extends Common
{
    public function index()
    {
        $rec = new Article();
        $arr = $rec->getRec();
        $this->assign('ass', $arr);
        //推荐菜单
        $cate = new Cate();
        $recArr = $cate->getTjrec();
        $this->assign('recAdd', $recArr);

        //左边栏
        $art = $rec->getArt();
        $this->assign('art', $art);

        //右边栏
        $right = $rec->getRight();
        $this->assign('right', $right);

        $li = new Link();
        $link = $li->index();
        $this->assign('link', $link);

        //底部菜单
        $conf = new Conf();
        $confArr = $conf->getAll();
        $this->assign('arr', $confArr);
        $cate = new Cate();
        $cateAll = $cate->getAllCate();
        foreach($cateAll as $key => $val){
            foreach($cateAll as $k => $v){
                if($val['id'] == $v['pid']){
                    $cateAll[$key]['children'][] = $v;
                }
            }
        }
        $this->assign('cateArr', $cateAll);

        return view();
    }
}
