<?php

namespace app\index\controller;


use app\index\model\Cate;
use app\index\model\Conf;
use think\Controller;

class Common extends Controller
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        /**
         * 1.查询网站配置信息
         * 2.查询菜单
         * 3.查询推荐到底部的栏目
         */

        // 1.
        $conf = new Conf();
        $confArr = $conf->getAll();
        $this->assign('arr', $confArr);
        $cate = new Cate();
        $cateAll = $cate->getAllCate();
        foreach($cateAll as $key=>$val){
            foreach($cateAll as $k => $v){
                if($val['id']==$v['pid']) {
                    $cateAll[$key]['children'][] = $v;
                }
            }
        }

        // 2.查询网站的菜单目录
        /*$cate = new Cate();
        //查询到父级菜单
        $mainCate = $cate->getMainCate();
        foreach($mainCate as $k => $val){
            //查询子菜单的
            $subCate = $cate->getSubCate($val["id"]);
            if($subCate){
                $mainCate[$k]["children"] = $subCate;
            }
        }
        $this->assign("cateArr", $mainCate);*/

        $this->assign("cateArr", $cateAll);

        $ass = $cate->getFoot();
        $this->assign("aee", $ass);
    }
}