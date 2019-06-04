<?php
return [
    // 上传图片配置项
    // 执行上传图片的action名称
    'imageActionName' => 'uploadimage',
    // 提交的图片表单名称
    'imageFieldName' => 'file',
    // 上传大小限制，单位B
    'imageMaxSize' => 2048000,
    // 上传图片格式显示
    'imageAllowFiles' => ['.png', '.jpg', '.jpeg', '.gif', '.bmp'],
    // 是否压缩图片,默认是true
    'imageCompressEnable' => true,
    // 图片压缩最长边限制
    'imageCompressBorder' => 1600,
    // 插入的图片浮动方式
    'imageInsertAlign' => 'none',
    // 图片访问路径前缀
    'imageUrlPrefix' => request()->root() . '/upload/',
    // 上传保存路径
    'imagePath' => Env::get('root_path') . 'public/upload/',

    // 上传视频配置
    // 执行上传视频的action名称
    'videoActionName' => 'uploadvideo',
    // 提交的视频表单名称
    'videoFieldName' => 'file',
    // 上传保存路径
    'videoPath' => Env::get('root_path') . 'public/upload/',
    // 视频访问路径前缀
    'videoUrlPrefix' => request()->root() . '/upload/',
    // 上传大小限制，单位B，默认100MB
    'videoMaxSize' => 102400000,
    // 上传视频格式显示
    'videoAllowFiles' => ['.flv', '.swf', '.mkv', '.avi', '.rm', '.rmvb', '.mpeg', '.mpg', '.ogg', '.ogv', '.mov', '.wmv', '.mp4', '.webm', '.mp3', '.wav', '.mid'],

    // 上传文件配置
    // 执行上传文件的action名称
    'fileActionName' => 'uploadfile',
    // 提交的文件表单名称
    'fileFieldName' => 'file',
    // 上传保存路径
    'filePath' => Env::get('root_path') . 'public/upload/',
    // 文件访问路径前缀
    'fileUrlPrefix' => request()->root() . '/upload/',
    // 上传大小限制，单位B，默认50MB
    'fileMaxSize' => 51200000,
    // 上传文件格式显示
    'fileAllowFiles' => ['.png', '.jpg', '.jpeg', '.gif', '.bmp', '.flv', '.swf', '.mkv', '.avi', '.rm', '.rmvb', '.mpeg', '.mpg', '.ogg', '.ogv', '.mov', '.wmv', '.mp4', '.webm', '.mp3', '.wav', '.mid', '.rar', '.zip', '.tar', '.gz', '.7z', '.bz2', '.cab', '.iso', '.doc', '.docx', '.xls', '.xlsx', '.ppt', '.pptx', '.pdf', '.txt', '.md', '.xml'],

    // 列出指定目录下的图片
    // 执行图片管理的action名称
    'imageManagerActionName' => 'listimage',
    // 指定要列出图片的目录
    'imageManagerListPath' => Env::get('root_path') . 'public/upload/',
    // 每次列出文件数量
    'imageManagerListSize' => 20,
    // 图片访问路径前缀
    'imageManagerUrlPrefix' => '',
    // 插入的图片浮动方式
    'imageManagerInsertAlign' => 'none',
    // 列出的文件类型
    'imageManagerAllowFiles' => ['.png', '.jpg', '.jpeg', '.gif', '.bmp'],

    // 列出指定目录下的文件
    // 执行文件管理的action名称
    'fileManagerActionName' => 'listfile',
    // 指定要列出文件的目录
    'fileManagerListPath' => Env::get('root_path') . 'public/upload/',
    // 文件访问路径前缀
    'fileManagerUrlPrefix' => '',
    // 每次列出文件数量
    'fileManagerListSize' => 20,
    // 列出的文件类型
    'fileManagerAllowFiles' => ['.png', '.jpg', '.jpeg', '.gif', '.bmp', '.flv', '.swf', '.mkv', '.avi', '.rm', '.rmvb', '.mpeg', '.mpg', '.ogg', '.ogv', '.mov', '.wmv', '.mp4', '.webm', '.mp3', '.wav', '.mid', '.rar', '.zip', '.tar', '.gz', '.7z', '.bz2', '.cab', '.iso', '.doc', '.docx', '.xls', '.xlsx', '.ppt', '.pptx', '.pdf', '.txt', '.md', '.xml'],
];
