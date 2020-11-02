<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    // +----------------------------------------------------------------------
    // | 应用设置
    // +----------------------------------------------------------------------

    'template'               => [
        //启用模板布局
        'layout_on'    =>true,
        //布局页的名称
        'layout_name' =>'layout_admin'
    ],

    'view_replace_str'  =>  [
        '__PUBLIC__'=>'http://localhost/LearnPhp/bick/public/static/admin/style/',
        '__IMG__'   =>'http://localhost/LearnPhp/bick/public/static/admin/images/'
    ]
];
