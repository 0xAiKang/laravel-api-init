<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthException;
use App\Exceptions\InvalidRequestException;
use App\Models\UserModel;
use Closure;
use Illuminate\Http\Request;

class AuthApi
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
        // 只有需要验证的接口才会走该中间件，登录等接口无需验证此中间件
        $guard = \Auth::guard("api");

        // 调试模式下不验证身份，分配默认用户
        if (app()->environment() !== 'production' && !$guard->check()) {
            $user = UserModel::find(1);
            if (!$user) {
                throw new AuthException();
            }

            auth("api")->setUser($user);

            return $next($request);
        }

        if (!$guard->check()) {
            throw new AuthException();
        }

        $user = $guard->user();

        if ($user->is_deleted) {
            throw new InvalidRequestException("账户存在异常");
        }

        return $next($request);
    }
}
