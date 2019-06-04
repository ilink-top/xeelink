<?php
namespace app\common\handle;

use Exception;
use think\Response;

class Web extends Base
{
    public function render(Exception $exception)
    {
        if (config('app_debug')) {
            return parent::render($exception);
        }

        $isAjax = $app['request']->isAjax();
        $config = $app['config'];

        $type = $isAjax
        ? $config->get('default_ajax_return')
        : $config->get('default_return_type');

        $result = [
            'code' => 0,
            'msg' => $this->getMessage($exception),
            'data' => '',
            'url' => $isAjax ? '' : 'javascript:history.back(-1);',
            'wait' => 3,
        ];

        if ('html' == strtolower($type)) {
            $type = 'jump';
        }
        return Response::create($result, $type)->options(['jump_template' => $app['config']->get('dispatch_error_tmpl')]);
    }
}
