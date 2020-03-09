<?php
namespace app\http\middleware;

class AdminAuth extends Base
{
    public function handle($request, \Closure $next)
    {
        try {
            $auth = strtolower($request->method() . '-' . $request->baseUrl());
            $this->app->admin->checkAuth($auth);
        } catch (\Exception $e) {
            return api_result($e->getCode(), $e->getMessage());
        }

        return $next($request);
    }
}
