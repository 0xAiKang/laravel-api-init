
基于`Laravel 8.x` 版本搭建的Api 手脚架，已有功能：
* 统一全局响应
* 服务端异常捕获及处理
* 基于场景表单验证
* JWT 授权认证
* 基于`laravel-permission` 的权限管理

## 快速上手
安装Package：
```shell
composer install
```

数据表迁移：
```shell
php artisan migrate
```

Run：
```shell
php artisan serve
```

### Api Test
```shell
curl http://127.0.0.1:8000/api/v1/users/test 
```

### Admin Login
```shell
curl -d "username=admin&password=123456" http://127.0.0.1:8000/admin/auth/login
```

## 目录结构
```shell
./
├── README.md
├── app 			应用目录
│   ├── Console		        命令行
│   │   ├── Commands            自定义Artisan 命令
│   │   └── Kernel.php
│   ├── Enums                   自定义枚举
│   ├── Exceptions              异常处理器
│   │   ├── Handler.php                   
│   │   ├── AuthException.php             身份验证异常
│   │   ├── InternalException.php         系统内部异常
│   │   └── InvalidRequestException.php   用户行为异常
│   ├── Helpers                 助手函数
│   │   └── helper.php          自定义助手函数
│   ├── Http 		        请求相关
│   │   ├── Controllers         控制器
│   │   │  ├── Admin            后台相关接口
│   │   │  ├── Api              客户端接口
│   │   ├── Middleware          中间件
│   │   └── Requests            表单请求
│   │   ├── Kernel.php          核心类  
│   ├── Models                  Eloquent 模型
│   │   ├── Admin               后台相关模块
│   │   └── User                用户模块
│   ├── Providers               服务提供者
│   │   ├── AppServiceProvider.php
│   │   ├── AuthServiceProvider.php
│   │   ├── BroadcastServiceProvider.php
│   │   ├── EventServiceProvider.php
│   │   └── RouteServiceProvider.php
│   ├── Rules                       常用验证规则封装
│   ├── Services                    商业逻辑处理层
│   │   ├── Admin
│   │   ├── Api
│   └── Traits                      可复用代码封装           
│       ├── ApiResponse.php         统一 Response 响应
│       ├── SoftDeletesEx.php       自定义软删除字段
│       └── SoftDeletingScopeEx.php 自定义软删除全局查询作用域
├── config                       配置
│   ├── app.php                  应用配置
│   ├── auth.php                 Auth guard 配置
│   ├── cache.php                缓存配置
│   ├── captcha.php              验证码配置
│   ├── cors.php                 跨域配置
│   ├── database.php             数据库配置
│   ├── filesystems.php          文件系统配置
│   ├── hashing.php              Hash 配置
│   ├── jwt.php                  JWT 配置
│   ├── logging.php              查询日志配置
│   ├── mail.php                 邮件配置
│   ├── queue.php                队列配置
│   └── wechat.php               微信相关配置
│   └── permission.php           权限配置配置
├── routes
│   ├── api.php                  客户端路由
│   ├── admin.php                管理后台路由
├── server.php
├── storage
│   └── logs                     日志
├── vendor	                 composer 依赖
```

## 约定大于配置
### 编码

默认遵循 [PSR-2](https://www.php-fig.org/psr/psr-2/) 命名规范和 [PSR-4](https://www.php-fig.org/psr/psr-4/) 自动加载规范，并注意如下规范：

* 类库、函数文件统一以 `.php` 为后缀
* 类的命名采用大驼峰法，并添加相应后缀，例如用户表单验证类：`UserRequest`
* 函数的命名使用小写字母加下划线
* 方法的命名使用小驼峰法
* 属性/变量的命名使用小驼峰法
* 常量以大写字母和下划线命名

### 数据库
* 没有表前缀
* 数据库里面的密码一定要加密，不能保存明文
* Mysql 引擎类型统一使用 `InnoDB`，字符编码统一使用 `utf8mb4`
* 统一使用 `int` 存储货币，精确到分
* 所有删除操作，均使用软删除，通过 `is_deleted` 字段进行标示
* 所有时间相关的字段均存储 `Timestamp`，几乎每张表都需要有 `created_at`、`updated_at` 字段
* 尽量给每个字段一个默认值，**避免使用 NULL**。字符型默认值为一个空字符值串，数值型的默认值为数值 `0`，逻辑型的默认值为数值 `0`
* 能用 `tinyint` 就不用 `int`，能用 `int` 就不要用 `varchar`，能用 `varchar(16)`就不要用 `varchar(225)`
* `boolean` 类型的字段命名统一使用 `is_xxx` 格式，状态、类型相关的字段统一从 `1` 开始定义，尽量不要占用 `0`

## 单一职责
* `Models`： Eloquent 模型，ORM 维护
* `Controller`：接收请求参数，调用 Service，返回响应
* `Services`： 辅助 Controller，商业逻辑处理，注入到 Controller
* `Requests`：表单验证
* `Traits`：可复用代码封装
* `Rules`：常用表单验证规则封装

## Wiki

### Generator Model

```shell
php artisan krlove:generate:model UserModel --table-name=user --output-path=./Models --namespace=App\\Models
```

### 生成模型注解
```shell
php artisan ide-helper:models "App\Models\UserModel"

Do you want to overwrite the existing model files? Choose no to write to _ide_helper_models.php instead (yes/no) [no]:
> yes
```

### Generator Service

```shell
php artisan make:service Api/TestService
```

### Generator Enum

```shell
php artisan make:enum Api/UserStatus
```

### 实时打印SQL 执行日志
```shell
tail -f ./storage/logs/laravel.log
```

### 其他
安装开发专用扩展包时，必须使用 `--dev` 参数，如：

```shell
composer require overtrue/laravel-query-logger --dev
```

对于开发专用的 provider 不要在 `config/app.php` 中注册，尽量在 `app/Providers/AppServiceProvider.php` 文件中以如下方式进行注册：

```php
public function register()
{
    if ($this->app->environment() == 'local') {
        $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
    }
}
```

## 相关资源
* [Laravel 8 中文文档](https://learnku.com/docs/laravel/8.x)
* [Laravel 项目开发规范](https://learnku.com/docs/laravel-specification/7.x)
* [Laravel 8 速查表](https://learnku.com/docs/laravel-cheatsheet/8.x)