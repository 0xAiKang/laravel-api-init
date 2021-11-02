<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthException;
use App\Exceptions\InvalidRequestException;
use App\Models\AdminModel;
use Closure;
use Illuminate\Http\Request;

/**
 * 管理员身份验证中间件
 *
 * Class AuthAdmin
 *
 * @package App\Http\Middleware
 */
class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     * @throws \App\Exceptions\AuthException
     * @throws \App\Exceptions\InvalidRequestException
     */
    public function handle(Request $request, Closure $next)
    {
        /**
         * 因为控制器中定义的Except 规则没有生效
         * 这里使用自定义的方式过滤 Except 中定义的Action
         */
        $action = $request->route()->getActionMethod();
        $target = $request->route()->getController()->getMiddleware();
        foreach ($target as $item) {
            foreach ($item["options"] ?? [] as $value) {
                if (in_array($action, $value)) {
                    return $next($request);
                }
            }
        }

        // 只有需要验证的接口才会走该中间件，登录等接口无需验证此中间件
        $guard = \Auth::guard("admin");

        // 开发模式不验证身份，分配默认用户
        if (app()->environment() === 'DEV') {
            $admin = AdminModel::find(1);
            if (!$admin) {
                throw new AuthException();
            }

            auth("admin")->setUser($admin);
            return $next($request);
        }

        if (!$guard->check()) {
            throw new AuthException();
        }

        $admin = $guard->user();

        if (0 == $admin->is_enable) {
            throw new InvalidRequestException("该管理员已被禁用");
        }

        return $next($request);
    }
}
