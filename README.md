# e瞳网2015年招新报名网站

## 安装

* 需要`php >= 5.3`

* 解压到某个文件夹下，从ThinkPHP官网下载一个ThinkPHP3.2.3框架，与本目录合并

* 在MySQL中选择一个数据库，并执行以下MySQL语句，表前缀`join_`可以自行修改

```mysql
CREATE TABLE IF NOT EXISTS `join_apply2` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` VARCHAR(30) NOT NULL COMMENT '姓名',
  `sex` VARCHAR(6) NOT NULL COMMENT '性别',
  `native_place` VARCHAR(30) NOT NULL COMMENT '专业班级',
  `academy` VARCHAR(30) NOT NULL COMMENT '籍贯',
  `class` VARCHAR(30) NOT NULL COMMENT '书院',
  `mobile` VARCHAR(24) NOT NULL COMMENT '手机',
  `email` VARCHAR(50) NOT NULL COMMENT '邮箱',
  `firstwant` VARCHAR(24) NOT NULL COMMENT '第一志愿',
  `secondwant` VARCHAR(24) NOT NULL COMMENT '第二志愿',
  `intro` VARCHAR(255) NOT NULL COMMENT '个人简历',
  `reason` VARCHAR(255) NOT NULL COMMENT '为什么加入e瞳网',
  `timestamp` INT NOT NULL COMMENT '时间戳',
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '简历投递时间',
  `ip` VARCHAR(15) NOT NULL COMMENT 'IP',
  PRIMARY KEY (`id`)
) ENGINE = MyISAM CHARSET = utf8 COLLATE utf8_general_ci;
```

* 修改`./Application/Common/Conf/config.php`中的配置

## 说明

* 项目使用 ThinkPHP 3.2.3 框架

* 代码中包含访问两个版本的数据的后台管理，最新的版本以`2`结尾

## Author

LorinLee

## LICENSE

[Apache 2.0](http://www.apache.org/licenses/LICENSE-2.0)
