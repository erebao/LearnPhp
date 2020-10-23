<?php
/**
 * Created by PhpStorm.
 * User: tanwb
 * Date: 2020/10/9
 * Time: 15:45
 */
$db = require_once __DIR__ . '/lib/db.php';
require_once __DIR__ . '/class/User.php';
require_once __DIR__ . '/class/Article.php';
require_once __DIR__ . '/class/Rest.php';

//开启session
session_start();

$user = new User($db);
$article = new Article($db);
$api = new Rest($user, $article);

//启动api
$api->run();