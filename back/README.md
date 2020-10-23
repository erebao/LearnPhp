```
【千锋】PHP高级实战教程全集（43集）：https://www.bilibili.com/video/BV1pJ411p781?p=1
```

## 9  验证码类

## 10 分页类

## 11 文件上传类

## 12 高级图像类

## 13 数据库操作类

## 14 模板引擎类

## 15 设计模式

## 16 自己打造MVC框架

## 17 composer

** 1)下载composer：**
```
https://docs.phpcomposer.com/
```

** 2)创建composer.json文件 **
** 写入空的json： **
```
{
}
```

** 3)执行 **
```
composer update
```

** 4)修改国内镜像 **
**     4.1)指令修改(全局修改) **
```
composer config repo.packagist composer https://packagist.phpcomposer.com
```
**     4.2)配置文件修改(composer.json) **
```
"repositories": {
    "packagist": {
        "type": "composer",
        "url": "https://packagist.phpcomposer.com"
    } 
}
```

** 5）require加载路由包 **
**     5.1)配置文件增加需要下载的包(composer.json) **
```
"require": {
    "noahbuscher/macaw":"dev-master"
}
```
** 5.2)执行 **
```
composer update
```

** 6）版本号 **
```
1.0.1                       指定版本号
>=1.0                       大于等于1.0版本
>=1.0,<2.0                  大于等于1.0，小于2.0
>=1.0,<1.1|>1.2             大于等于1.0，小于1.1或者大于等于1.2
1.0.*                       匹配1.0所有版本
~1.2                        相当于>=1.2,<2.0
~1.2.3                      相当于>=1.2.3,<1.3
dev-master                  代表是github上面的版本
```

** 7）常用指令 **
```
dump-autoload       修改完composer.json里面的autoload执行
require
selfupdate          自己更新
install             安装
list                显示所有指令
clearcache          清除缓存
remove              移除一个包
```