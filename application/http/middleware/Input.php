<?php
namespace app\http\middleware;

class Input extends Base
{
    public function handle($request, \Closure $next)
    {
        if (!is_null($request->param('pn'))) {
            $request->page = $request->param('pn');
        }

        return $next($request);
    }
}
