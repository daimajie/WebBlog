<p align="center">
    <h1 align="center">web blog (Yii2.0)</h1>
    <br>
</p>

基于Yii2.0的博客系统

安装步骤如下

1.克隆项目到本地
~~~
git clone https://github.com/daimajie/WebBlog.git
~~~

2.安装依赖

~~~
composer install
~~~

3.设置数据库 config/db.php

~~~
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=XXX',
    'username' => 'XXX',
    'password' => 'XXX',
    'charset' => 'utf8',
    'tablePrefix' => '',

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',
];
~~~

4.执行数据库迁移脚本

~~~
./yii migrate  (window 去掉前面的 './' 符号)
~~~

5.创建用户 管理员
~~~
./yii manager/index  (按提示输入即可)
~~~

6.本程序使用了简单的rbac权限验证，请保证如下设置 config/rbac.php (默认创建的第一个用户就是管理员，如果ID非1，设置添加id即可)
~~~
return [
    'RBAC_ROLES' => [
        1 => '管理员',
        2 => '作者',
    ],
    'RBAC_AUTHS' => [
        1 => ['*'], //管理员可访问全部路由
        2 => ['blog/*', 'topic/*', 'zones/*', 'admin/*'] //作者可访问的模块路由
    ],
    'RBAC_PERMISS' => [
        1 => [1],       //管理员id
        2 => [2, 3],    //作者id
    ],
];
~~~

7.创建一个虚拟主机，目录指向project/web,并设置路由重写规则
访问站点即可，管理平台(www.domain.com/admin)

