<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

/**
 * Token 刷新中间件（注意⚠️，这里继承的是 jwt 的Base Middleware）
 *
 * Class RefreshToken
 *
 * @package App\Http\Middleware
 */
class RefreshToken extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // 检查此次请求，是否携带了Token，如果没有，抛出异常
        $this->checkForToken($request);

        // 使用try catch 捕捉Token 过期所抛出的TokenExpiredException 异常
        try {
            // 检查用户登录状态，如果正常则通过
            if ($this->auth->parseToken()->authenticate()) {
                return $next($request);
            }

            throw new UnauthorizedHttpException("jwt-auth", "未登录");
        } catch (TokenExpiredException $exception) {
            // 此处捕获到了 token 过期所抛出的 TokenExpiredException 异常，我们在这里需要做的是刷新该用户的 token 并将它添加到响应头中
            try {
                // 刷新用户Token
                $token = $this->auth->refresh();
                // 使用一次性登录以保证此次登录的成功
                Auth::guard("api")->onceUsingId($this->auth->manager()->getPayloadFactory()->buildClaimsCollection()->toPlainArray()["sub"]);
                // 将新的Token 存入数据库
                $user = Auth::user();
                $user->last_token = $token;
                $user->save();
            } catch (JWTException $exception) {
                // 如果捕获到此异常，即代表 refresh 也过期了，用户无法刷新令牌，需要重新登录。
                throw new UnauthorizedHttpException("jwt-auth", $exception->getMessage());
            }
        }

        // 在响应头中返回新的 token
        return $this->setAuthenticationHeader($next($request), $token);
        // return $next($request);
    }
}
