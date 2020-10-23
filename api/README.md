```
【千峰】Restful接口开发实战教程：https://www.bilibili.com/video/av46827890/
```

#### Table user:
```
CREATE TABLE `user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `create_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;
```

#### Table article:
```
CREATE TABLE `article`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `create_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;
```

#### postman:
**register**
```
POST：http://api.local.com/1.0/users/register
body raw JSON(application/json)：{"name":"zhaosi","password":"123456"}
```

**login**
```
POST：http://api.local.com/1.0/users/login
body raw JSON(application/json)：{"name":"zhaosi","password":"123456"}
```

**article**

add：
```
POST：http://api.local.com/1.0/articles
body raw JSON(application/json)：{"title":"测试","content":"内容","token":"21qnj2qd9qm2tr6kfctt6975r2"}
```

edit：
```
PUT：http://api.local.com/1.0/articles/3
body raw JSON(application/json)：{"title":"测试2","content":"内容2","token":"21qnj2qd9qm2tr6kfctt6975r2"}
```

delete：
```
DELETE：http://api.local.com/1.0/articles/1
body raw JSON(application/json)：{"token":"21qnj2qd9qm2tr6kfctt6975r2"}
```

view：
```
GET：http://api.local.com/1.0/articles/1
header：token=21qnj2qd9qm2tr6kfctt6975r2
```