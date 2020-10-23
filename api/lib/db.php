<?php
/**
 * Created by PhpStorm.
 * User: tanwb
 * Date: 2020/10/9
 * Time: 15:45
 */
require_once __DIR__."/conf.php";
return new PDO('mysql:host='.HOST.';dbname='.DBNAME, DBUSER, DBPASS);