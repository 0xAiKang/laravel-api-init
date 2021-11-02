<?php

namespace App\Http\Middleware;

use App\Exceptions\InvalidRequestException;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Guard;

/**
 * Class CheckPermissions
 *
 * @package App\Http\Middleware
 */
class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 超级管理员默认通过所有权限
//        if (Auth::user()->isRoot()) {
//            return $next($request);
//        }
//        return $next($request);

        // 获取当前路由名称
        $currentRouteName = Route::currentRouteName();


        // 当路由不为 null 时，验证权限
        if (!is_null($currentRouteName)) {

            // 获取当前守卫名称
            $guardName = Guard::getDefaultName(self::class);
//            $permission = auth($guardName)->user()->getAllPermissions()->pluck('name')->toArray();
            if ( auth($guardName)->user()->can($currentRouteName)) {
                return $next($request);
            }

            throw new InvalidRequestException('暂无权限');
//            if (!in_array($currentRouteName, $permission)) {
//
//                if ( auth($guardName)->user()->can($currentRouteName)) {
//                    return $next($request);
//                }
//                Gate::authorize($currentRouteName);
//            }
        }

        return $next($request);
    }
}
