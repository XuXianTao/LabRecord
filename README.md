LabRecord
===============
#### 本次实验用到的开源项目
1. Bootstrapv4.0[http://wiki.jikexueyuan.com/project/bootstrap4/getting-started/introduction/]
2. Bootstrap-table[http://bootstrap-table.wenzhixin.net.cn/zh-cn/documentation/]
3. phpoffice/phpspreadsheet[https://phpspreadsheet.readthedocs.io/en/develop/]

# Thinkphp5.1
## 安装
php本地安装`php composer.phar install`
composer安装 `composer install`
如果速度太慢就配置国内镜像Url(使用phar文件的就直接采用第二点然后`composer`换成`php composer.phar`)
1. 全局配置`composer config -g repo.packagist composer https://packagist.phpcomposer.com`
2. 单个项目配置`composer config repo.packagist composer https://packagist.phpcomposer.com`


### 基本文件说明
~~~
controller
├─Excel.php                   Excel文件的导入导出（学生的签到情况表）
├─Login.php                   登陆页面的显示和逻辑处理(包括了ajax函数处理)
├─Signup.php                  注册页面的显示和逻辑处理(包括了ajax函数处理)
├─Home.php                    登入之后的主界面内容显示、登出逻辑处理
└─Table.php                   表格内容的获取逻辑处理
view
├─layout
│  └─common.html              每个页面都在使用的模板(head+body前半部分【也就是Logo那一栏】)
├─login
│  ├─login_admin.html         助理、上课老师、仪器管理老师登陆界面
│  └─login_stu.html           学生登陆界面
├─signup
│  ├─signup_ta.html           助理的注册页面
│  └─signup_teacher.html      老师的注册页面
├─home
│  ├─home_edu_teacher.html    上课老师主界面
│  ├─home_lab_teacher.html    仪器管理老师主界面
│  ├─home_stu.html            学生主界面
│  └─hom_ta.html              助理主界面
├─tables
│  ├─course.html              显示所有课程信息的表格
│  ├─student_list.html        显示当前课程的学生信息
│  └─tas_list.html            显示所有助理的信息
└─excel
   └─excel.html               导入表格的页面(老师创建课程并导入学生excel)
common.php                    公共函数get_present_course获取当前时间的课程信息
behavior                      里面UpdateDate后期估计要去掉，现在应用在tags.php中
~~~

修改的几个配置/config
~~~
template.php -模板配置
    //路径添加 5.1版本的__STATIC__等字段信息都去掉了，要手动添加
    'tpl_replace_string' => [
    '__ROOT__' => Request::root(),
    '__STATIC__'=>Request::root() .'/static',
    ],
    //模板布局-配置到每一个html的模板信息
    'layout_on'     =>  true,
    'layout_name'   =>  'layout/common',
database.php -数据库配置
	// 数据库名
    'database'        => 'LabRecord',
app.php      -总体配置
    // 默认模块名
    'default_module'         => 'index',
    // 默认控制器名
    'default_controller'     => 'Login',
    // 默认操作名
    'default_action'         => 'loginStu',


    // 应用调试模式->显示错误信息
    'app_debug'              => true,
    // 应用Trace->右下角那个logo
    'app_trace'              => true,
~~~

路由修改/route/route.php
~~~
Route::rule('admin','index/login/loginAdmin');
~~~

# gulp-dev【自动化代码工具-用来修改样式】
## 安装
1. 安装项目
  还没配置package.json，目前就直接`npm install --save gulp gulp-less gulp-sourcemaps gulp-postcss autoprefixer cssnano gulp-livereload browser-sync`
2. 安装全局gulp `npm install -g gulp`
3. 编辑器安装livereload
4. 浏览器安装livereload

## 运行
1. `gulp`
2. 代码编辑器开启livereload
3. 浏览器对应页面打开livereload
【每次修改less文件浏览器都会自动刷新】



ThinkPHP 5.1
===============

ThinkPHP5.1对底层架构做了进一步的改进，减少依赖，其主要特性包括：

 + 采用容器统一管理对象
 + 支持Facade
 + 注解路由支持
 + 路由跨域请求支持
 + 配置和路由目录独立
 + 取消系统常量
 + 助手函数增强
 + 类库别名机制
 + 增加条件查询
 + 改进查询机制
 + 配置采用二级
 + 依赖注入完善
 + 中间件支持（V5.1.6+）


> ThinkPHP5的运行环境要求PHP5.6以上。


## 目录结构

初始的目录结构如下：

~~~
www  WEB部署目录（或者子目录）
├─application           应用目录
│  ├─common             公共模块目录（可以更改）
│  ├─module_name        模块目录
│  │  ├─common.php      模块函数文件
│  │  ├─controller      控制器目录
│  │  ├─model           模型目录
│  │  ├─view            视图目录
│  │  └─ ...            更多类库目录
│  │
│  ├─command.php        命令行定义文件
│  ├─common.php         公共函数文件
│  └─tags.php           应用行为扩展定义文件
│
├─config                应用配置目录
│  ├─module_name        模块配置目录
│  │  ├─database.php    数据库配置
│  │  ├─cache           缓存配置
│  │  └─ ...            
│  │
│  ├─app.php            应用配置
│  ├─cache.php          缓存配置
│  ├─cookie.php         Cookie配置
│  ├─database.php       数据库配置
│  ├─log.php            日志配置
│  ├─session.php        Session配置
│  ├─template.php       模板引擎配置
│  └─trace.php          Trace配置
│
├─route                 路由定义目录
│  ├─route.php          路由定义
│  └─...                更多
│
├─public                WEB目录（对外访问目录）
│  ├─index.php          入口文件
│  ├─router.php         快速测试文件
│  └─.htaccess          用于apache的重写
│
├─thinkphp              框架系统目录
│  ├─lang               语言文件目录
│  ├─library            框架类库目录
│  │  ├─think           Think类库包目录
│  │  └─traits          系统Trait目录
│  │
│  ├─tpl                系统模板目录
│  ├─base.php           基础定义文件
│  ├─console.php        控制台入口文件
│  ├─convention.php     框架惯例配置文件
│  ├─helper.php         助手函数文件
│  ├─phpunit.xml        phpunit配置文件
│  └─start.php          框架入口文件
│
├─extend                扩展类库目录
├─runtime               应用的运行时目录（可写，可定制）
├─vendor                第三方类库目录（Composer依赖库）
├─build.php             自动生成定义文件（参考）
├─composer.json         composer 定义文件
├─LICENSE.txt           授权说明文件
├─README.md             README 文件
├─think                 命令行入口文件
~~~

> router.php用于php自带webserver支持，可用于快速测试
> 切换到public目录后，启动命令：php -S localhost:8888  router.php
> 上面的目录结构和名称是可以改变的，这取决于你的入口文件和配置参数。

## 升级指导

原有下面系统类库的命名空间需要调整：

* think\App      => think\facade\App （或者 App ）
* think\Cache    => think\facade\Cache （或者 Cache ）
* think\Config   => think\facade\Config （或者 Config ）
* think\Cookie   => think\facade\Cookie （或者 Cookie ）
* think\Debug    => think\facade\Debug （或者 Debug ）
* think\Hook     => think\facade\Hook （或者 Hook ）
* think\Lang     => think\facade\Lang （或者 Lang ）
* think\Log      => think\facade\Log （或者 Log ）
* think\Request  => think\facade\Request （或者 Request ）
* think\Response => think\facade\Reponse （或者 Reponse ）
* think\Route    => think\facade\Route （或者 Route ）
* think\Session  => think\facade\Session （或者 Session ）
* think\Url      => think\facade\Url （或者 Url ）

原有的配置文件config.php 拆分为app.php cache.php 等独立配置文件 放入config目录。
原有的路由定义文件route.php 移动到route目录

## 命名规范

`ThinkPHP5`遵循PSR-2命名规范和PSR-4自动加载规范，并且注意如下规范：

### 目录和文件

*   目录不强制规范，驼峰和小写+下划线模式均支持；
*   类库、函数文件统一以`.php`为后缀；
*   类的文件名均以命名空间定义，并且命名空间的路径和类库文件所在路径一致；
*   类名和类文件名保持一致，统一采用驼峰法命名（首字母大写）；

### 函数和类、属性命名
*   类的命名采用驼峰法，并且首字母大写，例如 `User`、`UserType`，默认不需要添加后缀，例如`UserController`应该直接命名为`User`；
*   函数的命名使用小写字母和下划线（小写字母开头）的方式，例如 `get_client_ip`；
*   方法的命名使用驼峰法，并且首字母小写，例如 `getUserName`；
*   属性的命名使用驼峰法，并且首字母小写，例如 `tableName`、`instance`；
*   以双下划线“__”打头的函数或方法作为魔法方法，例如 `__call` 和 `__autoload`；

### 常量和配置
*   常量以大写字母和下划线命名，例如 `APP_PATH`和 `THINK_PATH`；
*   配置参数以小写字母和下划线命名，例如 `url_route_on` 和`url_convert`；

### 数据表和字段
*   数据表和字段采用小写加下划线方式命名，并注意字段名不要以下划线开头，例如 `think_user` 表和 `user_name`字段，不建议使用驼峰和中文作为数据表字段命名。

## 参与开发
请参阅 [ThinkPHP5 核心框架包](https://github.com/top-think/framework)。

## 版权信息

ThinkPHP遵循Apache2开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2006-2018 by ThinkPHP (http://thinkphp.cn)

All rights reserved。

ThinkPHP® 商标和著作权所有者为上海顶想信息科技有限公司。

更多细节参阅 [LICENSE.txt](LICENSE.txt)
