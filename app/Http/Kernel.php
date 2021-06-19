<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * 应用程序的全局HTTP中间件堆栈
     *
     * 这些中间件在应用程序的每个请求期间都会运行
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,

        // 配置可信代理。可通过 $proxies 属性设置可信代理列表，$headers 属性设置用来检测代理的 HTTP 头字段
        \App\Http\Middleware\TrustProxies::class,

        // 跨域中间件 对应配置文件 cors.php
        \Fruitcake\Cors\HandleCors::class,

        // 启用维护模式时应可访问的URI
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,

        // 处理传入请求
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,

        // 对请求参数内容进行 前后空白字符清理。可通过 $except 数组属性设置不做处理的参数
        \App\Http\Middleware\TrimStrings::class,

        // 对空 转换成  null
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * 应用程序的路由中间件组
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // 访问节流
            'throttle:api',

            // 路由模型绑定
            "bindings",
        ],
    ];

    /**
     * 应用程序的路由中间件组
     *
     * 这些中间件可以分配给组或单独使用
     *
     * @var array
     */
    protected $routeMiddleware = [
        // Auth 验证中间件，限制登录用户才能访问的接口
        'auth' => \App\Http\Middleware\Authenticate::class,

        // HTTP Basic Auth 认证
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,

        // 缓存标头
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,

        // 用户授权功能
        'can' => \Illuminate\Auth\Middleware\Authorize::class,

        // 只有未登录用户才能访问，在 register 和 login 请求中使用
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,

        // 密码确认，你可以在做一些安全级别较高的修改时使用，例如说支付前进行密码确认
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,

        // 签名认证
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,

        // 访问节流，类似于 『1 分钟只能请求 10 次』的需求，一般在 API 中使用
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        // 路由模型绑定
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,

        // Laravel 自带的强制用户邮箱认证的中间件
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        // api身份认证
        "auth.api" => \App\Http\Middleware\AuthApi::class,
    ];
}
