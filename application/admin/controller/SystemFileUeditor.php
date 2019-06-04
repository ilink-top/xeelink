<?php
namespace app\admin\controller;

class SystemFileUeditor extends SystemFile
{
    public function index()
    {
        $action = $this->request->param('action');
        $result = [];

        if ($action == 'config') {
            $result = $this->config;
        } elseif (in_array($action, ['uploadimage', 'uploadvideo', 'uploadfile'])) {
            switch ($action) {
                case 'uploadimage':
                    $type = 'image';
                    break;

                case 'uploadvideo':
                    $type = 'video';
                    break;

                case 'uploadfile':
                    $type = 'file';
                    break;
            }

            $this->request->type = $type;
            $result = $this->upload();
        } elseif (in_array($action, ['listimage', 'listfile'])) {
            switch ($action) {
                case 'listimage':
                    $type = 'image';
                    break;

                case 'listfile':
                    $type = 'file';
                    break;
            }

            $this->request->type = $type;
            $result = $this->list();
        } else {
            $result = [
                'state' => '请求地址出错',
            ];
        }

        return json_encode($result);
    }

    protected function jump($url = null, $data = [], $msg = '操作成功')
    {
        $data['state'] = 'SUCCESS';
        return $data;
    }

    protected function check($msg = true)
    {
        return [
            'state' => $msg !== true ? $msg : 'SUCCESS',
        ];
    }
}
