<?php

include 'Tpl.php';
$tpl = new Tpl();

$title = '你好';
$data = ['科比', '伟大'];

$abc = '天气不错';

$tpl->assign('title', $title);
$tpl->assign('data', $data);
$tpl->assign('abc', $abc);

$tpl->display('test.html');