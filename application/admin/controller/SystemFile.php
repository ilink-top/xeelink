<?php
namespace app\admin\controller;

class SystemFile extends BaseLogin
{
    public function __construct()
    {
        parent::__construct();
        $this->config = config('file.');
    }

    public function list()
    {
        $type = $this->request->param('type', 'file');
        if ($type == 'image') {
            $ext = $this->config['imageManagerAllowFiles'];
            $path = $this->config['imageManagerListPath'];
            $size = $this->config['imageManagerListSize'];
        } else {
            $ext = $this->config['fileManagerAllowFiles'];
            $path = $this->config['fileManagerListPath'];
            $size = $this->config['fileManagerListSize'];
        }
        $start = $this->request->param('start', 0);
        $size = $this->request->param('size', $size);
        $result = $this->getFiles($ext, $path, $start, $size);

        return $this->jump('', [
            'list' => $result['list'],
            'start' => $start,
            'total' => $result['total'],
        ]);
    }

    private function getFiles($ext, $path, $start, $size)
    {
        $ext = stringtoarray($ext);
        foreach ($ext as $k => $v) {
            $ext[$k] = trim($v, '.');
        }
        $ext = implode('|', $ext);

        /* 获取参数 */
        $end = $start + $size;

        /* 获取文件列表 */
        $files = file_list($path, $ext);
        if (!count($files)) {
            $this->check('no match file');
        }

        /* 获取指定范围的列表 */
        $len = count($files);
        for ($i = min($end, $len) - 1, $list = []; $i < $len && $i >= 0 && $i >= $start; $i--) {
            $list[] = $files[$i];
        }
        //倒序
        //for ($i = $end, $list = []; $i < $len && $i < $end; $i++){
        //    $list[] = $files[$i];
        //}

        /* 返回数据 */
        return [
            'list' => $list,
            'total' => count($files),
        ];
    }

    public function upload()
    {
        $type = $this->request->param('type', 'file');
        if ($type == 'image') {
            $name = $this->config['imageFieldName'];
            $path = $this->config['imagePath'];
            $validate = [
                'size' => $this->config['imageMaxSize'],
                'ext' => $this->config['imageAllowFiles'],
            ];
        } elseif ($type == 'video') {
            $name = $this->config['videoFieldName'];
            $path = $this->config['videoPath'];
            $validate = [
                'size' => $this->config['videoMaxSize'],
                'ext' => $this->config['videoAllowFiles'],
            ];
        } else {
            $name = $this->config['fileFieldName'];
            $path = $this->config['filePath'];
            $validate = [
                'size' => $this->config['fileMaxSize'],
                'ext' => $this->config['fileAllowFiles'],
            ];
        }
        $name = $this->request->param('name', $name);

        try {
            $result = upload_file($name, $path, $validate);
        } catch (\Exception $e) {
            return $this->check($e->getMessage());
        }

        return $this->jump('', [
            'url' => str_replace('\\', '/', $result->getSaveName()),
            'title' => basename($result->getSaveName()),
            'original' => $result->getInfo('name'),
            'type' => '.' . $result->getExtension(),
            'size' => file_size($result->getSize()),
        ]);
    }
}
