<?php
namespace app\http\middleware;

class AdminLogin extends Base
{
    public function handle($request, \Closure $next)
    {
        try {
            $this->app->admin->checkToken();
        } catch (\Exception $e) {
            return api_result($e->getCode(), $e->getMessage());
        }

        return $next($request);
    }
}
