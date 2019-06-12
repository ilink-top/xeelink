<?php
namespace app\common\handle;

use Exception;
use think\Container;
use think\Response;

class Web extends Base
{
    public function render(Exception $exception)
    {
        $app = Container::get('app');
        $isDebug = $app->isDebug();
        $isAjax = $app['request']->isAjax();
        $config = $app['config'];

        if ($isDebug && !$isAjax) {
            return parent::render($exception);
        }

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
        return Response::create($result, $type)->options(['jump_template' => $config->get('dispatch_error_tmpl')]);
    }
}
