<?php
namespace app\library;

use Exception;
use think\Container;
use think\exception\Handle;
use think\exception\HttpException;

class ExceptionHandle extends Handle
{
    public function render(Exception $e)
    {
        if ($this->render && $this->render instanceof \Closure) {
            $result = call_user_func_array($this->render, [$e]);

            if ($result) {
                return $result;
            }
        }

        $app = Container::get('app');
        $debug = $app->request->param('debug', $app->isDebug());
        // 收集异常数据
        $code = $this->getCode($e) != 0 ? $this->getCode($e) : 1;
        if ($debug) {
            // 调试模式，获取详细的错误信息
            $data = [
                'name' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'message' => $this->getMessage($e),
                'trace' => $e->getTrace(),
                'code' => $code,
                'source' => $this->getSourceCode($e),
                'datas' => $this->getExtendData($e),
                'tables' => [
                    'GET Data' => $_GET,
                    'POST Data' => $_POST,
                    'Files' => $_FILES,
                    'Cookies' => $_COOKIE,
                    'Session' => isset($_SESSION) ? $_SESSION : [],
                    'Server/Request Data' => $_SERVER,
                    'Environment Variables' => $_ENV,
                    'ThinkPHP Constants' => $this->getConst(),
                ],
            ];
        } else {
            // 部署模式仅显示 Code 和 Message
            $data = [
                'code' => $code,
                'message' => $this->getMessage($e),
            ];
        }

        $statusCode = ($e instanceof HttpException) ? $e->getStatusCode() : 200;

        return json($data, $statusCode);
    }

    private static function getConst()
    {
        $const = get_defined_constants(true);

        return isset($const['user']) ? $const['user'] : [];
    }
}
